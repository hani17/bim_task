<?php

namespace App\Enums;

enum TransactionStatus: int
{
    case OUTSTANDING = 1;
    case OVERDUE = 2;
    case PAID = 3;

    public function text(): string
    {
        return match($this)
        {
            TransactionStatus::OUTSTANDING => 'Outstanding',
            TransactionStatus::OVERDUE => 'Overdue',
            TransactionStatus::PAID => 'Paid',
        };
    }
}
