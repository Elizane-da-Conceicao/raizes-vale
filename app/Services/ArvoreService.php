<?php

namespace App\Services;

use App\Models\Arvore;
use Illuminate\Http\Request;

class ArvoreService
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function store($request)
    {
        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if (!$usuario->model) {
            return (object) [
                'message' => $usuario->message,
                'model' => null,
                'status_code' => 404,
            ];
        }

        $validacao = '1';
        if ($usuario->model->administrador === '2') {
            $validacao = '2';
        }

        $arvore = new Arvore();
        $arvore->descendencia_id = $request->input('descendencia_id');
        $arvore->familia_id = $request->input('familia_id');
        $arvore->validacao = $validacao;
        $arvore->data_criacao = now();
        $arvore->save();

        return (object) [
            'message' => 'Arvore criado com sucesso',
            'model' => $arvore,
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $arvore = Arvore::find($id);

        if (!$arvore) {
            return (object) [
                'message' => 'Arvore não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $arvore->descendencia_id = $request->input('descendencia_id', $arvore->descendencia_id);
        $arvore->familia_id = $request->input('familia_id', $arvore->familia_id);
        $arvore->data_alteracao = now();
        $arvore->save();

        return (object) [
            'message' => 'Casal atualizado com sucesso',
            'model' => $arvore,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $arvore = Arvore::find($id);

        if (!$arvore) {
            return (object) [
                'message' => 'Arvore não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $arvore->delete();

        return (object) [
            'message' => 'Arvore excluída com sucesso',
            'model' => $arvore,
            'status_code' => 200,
        ];
    }
}
