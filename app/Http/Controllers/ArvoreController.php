<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arvore;
use App\Services\ArvoreService;

class ArvoreController extends Controller
{
    protected $arvoreService;

    public function __construct(ArvoreService $arvoreService)
    {
        $this->arvoreService = $arvoreService;
    }
    
    //Grava Arvore
    public function store(Request $request)
    {
        $retorno = $this->arvoreService->store($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Lista Arvore
    public function index()
    {
        $arvores = Arvore::all();
        return response()->json(['arvores' => $arvores], 200);
    }
    //Altera Arvore
    public function update(Request $request, $id)
    {
        $retorno = $this->arvoreService->update($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Deleta Arvore
    public function destroy($id)
    {
        $retorno = $this->arvoreService->delete($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Valida Arvore
    public function valida($id)
    {
        $retorno = $this->arvoreService->delete($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Busca Arvore completa a partir de uma familia
    public function Montar($id)
    {
        $retorno = $this->arvoreService->MontaArvore($id);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Busca Arvore a partir de uma pessoa
    public function MontarArvorePessoa($id)
    {
        $retorno = $this->arvoreService->MontaArvorePessoa($id);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
}
