<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Familia; // Substituído de Pessoa para Familia
use App\Services\FamiliaService; // Não alterado, presumindo que o serviço ainda seja válido para Família

class FamiliaController extends Controller
{
    protected $familiaService;

    public function __construct(FamiliaService $familiaService)
    {
        $this->familiaService = $familiaService;
    }
    
    //Grava familia
    public function store(Request $request)
    {
        $retorno = $this->familiaService->store($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Lista familias
    public function index()
    {
        $familias = Familia::all();
        return response()->json(['familias' => $familias], 200);
    }
    //Altera familias
    public function update(Request $request, $id)
    {
        $retorno = $this->familiaService->update($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Deleta familias
    public function destroy($id)
    {
        $retorno = $this->familiaService->delete($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Altera create
    public function validacao(Request $request)
    {
        $retorno = $this->familiaService->validacao($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //validacao update
    public function validacaoSolicitacao(Request $request, $id)
    {
        $retorno = $this->familiaService->validacaoSolicitacao($request,$id);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
}
