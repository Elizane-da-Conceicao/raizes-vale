<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DescendenciaController extends Controller
{
    public function store(Request $request)
    {
        $descendencia = new Descendencia();
        $descendencia->filho_id = $request->input('filho_id');
        $descendencia->casal_id = $request->input('casal_id');
        $descendencia->data_criacao = now();
        $descendencia->save();

        return response()->json(['message' => 'Descendência criada com sucesso', 'descendencia' => $descendencia], 201);
    }

    public function index()
    {
        $descendencias = Descendencia::all();
        return response()->json(['descendencias' => $descendencias], 200);
    }

    public function update(Request $request, $id)
    {
        $descendencia = Descendencia::find($id);

        if (!$descendencia) {
            return response()->json(['message' => 'Descendência não encontrada'], 404);
        }

        $descendencia->filho_id = $request->input('filho_id', $descendencia->filho_id);
        $descendencia->casal_id = $request->input('casal_id', $descendencia->casal_id);
        $descendencia->data_criacao = now();
        $descendencia->save();

        return response()->json(['message' => 'Descendência atualizada com sucesso', 'descendencia' => $descendencia], 200);
    }

    public function destroy($id)
    {
        $descendencia = Descendencia::find($id);

        if (!$descendencia) {
            return response()->json(['message' => 'Descendência não encontrada'], 404);
        }

        $descendencia->delete();

        return response()->json(['message' => 'Descendência excluída com sucesso'], 200);
    }
}
