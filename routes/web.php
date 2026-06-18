<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PedidoController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard',
    [DashboardController::class, 'index']
)->middleware(['auth', 'role:administrador'])
 ->name('dashboard');

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

        Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('admin.productos.update');

        Route::get('/productos/verificar-codigo', [ProductoController::class, 'verificarCodigo']);

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

        Route::prefix('reportes')->name('reportes.')->group(function () {
            
            // Ruta principal (Historial) - Equivale a 'admin.reportes.index'
            Route::get(
                '/', 
                [ReporteController::class, 'index']
            )->name('index');

            // Ruta de la vista de configuración - Equivale a 'admin.reportes.create'
            Route::get(
                '/configurar', 
                [ReporteController::class, 'create']
            )->name('create');

            // Ruta que procesa y descarga el archivo - Equivale a 'admin.reportes.exportar'
            Route::get(
                '/exportar', 
                [ReporteController::class, 'exportar']
            )->name('exportar');

        });
});

/*
|--------------------------------------------------------------------------
| GARZON Y COCINA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:garzon,cocina'])
    ->get('/pedidos', [PedidoController::class, 'index'])
    ->name('pedidos.index');


require __DIR__.'/auth.php';