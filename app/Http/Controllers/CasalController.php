<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Casal;
use App\Services\CasalService;

class CasalController extends Controller
{
    public function store(Request $request)
    {
        $casal = new Casal();
        $casal->marido_id = $request->input('marido_id');
        $casal->esposa_id = $request->input('esposa_id');
        $casal->data_casamento = $request->input('data_casamento');
        $casal->save();

        return response()->json(['message' => 'Casal criado com sucesso', 'casal' => $casal], 201);
    }

    public function index()
    {
        $casais = Casal::all();
        return response()->json(['casais' => $casais], 200);
    }

    public function update(Request $request, $id)
    {
        $casal = Casal::find($id);

        if (!$casal) {
            return response()->json(['message' => 'Casal não encontrado'], 404);
        }

        $casal->marido_id = $request->input('marido_id', $casal->marido_id);
        $casal->esposa_id = $request->input('esposa_id', $casal->esposa_id);
        $casal->data_casamento = $request->input('data_casamento', $casal->data_casamento);
        $casal->save();

        return response()->json(['message' => 'Casal atualizado com sucesso', 'casal' => $casal], 200);
    }

    public function destroy($id)
    {
        $casal = Casal::find($id);

        if (!$casal) {
            return response()->json(['message' => 'Casal não encontrado'], 404);
        }

        $casal->delete();

        return response()->json(['message' => 'Casal excluído com sucesso'], 200);
    }
}
