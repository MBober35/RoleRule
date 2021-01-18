<?php

namespace MBober35\RoleRule\Models;

use App\Models\Rule;
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
     * Пользователи.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Права доступа.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rules()
    {
        return $this->belongsToMany(Rule::class)->withPivot("rights");
    }

    /**
     * Стандартная роль.
     *
     * @return bool
     */
    public function getDefaultAttribute()
    {
        return ! empty(self::DEFAULT_ROLES[$this->key]);
    }
}
