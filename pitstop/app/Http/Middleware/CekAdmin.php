<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekAdmin
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if ($user && $user->role === $role) {
            return $next($request);
        }

        if ($user?->role === User::ROLE_ADMIN) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
