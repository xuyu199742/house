<?php

namespace App\Http\Middleware;

use App\Models\Blacklist;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;

class BanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Blacklist::check()) {
            throw new HttpResponseException('暂时无法进行此操作，请和管理员联系', 401);
        }
        return $next($request);
    }
}
