<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        try {
            LogModel::create([
                'user_id' => optional($request->user())->id,
                'action'  => $request->method(),
                'module'  => $request->route()->getName() ?? '',
                'ip'      => $request->ip(),
            ]);
        } catch (\Throwable $e) {
            report($e); // nunca interrumpe la petición
        }

        return $response;
    }
}
