<?php

namespace App\Services;
use App\Models\Documento; 
use Illuminate\Http\Request;

class DocumentoService 
{
    public function store(Request $request)
    {
        $documento = new Documento(); 
        $documento->pessoa_id = $request->input('pessoa_id');
        $documento->Descricao = $request->input('Descricao');
        $documento->Caminho = $request->input('Caminho');
        $documento->Tipo_arquivo = $request->input('Tipo_arquivo');
        $documento->Data_criacao = now();
        $documento->save();

        return (object) [
            'message' => 'Documento criado com sucesso', 
            'documento' => $documento, 
            'status_code' => 201,
        ];
    }

    public function update(Request $request, $id)
    {
        $documento = Documento::find($id); 

        if (!$documento) {
            return (object) [
                'message' => 'Documento não encontrado', 
                'status_code' => 404,
            ];
        }

        $documento->pessoa_id = $request->input('pessoa_id');
        $documento->Descricao = $request->input('Descricao');
        $documento->Caminho = $request->input('Caminho');
        $documento->Tipo_arquivo = $request->input('Tipo_arquivo');
        $documento->Data_alteracao = now();
        $documento->save();

        return (object) [
            'message' => 'Documento atualizado com sucesso',
            'documento' => $documento,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return (object) [
                'message' => 'Documento não encontrado',
                'status_code' => 404,
            ];
        }

        $documento->delete();

        return (object) [
            'message' => 'Documento excluido com sucesso',
            'documento' => $documento,
            'status_code' => 200,
        ];
    }
}
