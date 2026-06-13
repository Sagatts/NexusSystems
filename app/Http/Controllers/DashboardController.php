<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ventas mensuales
        $ventas = DB::table('DETALLE_RETIRO as dr')
            ->join('RETIRO as r', 'dr.id_retiro', '=', 'r.id')
            ->join('PRODUCTO as p', 'dr.id_producto', '=', 'p.id')
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

        // Stock mínimo
        $productosStockMinimo = Producto::orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Usuarios
        $usuarios = Usuario::latest('rut')
            ->take(5)
            ->get();

        // Productos más retirados
        $productosMasRetirados = DB::table('DETALLE_RETIRO as dr')
            ->join('PRODUCTO as p', 'dr.id_producto', '=', 'p.id')
            ->select(
                'p.nombre',
                DB::raw('SUM(dr.cantidad) as total')
            )
            ->groupBy('p.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Productos menos retirados
        $productosMenosRetirados = DB::table('DETALLE_RETIRO as dr')
            ->join('PRODUCTO as p', 'dr.id_producto', '=', 'p.id')
            ->select(
                'p.nombre',
                DB::raw('SUM(dr.cantidad) as total')
            )
            ->groupBy('p.nombre')
            ->orderBy('total')
            ->limit(5)
            ->get();

        $labelsMasRetirados = $productosMasRetirados->pluck('nombre');
        $totalesMasRetirados = $productosMasRetirados->pluck('total');

        $labelsMenosRetirados = $productosMenosRetirados->pluck('nombre');
        $totalesMenosRetirados = $productosMenosRetirados->pluck('total');

        // Ventas por categoría
        $ventasCategoria = DB::table('DETALLE_RETIRO as dr')
            ->join('PRODUCTO as p', 'dr.id_producto', '=', 'p.id')
            ->join('CATEGORIA as c', 'p.id_categoria', '=', 'c.id')
            ->select(
                'c.nombre',
                DB::raw('SUM(dr.cantidad * p.precio_neto) as total')
            )
            ->groupBy('c.nombre')
            ->orderByDesc('total')
            ->get();

        $labelsCategorias = $ventasCategoria->pluck('nombre');
        $totalesCategorias = $ventasCategoria->pluck('total');

        return view('dashboard', compact(
            'labels',
            'totales',
            'productosPorVencer',
            'productosStockMinimo',
            'usuarios',
            'labelsMasRetirados',
            'totalesMasRetirados',
            'labelsMenosRetirados',
            'totalesMenosRetirados',
            'labelsCategorias',
            'totalesCategorias'
        ));
    }
}