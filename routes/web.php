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

Route::get('/home', function () {

    $user = auth()->user();

    switch ($user->rol) {

        case 'administrador':
            return redirect()->route('dashboard');

        case 'garzon':
        case 'cocina':
            return redirect()->route('pedidos.index');

        default:
            Auth::logout();
            return redirect()->route('login');
    }

})->middleware('auth')->name('home');

Route::get('/dashboard',
    [DashboardController::class, 'index']
)->middleware([
    'auth',
    'role:administrador'
])->name('dashboard');

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

        Route::get('productos-datatable',[ProductoController::class, 'getProductos'])->name('productos.datatable');

        Route::get('/productos/verificar-codigo', [ProductoController::class, 'verificarCodigo']);
        Route::get('productos/plantilla', [ProductoController::class, 'descargarPlantilla'])->name('productos.plantilla');
        Route::post('productos/importar', [ProductoController::class, 'importar'])->name('productos.importar');

        Route::resource(
            'productos',
            ProductoController::class
        );

        Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('admin.productos.update');

        // =========================
        // USUARIOS
        // =========================

        Route::get('usuarios-datatable',[UsuarioController::class, 'getUsuarios'])->name('usuarios.datatable');

        Route::resource(
            'usuarios',
            UsuarioController::class
        );

        // =========================
        // REPORTES
        // =========================
        Route::prefix('reportes')->name('reportes.')->group(function () {
            
            Route::get('/', [ReporteController::class, 'index'])->name('index');
            Route::get('/configurar', [ReporteController::class, 'create'])->name('create');
            Route::get('/exportar', [ReporteController::class, 'exportar'])->name('exportar');
            Route::get('/previa-pdf', [ReporteController::class, 'previaPdf'])->name('previa.pdf');
        });
});

/*
|--------------------------------------------------------------------------
| GARZON Y COCINA
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:garzon,cocina'
])->get('/pedidos', [PedidoController::class, 'index'])
 ->name('pedidos.index');
    
Route::post('/pedidos/procesar', [App\Http\Controllers\PedidoController::class, 'procesarPedido'])->name('pedidos.procesar');


require __DIR__.'/auth.php';