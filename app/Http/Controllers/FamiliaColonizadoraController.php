<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FamiliaColonizadoraController extends Controller
{
    public function store(Request $request)
    {
        $familiaColonizadora = new FamiliaColonizadora();
        $familiaColonizadora->colonizador_id = $request->input('colonizador_id');
        $familiaColonizadora->familia_id = $request->input('familia_id');
        $familiaColonizadora->data_chegada = $request->input('data_chegada');
        $familiaColonizadora->comentarios = $request->input('comentarios');
        $familiaColonizadora->save();

        return response()->json(['message' => 'Família colonizadora criada com sucesso', 'familia_colonizadora' => $familiaColonizadora], 201);
    }

    public function index()
    {
        $familiasColonizadoras = FamiliaColonizadora::all();
        return response()->json(['familias_colonizadoras' => $familiasColonizadoras], 200);
    }

    public function update(Request $request, $id)
    {
        $familiaColonizadora = FamiliaColonizadora::find($id);

        if (!$familiaColonizadora) {
            return response()->json(['message' => 'Família colonizadora não encontrada'], 404);
        }

        $familiaColonizadora->colonizador_id = $request->input('colonizador_id', $familiaColonizadora->colonizador_id);
        $familiaColonizadora->familia_id = $request->input('familia_id', $familiaColonizadora->familia_id);
        $familiaColonizadora->data_chegada = $request->input('data_chegada', $familiaColonizadora->data_chegada);
        $familiaColonizadora->comentarios = $request->input('comentarios', $familiaColonizadora->comentarios);
        $familiaColonizadora->save();

        return response()->json(['message' => 'Família colonizadora atualizada com sucesso', 'familia_colonizadora' => $familiaColonizadora], 200);
    }

    public function destroy($id)
    {
        $familiaColonizadora = FamiliaColonizadora::find($id);

        if (!$familiaColonizadora) {
            return response()->json(['message' => 'Família colonizadora não encontrada'], 404);
        }

        $familiaColonizadora->delete();

        return response()->json(['message' => 'Família colonizadora excluída com sucesso'], 200);
    }
}
