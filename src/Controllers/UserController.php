<?php

namespace MBober35\RoleRule\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->with("roles");

        // TODO: add filters

        $users = $query
            ->orderBy("name")
            ->paginate()
            ->appends($request->input());
        return view("mbober-admin::users.index", compact("users", "request"));
    }

    public function create()
    {
        return view("mbober-admin::users.create");
    }
}
