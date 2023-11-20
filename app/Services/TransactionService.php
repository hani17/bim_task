<?php

namespace App\Services;

use App\Enums\TransactionStatus;
use App\Exceptions\PaymentException;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TransactionService
{
    public function getTransactions(): LengthAwarePaginator
    {
        return Transaction::with('payer')
            ->latest()
            ->paginate(10);
    }

    public function createTransaction(array $data): Transaction
    {
        $amount = $data['amount'];
        $vat = $data['vat'];
        $dueOn = $data['due_on'];
        $isVatInclusive = $data['is_vat_inclusive'];
        $payer = User::customers()->findOrFail($data['payer']);

        $originalAmount = $this->calculateOriginalAmount($amount, $vat, $isVatInclusive);
        $vatAmount = $this->calculateVatAmount($amount, $vat, $isVatInclusive);

        return Transaction::create([
            'amount' => $originalAmount,
            'payer_id' => $payer->id,
            'due_on' => $dueOn,
            'vat_amount' => $vatAmount,
            'is_vat_inclusive' => $isVatInclusive,
            'status' => Carbon::now()->gt(Carbon::parse($dueOn))
                ? TransactionStatus::OVERDUE
                : TransactionStatus::OUTSTANDING
        ]);
    }

    /**
     * @throws PaymentException
     */
    public function recordPayment(array $data): Transaction
    {
        $transaction = Transaction::findOrFail($data['transaction_id']);
        if ($transaction->status == TransactionStatus::PAID) {
            throw PaymentException::fullyPaid();
        }
        $transaction->payments()->create($data);
        $totalPaidAmount = $transaction->payments()->sum('amount');
        $transaction->update([
            'total_paid_amount' => $totalPaidAmount,
            'status' => $this->calculateStatus($totalPaidAmount, $transaction->amount_with_vat, $transaction->due_on)
        ]);
        return $transaction->refresh();
    }

    public function calculateOriginalAmount(float $amount, float $vat, bool $isVatInclusive): float
    {
        return $isVatInclusive ? ($amount / (1 + ($vat / 100))) : $amount;
    }

    public function calculateVatAmount(float $amount, float $vat, bool $isVatInclusive): float
    {
        return $isVatInclusive
            ? ($amount - $this->calculateOriginalAmount($amount, $vat, true))
            : ($amount * ($vat / 100));
    }

    public function calculateStatus($totalPaidAmount, $amountWithVat, $dueOn): TransactionStatus
    {
        $currentDate = Carbon::now();
        $dueDate = Carbon::parse($dueOn);

        if ($totalPaidAmount >= $amountWithVat) {
            return TransactionStatus::PAID;
        } elseif ($currentDate->gt($dueDate)) {
            return TransactionStatus::OVERDUE;
        } else {
            return TransactionStatus::OUTSTANDING;
        }
    }

    public function getAuthUserTransactions(): LengthAwarePaginator
    {
        return Auth::user()->transactions()->latest()->paginate();
    }
}
