<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Producto;

class ProductoPolicy
{
    /**
     * Determina si el usuario puede ver la lista de productos.
     */
    public function viewAny(Usuario $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Determina si el usuario puede ver un producto específico.
     */
    public function view(Usuario $user, Producto $producto): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Determina si el usuario puede crear productos.
     */
    public function create(Usuario $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Determina si el usuario puede actualizar un producto.
     */
    public function update(Usuario $user, Producto $producto): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Determina si el usuario puede eliminar un producto.
     */
    public function delete(Usuario $user, Producto $producto): bool
    {
        return $user->rol === 'administrador';
    }
}
