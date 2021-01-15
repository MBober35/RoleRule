<?php

namespace MBober35\RoleRule\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("mbober-admin::roles.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("mbober-admin::roles.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->storeValidator($request->all());

        $role = Role::create($request->all());

        return redirect()
            ->route("admin.roles.show", compact("role"))
            ->with("success", "Роль успешно добавлена");
    }

    /**
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function storeValidator(array $data)
    {
        Validator::make($data, [
            "title" => ["required", "max:50", "unique:roles,title"],
            "key" => ["nullable", "max:50", "unique:roles,title"],
        ], [], [
            "title" => "Заголовок",
            "key" => "Адрес",
        ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view("mbober-admin::roles.show", compact("role"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view("mbober-admin::roles.edit", compact("role"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->updateValidator($request->all(), $role);
        $role->update($request->all());
        return redirect()
            ->route("admin.roles.show", compact("role"))
            ->with("success", "Успешно обновлено");
    }

    /**
     * @param array $data
     * @param Role $role
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateValidator(array $data, Role $role)
    {
        $id = $role->id;
        Validator::make($data, [
            "title" => ["required", "max:50", "unique:roles,title,{$id}"],
            "key" => ["nullable", "max:50", "unique:roles,key,{$id}"],
        ], [], [
            "title" => "Заголовок",
            "key" => "Адрес",
        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
