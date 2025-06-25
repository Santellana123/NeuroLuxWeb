<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('Registro');
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('Login');
Route::post('/registro', [AuthController::class, 'store'])->name('Registro.store');

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
    return view('Home');
});
