<?php

namespace App\Http\Controllers\V1\Customer;

use App\Http\Resources\Customer\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransactionController
{
    public function __construct(protected TransactionService $transactionService)
    {
    }

    public function getTransactions(): AnonymousResourceCollection
    {
        return TransactionResource::collection(
            $this->transactionService->getAuthUserTransactions()
        );
    }

}
