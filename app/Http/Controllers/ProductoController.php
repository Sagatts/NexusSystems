<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

// Importaciones necesarias para manejar Excel/CSV y capturar errores
use App\Imports\ProductosImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductoController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        
        return view(
            'admin.productos.index', 
            compact('categorias')
        );
    }

    public function create()
    {
        $categorias = Categoria::all();

        return view(
            'admin.productos.create',
            compact('categorias')
        );
    }

    public function getProductos(Request $request) 
    {
        $productos = Producto::with('categoria');

        return DataTables::of($productos)

            ->filter(function ($query) use ($request) {

                $search = $request->input('search.value') ?? '';

                if (!empty($search)) {
                    $query->where('nombre', 'like', "%{$search}%");
                }


                if ($request->has('categoria') && $request->categoria != '') {
                    $query->where('id_categoria', $request->categoria);
                }
            })

            ->addColumn('categoria', function ($producto) {
                return $producto->categoria->nombre ?? 'Sin categoría';
            })

            ->addColumn('acciones', function ($producto) {
                return '
                    <a href="'.route('admin.productos.edit', $producto->id).'" class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <button class="btn btn-danger btn-sm" onclick="abrirModalEliminar(\''.$producto->id.'\')">
                        Eliminar
                    </button>
                ';
            })
            
            ->editColumn('fecha_vencimiento', function ($producto) {
                return $producto->fecha_vencimiento
                    ? $producto->fecha_vencimiento->format('d-m-Y')
                    : '';
            })

            ->rawColumns(['acciones'])

            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_barras' => [
                'required',
                'string',
                'max:100',
                Rule::unique('PRODUCTO', 'codigo_barras')->whereNull('deleted_at'), // ← ignora eliminados
            ],
            'id_categoria' => 'required|exists:CATEGORIA,id',
            'precio_neto' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'fecha_vencimiento' => 'required|date|after_or_equal:today',
        ], [
            'nombre.required' => 'Debe ingresar el nombre del producto.',
            'codigo_barras.required' => 'Debe ingresar un código de barras.',
            'codigo_barras.unique' => 'Ya existe un producto registrado con este código de barras.',
            'id_categoria.required' => 'Debe seleccionar una categoría.',
            'precio_neto.required' => 'Debe ingresar el precio del producto.',
            'stock.required' => 'Debe ingresar el stock inicial.',
            'fecha_vencimiento.required' => 'Debe ingresar una fecha de vencimiento.',
            'fecha_vencimiento.after_or_equal' => 'La fecha de vencimiento no puede ser anterior a hoy.',
        ]);

        Producto::create($request->all());

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function verificarCodigo(Request $request)
    {
        return response()->json([
            'existe' => Producto::where('codigo_barras', $request->codigo)
                ->whereNull('deleted_at')  // ← ignora eliminados
                ->exists()
        ]);
    }

    public function edit(Producto $producto)
    {
        $producto = Producto::findOrFail($producto->id);

        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.edit', compact(
            'producto',
            'categorias'
        ));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_barras' => [
                'required',
                Rule::unique('PRODUCTO', 'codigo_barras')->ignore($producto->id)->whereNull('deleted_at'), // ← por consistencia
            ],
            'id_categoria' => 'required|exists:categoria,id',
            'precio_neto' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:today',
        ], [
            'nombre.required' => 'Debe ingresar el nombre del producto.',
            'codigo_barras.unique' => 'Ya existe un producto registrado con este código de barras.',
            'id_categoria.required' => 'Debe seleccionar una categoría.',
            'precio_neto.required' => 'Debe ingresar el precio del producto.',
            'stock.required' => 'Debe ingresar el stock inicial.',
            'fecha_vencimiento.after_or_equal' => 'La fecha de vencimiento no puede ser anterior a hoy.',
        ]);

        $producto->update($request->all());
 
        return redirect()
            ->route('admin.productos.index')
            ->with(
                'success',
                'Producto actualizado correctamente'
            );
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente'
        ]);
    }

    // ==========================================
    // FUNCIÓN PARA IMPORTAR EL EXCEL
    // ==========================================
    public function importar(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|mimes:xlsx,xls,csv,txt|max:5120',
        ]);

        try {
            Excel::import(new ProductosImport, $request->file('archivo_excel'));

            // Si TODO sale bien, redirige al Index (Inventario) con mensaje de éxito
            return redirect()->route('admin.productos.index')
                ->with('success', '¡Productos importados correctamente!');
                
        } catch (ValidationException $e) {
            $fallas = $e->failures();
            $mensajeError = "Errores en el Excel: ";
            
            foreach ($fallas as $falla) {
                $mensajeError .= "Fila " . $falla->row() . ": " . $falla->errors()[0] . " | ";
            }

            // Redirige "atrás" (a la vista de Crear) y muestra el error detallado
            return back()->with('error', $mensajeError);
                
        } catch (\Exception $e) {
            // Redirige "atrás" y usa $e->getMessage() para mostrar el error exacto (ej: "La categoría no existe")
            return back()->with('error', $e->getMessage());
        }
    }

    // ==========================================
    // FUNCIÓN PARA DESCARGAR LA PLANTILLA
    // ==========================================
    public function descargarPlantilla()
    {
        $fileName = 'Plantilla_Productos.csv';
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Formato UTF-8 para que las tildes y ñ no se rompan
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Títulos legibles: Cambiamos 'id_categoria' por 'categoria'
            fputcsv($file, ['codigo_barras', 'nombre', 'precio_neto', 'stock', 'fecha_vencimiento', 'categoria']);
            
            // Fila de ejemplo con el nombre real de la categoría
            fputcsv($file, ['7890123', 'Bebida Coca Cola 3L', '2500', '50', '2026-12-31', 'Bebidas']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}