<?php

namespace App\Services;
use App\Models\Familia;
use Illuminate\Http\Request;

class FamiliaService
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function store($request)
    {
        $familia = new FamiliaSolicitacao();
        $familia->Nome = $request->input('Nome');
        $familia->Data_criacao = $request->input('Data_criacao');
        $familia->Data_alteracao = $request->input('Data_alteracao');
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

    public function update($request, $id)
    {
        $familia = FamiliaSolicitacao::find($id);

        if (!$familia) {
            return (object) [
                'message' => 'Familia não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }
        
        $familia->Nome = $request->input('Nome');
        $familia->Data_criacao = $request->input('Data_criacao');
        $familia->Data_alteracao = $request->input('Data_alteracao');
        $familia->Resumo = $request->input('Resumo');
        $familia->Colonizador = $request->input('Colonizador');
        $familia->save();

        return (object) [
            'message' => 'Familia atualizado com sucesso',
            'model' => $familia,
            'status_code' => 200,
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