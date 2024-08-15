<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpleadoController;
use App\Models\Empleado;

Route::get('/', function () {
    return view('auth.login');
});

//Route::get('/empleado', function () {
   // return view('empleado.index');
//});
//Route::get('empleado/create',[EmpleadoController::class,'create']);

Route::resource('empleado', EmpleadoController::class)->middleware('auth');
Auth::routes(['register'=>false,'reset'=>false ]);

Route::get('/register', 'Auth\RegisterController@showRegistrationForm');

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){


    Route::get('/', [EmpleadoController::class, 'index'])->name('home');


});
//Auth::routes();

//Route::get('/home', [EmpleadoController::class, 'index'])->name('home');
