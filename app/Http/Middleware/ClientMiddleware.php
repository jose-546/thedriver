<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
{
    if (!Auth::check()) {
        // Stocker l'URL actuelle avant la redirection
        session(['url.intended' => $request->url()]);
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
    }

    if (!Auth::user()->isClient()) {
        return redirect()->route('admin.dashboard')->with('error', 'Accès refusé. Cette zone est réservée aux clients.');
    }

    return $next($request);   }
}