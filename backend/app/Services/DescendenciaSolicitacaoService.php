<?php

namespace App\Services;
use App\Models\Descendencia; 
use Illuminate\Http\Request;

class DescendenciaSolicitacaoService 
{
    public function store($request)
    {
        $descendencia = new DescendenciaSolicitacao(); 
        $descendencia->Filho_id_solicitacao = $request->input('Filho_id_solicitacao');
        $descendencia->Casal_id_solicitacao = $request->input('Casal_id_solicitacao');
        $descendencia->Filho_id = $request->input('Filho_id');
        $descendencia->Casal_id = $request->input('Casal_id');
        $descendencia->usuario_id = $request->input('Usuario_id');
        $descendencia->Data_criacao = now();
        $descendencia->save();

        return (object) [
            'message' => 'Descendencia criada com sucesso', 
            'model' => $descendencia, 
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $descendencia = DescendenciaSolicitacao::find($id); 

        if (!$descendencia) {
            return (object) [
                'message' => 'Descendencia não encontrada', 
                'model' => null,
                'status_code' => 404,
            ];
        }

        $descendencia->Filho_id_solicitacao = $request->input('Filho_id_solicitacao');
        $descendencia->Casal_id_solicitacao = $request->input('Casal_id_solicitacao');
        $descendencia->Filho_id = $request->input('Filho_id');
        $descendencia->Casal_id = $request->input('Casal_id');
        $descendencia->Data_alteracao = now();
        $descendencia->save();

        return (object) [
            'message' => 'Descendencia atualizada com sucesso',
            'model' => $descendencia,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $descendencia = DescendenciaSolicitacao::find($id);

        if (!$descendencia) {
            return (object) [
                'message' => 'Descendencia não encontrada',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $descendencia->delete();

        return (object) [
            'message' => 'Descendencia excluida com sucesso',
            'model' => $descendencia,
            'status_code' => 200,
        ];
    }
}
