<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('admin.usuarios.index');
    }

    public function create()
    {
        // Ya no necesitamos traer categorías
        return view('admin.usuarios.create');
    }

    public function getUsuarios()
    {
        $usuarios = Usuario::query();

        return DataTables::of($usuarios)

            ->filter(function ($query) {

                $search = request('search')['value'] ?? '';

                if (!empty($search)) {
                    $query->where('nombre', 'like', "%{$search}%")
                          ->orWhere('rut', 'like', "%{$search}%");
                }
            })

            ->addColumn('acciones', function ($usuario) {

                return '
                    <a href="'.route('admin.usuarios.edit', $usuario->rut).'" class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <button class="btn btn-danger btn-sm" onclick="abrirModalEliminar(\''.$usuario->rut.'\')">
                        Eliminar
                    </button>
                ';
            })

            ->rawColumns(['acciones'])

            ->make(true);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        
        // Encriptar la contraseña antes de guardar en la BD
        if (!empty($data['contrasena'])) {
            $data['contrasena'] = Hash::make($data['contrasena']);
        }

        Usuario::create($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with(
                'success',
                'Usuario creado correctamente'
            );
    }

    public function edit(Usuario $usuario)
    {
        return view(
            'admin.usuarios.edit',
            compact('usuario')
        );
    }

    public function update(
        UserRequest $request,
        Usuario $usuario
    )
    {
        $data = $request->validated();

        // Si se ingresó una nueva contraseña, la encriptamos. Si no, la ignoramos.
        if (!empty($data['contrasena'])) {
            $data['contrasena'] = Hash::make($data['contrasena']);
        } else {
            unset($data['contrasena']);
        }

        $usuario->update($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with(
                'success',
                'Usuario actualizado correctamente'
            );
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return response()->json([
            'success' => true
        ]);
    }
}