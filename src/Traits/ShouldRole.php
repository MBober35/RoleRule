<?php

namespace MBober35\RoleRule\Traits;

use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

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
    public function getRoleKeysAttribute()
    {
        $user = $this;
        return Cache::rememberForever("user-role-keys:{$this->id}", function () use ($user) {
            return $user->roles()
                ->select("key")
                ->pluck("key")
                ->toArray();
        });
    }

    /**
     * Получить id ролей.
     *
     * @return mixed
     */
    public function getRoleIdsAttribute()
    {
        $user = $this;
        return Cache::rememberForever("user-role-ids:{$this->id}", function () use ($user) {
            return $user->roles()
                ->select("id")
                ->pluck("id")
                ->toArray();
        });
    }

    /**
     * Хэш пароля при сохранении.
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value)) {
            $this->attributes["password"] = Hash::make($value);
        }
    }

    /**
     * Очистить кэш ролей.
     */
    public function clearRolesCache()
    {
        Cache::forget("user-role-keys:{$this->id}");
        Cache::forget("user-role-ids:{$this->id}");
    }

    /**
     * Проверка наличия роли.
     *
     * @param $role
     * @return mixed
     */
    public function hasRole($role)
    {
        $keys = $this->role_keys;
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