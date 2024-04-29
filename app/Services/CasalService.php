<?php

namespace App\Services;

use App\Models\Casal;
use Illuminate\Http\Request;

class CasalService
{
    public function store(Request $request)
    {
        $casal = new Casal();
        $casal->Marido_id = $request->input('Marido_id');
        $casal->Esposa_id = $request->input('Esposa_id');
        $casal->Data_casamento = $request->input('Data_casamento');
        $casal->save();

        return (object) [
            'message' => 'Casal criado com sucesso',
            'casal' => $casal,
            'status_code' => 201,
        ];
    }

    public function update(Request $request, $id)
    {
        $casal = Casal::find($id);

        if (!$casal) {
            return (object) [
                'message' => 'Casal não encontrado',
                'status_code' => 404,
            ];
        }

        $casal->Marido_id = $request->input('Marido_id', $casal->Marido_id);
        $casal->Esposa_id = $request->input('Esposa_id', $casal->Esposa_id);
        $casal->Data_casamento = $request->input('Data_casamento', $casal->Data_casamento);
        $casal->save();

        return (object) [
            'message' => 'Casal atualizado com sucesso',
            'casal' => $casal,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $casal = Casal::find($id);

        if (!$casal) {
            return (object) [
                'message' => 'Casal não encontrado',
                'status_code' => 404,
            ];
        }

        $casal->delete();

        return (object) [
            'message' => 'Casal excluído com sucesso',
            'casal' => $casal,
            'status_code' => 200,
        ];
    }
}
