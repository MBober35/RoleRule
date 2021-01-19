<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleRule\UserController;
use App\Http\Controllers\RoleRule\RoleController;

Route::group([
    "middleware" => ["web", "auth", "management"],
    "prefix" => "admin",
    "as" => "admin.",
], function () {
    Route::get("/", [AdminController::class, "index"]);

    Route::resource("users", UserController::class);

    Route::group([
        "prefix" => "users/{user}",
        "as" => "users.",
    ], function () {
        Route::post("get-link", [UserController::class, "getLink"])
            ->name("get-link");
        Route::post("send-link", [UserController::class, "sendLink"])
            ->name("send-link");
        Route::post("self-link", [UserController::class, "selfLink"])
            ->name("self-link");
    });

    Route::group([
        "middleware" => ["role-master"],
    ], function () {
        Route::resource("roles", RoleController::class);
        Route::group([
            "as" => "roles.",
            "prefix" => "/roles/{role}/{rule}",
        ], function () {
            Route::get("/", [RoleController::class, "show"])
                ->name("rule");
            Route::put("/", [RoleController::class, "updateRule"]);
            Route::post("/", [RoleController::class, "defaultRules"]);
        });
    });
});