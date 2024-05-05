<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Services\PessoaService;

class PessoaController extends Controller
{
    protected $pessoaService;

    public function __construct(PessoaService $pessoaService)
    {
        $this->pessoaService = $pessoaService;
    }
    
    //Grava pessoas
    public function store(Request $request)
    {
        $retorno = $this->pessoaService->store($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Lista pessoas
    public function index()
    {
        $pessoas = Pessoa::all();
        return response()->json(['pessoas' => $pessoas], 200);
    }
    //Altera pessoas
    public function update(Request $request, $id)
    {
        $retorno = $this->pessoaService->update($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Deleta pessoas
    public function destroy($id)
    {
        $retorno = $this->pessoaService->delete($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Obter pessoa por id
    public function show($id)
    {
        $retorno = $this->pessoaService->ObterPessoaporId($id);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
}
