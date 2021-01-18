<?php


namespace MBober35\RoleRule\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SuperUser
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()) return redirect("login");

        if (! Gate::allows("settings-management")) {
            abort(403, trans("Access denied"));
        }
        return $next($request);
    }
}