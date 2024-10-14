<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetInstitution
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            // Check if the institution is null (consider as Super Admin)
            if (is_null($user->institution)) {
                // Super Admin, grant access to all institutions
                $request->attributes->set('institution', 'all');
            } else {
                // Regular user, set their institution
                $request->attributes->set('institution', $user->institution);
            }
        }

        return $next($request);
    }
}
