<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        // Ventas por mes
        $ventasMes = DB::table('DETALLE_RETIRO as dr')
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

        $labelsVentas = [];
        $totalesVentas = [];

        foreach ($ventasMes as $venta) {
            $labelsVentas[] = $meses[$venta->mes];
            $totalesVentas[] = $venta->total;
        }

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

        $labelsProductos = $productosMasRetirados->pluck('nombre');
        $totalesProductos = $productosMasRetirados->pluck('total');

        // Historial
        $movimientos = DB::table('DETALLE_RETIRO as dr')
            ->join('RETIRO as r', 'dr.id_retiro', '=', 'r.id')
            ->join('USUARIO as u', 'r.id_usuario', '=', 'u.rut')
            ->join('PRODUCTO as p', 'dr.id_producto', '=', 'p.id')
            ->select(
                'u.rut',
                'u.nombre as usuario',
                'p.codigo_barras',
                'p.nombre as producto',
                'p.precio_neto',
                'dr.cantidad',
                'r.fecha_hora'
            )
            ->orderByDesc('r.fecha_hora')
            ->get();

        return view('admin.reportes', compact(
            'labelsVentas',
            'totalesVentas',
            'labelsProductos',
            'totalesProductos',
            'movimientos'
        ));
    }
}