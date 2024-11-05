<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearSessionMessages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Clear specific session messages after response
        if ($request->session()->has('success') ||
            $request->session()->has('error') ||
            $request->session()->has('updated') ||
            $request->session()->has('deleted')) {
                
            // Clear the session messages
            $request->session()->forget('success');
            $request->session()->forget('error');
            $request->session()->forget('updated');
            $request->session()->forget('deleted');
        }

        return $response;
    }
}
