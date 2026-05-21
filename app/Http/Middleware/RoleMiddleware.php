<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, string $role): Response
    {
       
        if (!Auth::check()) {
            return redirect('login');
        }


        if ($request->user()->role !== $role) {
            
            return redirect('/dashboard')->with('error', 'Access Denied: You do not have ' . $role . ' privileges.');
        }

        return $next($request);
    }
}