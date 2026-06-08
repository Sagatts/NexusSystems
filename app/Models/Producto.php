<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    public $timestamps = false;

    protected $fillable = [
        'codigo_barras',
        'nombre',
        'precio_neto',
        'stock',
        'fecha_vencimiento',
        'id_categoria'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
