<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "users"], function () {
    Route::get("/", [UserController::class, "index"])->name("index");
    Route::get("/{id}", [UserController::class, "show"])->name("show")->middleware("auth:sanctum");
    Route::post("/", [UserController::class, "store"])->name("store");
    Route::put("/{id}", [UserController::class, "update"])->name("update");
    Route::delete("/{id}", [UserController::class, "destroy"])->name("destroy");
});


Route::group(["prefix"=> "/auth"], function () {
    Route::post("/", [LoginController::class,"login"])->name("login");
});