<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTransactionRequest;
use App\Http\Resources\Admin\TransactionResource;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function __construct(protected TransactionService $transactionService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransactionResource::collection(
            $this->transactionService->getTransactions()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $this->transactionService->createTransaction($request->validated());
        return response()->json(
            ['message' => 'Transaction created successfully'],
            Response::HTTP_CREATED
        );
    }

}
