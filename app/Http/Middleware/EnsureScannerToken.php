<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureScannerToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user?->role !== 'admin' || ! $user->tokenCan('rpc:scan')) {
            return response()->json([
                'message' => 'Akses scanner hanya tersedia untuk token admin yang diizinkan.',
            ], 403);
        }

        return $next($request);
    }
}
