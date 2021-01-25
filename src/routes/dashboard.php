<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::group([
    "middleware" => ["web", "auth", "management"],
    "prefix" => "admin",
    "as" => "admin.",
], function () {
    Route::get("/", [AdminController::class, "index"])->name("dashboard");
});