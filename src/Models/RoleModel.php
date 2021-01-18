<?php

namespace MBober35\RoleRule\Models;

use App\Models\Role;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
        return ! empty(Role::DEFAULT_ROLES[$this->key]);
    }

    /**
     * Получить роли для создания или редактирования.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getForAdmin()
    {
        $roles = Role::query()
            ->select("title", "id");
        if (! Auth::user()->isSuperUser()) {
            $roles->where("key", "!=", Role::SUPER);
        }
        return $roles
            ->orderBy("title")
            ->get();
    }

    /**
     * Получить id главной роли.
     *
     * @return false|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public static function getSuperId()
    {
        $id = Role::query()
            ->select("id")
            ->where("key", Role::SUPER)
            ->first();
        if (empty($id)) return false;
        return $id->id;
    }
}
