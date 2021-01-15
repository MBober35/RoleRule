<?php

namespace MBober35\RoleRule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MBober35\Helpers\Traits\ShouldSlug;

class RoleModel extends Model
{
    use HasFactory, ShouldSlug;

    protected $fillable = [
        "key",
        "title",
    ];

    protected $routeKey = "key";
}
