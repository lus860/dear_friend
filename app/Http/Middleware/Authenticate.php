<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');
        if (Auth::check()) {
            // User is authenticated, proceed to the next middleware or route handler
            return $next($request);
        } else {
            // User is not authenticated, you can customize the response or redirect as needed
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

}
