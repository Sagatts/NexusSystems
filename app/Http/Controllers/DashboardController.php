<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $ventas = DB::table('detalle_retiro as dr')
            ->join('retiro as r', 'dr.id_retiro', '=', 'r.id')
            ->join('producto as p', 'dr.id_producto', '=', 'p.id')
            ->selectRaw('
                MONTH(r.fecha_hora) as mes,
                SUM(dr.cantidad * p.precio_neto) as total
            ')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        $labels = [];
        $totales = [];

        foreach ($ventas as $venta) {
            $labels[] = $meses[$venta->mes];
            $totales[] = $venta->total;
        }

        // Productos próximos a vencer
        $productosPorVencer = Producto::whereDate(
                'fecha_vencimiento',
                '>=',
                now()
            )
            ->orderBy('fecha_vencimiento', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'labels',
            'totales',
            'productosPorVencer'
        ));
    }
}