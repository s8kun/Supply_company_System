<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Ensure the authenticated user has one of the allowed roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $allowed = array_map('strtolower', $roles);
        $currentRole = strtolower((string) $user->role);

        if (!in_array($currentRole, $allowed, true)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden.',
            ], 403);
        }

        return $next($request);
    }
}
