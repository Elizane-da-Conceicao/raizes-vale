<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function store(Request $request)
    {
        $documento = new Documento();
        $documento->descricao = $request->input('descricao');
        $documento->caminho = $request->input('caminho');
        $documento->tipo_arquivo = $request->input('tipo_arquivo');
        $documento->save();

        return response()->json(['message' => 'Documento criado com sucesso', 'documento' => $documento], 201);
    }

    public function index()
    {
        $documentos = Documento::all();
        return response()->json(['documentos' => $documentos], 200);
    }

    public function update(Request $request, $id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return response()->json(['message' => 'Documento não encontrado'], 404);
        }

        $documento->descricao = $request->input('descricao', $documento->descricao);
        $documento->caminho = $request->input('caminho', $documento->caminho);
        $documento->tipo_arquivo = $request->input('tipo_arquivo', $documento->tipo_arquivo);
        $documento->save();

        return response()->json(['message' => 'Documento atualizado com sucesso', 'documento' => $documento], 200);
    }

    public function destroy($id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return response()->json(['message' => 'Documento não encontrado'], 404);
        }

        $documento->delete();

        return response()->json(['message' => 'Documento excluído com sucesso'], 200);
    }
}
