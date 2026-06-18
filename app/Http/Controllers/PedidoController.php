<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $rol = auth()->user()->rol;
        $productos = Producto::all();
        return view('garzon_cocina.pedidos', compact('rol', 'productos'));
    }
}