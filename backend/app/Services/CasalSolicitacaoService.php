<?php

namespace App\Services;

use App\Models\Casal;
use Illuminate\Http\Request;

class CasalSolicitacaoService
{
    protected $pessoaService;
    protected $usuarioService;

    public function __construct(PessoaService $pessoaService, UsuarioService $usuarioService)
    {
        $this->pessoaService = $pessoaService;
        $this->usuarioService = $usuarioService;
    }

    public function store($request)
    {
        $marido = $this->pessoaService->ObterPessoaporId($request->input('Marido_id'));
        $esposa = $this->pessoaService->ObterPessoaporId($request->input('Esposa_id')); 
        if (!$marido->model || !$esposa->model) {
            return (object) [
                'message' => 'Marido e ou esposa não encontrados',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if (!$usuario->model) {
            return (object) [
                'message' => $usuario->message,
                'model' => null,
                'status_code' => 404,
            ];
        }

        $casal = new CasalSolicitacao();
        $casal->Marido_id = $request->input('Marido_id');
        $casal->Esposa_id = $request->input('Esposa_id');
        $casal->Data_casamento = $request->input('Data_casamento');
        $casal->validacao = $validacao; 
        $casal->save();

        $marido->Data_casamento = $casal->Data_casamento;
        $esposa->Data_casamento = $casal->Data_casamento;
        
        $retorno = $this->pessoaService->update($marido->model,$marido->model->pessoa_id);
        $retorno = $this->pessoaService->update($marido->model,$marido->model->pessoa_id);

        return (object) [
            'message' => 'Casal criado com sucesso',
            'model' => $casal,
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $casal = CasalSolicitacao::find($id);

        if (!$casal) {
            return (object) [
                'message' => 'Casal não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $casal->Marido_id = $request->input('Marido_id', $casal->Marido_id);
        $casal->Esposa_id = $request->input('Esposa_id', $casal->Esposa_id);
        $casal->Data_casamento = $request->input('Data_casamento', $casal->Data_casamento);
        $casal->save();

        return (object) [
            'message' => 'Casal atualizado com sucesso',
            'model' => $casal,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $casal = Casal::find($id);

        if (!$casal) {
            return (object) [
                'message' => 'Casal não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $casal->delete();

        return (object) [
            'message' => 'Casal excluído com sucesso',
            'model' => $casal,
            'status_code' => 200,
        ];
    }
}
