<?php

namespace App\Services;
use App\Models\Familia;
use Illuminate\Http\Request;

class FamiliaService
{
    public function store(Request $request)
    {
        $familia = new Familia();
        $familia->Nome = $request->input('Nome');
        $familia->Data_criacao = $request->input('Data_criacao');
        $familia->Data_alteracao = $request->input('Data_alteracao');
        $familia->Resumo = $request->input('Resumo');
        $familia->Colonizador = $request->input('Colonizador');
        $familia->save();

        return (object) [
            'message' => 'Familia criado com sucesso',
            'familia' => $familia,
            'status_code' => 201,
        ];
    }

    public function update(Request $request, $id)
    {
        $familia = Familia::find($id);

        if (!$familia) {
            return (object) [
                'message' => 'Familia não encontrado',
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
            'familia' => $familia,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $familia = Familia::find($id);

        if (!$familia) {
            return (object) [
                'message' => 'Familia não encontrado',
                'status_code' => 404,
            ];
        }

        $familia->delete();

        return (object) [
            'message' => 'Familia excluido com sucesso',
            'familia' => $familia,
            'status_code' => 200,
        ];
    }
}