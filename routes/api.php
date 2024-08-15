<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\UsersControllers;


Route::get('/empleados',[EmpleadoController::class,'apiget']);

//Route::get('/user',[] function (Request $request) {
  //  return $request->user();
//});
Route::post('/users',[UsersControllers::class,'apistore']);