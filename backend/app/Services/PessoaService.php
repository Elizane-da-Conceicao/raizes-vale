<?php

namespace App\Services;
use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaService
{
    protected $usuarioService;
    protected $pessoaSolicitacaoService;

    public function __construct(UsuarioService $usuarioService, PessoaSolicitacaoService $pessoaSolicitacaoService)
    {
        $this->usuarioService = $usuarioService;
        $this->pessoaSolicitacaoService = $pessoaSolicitacaoService;
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
            $this->pessoaSolicitacaoService->store($request);
        }

        $pessoa = new Pessoa();
        $pessoa->nome = $request->input('nome');
        $pessoa->sexo = $request->input('sexo');
        $pessoa->data_nascimento = $request->input('data_nascimento');
        $pessoa->data_obito = $request->input('data_obito');
        $pessoa->local_nascimento = $request->input('local_nascimento');
        $pessoa->local_sepultamento = $request->input('local_sepultamento');
        $pessoa->resumo = $request->input('resumo');
        $pessoa->colonizador = $request->input('colonizador', '2');
        $pessoa->save();

        return (object) [
            'message' => 'Usuário criado com sucesso',
            'model' => $pessoa,
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if ($usuario->model->administrador === '1') {
            $this->pessoaSolicitacaoService->update($request);
        }

        $pessoa = Pessoa::find($id);
        if (!$pessoa) {
            return (object) [
                'message' => 'Pessoa não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $pessoa->nome = $request->input('nome', $pessoa->nome);
        $pessoa->sexo = $request->input('sexo', $pessoa->sexo);
        $pessoa->data_nascimento = $request->input('data_nascimento', $pessoa->data_nascimento);
        $pessoa->data_casamento = $request->input('data_casamento', $pessoa->data_casamento);
        $pessoa->data_obito = $request->input('data_obito', $pessoa->data_obito);
        $pessoa->local_nascimento = $request->input('local_nascimento', $pessoa->local_nascimento);
        $pessoa->local_sepultamento = $request->input('local_sepultamento', $pessoa->local_sepultamento);
        $pessoa->resumo = $request->input('resumo', $pessoa->resumo);
        $pessoa->colonizador = $request->input('colonizador', $pessoa->colonizador);
        $pessoa->save();

        return (object) [
            'message' => 'Usuário atualizado com sucesso',
            'model' => $pessoa,
            'status_code' => 200,
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