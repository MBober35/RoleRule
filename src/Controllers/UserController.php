<?php

namespace MBober35\RoleRule\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use MBober35\RoleRule\Events\UserRoleChange;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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

    /**
     * Форма добавления.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::query()
            ->select("title", "id")
            ->orderBy("title")
            ->get();

        return view("mbober-admin::users.create", compact("roles"));
    }

    /**
     * Создание пользователя.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->storeValidator($request->all());

        $user = User::create($request->all());
        /**
         * @var User $user
         */
        $user->save();
        $user->roles()->sync($request->get("roles", []));
        return redirect()
            ->route("admin.users.show", compact("user"))
            ->with("success", "Пользователь успешно добавлен");
    }

    /**
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function storeValidator(array $data)
    {
        Validator::make($data, [
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", "unique:users,email"],
            "password" => ["required", "string", "min:8", "confirmed"],
        ], [], [
            "name" => "Имя",
            "email" => "E-mail",
            "password" => "Пароль",
        ])->validate();
    }

    /**
     * Просмотр пользователя.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view("mbober-admin::users.show", compact("user"));
    }

    /**
     * Редактирование.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::query()
            ->select("title", "id")
            ->orderBy("title")
            ->get();

        $current = $user->role_ids;
        return view("mbober-admin::users.edit", compact("user", "roles", "current"));
    }

    /**
     * Обновление.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user)
    {
        $this->updateValidator($request->all(), $user);
        $user->update($request->all());

        $user->roles()->sync($request->get("roles", []));
        UserRoleChange::dispatch($user);
        return redirect()
            ->route("admin.users.show", compact("user"))
            ->with("success", "Пользователь успешно обновлен");
    }

    /**
     * @param array $data
     * @param User $user
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateValidator(array $data, User $user)
    {
        $id = $user->id;
        Validator::make($data, [
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", "unique:users,email,{$id}"],
        ], [], [
            "name" => "Имя",
            "email" => "E-mail",
        ])->validate();
    }

    /**
     * Удаление пользователя.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()
            ->route("admin.users.index")
            ->with("success", "Пользователь успешно удален");
    }
}
