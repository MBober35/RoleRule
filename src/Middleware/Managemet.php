<?php

namespace MBober35\RoleRule\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class Managemet
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()) {
            return redirect("login");
        }
        if (! Gate::allows("app-management")) {
            abort(403, trans("Access denied"));
        }
        return $next($request);
    }
}