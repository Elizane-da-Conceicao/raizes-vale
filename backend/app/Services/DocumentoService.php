<?php

namespace App\Services;
use App\Models\Documento; 
use Illuminate\Http\Request;

class DocumentoService 
{
    protected $usuarioService;
    protected $documentoSolicitacaoService;

    public function __construct(UsuarioService $usuarioService, DocumentoSolicitacaoService $documentoSolicitacaoService)
    {
        $this->usuarioService = $usuarioService;
        $this->documentoSolicitacaoService = $documentoSolicitacaoService;
    }

    public function store($request)
    {
        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if (!$usuario->model) {
            return (object) [
                'message' => $usuario->message,
                'model' => null,
                'status_code' => 404,
            ];
        }

        $documento = new Documento(); 
        $documento->pessoa_id = $request->input('pessoa_id');
        $documento->Descricao = $request->input('Descricao');
        $documento->Caminho = $request->input('Caminho');
        $documento->Tipo_arquivo = $request->input('Tipo_arquivo');
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
        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if ($usuario->model->administrador === '1') 
        {
            return $this->documentoSolicitacaoService->store($request,$id);
        }

        $documento = Documento::find($id); 
        if (!$documento) {
            return (object) [
                'message' => 'Documento não encontrado', 
                'model' => null,
                'status_code' => 404,
            ];
        }

        Documento::where('documento_id', $id) 
        ->update([
            'pessoa_id' => $pessoa_id,
            'Descricao' => $descricao,
            'Caminho' => $caminho,
            'Tipo_arquivo' => $tipo_arquivo,
            'Data_criacao' => $data_criacao,
        ]);

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

    public function Validacao(Request $request,$id)
    {
        $documento = Documento::find($id);
        if (!$documento) {
            return (object) [
                'message' => 'Documento não encontrado.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $documento->validado =  $request->input('validado');
        $documento->motivo =  $request->input('motivo');
        $documento->save();

        return (object) [
            'message' => 'Documento validado.',
            'model' => $pessoa,
            'status_code' => 200,
        ];
    }

    public function ValidacaoSolicitacao(Request $request,$id)
    {
        $documentoSolicitacao = DocumentoSolicitacao::find($id);
        if (!$documentoSolicitacao) {
            return (object) [
                'message' => 'Pessoa não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }
        if($request->input('validado') !== 2)
        {
            $documentoSolicitacao->validado = $request->input('validado');
            $documentoSolicitacao->motivo =  $request->input('motivo');
            $documentoSolicitacao->save();

            return (object) [
                'message' => 'Pessoa validada.',
                'model' => $documentoSolicitacao,
                'status_code' => 200,
            ];
        }

        $documento = new Documento(); 
        $documento->pessoa_id = $documentoSolicitacao->pessoa_id;
        $documento->Descricao = $documentoSolicitacao->Descricao;
        $documento->Caminho = $documentoSolicitacao->Caminho;
        $documento->Tipo_arquivo = $documentoSolicitacao->Tipo_arquivo;
        $documento->Data_alteracao = now();
        $documento->Validacao = $request->input('validado');
        $documento->save();

        return (object) [
            'message' => 'Pessoa validada.',
            'model' => $pessoa,
            'status_code' => 200,
        ];
    }
}
