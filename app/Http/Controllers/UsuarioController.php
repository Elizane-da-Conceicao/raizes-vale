<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function store(Request $request)
    {
        $usuario = new Usuario();
        $usuario->Nome = $request->input('Nome');
        $usuario->CPF = $request->input('CPF');
        $usuario->Email = $request->input('Email');
        $usuario->administrador = $request->input('administrador', '2');
        $usuario->save();

        return response()->json(['message' => 'Usuário criado com sucesso', 'usuario' => $usuario], 201);
    }

    /**
     * Retorna todos os usuários.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json(['usuarios' => $usuarios], 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $usuario->Nome = $request->input('Nome', $usuario->Nome);
        $usuario->CPF = $request->input('CPF', $usuario->CPF);
        $usuario->Email = $request->input('Email', $usuario->Email);
        $usuario->administrador = $request->input('administrador', $usuario->administrador);
        $usuario->save();

        return response()->json(['message' => 'Usuário atualizado com sucesso', 'usuario' => $usuario], 200);
    }
    
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso'], 200);
    }
}
