<?php
namespace App\Academic;

final class IsolationMiddleware
{
    public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        if (!in_array($request->getHost(), ['127.0.0.1', 'localhost', '::1'], true) || !in_array($request->ip(), ['127.0.0.1', '::1'], true)) {
            abort(403, 'Solo se aceptan conexiones locales.');
        }
        $paths = ['/' => ['GET'], '/login' => ['GET', 'POST'], '/logout' => ['POST'], '/dashboard' => ['GET'], '/customers' => ['GET'], '/contracts' => ['GET'], '/invoices' => ['GET'], '/payments' => ['GET'], '/demo/yape' => ['GET', 'POST']];
        if (!isset($paths[$request->getPathInfo()]) || !in_array($request->method(), $paths[$request->getPathInfo()], true)) { abort(404); }
        IsolationGuard::assertDatabase(base_path(), config('database.default'), config('database.connections.sqlite.database'), config('app.env'));
        return $next($request);
    }
}
