<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:administrador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/productos', fn() => view('admin.productos'))
            ->name('productos');

        Route::get('/usuarios', fn() => view('admin.usuarios'))
            ->name('usuarios');

        Route::get('/reportes', fn() => view('admin.reportes'))
            ->name('reportes');
});


/*
|--------------------------------------------------------------------------
| GARZON Y COCINA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:garzon,cocina'])
    ->prefix('operaciones')
    ->name('operaciones.')
    ->group(function () {

        Route::get('/pedidos', fn() => view('garzon_cocina.pedidos'))
            ->name('pedidos');
});


require __DIR__.'/auth.php';