<?php

namespace App\Services;
use App\Models\Documento; 
use App\Models\DocumentoSolicitacao; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        // Verifique se o arquivo Base64 foi enviado
        if ($request->filled('arquivo')) {
            $base64File = $request->input('arquivo');
            if (preg_match('/^data:(.*?);base64,/', $base64File, $match)) {
                // Extrair o tipo MIME do arquivo
                $mime = $match[1];
                // Remover a parte "data:tipo/arquivo;base64," da string base64
                $base64File = substr($base64File, strpos($base64File, ',') + 1);
                // Decodificar a string base64
                $fileData = base64_decode($base64File);

                // Salvar o arquivo em algum local no servidor
                $hashDocuemnto = Str::random(10);
                // Determinar a extensão do arquivo a partir do tipo MIME
                $extension = explode('/', $mime)[1];
                $filename = $hashDocuemnto .".". $extension; 
                $path = '/Documentos/'; 
                Storage::put($path . $filename, $fileData);

                // Verificar se o arquivo foi salvo corretamente
                if (Storage::exists($path . $filename)) {
                    $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
                    if (!$usuario->model) {
                        return (object) [
                            'message' => "Não há usuario",
                            'model' => null,
                            'status_code' => 404,
                        ];
                    }

                    $documento = new Documento();
                    $documento->pessoa_id = $request->input('pessoa_id');
                    $documento->Descricao = $request->input('Descricao');
                    $documento->Caminho = $path . $filename;
                    $documento->Tipo_arquivo = $request->input('Tipo_arquivo');
                    $documento->privado = $request->input('privado');
                    $documento->Data_criacao = now();
                    $documento->save();

                    return (object) [
                        'message' => 'Documento criado com sucesso',
                        'model' => $documento,
                        'status_code' => 201,
                    ];
                } else {
                    return (object) [
                        'message' => 'Erro ao salvar o arquivo.',
                        'model' => null,
                        'status_code' => 500,
                    ];
                }
            } else {
                return response()->json([
                    'message' => 'Formato de arquivo inválido.',
                    'status_code' => 400,
                ], 400);
            }
            
        } else {
            return (object) [
                'message' => 'Nenhum arquivo enviado.',
                'model' => null,
                'status_code' => 400,
            ];
        }
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
            'Privado'
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

    public function ObterDocumentoPorIdPessoa($idPessoa)
    {
        $documentos = Documento::where('pessoa_id', $idPessoa)->get();
        if(!$documentos)
        {
            return (object) [
                'message' => 'Documentos não encontrados.',
                'model' => null,
                'status_code' => 400,
            ];
        }
        $arquivos = [];
        foreach($documentos as $documento)
        {
            $nomeArquivo = explode("/Documentos/", $documento->Caminho)[1];
            $arquivoBase64 = $this->buscarArquivosPorPessoa($nomeArquivo);
            $nomeEArquivo = [
                'privado' => $documento->Privado,
                'nome' => $documento->Descricao,
                'caminho' => $nomeArquivo = explode("/Documentos/", $documento->Caminho)[1]
            ];

            array_push($arquivos, $nomeEArquivo);
        }

        return (object) [
            'message' => 'Documentos achados com sucesso',
            'model' => $arquivos,
            'status_code' => 200,
        ];
    }

    public function ObterDocumentoPorIdPessoaSolicitacao($idPessoa)
    {
        $documentos = DocumentoSolicitacao::where('pessoa_id_solicitacao', $idPessoa)->get();
        if(!$documentos)
        {
            return (object) [
                'message' => 'Documentos não encontrados.',
                'model' => null,
                'status_code' => 400,
            ];
        }
        $arquivos = [];
        foreach($documentos as $documento)
        {
            $nomeArquivo = explode("/Documentos/", $documento->Caminho)[1];
            $arquivoBase64 = $this->buscarArquivosPorPessoa($nomeArquivo);
            $nomeEArquivo = [
                'privado' => $documento->privado,
                'nome' => $documento->Descricao,
                'caminho' => $nomeArquivo = explode("/Documentos/", $documento->Caminho)[1]
            ];

            array_push($arquivos, $nomeEArquivo);
        }

        return (object) [
            'message' => 'Documentos achados com sucesso',
            'model' => $arquivos,
            'status_code' => 200,
        ];
    }


    public function buscarArquivosPorPessoa($nomeArquivo)
    {
        $arquivos = Storage::files('Documentos');
        
        foreach ($arquivos as $arquivo) {
            if (basename($arquivo) === $nomeArquivo) {
                $conteudoArquivo = Storage::get($arquivo);
        
                $base64Arquivo = base64_encode($conteudoArquivo);
        
                return $base64Arquivo;
            }
        }
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
