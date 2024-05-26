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
            return $this->familiaColonizadoraSolicitacao->store($request,$id );
        }

        $familiaColonizadora = FamiliaColonizadora::find($id);
        if (!$familiaColonizadora) {
            return (object) [
                'message' => 'Familia não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }
        
        FamiliaColonizadora::where('id', $id)
        ->update([
            'Colonizador_id' => $request->input('Colonizador_id'),
            'Familia_id' => $request->input('Familia_id'),
            'Data_chegada' => $request->input('Data_chegada'),
        ]);

        $familiaColonizadora = FamiliaColonizadora::find($id);
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
    public function Validacao(Request $request,$id)
    {
        $familiaColonizadora = FamiliaColonizadora::find($id);
        if (!$familiaColonizadora) {
            return (object) [
                'message' => 'Pessoa não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $familiaColonizadora->validado =  $request->input('validado');
        $familiaColonizadora->motivo =  $request->input('motivo');
        $familiaColonizadora->save();

        return (object) [
            'message' => 'Pessoa encontrada.',
            'model' => $familiaColonizadora,
            'status_code' => 200,
        ];
    }

    public function ValidacaoSolicitacao(Request $request,$id)
    {
        $familiaColonizadoraSolicitacao = FamiliaColonizadoraSolicitacao::find($id);
        if (!$familiaColonizadoraSolicitacao) {
            return (object) [
                'message' => 'Familia Colonizadora não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        if($request->input('validado') !== 2)
        {
            $familiaColonizadoraSolicitacao->validado = $request->input('validado');
            $familiaColonizadoraSolicitacao->motivo =  $request->input('motivo');
            $familiaColonizadoraSolicitacao->save();

            return (object) [
                'message' => 'Familia Colonizadora validada.',
                'model' => $familiaColonizadoraSolicitacao,
                'status_code' => 200,
            ];
        }

        $familiaColonizadora = new FamiliaColonizadora();
        $familiaColonizadora->Colonizador_id = $familiaColonizadoraSolicitacao->Colonizador_id;
        $familiaColonizadora->Familia_id = $familiaColonizadoraSolicitacao->Familia_id;
        $familiaColonizadora->Data_chegada = $familiaColonizadoraSolicitacao->Data_chegada;
        $familiaColonizadora->Validado = $request->input('validado');
        $familiaColonizadora->save();

        return (object) [
            'message' => 'Familia Colonizadora validada.',
            'model' => $familiaColonizadora,
            'status_code' => 200,
        ];
    }
}