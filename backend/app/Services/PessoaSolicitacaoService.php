<?php

namespace App\Services;
use App\Models\PessoaSolicitacao;
use Illuminate\Http\Request;

class PessoaSolicitacaoService
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function store($request,$id)
    {
        $pessoa = new PessoaSolicitacao();
        $pessoa->Pessoa_id = $id;
        $pessoa->nome = $request->input('nome');
        $pessoa->sexo = $request->input('sexo');
        $pessoa->data_nascimento = $request->input('data_nascimento');
        $pessoa->data_obito = $request->input('data_obito');
        $pessoa->local_nascimento = $request->input('local_nascimento');
        $pessoa->local_sepultamento = $request->input('local_sepultamento');
        $pessoa->resumo = $request->input('resumo');
        $pessoa->Usuario_id = $request->input('usuario_id');
        $pessoa->Religiao = $request->input('religiao');
        $pessoa->Motivo = '';
        $pessoa->validacao = '1';
        $pessoa->save();

        return (object) [
            'message' => 'Usuário criado com sucesso',
            'model' => $pessoa,
            'status_code' => 201,
        ];
    }

    public function delete($id)
    {
        $pessoa = Pessoa::find($id);

        if (!$pessoa) {
            return (object) [
                'message' => 'Usuário não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $pessoa->delete();

        return (object) [
            'message' => 'Usuário excluido com sucesso',
            'model' => $pessoa,
            'status_code' => 200,
        ];
    }

    public function ObterPessoaporId($id)
    {
        $pessoa = Pessoa::find($id);

        if (!$pessoa) {
            return (object) [
                'message' => 'Pessoa não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        return (object) [
            'message' => 'Pessoa encontrada.',
            'model' => $pessoa,
            'status_code' => 200,
        ];
    }
}