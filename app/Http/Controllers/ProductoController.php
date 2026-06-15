<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
        Producto::create($request->all());

        return redirect()
            ->route('admin.productos.index')
            ->with(
                'success',
                'Producto creado correctamente'
            );
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