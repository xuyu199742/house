<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Log;
use App\Models\SystemLog;

/**
 * Class SystemLogMiddleware
 *
 */
class SystemLogMiddleware
{
    protected $except = [
        'admin/systemlog',
        'admin/log-viewer',
    ];

    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $request_path = $request->path();
        foreach ($this->except as $path) {
            if (Str::startsWith($request_path, $path)) {
                return;
            }
        }

        try {
            SystemLog::record($request, $response);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
