<?php

namespace MBober35\RoleRule\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use MBober35\RoleRule\Events\UserRoleChange;
use Symfony\Component\Console\Output\BufferedOutput;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, "user");
    }

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

        if ($name = $request->get("name", false)) {
            $query->where("name", "like", "%{$name}%");
        }

        if ($email = $request->get("email", false)) {
            $query->where("email", "like", "%{$email}%");
        }

        $users = $query
            ->orderBy("name")
            ->paginate()
            ->appends($request->input());

        return view("mbober-admin::users.index", compact("users"));
    }

    /**
     * Форма добавления.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = Role::getForAdmin();

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
        $roles = Role::getForAdmin();

        $current = $user->role_ids;
        $showHidden = ! Auth::user()->isSuperUser() && $user->isSuperUser();
        return view("mbober-admin::users.edit", compact("user", "roles", "current", "showHidden"));
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

        $roles = $request->get("roles", []);
        
        // Что бы не убрать Админа у себя.
        $superId = Role::getSuperId();
        if ($user->id == Auth::id() && ! in_array($superId, $roles)) {
            $roles[] = $superId;
        }

        $user->roles()->sync($roles);
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

    /**
     * Получить ссылку на вход.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLink(User $user)
    {
        $output = new BufferedOutput;

        Artisan::call("login-link", [
            "email" => $user->email,
            "--get" => true,
        ], $output);

        return redirect()
            ->back()
            ->with("success", $output->fetch());
    }

    /**
     * Отправить ссылку на вход.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendLink(User $user)
    {
        $output = new BufferedOutput;

        Artisan::call("login-link", [
            "email" => $user->email,
        ], $output);

        return redirect()
            ->back()
            ->with("success", "Ссылка создана");
    }

    /**
     * Отправить ссылку текущему пользователю.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selfLink(User $user)
    {
        $output = new BufferedOutput;

        Artisan::call("login-link", [
            "email" => $user->email,
            "--send" => Auth::user()->email,
        ], $output);

        return redirect()
            ->back()
            ->with("success", "Ссылка создана");
    }
}
