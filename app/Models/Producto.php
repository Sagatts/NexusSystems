<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;    

    protected $table = 'PRODUCTO';

    public $timestamps = false;

    protected $fillable = [
        'codigo_barras',
        'nombre',
        'precio_neto',
        'stock',
        'fecha_vencimiento',
        'id_categoria'
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date'
    ];

    public function categoria()
    {
        return $this->belongsTo(
            Categoria::class,
            'id_categoria'
        );
    }

    public function detallesRetiro()
    {
        return $this->hasMany(
            DetalleRetiro::class,
            'id_producto'
        );
    }
}
