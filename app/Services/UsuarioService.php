<?php

namespace App\Services;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioService
{
    public function store(Request $request)
    {
        $usuario = new Usuario();
        $usuario->Nome = $request->input('Nome');
        $usuario->CPF = $request->input('CPF');
        $usuario->Email = $request->input('Email');
        $usuario->administrador = $request->input('administrador', '2');
        $usuario->senha = $request->input('senha');
        $usuario->data_criacao = now();
        $usuario->save();

        return (object) [
            'message' => 'Usuário criado com sucesso',
            'usuario' => $usuario,
            'status_code' => 201,
        ];
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return (object) [
                'message' => 'Usuário não encontrado',
                'status_code' => 404,
            ];
        }

        $usuario->Nome = $request->input('Nome', $usuario->Nome);
        $usuario->CPF = $request->input('CPF', $usuario->CPF);
        $usuario->Email = $request->input('Email', $usuario->Email);
        $usuario->administrador = $request->input('administrador', $usuario->administrador);
        $usuario->senha = $request->input('senha', $usuario->senha);
        $usuario->data_alteracao = now();
        $usuario->save();

        return (object) [
            'message' => 'Usuário atualizado com sucesso',
            'usuario' => $usuario,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return (object) [
                'message' => 'Usuário não encontrado',
                'status_code' => 404,
            ];
        }

        $usuario->delete();

        return (object) [
            'message' => 'Usuário excluido com sucesso',
            'usuario' => $usuario,
            'status_code' => 200,
        ];
    }
    
    public function logar(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'senha' => 'required',
        ]);

        $nomeUsuario = $request->input('nome');
        $senha = $request->input('senha');

        $usuario = Usuario::where('Nome', $nomeUsuario)->first();


        if ($usuario && $senha = $usuario->senha) {
            //Usar futuramente
            //$request->session()->put('usuario_id', $usuario->id);
            return (object) [
                'message' => 'Usuário logado  com sucesso',
                'usuario' => $usuario,
                'status_code' => 200,
            ];  
            //return redirect()->route('home');
        }
        return (object) [
            'message' => 'Nome de usuário ou senha incorretos.',
            'status_code' => 400,
        ];
    }
}