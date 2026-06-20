<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedido'; // Nombre de tu tabla

    protected $fillable = [
        'id_pedido',
        'id_producto',
        'cantidad',
        'costo',
        'fecha_vencimiento'
    ];

    public $timestamps = false; // Quitar si tu tabla no tiene created_at/updated_at
}