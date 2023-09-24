<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function login()
    {
        $user = User::where('email', 'gulertayfun@outlook.com')->firstOrFail();

        $this->actingAs($user);
    }
}
