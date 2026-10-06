<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek user login via guard 'api'
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated. Silakan login terlebih dahulu.',
            ], 401);
        }

        return $next($request);
    }
}