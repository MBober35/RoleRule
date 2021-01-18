<?php
use Illuminate\Support\Facades\Route;

Route::group([
    "middleware" => ["web", "auth", "management"],
    "prefix" => "admin",
    "as" => "admin.",
], function () {
    Route::get("/", [\App\Http\Controllers\AdminController::class, "index"]);

    Route::resource("roles", \App\Http\Controllers\RoleRule\RoleController::class);
});