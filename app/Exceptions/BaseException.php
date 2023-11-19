<?php

namespace App\Exceptions;

class BaseException extends \Exception
{
    public function __construct(
        public $message = 'invalid data',
        public $code = 200,
    ) {
        parent::__construct($message, $code);
    }

    public static function make(string $errorMessage = 'invalid data', int $statusCode = 200): static
    {
        return new static(
            $errorMessage,
            $statusCode,
        );
    }
}
