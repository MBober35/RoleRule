<?php
use Illuminate\Support\Facades\Route;

Route::group([
    "middleware" => ["web", "auth", "management"],
    "prefix" => "admin",
    "as" => "admin.",
], function () {
    Route::get("/", [\App\Http\Controllers\AdminController::class, "index"]);

    Route::resource("users", \App\Http\Controllers\RoleRule\UserController::class);

    Route::group([
        "middleware" => ["role-master"],
    ], function () {
        Route::resource("roles", \App\Http\Controllers\RoleRule\RoleController::class);
        Route::group([
            "as" => "roles.",
            "prefix" => "/roles/{role}/{rule}",
        ], function () {
            Route::get("/", [\App\Http\Controllers\RoleRule\RoleController::class, "show"])
                ->name("rule");
            Route::put("/", [\App\Http\Controllers\RoleRule\RoleController::class, "updateRule"]);
            Route::post("/", [\App\Http\Controllers\RoleRule\RoleController::class, "defaultRules"]);
        });
    });
});