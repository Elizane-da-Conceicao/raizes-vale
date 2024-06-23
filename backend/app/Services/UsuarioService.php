<?php

namespace App\Services;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioService
{
    public function store($request)
    {

        $usuarioExiste = Usuario::where('Email', $request->input('Email'))->first();
        if ($usuarioExiste !== null) {
            return (object) [
                'message' => 'Ja possue um usuario cadastrado com esse Email.',
                'model' => null,
                'status_code' => 400,
            ];
        }

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
            'model' => $usuario,
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return (object) [
                'message' => 'Usuário não encontrado',
                'model' => null,
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
            'model' => $usuario,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return (object) [
                'message' => 'Usuário não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $usuario->delete();

        return (object) [
            'message' => 'Usuário excluido com sucesso',
            'model' => $usuario,
            'status_code' => 200,
        ];
    }
    
    public function logar($request)
    {
        $request->validate([
            'email' => 'required',
            'senha' => 'required',
        ]);

        $email = $request->input('email');
        $senha = $request->input('senha');

        $usuario = Usuario::where('Email', $email)->first();


        if ($usuario && $senha === $usuario->senha) {
            //Usar futuramente
            //$request->session()->put('usuario_id', $usuario->id);
            return (object) [
                'message' => 'Usuário logado  com sucesso',
                'model' => $usuario,
                'status_code' => 200,
            ];  
            //return redirect()->route('home');
        }
        return (object) [
            'message' => 'Email de usuário ou senha incorretos.',
            'model' => null,
            'status_code' => 400,
        ];
    }

    public function ObterUsuarioPorId($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return (object) [
                'message' => 'Usuario não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        return (object) [
            'message' => 'Usuario encontrada.',
            'model' => $usuario,
            'status_code' => 200,
        ];
    }
}