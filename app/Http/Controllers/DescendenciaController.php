<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descendencia;
use App\Services\DescendenciaService; 

class DescendenciaController extends Controller
{
    protected $descendenciaService;

    public function __construct(DescendenciaService $descendenciaService)
    {
        $this->descendenciaService = $descendenciaService;
    }
    
    //Grava descendencia
    public function store(Request $request)
    {
        $retorno = $this->descendenciaService->store($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Lista descendencias
    public function index()
    {
        $arvores = Arvore::all(); 
        return response()->json(['descendencias' => $descendencias], 200);
    }
    //Altera descendencias
    public function update(Request $request, $id)
    {
        $retorno = $this->descendenciaService->update($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Deleta descendencias
    public function destroy($id)
    {
        $retorno = $this->descendenciaService->delete($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
}
