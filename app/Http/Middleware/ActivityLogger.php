<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class ActivityLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Procesa la solicitud primero
        $response = $next($request);

        // Crea el registro en un try-catch para no romper el flujo
        try {
            Log::create([
                'user_id' => optional($request->user())->id,
                'method'  => $request->method(),
                'path'    => $request->path(),
                'action'  => Route::currentRouteName()      // cards.store, etc.
                               ?? Route::currentRouteAction(), // App\Http\Controllers…
                'ip'      => $request->ip(),
            ]);
        } catch (\Throwable $e) {
            report($e); // registra en logs de Laravel pero no detiene la respuesta
        }

        return $response;
    }
}
