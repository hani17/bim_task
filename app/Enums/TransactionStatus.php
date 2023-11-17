<?php

namespace App\Enums;

enum TransactionStatus: int
{
    case PAID = 1;
    case OUTSTANDING = 2;
    case OVERDUE = 3;
}
