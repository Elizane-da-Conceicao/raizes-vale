<?php

namespace App\Services;

use App\Models\Casal;
use Illuminate\Http\Request;

class CasalService
{
    protected $pessoaService;
    protected $usuarioService;
    protected $casalSolicitacaoService;

    public function __construct(PessoaService $pessoaService, UsuarioService $usuarioService, CasalSolicitacaoService $casalSolicitacaoService)
    {
        $this->pessoaService = $pessoaService;
        $this->usuarioService = $usuarioService;
        $this->casalSolicitacaoService = $casalSolicitacaoService;
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

        $casal = new Casal();
        $casal->Marido_id = $request->input('Marido_id');
        $casal->Esposa_id = $request->input('Esposa_id');
        $casal->Data_casamento = $request->input('Data_casamento');
        $casal->save();

        // $marido->Data_casamento = $casal->Data_casamento;
        // $esposa->Data_casamento = $casal->Data_casamento;
        
        // $retorno = $this->pessoaService->update($marido->model,$marido->model->pessoa_id);
        // $retorno = $this->pessoaService->update($marido->model,$marido->model->pessoa_id);

        return (object) [
            'message' => 'Casal criado com sucesso',
            'model' => $casal,
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if ($usuario->model->administrador === '1') 
        {
            return $this->casalSolicitacaoService->update($request);
        }
        
        $casal = Casal::find($id);
        if (!$casal) {
            return (object) [
                'message' => 'Casal não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        Casal::where('casal_id', $id)
        ->update([
            'Marido_id' => $marido_id,
            'Esposa_id' => $esposa_id,
            'Data_casamento' => $data_casamento,
        ]);

        $casal = Casal::find($id);
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
