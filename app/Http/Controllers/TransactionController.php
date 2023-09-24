<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionCollection;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $transactionService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request, int $userId): JsonResponse
    {
        $transaction = $this->transactionService->create($userId, $request->validated());

        $response = [
            'code' => 201,
            'message' => 'Transaction added successfully',
            'data' => new TransactionCollection($transaction),
            'errors' => null
        ];

        return response()->json($response, 201);
    }
}
