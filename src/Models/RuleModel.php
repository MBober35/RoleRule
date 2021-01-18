<?php

namespace MBober35\RoleRule\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MBober35\Helpers\Traits\ShouldSlug;

class RuleModel extends Model
{
    use HasFactory, ShouldSlug;

    protected $fillable = [
        "title",
        "policy",
        "slug",
    ];

    /**
     * Роли.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot("rights");
    }

    /**
     * Доступне права.
     *
     * @return array
     */
    public function getPermitListAttribute()
    {
        $class = $this->policy;
        if (class_exists($class) && method_exists($class, "getPermissions")) {
            return $class::getPermissions();
        }
        return [];
    }
}
