<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleRule\RoleController;

Route::group([
    "middleware" => ["web", "auth", "management"],
    "prefix" => "admin",
    "as" => "admin.",
], function () {
    Route::group([
        "middleware" => ["role-master"],
    ], function () {
        Route::resource("roles", RoleController::class);
        Route::group([
            "as" => "roles.",
            "prefix" => "/roles/{role}",
        ], function () {
            Route::get("list/users", [RoleController::class, "users"])
                ->name("users");
            Route::group([
                "prefix" => "{rule}"
            ], function () {
                Route::get("/", [RoleController::class, "show"])
                    ->name("rule");
                Route::put("/", [RoleController::class, "updateRule"]);
                Route::post("/", [RoleController::class, "defaultRules"]);
            });
        });
    });
});