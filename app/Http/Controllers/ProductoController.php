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
        return view('admin.productos.index');
    }

    public function create()
    {
        $categorias = Categoria::all();

        return view(
            'admin.productos.create',
            compact('categorias')
        );
    }

    public function getProductos()
    {
        $productos = Producto::with('categoria');

        return DataTables::of($productos)

            ->filter(function ($query) {

                $search = request('search')['value'] ?? '';

                if (!empty($search)) {
                    $query->where('nombre', 'like', "%{$search}%");
                }
            })

            ->addColumn('categoria', function ($producto) {
                return $producto->categoria->nombre ?? 'Sin categoría';
            })

            ->addColumn('acciones', function ($producto) {
                return '
                    <button class="btn btn-warning btn-sm">
                        Editar
                    </button>

                    <button class="btn btn-danger btn-sm">
                        Eliminar
                    </button>
                ';
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
        $categorias = Categoria::all();

        return view(
            'admin.productos.edit',
            compact(
                'producto',
                'categorias'
            )
        );
    }

    public function update(
        Request $request,
        Producto $producto
    )
    {
        $producto->update($request->all());

        return redirect()
            ->route('admin.productos.index');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return response()->json([
            'success' => true
        ]);
    }
}