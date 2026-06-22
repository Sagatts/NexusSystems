<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido'; // Nombre de tu tabla

    protected $fillable = [
        'fecha',
        'id_usuario'
    ];

    public $timestamps = false; // Quitar si tu tabla no tiene created_at/updated_at

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido');
    }
}