<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubscriptionCollection;
use App\Http\Requests\SubscriptionRequest;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function __construct(private SubscriptionService $subscriptionService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function list(int $id): JsonResponse
    {
        $subscriptions = $this->subscriptionService->list($id);

        $response = [
            'code' => 200,
            'message' => 'Subscription lists',
            'data' => $subscriptions,
            'errors' => null
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request, int $userId): JsonResponse
    {
        $subscription = $this->subscriptionService->create($userId, $request->validated());

        $response = [
            'code' => 201,
            'message' => 'Subscription added successfully',
            'data' => new SubscriptionCollection($subscription),
            'errors' => null
        ];

        return response()->json($response, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionRequest $request, int $userId, int $subscriptionId): JsonResponse
    {
        $subscription = $this->subscriptionService->update($userId, $subscriptionId, $request->validated());

        $response = [
            'code' => 200,
            'message' => 'Subscription updated successfully',
            'data' => new SubscriptionCollection($subscription),
            'errors' => null
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->subscriptionService->delete($id);

        $response = [
            'code' => 200,
            'message' => 'Subscription delete successfully',
            'data' => null,
            'errors' => null
        ];

        return response()->json($response, 200);
    }
}
