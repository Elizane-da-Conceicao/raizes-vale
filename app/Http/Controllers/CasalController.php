<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Casal;
use App\Services\CasalService;

class CasalController extends Controller
{
    protected $casalService;

    public function __construct(CasalService $casalService)
    {
        $this->casalService = $casalService;
    }
    
    //Grava Casal
    public function store(Request $request)
    {
        $retorno = $this->casalService->store($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Lista Casal
    public function index()
    {
        $casais = Casal::all();
        return response()->json(['casais' => $casais], 200);
    }
    //Altera Casal
    public function update(Request $request, $id)
    {
        $retorno = $this->casalService->update($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Deleta Casal
    public function destroy($id)
    {
        $retorno = $this->casalService->delete($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
}
