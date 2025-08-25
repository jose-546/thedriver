<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Zone réservée aux administrateurs.');
        }

        return $next($request);
    }
}