<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        // Convert pipe-separated roles to array
        $allowedRoles = explode('|', $roles);

        // Check if user has any of the required roles
        foreach ($allowedRoles as $role) {
            if ($request->user()->tokenCan($role)) {
                return $next($request);
            }
        }

        return response()->json([
            'message' => 'Unauthorized for any of these roles: ' . $roles
        ], 403);
    }
}
