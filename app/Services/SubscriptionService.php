<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionService
{
    public function list(int $id): Collection
    {
        return Subscription::with('transactions')->whereHas('subscriptionUser', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();
    }

    public function create(int $userId, array $validatedData): Subscription
    {
        $user = User::findOrFail($userId);

        return $user->subscriptions()->create($validatedData);
    }

    public function update(int $userId, int $subscriptionId, array $validatedData): Subscription
    {
        $user = User::findOrFail($userId);

        $subscription = $user->subscriptions()->findOrFail($subscriptionId);
        $subscription->update($validatedData);

        return $subscription;
    }

    public function delete(int $userId): int
    {
        $user = User::findOrFail($userId);

        return $user->subscriptions()->delete();
    }

    public function expiredSubscriptions(): Collection
    {
        return Subscription::with('subscriptionUser')->whereDate('expired_at', '=', now()->format('Y-m-d'))->get();
    }

    public function renew(int $subscriptionId): Subscription
    {
        $subscription = Subscription::findOrFail($subscriptionId);

        $subscription->update([
            'renewed_at' => now(),
            'expired_at' => now()->addMonth()
        ]);

        return $subscription;
    }
}
