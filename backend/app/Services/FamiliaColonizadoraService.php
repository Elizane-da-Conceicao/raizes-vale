<?php

namespace App\Services;
use App\Models\FamiliaColonizadora;
use Illuminate\Http\Request;

class FamiliaColonizadoraService
{
    protected $usuarioService;
    protected $familiaColonizadoraSolicitacao;

    public function __construct(UsuarioService $usuarioService,FamiliaColonizadoraSolicitacao $familiaColonizadoraSolicitacao)
    {
        $this->usuarioService = $usuarioService;
        $this->familiaColonizadoraSolicitacao = $familiaColonizadoraSolicitacao;
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

        if ($usuario->model->administrador === '1') {
            $this->familiaColonizadoraSolicitacao->store($request);
        }

        $familiaColonizadora = new FamiliaColonizadora();
        $familiaColonizadora->Colonizador_id = $request->input('Colonizador_id');
        $familiaColonizadora->Familia_id = $request->input('Familia_id');
        $familiaColonizadora->Data_chegada = $request->input('Data_chegada');
        $familiaColonizadora->save();

        return (object) [
            'message' => 'Familia criado com sucesso',
            'model' => $familiaColonizadora,
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if ($usuario->model->administrador === '1') 
        {
            return $this->familiaColonizadoraSolicitacao->update($request);
        }

        $familiaColonizadora = FamiliaColonizadora::find($id);
        if (!$familiaColonizadora) {
            return (object) [
                'message' => 'Familia não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }
        
        $familiaColonizadora->Colonizador_id = $request->input('Colonizador_id');
        $familiaColonizadora->Familia_id = $request->input('Familia_id');
        $familiaColonizadora->Data_chegada = $request->input('Data_chegada');
        $familiaColonizadora->Comentarios = $request->input('Comentarios');
        $familiaColonizadora->save();

        return (object) [
            'message' => 'Familia atualizado com sucesso',
            'model' => $familiaColonizadora,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $familiaColonizadora = FamiliaColonizadora::find($id);

        if (!$familiaColonizadora) {
            return (object) [
                'message' => 'Familia não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $familiaColonizadora->delete();

        return (object) [
            'message' => 'Familia excluido com sucesso',
            'model' => $familiaColonizadora,
            'status_code' => 200,
        ];
    }
}