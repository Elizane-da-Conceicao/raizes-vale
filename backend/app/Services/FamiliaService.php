<?php

namespace App\Services;
use App\Models\Familia;
use Illuminate\Http\Request;

class FamiliaService
{
    protected $usuarioService;
    protected $familiaSolicitacaoService;

    public function __construct(UsuarioService $usuarioService, FamiliaSolicitacaoService $familiaSolicitacaoService)
    {
        $this->usuarioService = $usuarioService;
        $this->familiaSolicitacaoService = $familiaSolicitacaoService;
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

        $familia = new Familia();
        $familia->Nome = $request->input('Nome');
        $familia->Data_criacao = now();
        $familia->Resumo = $request->input('Resumo');
        $familia->Colonizador = $request->input('Colonizador');
        $familia->save();

        return (object) [
            'message' => 'Familia criado com sucesso',
            'model' => $familia,
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if ($usuario->model->administrador === '1') {
           return $this->familiaSolicitacaoService->store($request,$id);
        }

        $familia = Familia::find($id);
        if (!$familia) {
            return (object) [
                'message' => 'Familia não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }
        
        Familia::where('id', $id)
        ->update([
            'Nome' => $request->input('Nome'),
            'Data_alteracao' => now(),
            'Resumo' => $request->input('Resumo'),
            'Colonizador' => $request->input('Colonizador'),
        ]);

        return (object) [
            'message' => 'Familia atualizado com sucesso',
            'model' => $familia,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $familia = Familia::find($id);

        if (!$familia) {
            return (object) [
                'message' => 'Familia não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $familia->delete();

        return (object) [
            'message' => 'Familia excluido com sucesso',
            'model' => $familia,
            'status_code' => 200,
        ];
    }

    public function Validacao(Request $request,$id)
    {
        $familia = Familia::find($id);
        if (!$pessoa) {
            return (object) [
                'message' => 'Familia não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $familia->validado =  $request->input('validado');
        $familia->motivo =  $request->input('motivo');
        $familia->save();

        return (object) [
            'message' => 'Pessoa encontrada.',
            'model' => $familia,
            'status_code' => 200,
        ];
    }

    public function ValidacaoSolicitacao(Request $request,$id)
    {
        $familiaSolicitacao = FamiliaSolicitacao::find($id);
        if (!$familiaSolicitacao) {
            return (object) [
                'message' => 'Familia não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        if($request->input('validado') !== 2)
        {
            $familiaSolicitacao->validado = $request->input('validado');
            $familiaSolicitacao->motivo =  $request->input('motivo');
            $familiaSolicitacao->save();

            return (object) [
                'message' => 'Familia validada.',
                'model' => $familiaSolicitacao,
                'status_code' => 200,
            ];
        }

        $familia = new Familia();
        $familia->Nome = $familiaSolicitacao->Nome;
        $familia->Data_criacao = $familiaSolicitacao->Data_criacao;
        $familia->Data_alteracao = now();
        $familia->Resumo = $familiaSolicitacao->Resumo;
        $familia->Colonizador = $familiaSolicitacao->Colonizador;
        $familia->validado = $request->input('validado');
        $familia->save();

        return (object) [
            'message' => 'Pessoa validada.',
            'model' => $pessoa,
            'status_code' => 200,
        ];
    }
}