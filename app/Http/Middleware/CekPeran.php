<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekPeran
{
    public function handle(Request $request, Closure $next, string ...$peran): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->peran, $peran)) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}