<?php

namespace App\Policies;

use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class UsuarioPolicy
{
    /**
     * Determina si el usuario puede ver la lista de usuarios.
     */
    public function viewAny(Usuario $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Determina si el usuario puede ver un usuario específico.
     */
    public function view(Usuario $user, Usuario $usuario): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Determina si el usuario puede crear usuarios.
     */
    public function create(Usuario $user): bool
    {
        return $user->rol === 'administrador';
    }

    /**
     * Determina si el usuario puede actualizar un usuario.
     */
    public function update(Usuario $user, Usuario $usuario): bool
    {
        // Solo administradores pueden editar usuarios
        if ($user->rol !== 'administrador') {
            return false;
        }

        // Un administrador NO puede editar a otro administrador (opcional, puedes quitar esto si lo deseas)
        // if ($usuario->rol === 'administrador' && $user->rut !== $usuario->rut) {
        //     return false;
        // }

        return true;
    }

    /**
     * Determina si el usuario puede eliminar un usuario.
     */
    public function delete(Usuario $user, Usuario $usuario): bool
    {
        // Un administrador no puede eliminarse a sí mismo
        if ($user->rut === $usuario->rut) {
            return false;
        }

        return $user->rol === 'administrador';
    }
}
