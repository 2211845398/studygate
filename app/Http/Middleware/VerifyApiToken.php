<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $validToken = config('services.api_access_token');

        // إذا لم يتم إعداد توكن في النظام، نرفض الطلب للأمان
        if (!$validToken) {
            return response()->json([
                'success' => false,
                'message' => 'API configuration error: No access token configured.'
            ], 500);
        }

        if ($token !== $validToken) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid access token.'
            ], 401);
        }

        return $next($request);
    }
}
