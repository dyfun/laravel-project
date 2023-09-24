<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * User register successfully
     */
    public function testRegisterSuccessfully(): void
    {
        $response = $this->post('api/register', [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'unittest123'
        ]);

        $response->assertStatus(201);
    }

    /**
     * User register name validation error
     */
    public function testRegisterNameValidationError(): void
    {
        $response = $this->post('api/register', [
            'name' => '',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'unittest123'
        ]);

        $response->assertStatus(422);
    }

    /**
     * User register email validation error
     */
    public function testRegisterEmailValidationError(): void
    {
        $response = $this->post('api/register', [
            'name' => fake()->name(),
            'email' => '',
            'password' => 'unittest123'
        ]);

        $response->assertStatus(422);
    }

    /**
     * User register password validation error
     */
    public function testRegisterPasswordValidationError(): void
    {
        $response = $this->post('api/register', [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * User register exist user validation error
     */
    public function testRegisterExistValidationError(): void
    {
        $response = $this->post('api/register', [
            'name' => 'Tayfun Güler',
            'email' => 'gulertayfun@outlook.com',
            'password' => 'helloworld'
        ]);

        $response->assertStatus(422);
    }
}
