<?php

namespace App\Http\Requests\Admin;

use App\Models\Transaction;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RecordePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $transaction = Transaction::findOrFail($this->transaction_id);
        $maxAmount = $transaction->amount_with_vat - $transaction->total_paid_amount;
        return [
            'transaction_id' => 'required|integer|exists:transactions,id',
            'amount' => 'required|numeric|gt:0|max:'.$maxAmount,
            'paid_on' => 'required|date',
            'details' => 'nullable|string'
        ];
    }
}
