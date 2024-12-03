<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('sanctum')->check() && Auth::guard('sanctum')->user()->status == 0)
        {
            //if user blocked
            auth('sanctum')->user()->currentAccessToken()->delete();
            return responseApi(403, 'User blocked');
        }
        if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->status == 0)
        {
            //if user blocked
            auth('admin')->user()->currentAccessToken()->delete();
            return responseApi(403, 'User blocked');
        }
        return $next($request);
    }
}
