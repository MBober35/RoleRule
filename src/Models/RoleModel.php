<?php

namespace MBober35\RoleRule\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MBober35\Helpers\Traits\ShouldSlug;

class RoleModel extends Model
{
    use HasFactory, ShouldSlug;

    const DEFAULT_ROLES = [
        "admin" => "Администратор",
        "editor" => "Редактор",
    ];

    const SUPER = "admin";

    protected $fillable = [
        "key",
        "title",
    ];

    protected $routeKey = "key";

    /**
     * Стандартная роль.
     *
     * @return bool
     */
    public function getDefaultAttribute()
    {
        return ! empty(self::DEFAULT_ROLES[$this->key]);
    }

    /**
     * Пользователи.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
