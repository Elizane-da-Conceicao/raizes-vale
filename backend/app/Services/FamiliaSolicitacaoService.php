<?php

namespace App\Services;
use App\Models\Familia;
use Illuminate\Http\Request;

class FamiliaSolicitacaoService
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function store($request,$id)
    {
        $familia = new FamiliaSolicitacao();
        $familia->Familia_id = $id;
        $familia->Nome = $request->input('Nome');
        $familia->Data_criacao = now();
        $familia->Resumo = $request->input('Resumo');
        $familia->Colonizador = $request->input('Colonizador');
        $familia->Validacao = '1';
        $familia->Usuario_id = $request->input('Usuario_id');
        $familia->save();

        return (object) [
            'message' => 'Familia criado com sucesso',
            'model' => $familia,
            'status_code' => 201,
        ];
    }

    public function delete($id)
    {
        $familia = Familia::find($id);

        if (!$familia) {
            return (object) [
                'message' => 'Familia não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $familia->delete();

        return (object) [
            'message' => 'Familia excluido com sucesso',
            'model' => $familia,
            'status_code' => 200,
        ];
    }
}