<?php

use app\Http\Controllers\estudiantesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function(){

    Route::prefix('estudiantes')->group(function() {
        Route::post('/', [estudiantesController::class,'store']);
    });

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
