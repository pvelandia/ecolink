<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Por favor, inicia sesión.');
        }
    
        if (auth()->user()->role->name !== $role) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
        }
    
        return $next($request);
    }
    
}
