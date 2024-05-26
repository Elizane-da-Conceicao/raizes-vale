<?php

namespace App\Services;
use App\Models\Descendencia; 
use Illuminate\Http\Request;

class DescendenciaService 
{
    protected $usuarioService;
    protected $descendenciaSolictacaoService;

    public function __construct(UsuarioService $usuarioService, DescendenciaSolicitacaoService $descendenciaSolictacaoService )
    {
        $this->usuarioService = $usuarioService;
        $this->descendenciaSolictacaoService = $descendenciaSolictacaoService;
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
        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if ($usuario->model->administrador === '1') 
        {
            return $this->descendenciaSolictacaoService->update($request);
        }

        $descendencia = Descendencia::find($id); 
        if (!$descendencia) {
            return (object) [
                'message' => 'Descendencia não encontrada', 
                'model' => null,
                'status_code' => 404,
            ];
        }

        Descendencia::where('descendencia_id', $id)
        ->update([
            'Filho_id' => $filho_id,
            'Casal_id' => $casal_id,
            'Data_alteracao' => $data_alteracao,
        ]);
        
        $descendencia = Descendencia::find($id); 
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
