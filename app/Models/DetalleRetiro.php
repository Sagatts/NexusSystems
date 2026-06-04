<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRetiro extends Model
{
    protected $table = 'DETALLE_RETIRO';
    public $timestamps = false;

    protected $fillable = [
        'id_retiro',
        'id_producto',
        'cantidad'
    ];

    public function retiro()
    {
        return $this->belongsTo(Retiro::class, 'id_retiro');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
