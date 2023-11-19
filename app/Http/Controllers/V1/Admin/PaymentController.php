<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RecordePaymentRequest;
use App\Http\Resources\Admin\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function __construct(protected TransactionService $transactionService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function recordPayment(RecordePaymentRequest $request)
    {
        $transaction = $this->transactionService->recordPayment($request->validated());
        return response()->json(
            [
                'message' => 'Payment Recorded successfully',
                'data' => new TransactionResource(
                    $transaction->load(['payer', 'payments'])
                )
            ],
            Response::HTTP_CREATED
        );
    }

}
