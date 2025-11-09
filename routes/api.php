<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\MenusController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('branches', BranchesController::class);
Route::apiResource('menus', MenusController::class);
