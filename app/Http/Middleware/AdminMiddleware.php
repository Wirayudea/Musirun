<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is not logged in, redirect to login
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        $user = Auth::user();

        // If user doesn't have role 'admin', redirect to home with message
        if (!isset($user->role) || $user->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return $next($request);
    }
}
