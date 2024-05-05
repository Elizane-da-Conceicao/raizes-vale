<?php

namespace App\Services;
use App\Models\Descendencia; 
use Illuminate\Http\Request;

class DescendenciaService 
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
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

        $descendencia = new Descendencia(); 
        $descendencia->Filho_id = $request->input('Filho_id');
        $descendencia->Casal_id = $request->input('Casal_id');
        $descendencia->Data_criacao = now();
        $descendencia->save();

        return (object) [
            'message' => 'Descendencia criada com sucesso', 
            'model' => $descendencia, 
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $descendencia = Descendencia::find($id); 

        if (!$descendencia) {
            return (object) [
                'message' => 'Descendencia não encontrada', 
                'model' => null,
                'status_code' => 404,
            ];
        }

        $descendencia->Filho_id = $request->input('Filho_id');
        $descendencia->Casal_id = $request->input('Casal_id');
        $descendencia->Data_alteracao = now();
        $descendencia->save();

        return (object) [
            'message' => 'Descendencia atualizada com sucesso',
            'model' => $descendencia,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $descendencia = Descendencia::find($id);

        if (!$descendencia) {
            return (object) [
                'message' => 'Descendencia não encontrada',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $descendencia->delete();

        return (object) [
            'message' => 'Descendencia excluida com sucesso',
            'model' => $descendencia,
            'status_code' => 200,
        ];
    }
}
