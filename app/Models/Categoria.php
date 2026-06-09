<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'CATEGORIA';

    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }
}