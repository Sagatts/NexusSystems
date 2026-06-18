<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;



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
            'codigo_barras' => 'required|string|max:100|unique:producto,codigo_barras',
            'id_categoria' => 'required|exists:categoria,id',
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
            ->with(
                'success',
                'Producto creado correctamente'
            );
    }

    public function verificarCodigo(Request $request)
    {
        return response()->json([
            'existe' => Producto::where(
                'codigo_barras',
                $request->codigo
            )->exists()
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

    public function update(Request $request,Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_barras' => [
                'required',
                Rule::unique('producto', 'codigo_barras')->ignore($producto->id)
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
        // Buscamos el producto
        $producto = Producto::findOrFail($id);
        
        // Lo eliminamos de la base de datos
        $producto->delete();

        // Le respondemos al AJAX que todo salió bien
        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente'
        ]);
    }
}