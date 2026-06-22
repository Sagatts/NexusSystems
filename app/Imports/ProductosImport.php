<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProductosImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        // Si no hay filas de datos, salimos temprano
        if ($rows->isEmpty()) {
            return;
        }

        // Envolvemos todo el proceso en una transacción de Base de Datos.
        // Si alguna fila arroja un error de categoría u otro tipo, nada se guardará.
        DB::transaction(function () use ($rows) {
            
            // 1. Crear la cabecera del Pedido único para esta importación masiva
            $pedido = Pedido::create([
                'fecha'      => Carbon::now()->format('Y-m-d H:i:s'),
                'id_usuario' => Auth::id() ?? 1, // Obtiene el id del usuario logueado o asigna 1 por defecto
            ]);

            foreach ($rows as $row) {
                // Validación de escape por si vienen filas completamente vacías al final del archivo
                if (empty($row['codigo_barras']) && empty($row['nombre'])) {
                    continue;
                }

                // 2. Buscamos la categoría
                $categoria = Categoria::where('nombre', trim($row['categoria']))->first();

                if (!$categoria) {
                    throw new \Exception("La categoría '" . $row['categoria'] . "' no existe en el sistema. Debes crearla primero en el panel.");
                }

                // 3. Manejo inteligente de la Fecha
                $fechaVencimiento = null;
                
                if (!empty($row['fecha_vencimiento'])) {
                    if (is_numeric($row['fecha_vencimiento'])) {
                        $fechaVencimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_vencimiento']);
                    } else {
                        try {
                            $fechaVencimiento = Carbon::parse($row['fecha_vencimiento']);
                        } catch (\Exception $e) {
                            throw new \Exception("La fecha de vencimiento no tiene un formato válido en el producto '" . $row['nombre'] . "'. Usa Año-Mes-Día (ej: 2026-12-31).");
                        }
                    }
                }

                // 4. LÓGICA DE ACTUALIZACIÓN O CREACIÓN DEL PRODUCTO
                $producto = Producto::where('codigo_barras', $row['codigo_barras'])->first();

                if ($producto) {
                    // Si el producto existe, actualizamos sus datos y sumamos stock
                    $producto->stock += $row['stock'];
                    $producto->fecha_vencimiento = $fechaVencimiento;
                    $producto->precio_neto = $row['precio_neto'];
                    $producto->id_categoria = $categoria->id;
                    $producto->save();
                } else {
                    // Si NO existe, creamos el producto desde cero
                    $producto = Producto::create([
                        'codigo_barras'     => $row['codigo_barras'],
                        'nombre'            => $row['nombre'],
                        'precio_neto'       => $row['precio_neto'],
                        'stock'             => $row['stock'],
                        'fecha_vencimiento' => $fechaVencimiento,
                        'id_categoria'      => $categoria->id,
                    ]);
                }

                // 5. REGISTRO EN LA TABLA detalle_pedido
                DetallePedido::create([
                    'id_pedido'         => $pedido->id,
                    'id_producto'       => $producto->id,
                    'cantidad'          => $row['stock'],
                    'costo'             => $row['precio_neto'],
                    'fecha_vencimiento' => $fechaVencimiento ? Carbon::parse($fechaVencimiento)->format('Y-m-d') : null,
                ]);
            }
        });
    }

    public function rules(): array
    {
        return [
            'codigo_barras'     => 'required',
            'nombre'            => 'required|string',
            'precio_neto'       => 'required|numeric',
            'stock'             => 'required|numeric',
            'categoria'         => 'required|string',
            'fecha_vencimiento' => 'nullable' 
        ];
    }

    public function customValidationMessages()
    {
        return [
            'codigo_barras.required' => 'Falta la columna o dato en "codigo_barras".',
            'nombre.required'        => 'Falta la columna o dato en "nombre".',
            'precio_neto.required'   => 'Falta la columna o dato en "precio_neto".',
            'stock.required'         => 'Falta la columna o dato en "stock".',
            'categoria.required'     => 'Falta la columna o dato en "categoria".'
        ];
    }
}