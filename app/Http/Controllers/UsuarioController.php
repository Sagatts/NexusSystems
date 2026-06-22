<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('admin.usuarios.index');
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function getUsuarios()
    {
        // Obtenemos el RUT del usuario autenticado de forma segura
        $rutAutenticado = Auth::user()->rut ?? null;

        // Si hay un usuario logueado, lo excluimos. Si no, traemos todos.
        $usuarios = Usuario::query();
        if ($rutAutenticado) {
            $usuarios->where('rut', '!=', $rutAutenticado);
        }

        return DataTables::of($usuarios)
            ->filter(function ($query) {
                $search = request('search')['value'] ?? '';

                if (!empty($search)) {
                    // Agrupamos el buscador para que el "orWhere" no altere el filtro anterior
                    $query->where(function ($q) use ($search) {
                        $q->where('nombre', 'like', "%{$search}%")
                          ->orWhere('rut', 'like', "%{$search}%");
                    });
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
        
        if (!empty($data['contrasena'])) {
            $data['contrasena'] = Hash::make($data['contrasena']);
        }

        Usuario::create($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function edit(Usuario $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(UserRequest $request, Usuario $usuario)
    {
        $data = $request->validated();

        if (!empty($data['contrasena'])) {
            $data['contrasena'] = Hash::make($data['contrasena']);
        } else {
            unset($data['contrasena']);
        }

        $usuario->update($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($rut)
    {
        $usuario = Usuario::where('rut', $rut)->firstOrFail();
        
        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ]);
    }
}