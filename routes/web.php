<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página principal (pública)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

// Rutas protegidas (requieren login)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard con mapa y tabla
    Route::get('/dashboard', [VisitController::class, 'index'])->name('dashboard');

    // CRUD de visitas (sin create/edit porque están integrados en el dashboard)
    Route::resource('visits', VisitController::class)->except(['create', 'edit']);

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación generadas por Breeze o Jetstream
require __DIR__.'/auth.php';
