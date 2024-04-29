<?php

namespace App\Services;
use App\Models\FamiliaColonizadora;
use Illuminate\Http\Request;

class FamiliaColonizadoraService
{
    public function store(Request $request)
    {
        $familiaColonizadora = new FamiliaColonizadora();
        $familiaColonizadora->Colonizador_id = $request->input('Colonizador_id');
        $familiaColonizadora->Familia_id = $request->input('Familia_id');
        $familiaColonizadora->Data_chegada = $request->input('Data_chegada');
        $familiaColonizadora->Comentarios = $request->input('Comentarios');
        $familiaColonizadora->save();

        return (object) [
            'message' => 'Familia criado com sucesso',
            'familiaColonizadora' => $familiaColonizadora,
            'status_code' => 201,
        ];
    }

    public function update(Request $request, $id)
    {
        $familiaColonizadora = FamiliaColonizadora::find($id);

        if (!$familiaColonizadora) {
            return (object) [
                'message' => 'Familia não encontrado',
                'status_code' => 404,
            ];
        }
        
        $familiaColonizadora->Colonizador_id = $request->input('Colonizador_id');
        $familiaColonizadora->Familia_id = $request->input('Familia_id');
        $familiaColonizadora->Data_chegada = $request->input('Data_chegada');
        $familiaColonizadora->Comentarios = $request->input('Comentarios');
        $familiaColonizadora->save();

        return (object) [
            'message' => 'Familia atualizado com sucesso',
            'familiaColonizadora' => $familiaColonizadora,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $familiaColonizadora = FamiliaColonizadora::find($id);

        if (!$familiaColonizadora) {
            return (object) [
                'message' => 'Familia não encontrado',
                'status_code' => 404,
            ];
        }

        $familiaColonizadora->delete();

        return (object) [
            'message' => 'Familia excluido com sucesso',
            'familiaColonizadora' => $familiaColonizadora,
            'status_code' => 200,
        ];
    }
}