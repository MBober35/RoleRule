<?php

namespace MBober35\RoleRule\Traits;

use App\Models\Role;
use Illuminate\Support\Facades\Cache;

trait ShouldRole
{
    /**
     * Роли пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Получить ключи ролей.
     *
     * @return bool
     */
    public function getRoleKeys()
    {
        $user = $this;
        return Cache::rememberForever("user-roles:{$this->id}", function () use ($user) {
            return $user->roles()
                ->select("key")
                ->pluck("key")
                ->toArray();
        });
    }

    /**
     * Очистить кэш ролей.
     */
    public function clearRolesCache()
    {
        Cache::forget("user-roles:{$this->id}");
    }

    /**
     * Проверка наличия роли.
     *
     * @param $role
     * @return mixed
     */
    public function hasRole($role)
    {
        $keys = $this->getRoleKeys();
        return in_array($role, $keys);
    }

    /**
     * Пользователь с доступом ко всему.
     *
     * @return mixed
     */
    public function isSuperUser()
    {
        return $this->hasRole(Role::SUPER);
    }
}