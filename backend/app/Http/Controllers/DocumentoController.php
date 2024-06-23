<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento; // Alteração de Familia para Documento
use App\Services\DocumentoService; // Não alterado, presumindo que o serviço ainda seja válido para Documento

class DocumentoController extends Controller
{
    protected $documentoService;

    public function __construct(DocumentoService $documentoService)
    {
        $this->documentoService = $documentoService;
    }
    
    //Grava documento
    public function store(Request $request)
    {
        $retorno = $this->documentoService->store($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Lista documentos
    public function index()
    {
        $documentos = Documento::all();
        return response()->json(['documentos' => $documentos], 200);
    }
    //Altera documentos
    public function update(Request $request, $id)
    {
        $retorno = $this->documentoService->update($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Obter documento por idPessoa
    public function show($id)
    {
        $retorno = $this->documentoService->ObterDocumentoPorIdPessoa($id);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
     //Obter documento por idPessoa
     public function solicitacao($id)
     {
         $retorno = $this->documentoService->ObterDocumentoPorIdPessoaSolicitacao($id);
         return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
     }
    //Deleta documentos
    public function destroy($id)
    {
        $retorno = $this->documentoService->delete($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Altera create
    public function validacao(Request $request)
    {
        $retorno = $this->documentoService->validacao($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //validacao update
    public function validacaoSolicitacao(Request $request, $id)
    {
        $retorno = $this->documentoService->validacaoSolicitacao($request,$id);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
}
