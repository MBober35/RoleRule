<?php

namespace MBober35\RoleRule\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Role::query();
        if ($title = $request->get("title", false)) {
            $query->where("title", "like", "%$title%");
        }
        $query->orderBy("title");
        $roles = $query
            ->paginate()
            ->appends($request->input());

        $perPage = $roles->perPage();
        $page = $roles->currentPage();
        return view("mbober-admin::roles.index", compact("request", "roles", "perPage", "page"));
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
    public function show(Role $role, Rule $rule = null)
    {
        $rules = Rule::query()
            ->orderBy("title")
            ->get();

        if ($rules->count() && empty($rule)) {
            $rule = $rules->first();
            return redirect()
                ->route("admin.roles.rule", compact("role", "rule"));
        }
        return view("mbober-admin::roles.show", compact("role", "rules", "rule"));
    }

    public function updateRule(Role $role, Rule $rule)
    {
        return redirect()
            ->back();
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
        $role->delete();

        return redirect()
            ->route("admin.roles.index")
            ->with("success", "Роль успешно удалена");
    }
}
