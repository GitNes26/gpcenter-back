<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('gpCenter')->group(function () {
    Route::get('/', function () {
        return 'API GPCenter';
    });
    include_once "gpcenter.routes.php";
});
