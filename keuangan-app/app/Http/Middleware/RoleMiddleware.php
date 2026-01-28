<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request)  $next
     * @param  string  $role  // bisa "admin" atau "admin|ceo"
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $roles = explode('|', $role);

        if (!in_array(Auth::user()->role, $roles)) {
            // Lebih profesional: langsung 403 Forbidden
            abort(Response::HTTP_FORBIDDEN, 'Akses ditolak!');
        }

        return $next($request);
    }
}
