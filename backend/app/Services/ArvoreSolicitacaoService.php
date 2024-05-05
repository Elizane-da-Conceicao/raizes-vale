<?php

namespace App\Services;

use App\Models\Arvore;
use Illuminate\Http\Request;

class ArvoreSolicitacaoService
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function store($request)
    {
        $arvore = new Arvore_Solicitacao();
        $arvore->descendencia_id = $request->input('descendencia_id');
        $arvore->familia_id = $request->input('familia_id');
        $arvore->descendencia_id = $request->input('descendencia_id_solicitacao');
        $arvore->familia_id = $request->input('familia_id_solicitacao');
        $arvore->usuario_id = $request->input('usuario_id');
        $arvore->validacao = '1';
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

        $usuario = $request->input('usuario_id');
        if($usuario !== $arvore->usuario_id)
        {
            return (object) [
                'message' => 'Usuario não possue permissão para alteração dessa arvore.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $arvore->descendencia_id = $request->input('descendencia_id');
        $arvore->familia_id = $request->input('familia_id');
        $arvore->descendencia_id = $request->input('descendencia_id_solicitacao');
        $arvore->familia_id = $request->input('familia_id_solicitacao');
        $arvore->data_alteracao = now();
        $arvore->save();

        return (object) [
            'message' => 'Arvore atualizado com sucesso',
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
