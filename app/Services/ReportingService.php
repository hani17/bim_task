<?php

namespace App\Services;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ReportingService
{
    public function generateReport(string $startDate, string $endDate)
    {
        $reports = Transaction::join('payments', 'transactions.id', '=', 'payments.transaction_id')
            ->select(
                DB::raw('MONTH(payments.paid_on) as month'),
                DB::raw('YEAR(payments.paid_on) as year'),
                DB::raw('SUM(payments.amount) as paid'),
                DB::raw('SUM(CASE WHEN transactions.due_on > NOW() AND (transactions.amount + transactions.vat_amount) > transactions.total_paid_amount  THEN (transactions.amount + transactions.vat_amount) - transactions.total_paid_amount ELSE 0 END) as outstanding'),
                DB::raw('SUM(CASE WHEN transactions.due_on < NOW() AND (transactions.amount + transactions.vat_amount) > transactions.total_paid_amount  THEN (transactions.amount + transactions.vat_amount) - transactions.total_paid_amount ELSE 0 END) as overdue')
            )
            ->whereBetween('payments.paid_on', [$startDate, $endDate])
            ->groupBy(DB::raw('YEAR(payments.paid_on)'), DB::raw('MONTH(payments.paid_on)'))
            ->orderBy(DB::raw('YEAR(payments.paid_on)'))
            ->get();

        return $reports->toArray();
    }

//    public function generateReport(string $startDate, string $endDate)
//    {
//        $reports = Transaction::select(
//            DB::raw('MONTH(due_on) as month'),
//            DB::raw('YEAR(due_on) as year'),
//            DB::raw('SUM(CASE WHEN status = '. TransactionStatus::PAID->value .' THEN total_paid_amount ELSE 0 END) as paid'),
//            DB::raw('SUM(CASE WHEN status = '. TransactionStatus::OUTSTANDING->value .' THEN (amount + vat_amount) - total_paid_amount ELSE 0 END) as outstanding'),
//            DB::raw('SUM(CASE WHEN status = '. TransactionStatus::OVERDUE->value .' THEN (amount + vat_amount) - total_paid_amount ELSE 0 END) as overdue')
//        )
//            ->whereBetween('due_on', [$startDate, $endDate])
//            ->groupBy(DB::raw('YEAR(due_on)'), DB::raw('MONTH(due_on)'))
//            ->get();
//
//        return $reports->toArray();
//    }
}
