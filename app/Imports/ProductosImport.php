<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class ProductosImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // 1. Buscamos la categoría
        $categoria = Categoria::where('nombre', trim($row['categoria']))->first();

        if (!$categoria) {
            throw new \Exception("La categoría '" . $row['categoria'] . "' no existe en el sistema. Debes crearla primero en el panel.");
        }

        // 2. Manejo inteligente de la Fecha
        $fechaVencimiento = null;
        
        if (!empty($row['fecha_vencimiento'])) {
            if (is_numeric($row['fecha_vencimiento'])) {
                $fechaVencimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_vencimiento']);
            } else {
                try {
                    $fechaVencimiento = Carbon::parse($row['fecha_vencimiento']);
                } catch (\Exception $e) {
                    throw new \Exception("La fecha de vencimiento no tiene un formato válido. Usa Año-Mes-Día (ej: 2026-12-31).");
                }
            }
        }

        // ========================================================
        // 3. NUEVO: LÓGICA DE REABASTECIMIENTO (SUMAR Y ACTUALIZAR)
        // ========================================================
        
        $productoExistente = Producto::where('codigo_barras', $row['codigo_barras'])->first();

        if ($productoExistente) {
            // Le sumamos el stock nuevo al que ya existía en bodega
            $productoExistente->stock += $row['stock'];
            
            // Reemplazamos la fecha de vencimiento por la del lote nuevo
            $productoExistente->fecha_vencimiento = $fechaVencimiento;
            
            // Opcional: Si quieres que también se actualice el precio, puedes descomentar esto:
            // $productoExistente->precio_neto = $row['precio_neto'];
            
            // Guardamos los cambios directos en la base de datos
            $productoExistente->save();

            // Retornamos null para que Laravel Excel NO intente insertar una fila duplicada
            return null;
        }

        // ========================================================
        // 4. Si NO existe, creamos el producto desde cero
        // ========================================================
        return new Producto([
            'codigo_barras'     => $row['codigo_barras'],
            'nombre'            => $row['nombre'],
            'precio_neto'       => $row['precio_neto'],
            'stock'             => $row['stock'],
            'fecha_vencimiento' => $fechaVencimiento,
            'id_categoria'      => $categoria->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'codigo_barras' => 'required',
            'nombre'        => 'required|string',
            'precio_neto'   => 'required|numeric',
            'stock'         => 'required|numeric',
            'categoria'     => 'required|string',
            'fecha_vencimiento' => 'nullable' 
        ];
    }

    public function customValidationMessages()
    {
        return [
            'codigo_barras.required' => 'Falta la columna "codigo_barras".',
            'nombre.required'        => 'Falta la columna "nombre".',
            'precio_neto.required'   => 'Falta la columna "precio_neto".',
            'stock.required'         => 'Falta la columna "stock".',
            'categoria.required'     => 'Falta la columna "categoria".'
        ];
    }
}