<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tokens;

class ApiTokenControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->tokenControl($request)) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    public function tokenControl(Request $request): bool
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return false;
        }

        $token = explode(' ', $token)[1];
        $token = Tokens::where('token', $token)->first();
        if (!$token) {
            return false;
        }

        return true;
    }
}
