<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home.index');
});

Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::get('/users/data/{offset}/{limit}', [\App\Http\Controllers\UserController::class, 'getData'])->name('users.data');

Route::post('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::get('/users/edit/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::post('/users/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('/users/delete/{id}', [\App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
Route::post('/change-password', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('change.password');


Route::get('sensors', [\App\Http\Controllers\SensorController::class, 'index'])->name('sensors');
Route::get('/sensors/data', [\App\Http\Controllers\SensorController::class, 'getData'])->name('sensors.data');





Route::get('login', [\App\Http\Controllers\AuthController::class,'login'])->name('login');


