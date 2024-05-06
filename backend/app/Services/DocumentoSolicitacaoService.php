<?php

namespace App\Services;
use App\Models\Documento; 
use Illuminate\Http\Request;

class DocumentoService 
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function store($request)
    {
        $documento = new DocumentoSolicitacao(); 
        $documento->pessoa_id = $request->input('pessoa_id');
        $documento->pessoa_id_solicitacao = $request->input('pessoa_id_solicitacao');
        $documento->Descricao = $request->input('Descricao');
        $documento->Caminho = $request->input('Caminho');
        $documento->Tipo_arquivo = $request->input('Tipo_arquivo');
        $documento->validacao = '1';
        $documento->Data_criacao = now();
        $documento->save();

        return (object) [
            'message' => 'Documento criado com sucesso', 
            'model' => $documento, 
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $documento = DocumentoSolicitacao::find($id); 

        if (!$documento) {
            return (object) [
                'message' => 'Documento não encontrado', 
                'model' => null,
                'status_code' => 404,
            ];
        }

        $documento->pessoa_id = $request->input('pessoa_id');
        $documento->pessoa_id_solicitacao = $request->input('pessoa_id_solicitacao');
        $documento->Descricao = $request->input('Descricao');
        $documento->Caminho = $request->input('Caminho');
        $documento->Tipo_arquivo = $request->input('Tipo_arquivo');
        $documento->Data_alteracao = now();
        $documento->save();

        return (object) [
            'message' => 'Documento atualizado com sucesso',
            'model' => $documento,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $documento = Documento::find($id);

        if (!$documento) {
            return (object) [
                'message' => 'Documento não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $documento->delete();

        return (object) [
            'message' => 'Documento excluido com sucesso',
            'model' => $documento,
            'status_code' => 200,
        ];
    }
}
