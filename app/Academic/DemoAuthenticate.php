<?php
namespace App\Academic;

final class DemoAuthenticate
{
    public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        return \Illuminate\Support\Facades\Auth::check() ? $next($request) : redirect('/login');
    }
}
