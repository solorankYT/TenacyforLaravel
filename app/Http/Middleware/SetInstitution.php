<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Institution;

class SetInstitution
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            
            $institutionKey = $request->user()->institution;

            
            $institution = Institution::where('institution', $institutionKey)->first();

            if ($institution) { 
                // Set the institution on the request attributes
                $request->attributes->set('institution', $institution);
            } else {
                Log::warning('No institution found for user', [
                    'institution_key' => $institutionKey,
                ]);
            }
        }

        return $next($request);
    }
}
