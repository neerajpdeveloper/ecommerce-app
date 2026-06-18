<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        // 🔥 ADMIN BYPASS (FULL ACCESS)
        if ($user->role && $user->role->slug === 'admin') {
            return $next($request);
        }

        // 🔐 NORMAL USER CHECK
        if (!$user->hasPermission($permission)) {
            abort(403, 'Access Denied');
        }

        return $next($request);
    }
}