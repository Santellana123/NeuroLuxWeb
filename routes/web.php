<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SeguimientoController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscriptionController;

// --- RUTAS PÚBLICAS ---
Auth::routes(['register' => false, 'verify' => true]);

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'store'])->name('registro.store');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/nosotros', [PageController::class, 'about'])->name('nosotros.index');

// --- RUTAS PROTEGIDAS (REQUIEREN INICIO DE SESIÓN) ---
Route::middleware('auth')->group(function () {

    // Blog
    Route::post('/blog', [BlogController::class, 'storePost'])->name('blog.storePost');
    Route::put('/blog/{post}', [BlogController::class, 'updatePost'])->name('blog.updatePost');

    // Likes
    Route::post('/blog/{post}/like', [BlogController::class, 'toggleLike'])->name('blog.toggleLike');

    // Comentarios
    Route::get('/blog/{post}/comments', [BlogController::class, 'getComments'])->name('comments.list');
    Route::post('/blog/{post}/comment', [BlogController::class, 'storeComment'])->name('comments.store');

    // Perfil
    Route::post('/profile/update-photo', [AuthController::class, 'updateProfilePhoto'])->name('profile.update-photo');

    // Seguimiento (requiere suscripción activa)
    Route::middleware('check.subscription')->group(function () {
        Route::get('/seguimiento', [SeguimientoController::class, 'index'])->name('seguimiento.index');
        Route::get('/seguimiento/crear', [SeguimientoController::class, 'create'])->name('seguimiento.create');
        Route::post('/seguimiento', [SeguimientoController::class, 'store'])->name('seguimiento.store');
        Route::get('/seguimiento/child/{child}', [SeguimientoController::class, 'show'])->name('seguimiento.show');
    });

    // Suscripciones
    Route::get('/planes', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/upgrade', [SubscriptionController::class, 'upgrade'])->name('subscriptions.upgrade');
});
