<?php

use App\Http\Controllers\GameLikeController;
use App\Http\Controllers\GameBougthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "user"], function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get("/", [UserController::class, "show"])->name("show");
        Route::put("/{id}", [UserController::class, "update"])->name("update");
        Route::delete("/", [UserController::class, "destroy"])->name("destroy");
    });
});


Route::group(["prefix" => "/auth"], function () {
    Route::post("/login", [LoginController::class, "login"])->name("login");
    Route::post("/register", [UserController::class, "store"])->name("store");
});

Route::group(["prefix" => "/games/like"], function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post("/", [GameLikeController::class, "store"])->name("store");
        Route::delete("/{id}", [GameLikeController::class, "destroy"])->name("destroy");
    });
});

Route::group(["prefix" => "/games/buy"], function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post("/", [GameBougthController::class, "store"])->name("store");
        Route::delete("/{id}", [GameBougthController::class, "destroy"])->name("destroy");
    });
});