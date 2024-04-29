<?php

namespace App\Services;
use App\Models\Descendencia; 
use Illuminate\Http\Request;

class DescendenciaService 
{
    public function store(Request $request)
    {
        $descendencia = new Descendencia(); 
        $descendencia->Filho_id = $request->input('Filho_id');
        $descendencia->Casal_id = $request->input('Casal_id');
        $descendencia->Data_criacao = now();
        $descendencia->save();

        return (object) [
            'message' => 'Descendencia criada com sucesso', 
            'descendencia' => $descendencia, 
            'status_code' => 201,
        ];
    }

    public function update(Request $request, $id)
    {
        $descendencia = Descendencia::find($id); 

        if (!$descendencia) {
            return (object) [
                'message' => 'Descendencia não encontrada', 
                'status_code' => 404,
            ];
        }

        $descendencia->Filho_id = $request->input('Filho_id');
        $descendencia->Casal_id = $request->input('Casal_id');
        $descendencia->Data_alteracao = now();
        $descendencia->save();

        return (object) [
            'message' => 'Descendencia atualizada com sucesso',
            'descendencia' => $descendencia,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $descendencia = Descendencia::find($id);

        if (!$descendencia) {
            return (object) [
                'message' => 'Descendencia não encontrada',
                'status_code' => 404,
            ];
        }

        $descendencia->delete();

        return (object) [
            'message' => 'Descendencia excluida com sucesso',
            'descendencia' => $descendencia,
            'status_code' => 200,
        ];
    }
}
