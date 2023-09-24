<?php

namespace Tests\Unit;

use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    /**
     * Subscription not found error
     */
    public function testSubscriptionNotFoundError(): void
    {
        $this->login();

        $response = $this->post('api/user/9999/subscription', [
            'renewed_at' => now()->format('Y-m-d'),
            'expired_at' => now()->addMonth(1)->format('Y-m-d')
        ]);

        $response->assertStatus(404);
    }

    /**
     * Subscription renewed_at validation error
     */
    public function testSubscriptionRenewedAtValidationError(): void
    {
        $this->login();

        $response = $this->post('api/user/2/subscription', [
            'renewed_at' => '',
            'expired_at' => now()->addMonth(1)->format('Y-m-d')
        ]);

        $response->assertStatus(422);
    }

        /**
     * Subscription expired_at validation error
     */
    public function testSubscriptionExpiredAtValidationError(): void
    {
        $this->login();

        $response = $this->post('api/user/2/subscription', [
            'renewed_at' => now()->format('Y-m-d'),
            'expired_at' => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * Subscription added successfully
     */
    public function testAddSubscriptionSuccessfully(): void
    {
        $this->login();

        $response = $this->post('api/user/2/subscription', [
            'renewed_at' => now()->format('Y-m-d'),
            'expired_at' => now()->addMonth(1)->format('Y-m-d')
        ]);

        $response->assertStatus(201);
    }

    /**
     * Subscription updated successfully
     */
    public function testUpdateSubscriptionSuccessfully(): void
    {
        $this->login();

        $response = $this->put('api/user/2/subscription/2', [
            'renewed_at' => now()->format('Y-m-d'),
            'expired_at' => now()->addMonth(1)->format('Y-m-d')
        ]);

        $response->assertStatus(200);
    }

    /**
     * Subscription list by user id
     */
    public function testListSubscriptionSuccessfully(): void
    {
        $this->login();

        $response = $this->get('api/user/2');

        $response->assertStatus(200);
    }

    /**
     * Subscription deleted successfully
     */
    // public function testDeleteSubscriptionSuccessfully(): void
    // {
    //     $this->login();

    //     $response = $this->delete('api/user/1/subscription');

    //     $response->assertStatus(200);
    // }
}
