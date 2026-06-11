<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard',
    [DashboardController::class, 'index']
)->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

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

        // =========================
        // PRODUCTOS
        // =========================

        Route::get(
            'productos-datatable',
            [ProductoController::class, 'getProductos']
        )->name('productos.datatable');

        Route::resource(
            'productos',
            ProductoController::class
        );

        // =========================
        // USUARIOS
        // =========================

        Route::get(
            'usuarios-datatable',
            [UsuarioController::class, 'getUsuarios']
        )->name('usuarios.datatable');

        Route::resource(
            'usuarios',
            UsuarioController::class
        );

        // =========================
        // REPORTES
        // =========================

        Route::get('/reportes', function () {
            return view('admin.reportes');
        })->name('reportes');
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