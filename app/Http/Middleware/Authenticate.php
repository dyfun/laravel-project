<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $response = [
            'code' => 403,
            'message' => 'Forbidden',
            'data' => null,
            'errors' => null
        ];

        return $request->expectsJson() ? null : abort(response()->json($response, 403));
    }
}
