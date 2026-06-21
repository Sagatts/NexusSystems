<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function index()
    {
        $rol = Auth::user()->rol;

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

        try {
            // Iniciamos una transacción para asegurar que se guarde el retiro completo o nada
            DB::transaction(function () use ($productosSeleccionados) {
                
                // 1. Crear el registro principal en la tabla RETIRO
                $idRetiro = DB::table('RETIRO')->insertGetId([
                    'fecha_hora' => Carbon::now()->format('Y-m-d H:i:s'),
                    'id_usuario' => Auth::user()->rut, // Registra el RUT del garzón o cocina logueado
                ]);

                // 2. Recorremos cada producto para descontar stock e insertar en DETALLE_RETIRO
                foreach ($productosSeleccionados as $item) {
                    $producto = Producto::find($item['id']);
                    
                    if ($producto) {
                        // Validación de seguridad de Stock del lado del Servidor
                        if ($producto->stock < $item['cantidad']) {
                            throw new \Exception("El producto '{$producto->nombre}' no tiene suficiente stock disponible (Stock actual: {$producto->stock}).");
                        }

                        // Descontar del inventario
                        $producto->stock = $producto->stock - $item['cantidad'];
                        $producto->save();

                        // Guardar en la tabla DETALLE_RETIRO
                        DB::table('DETALLE_RETIRO')->insert([
                            'id_retiro'   => $idRetiro,
                            'id_producto' => $producto->id,
                            'cantidad'    => $item['cantidad']
                        ]);
                    }
                }
            });

            return response()->json(['success' => true, 'message' => 'Inventario actualizado y retiro registrado correctamente.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}