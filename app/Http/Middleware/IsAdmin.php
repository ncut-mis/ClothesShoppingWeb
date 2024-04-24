<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 檢查當前用戶是否登入且是管理員
        if (!auth()->check() || !auth()->user()->is_admin) {
            // 如果不是管理員，則重定向到首頁
            return redirect('/home')->with('error', 'You do not have access to this section.');
        }
        return $next($request);
    }
}
