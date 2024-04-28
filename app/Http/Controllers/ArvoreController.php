<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArvoreController extends Controller
{
    public function store(Request $request)
    {
        $arvore = new Arvore();
        $arvore->descendencia_id = $request->input('descendencia_id');
        $arvore->familia_id = $request->input('familia_id');
        $arvore->data_criacao = now();
        $arvore->data_alteracao = now();
        $arvore->save();

        return response()->json(['message' => 'Árvore criada com sucesso', 'arvore' => $arvore], 201);
    }

    public function index()
    {
        $arvores = Arvore::all();
        return response()->json(['arvores' => $arvores], 200);
    }

    public function update(Request $request, $id)
    {
        $arvore = Arvore::find($id);

        if (!$arvore) {
            return response()->json(['message' => 'Árvore não encontrada'], 404);
        }

        $arvore->descendencia_id = $request->input('descendencia_id', $arvore->descendencia_id);
        $arvore->familia_id = $request->input('familia_id', $arvore->familia_id);
        $arvore->data_alteracao = now();
        $arvore->save();

        return response()->json(['message' => 'Árvore atualizada com sucesso', 'arvore' => $arvore], 200);
    }

    public function destroy($id)
    {
        $arvore = Arvore::find($id);

        if (!$arvore) {
            return response()->json(['message' => 'Árvore não encontrada'], 404);
        }

        $arvore->delete();

        return response()->json(['message' => 'Árvore excluída com sucesso'], 200);
    }
}
