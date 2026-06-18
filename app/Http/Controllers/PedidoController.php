<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $rol = auth()->user()->rol;

        return view('garzon_cocina.pedidos', compact('rol'));
    }
}