<?php

namespace MBober35\RoleRule\Models;

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
