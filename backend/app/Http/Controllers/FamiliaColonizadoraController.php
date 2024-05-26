<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamiliaColonizadora; // Substituído de Pessoa para Familia
use App\Services\FamiliaColonizadoraService; // Não alterado, presumindo que o serviço ainda seja válido para Família

class FamiliaColonizadoraController extends Controller
{
    protected $familiaColonizadoraService;

    public function __construct(FamiliaColonizadoraService $familiaColonizadoraService)
    {
        $this->familiaColonizadoraService = $familiaColonizadoraService;
    }
    
    //Grava familia
    public function store(Request $request)
    {
        $retorno = $this->familiaColonizadoraService->store($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Lista familias
    public function index()
    {
        $familiaColonizadoras = FamiliaColonizadora::all(); 
        return response()->json(['familiaColonizadoras' => $familiaColonizadoras], 200);
    }
    //Altera familias
    public function update(Request $request, $id)
    {
        $retorno = $this->familiaColonizadoraService->update($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Deleta familias
    public function destroy($id)
    {
        $retorno = $this->familiaColonizadoraService->delete($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Altera create
    public function validacao(Request $request)
    {
        $retorno = $this->familiaColonizadoraService->validacao($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //validacao update
    public function validacaoSolicitacao(Request $request, $id)
    {
        $retorno = $this->familiaColonizadoraService->validacaoSolicitacao($request,$id);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
}
