<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\User;

class CheckUserRegistrationLimit
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
        $userCount = User::count();

        // Sesuaikan angka batasan sesuai kebutuhan Anda
        $registrationLimit = 50;

        if ($userCount >= $registrationLimit) {
            return response("Batas registrasi pengguna telah tercapai.", 403);
        }
        return $next($request);
    }
}
