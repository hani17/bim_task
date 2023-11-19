<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class AuthException extends BaseException
{
    public static function invalidCredentials(): static
    {
        return static::make(
            __('auth.failed'),
            Response::HTTP_UNAUTHORIZED
        );
    }
}
