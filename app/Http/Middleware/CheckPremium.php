<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPremium
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user || !$user->is_premium || now()->greaterThan($user->premium_expires_at)) {
        return redirect()->route('premium.form')->with('error', 'Bạn cần đăng ký Premium để xem nội dung này.');
    }
        return $next($request);
    }
}
