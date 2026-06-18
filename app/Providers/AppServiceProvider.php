<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Producto;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inyectamos la lógica en tu layout principal (app.blade.php)
        View::composer('layouts.app', function ($view) {
            $alertas = collect();

            // ==========================================
            // REGLA 1: Stock Crítico (Menor a 20)
            // ==========================================
            $productosStock = Producto::where('stock', '<', 20)->get();
            
            foreach ($productosStock as $prod) {
                $alertas->push([
                    'tipo' => 'stock',
                    'titulo' => $prod->nombre,
                    'mensaje' => 'Quedan solo ' . $prod->stock . ' unidades.',
                ]);
            }

            // ==========================================
            // REGLA 2: Vencimiento (Menor o igual a 7 días)
            // ==========================================
            $productosVencer = Producto::whereNotNull('fecha_vencimiento')
                ->whereDate('fecha_vencimiento', '<=', Carbon::now()->addDays(7))
                ->get();

            foreach ($productosVencer as $prod) {
                $fechaVenc = Carbon::parse($prod->fecha_vencimiento)->startOfDay();
                $hoy = Carbon::now()->startOfDay();
                
                // Calculamos la diferencia exacta de días
                $dias = $hoy->diffInDays($fechaVenc, false);

                if ($dias < 0) {
                    $mensaje = 'VENCIDO hace ' . abs($dias) . ' días.';
                } elseif ($dias == 0) {
                    $mensaje = 'Vence HOY.';
                } else {
                    $mensaje = 'Vence en ' . $dias . ' días.';
                }

                $alertas->push([
                    'tipo' => 'vencimiento',
                    'titulo' => $prod->nombre,
                    'mensaje' => $mensaje,
                ]);
            }

            // Pasamos las variables a la vista de la campana
            $view->with([
                'alertas' => $alertas,
                'conteoAlertas' => $alertas->count()
            ]);
        });
    }
}
