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
        $arvore = new ArvoreSolicitacao();
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

    public function valida($request)
    {
        if($request->input('validacao') === '2')
        {
            
        }
        if($request->input('validacao') === '3')
        {
            $arvore = ArvoreSolicitacao::find($request->input('ArvoreSolicitacao_id'));
            $arvore->Validacao = '3';
            $arvore->Motivo = $request->input('Motivo');
            $arvore->save();
        }
    }
}
