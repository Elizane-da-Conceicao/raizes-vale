<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    public function store(Request $request)
    {
        $familia = new Familia();
        $familia->nome = $request->input('nome');
        $familia->resumo = $request->input('resumo');
        $familia->data_criacao = now();
        $familia->data_alteracao = now();
        $familia->colonizador = $request->input('colonizador');
        $familia->save();

        return response()->json(['message' => 'Família criada com sucesso', 'familia' => $familia], 201);
    }

    public function index()
    {
        $familias = Familia::all();
        return response()->json(['familias' => $familias], 200);
    }

    public function update(Request $request, $id)
    {
        $familia = Familia::find($id);

        if (!$familia) {
            return response()->json(['message' => 'Família não encontrada'], 404);
        }

        $familia->nome = $request->input('nome', $familia->nome);
        $familia->resumo = $request->input('resumo', $familia->resumo);
        $familia->data_alteracao = now();
        $familia->colonizador = $request->input('colonizador', $familia->colonizador);
        $familia->save();

        return response()->json(['message' => 'Família atualizada com sucesso', 'familia' => $familia], 200);
    }

    public function destroy($id)
    {
        $familia = Familia::find($id);

        if (!$familia) {
            return response()->json(['message' => 'Família não encontrada'], 404);
        }

        $familia->delete();

        return response()->json(['message' => 'Família excluída com sucesso'], 200);
    }
}
