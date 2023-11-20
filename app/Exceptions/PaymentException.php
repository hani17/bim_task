<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class PaymentException extends BaseException
{
    public static function fullyPaid(): static
    {
        return static::make(
            'transaction is fully paid',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
