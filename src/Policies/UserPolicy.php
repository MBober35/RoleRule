<?php

namespace MBober35\RoleRule\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use MBober35\RoleRule\Traits\ShouldRule;

class UserPolicy
{
    use HandlesAuthorization, ShouldRule;

    const VIEW_ALL = 2;
    const VIEW = 4;
    const CREATE = 8;
    const UPDATE = 16;
    const DESTROY = 32;

    /**
     * @inheritDoc
     *
     * @return string[]
     */
    public static function getPermissions()
    {
        return [
            self::VIEW_ALL => "Просмотр всех",
            self::VIEW => "Просмотр",
            self::CREATE => "Создание",
            self::UPDATE => "Обновление",
            self::DESTROY => "Удаление",
        ];
    }

    /**
     * @inheritDoc
     *
     * @return int
     */
    public static function defaultRules()
    {
        return self::VIEW_ALL + self::VIEW + self::CREATE + self::UPDATE + self::DESTROY;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $this->checkPermit($user, self::VIEW_ALL);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $this->checkPermit($user, self::VIEW);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->checkPermit($user, self::CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $this->checkPermit($user, self::UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $this->checkPermit($user, self::DESTROY);
    }
}
