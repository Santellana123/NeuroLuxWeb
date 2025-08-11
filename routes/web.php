<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Auth;

// Rutas de autenticación de Laravel.
// Deshabilitamos el registro para usar nuestra ruta personalizada,
// pero habilitamos las rutas para la verificación de correo electrónico.
Auth::routes(['register' => false, 'verify' => true]);

// Tus rutas de registro personalizadas.
Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'store'])->name('registro.store');

// Rutas de tu aplicación
// La ruta principal debe tener un nombre descriptivo, como 'home'.
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

// Rutas protegidas que solo pueden acceder usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::post('/blog', [BlogController::class, 'storePost'])->name('blog.storePost');
    Route::post('/blog/{post}/comment', [BlogController::class, 'storeComment'])->name('blog.storeComment');
    Route::post('/blog/{post}/like', [BlogController::class, 'toggleLike'])->name('blog.toggleLike');
    Route::post('/blog/{post}/edit', [BlogController::class, 'updatePost'])->name('blog.updatePost');

    // Nueva ruta para actualizar la foto de perfil
    Route::post('/profile/update-photo', [AuthController::class, 'updateProfilePhoto'])->name('profile.update-photo');
});
