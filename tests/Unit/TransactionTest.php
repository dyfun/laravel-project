<?php

namespace Tests\Unit;

use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * Transaction subscription_id validation error
     */
    public function testTransactionSubscriptionIdValidationError(): void
    {
        $this->login();

        $response = $this->post('api/user/2/transaction', [
            'subscription_id' => '',
            'price' => 150
        ]);

        $response->assertStatus(422);
    }

    /**
     * Transaction price validation error
     */
    public function testTransactionPriceValidationError(): void
    {
        $this->login();

        $response = $this->post('api/user/2/transaction', [
            'subscription_id' => 1,
            'price' => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * Transaction 404 error
     */
    public function testTransactionNotFoundError(): void
    {
        $this->login();

        $response = $this->post('api/user/9999/transaction', [
            'subscription_id' => 1,
            'price' => 150
        ]);

        $response->assertStatus(404);
    }

    /**
     * Transaction added successfully
     */
    public function testAddTransactionSuccessfully(): void
    {
        $this->login();

        $response = $this->post('api/user/2/transaction', [
            'subscription_id' => 2,
            'price' => 150
        ]);

        $response->assertStatus(201);
    }
}
