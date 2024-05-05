<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Services\UsuarioService;

class UsuarioController extends Controller
{
    
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }
    
    //Grava usuario
    public function store(Request $request)
    {
        $retorno = $this->usuarioService->store($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Lista Usuarios
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json(['usuarios' => $usuarios], 200);
    }
    //Altera Usuarios
    public function update(Request $request, $id)
    {
        $retorno = $this->usuarioService->update($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Deleta Usuarios
    public function destroy($id)
    {
        $retorno = $this->usuarioService->delete($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
    //Logar usuarios
    public function logar(Request $request)
    {
        $retorno = $this->usuarioService->logar($request);
        return response()->json(['message' => $retorno->message, 'model' => $retorno->model], $retorno->status_code);
    }
}
