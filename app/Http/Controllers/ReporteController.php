<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    // ==========================================
    // 1. VISTA PRINCIPAL (Métricas y Tabla)
    // ==========================================
    public function index()
    {
        // Ventas por mes (Basado en Retiros / Salidas)
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
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        $labelsVentas = [];
        $totalesVentas = [];

        foreach ($ventasMes as $venta) {
            $labelsVentas[] = $meses[$venta->mes];
            $totalesVentas[] = $venta->total;
        }

        // Productos más retirados (Salidas)
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

        // Historial Unificado (Entradas de PEDIDO + Salidas de RETIRO)
        $entradas = DB::table('DETALLE_PEDIDO as dp')
            ->join('PEDIDO as pe', 'dp.id_pedido', '=', 'pe.id')
            ->join('USUARIO as u', 'pe.id_usuario', '=', 'u.rut')
            ->join('PRODUCTO as p', 'dp.id_producto', '=', 'p.id')
            ->select(
                'u.rut',
                'u.nombre as usuario',
                'u.rol',
                'p.codigo_barras',
                'p.nombre as producto',
                'p.precio_neto',
                'dp.cantidad',
                'pe.fecha as fecha_hora',
                DB::raw("'Entrada' as tipo_movimiento")
            );

        $movimientos = DB::table('DETALLE_RETIRO as dr')
            ->join('RETIRO as r', 'dr.id_retiro', '=', 'r.id')
            ->join('USUARIO as u', 'r.id_usuario', '=', 'u.rut')
            ->join('PRODUCTO as p', 'dr.id_producto', '=', 'p.id')
            ->select(
                'u.rut',
                'u.nombre as usuario',
                'u.rol',
                'p.codigo_barras',
                'p.nombre as producto',
                'p.precio_neto',
                'dr.cantidad',
                'r.fecha_hora',
                DB::raw("'Salida' as tipo_movimiento")
            )
            ->union($entradas)
            ->orderByDesc('fecha_hora')
            ->get();

        return view('admin.reportes.index', compact(
            'labelsVentas',
            'totalesVentas',
            'labelsProductos',
            'totalesProductos',
            'movimientos'
        ));
    }

    // ==========================================
    // 2. VISTA FORMULARIO DE DESCARGA
    // ==========================================
    public function create()
    {
        return view('admin.reportes.create');
    }

    // ==========================================
    // 3. PROCESAMIENTO DE EXPORTACIÓN (PDF / CSV)
    // ==========================================
    public function exportar(Request $request)
    {
        // Validación de los parámetros que vienen del formulario
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'formato' => 'required|in:pdf,csv'
        ]);

        $formato = $request->input('formato');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Obtener movimientos filtrados por rango de fecha con UNION unificado
        $movimientos = $this->obtenerMovimientosFiltrados($fechaInicio, $fechaFin);

        if ($formato === 'csv') {
            return $this->generarCsv($movimientos);
        }

        return $this->generarPdf($movimientos, $fechaInicio, $fechaFin);
    }

    // ==========================================
    // 4. GENERACIÓN DE PDF (DESCARGA)
    // ==========================================
    private function generarPdf($movimientos, $fechaInicio, $fechaFin)
    {
        Carbon::setLocale('es');
        $fechaActual = Carbon::now();

        $data = [
            'fecha' => $fechaActual->format('d/m/Y'),
            'dia' => ucfirst($fechaActual->translatedFormat('l')),
            'hora' => $fechaActual->format('H:i:s'),
            'generado_por' => Auth::user()->nombre ?? Auth::user()->name ?? 'Administrador',
            'fecha_inicio' => Carbon::parse($fechaInicio)->format('d/m/Y'),
            'fecha_fin' => Carbon::parse($fechaFin)->format('d/m/Y'),
            'movimientos' => $movimientos
        ];

        $pdf = Pdf::loadView('admin.reportes.pdf', $data);
        $pdf->setPaper('A4', 'landscape'); 

        return $pdf->download('Reporte_Movimientos_' . $fechaActual->format('Ymd_His') . '.pdf');
    }

    // ==========================================
    // 5. GENERACIÓN DE CSV
    // ==========================================
    private function generarCsv($movimientos)
    {
        $fileName = 'Reporte_Movimientos_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($movimientos) {
            $file = fopen('php://output', 'w');
            // Agregar BOM de UTF-8 para que Excel reconozca eñes y tildes correctamente
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Encabezados del CSV incluyendo Tipo de Movimiento
            fputcsv($file, ['RUT', 'Código Barras', 'Usuario', 'Rol', 'Tipo Movimiento', 'Producto', 'Cantidad', 'Precio Unitario', 'Total', 'Fecha y Hora']);

            foreach ($movimientos as $mov) {
                fputcsv($file, [
                    $mov->rut,
                    $mov->codigo_barras,
                    $mov->usuario,
                    $mov->rol,
                    $mov->tipo_movimiento,
                    $mov->producto,
                    $mov->cantidad,
                    $mov->precio_neto,
                    $mov->precio_neto * $mov->cantidad, 
                    Carbon::parse($mov->fecha_hora)->format('d/m/Y H:i')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ==========================================
    // 6. VISTA PREVIA PDF (PANTALLA DIVIDIDA / STREAM)
    // ==========================================
    public function previaPdf(Request $request)
    {
        $fechaInicio = $request->query('fecha_inicio');
        $fechaFin = $request->query('fecha_fin');

        // Reutilizamos la consulta con filtros por fecha
        $movimientos = $this->obtenerMovimientosFiltrados($fechaInicio, $fechaFin);

        Carbon::setLocale('es');
        $fechaActual = Carbon::now();

        $data = [
            'fecha' => $fechaActual->format('d/m/Y'),
            'dia' => ucfirst($fechaActual->translatedFormat('l')),
            'hora' => $fechaActual->format('H:i:s'),
            'generado_por' => Auth::user()->nombre ?? Auth::user()->name ?? 'Administrador',
            'fecha_inicio' => Carbon::parse($fechaInicio)->format('d/m/Y'),
            'fecha_fin' => Carbon::parse($fechaFin)->format('d/m/Y'),
            'movimientos' => $movimientos
        ];

        $pdf = Pdf::loadView('admin.reportes.pdf', $data);
        $pdf->setPaper('A4', 'landscape'); 

        return $pdf->stream('Vista_Previa.pdf');
    }

    // ==========================================
    // FUNCIÓN AUXILIAR: Evita repetir SQL complejo
    // ==========================================
    private function obtenerMovimientosFiltrados($fechaInicio, $fechaFin)
    {
        $inicioCompleto = $fechaInicio . ' 00:00:00';
        $finCompleto    = $fechaFin . ' 23:59:59';

        $entradas = DB::table('DETALLE_PEDIDO as dp')
            ->join('PEDIDO as pe', 'dp.id_pedido', '=', 'pe.id')
            ->join('USUARIO as u', 'pe.id_usuario', '=', 'u.rut')
            ->join('PRODUCTO as p', 'dp.id_producto', '=', 'p.id')
            ->select(
                'u.rut', 'u.nombre as usuario', 'u.rol', 'p.codigo_barras', 
                'p.nombre as producto', 'p.precio_neto', 'dp.cantidad', 
                'pe.fecha as fecha_hora', DB::raw("'Entrada' as tipo_movimiento")
            )
            ->whereBetween('pe.fecha', [$inicioCompleto, $finCompleto]);

        return DB::table('DETALLE_RETIRO as dr')
            ->join('RETIRO as r', 'dr.id_retiro', '=', 'r.id')
            ->join('USUARIO as u', 'r.id_usuario', '=', 'u.rut')
            ->join('PRODUCTO as p', 'dr.id_producto', '=', 'p.id')
            ->select(
                'u.rut', 'u.nombre as usuario', 'u.rol', 'p.codigo_barras', 
                'p.nombre as producto', 'p.precio_neto', 'dr.cantidad', 
                'r.fecha_hora', DB::raw("'Salida' as tipo_movimiento")
            )
            ->whereBetween('r.fecha_hora', [$inicioCompleto, $finCompleto])
            ->union($entradas)
            ->orderByDesc('fecha_hora')
            ->get();
    }
}