<?php

namespace App\Services;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ReportingService
{
    public function generateReport(string $startDate,string $endDate)
    {
        $reports = Transaction::select(
            DB::raw('MONTH(due_on) as month'),
            DB::raw('YEAR(due_on) as year'),
            DB::raw('SUM(CASE WHEN status = '. TransactionStatus::PAID->value .' THEN total_paid_amount ELSE 0 END) as paid'),
            DB::raw('SUM(CASE WHEN status = '. TransactionStatus::OUTSTANDING->value .' THEN (amount + vat_amount) - total_paid_amount ELSE 0 END) as outstanding'),
            DB::raw('SUM(CASE WHEN status = '. TransactionStatus::OVERDUE->value .' THEN (amount + vat_amount) - total_paid_amount ELSE 0 END) as overdue')
        )
            ->whereBetween('due_on', [$startDate, $endDate])
            ->groupBy(DB::raw('YEAR(due_on)'), DB::raw('MONTH(due_on)'))
            ->get();

        return $reports->toArray();
    }
}
