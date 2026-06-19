<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $rol = auth()->user()->rol;

        if ($rol === 'garzon') {
            
            // Garzón: Solo ve los productos de la categoría "Bebidas"
            $productos = Producto::whereHas('categoria', function ($query) {
                $query->where('nombre', 'Bebidas');
            })->get();

        } else {
            
            // Cocina: Ve todos los productos menos los de la categoría "Bebidas"
            $productos = Producto::whereHas('categoria', function ($query) {
                $query->where('nombre', '!=', 'Bebidas');
            })->get();
            
        }

        return view('garzon_cocina.pedidos', compact('rol', 'productos'));
    }

    public function procesarPedido(Request $request)
    {
        $productosSeleccionados = $request->input('productos');

        if (!$productosSeleccionados || count($productosSeleccionados) == 0) {
            return response()->json(['success' => false, 'message' => 'No hay productos seleccionados.']);
        }

        // Recorremos cada producto que nos envió el celular/computador
        foreach ($productosSeleccionados as $item) {
            $producto = Producto::find($item['id']);
            
            if ($producto) {
                // Restamos la cantidad solicitada
                $producto->stock = $producto->stock - $item['cantidad'];
                $producto->save(); // Guardamos el cambio en la base de datos
            }
        }

        return response()->json(['success' => true, 'message' => 'Inventario actualizado correctamente.']);
    }
}