<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Nếu người dùng đã đăng nhập, lấy user_id từ user hiện tại
            $userId = Auth::user()->id;
        } else {
            // Nếu không, tạo một session_id mới
            $userId = $request->session()->getId();
        }

        // Gán id hoặc session_id vào request
        $request->merge(['user_id' => $userId]);

        return $next($request);
    }
}
