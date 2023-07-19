<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AttachAPIKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('API-key', 'YOUR_API_KEY');

        return $next($request);
    }
}
