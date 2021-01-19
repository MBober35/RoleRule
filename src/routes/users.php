<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleRule\UserController;

Route::group([
    "middleware" => ["web", "auth", "management"],
    "prefix" => "admin",
    "as" => "admin.",
], function () {
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
});