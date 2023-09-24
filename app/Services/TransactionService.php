<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;

class TransactionService
{
    public function __construct(private readonly bool $paymentStatus = true)
    {
    }

    public function create(int $userId, array $validatedData): Transaction
    {
        $user = User::findOrFail($userId);
        $subscription = $user->subscriptions()->findOrFail($validatedData['subscription_id']);

        if($this->paymentStatus){
            return $subscription->transactions()->create(['price' => $validatedData['price'], 'status' => true]);
        }
    }
}
