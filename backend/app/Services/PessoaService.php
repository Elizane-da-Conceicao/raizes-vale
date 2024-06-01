<?php

namespace App\Services;
use App\Models\Pessoa;
use App\Models\Descendencia;
use App\Models\Casal;
use App\Models\Usuario;
use App\Models\PessoaSolicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $validado = '1';
        if ($usuario->model->administrador === '2') {
            $validado = '2';
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
        $pessoa->Validado = $validado;
        $pessoa->Data_criacao = now();
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
           return $this->pessoaSolicitacaoService->store($request,$id);
        }

        $pessoa = Pessoa::find($id);
        if (!$pessoa) {
            return (object) [
                'message' => 'Pessoa não encontrado',
                'model' => null,
                'status_code' => 404,
            ];
        }

        Pessoa::where('pessoa_id', $id)
        ->update([
            'nome' => $request->input('nome'),
            'sexo' => $request->input('sexo'),
            'data_nascimento' => $request->input('data_nascimento'),
            'data_casamento' => $request->input('data_casamento'),
            'data_obito' => $request->input('data_obito'),
            'local_nascimento' => $request->input('local_nascimento'),
            'local_sepultamento' => $request->input('local_sepultamento'),
            'resumo' => $request->input('resumo'),
            'validado' => '2',
        ]);
        $pessoa = Pessoa::find($id);

        return (object) [
            'message' => 'Usuário atualizado com sucesso',
            'model' => $pessoa,
            'status_code' => 200,
        ];
    }

    public function consultaPessoa($nome)
    {
        $pessoa = Pessoa::consultaPessoaPorNome($nome);
        $pessoas = [];
        foreach($pessoa as $p)
        {
            array_push($pessoas, $this->Parentesco($p->Pessoa_id));

        }
        return (object) [
            'message' => 'Pessoas encontradas com sucesso',
            'model' => $pessoas,
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

    public function Validacao(Request $request,$id)
    {
        $pessoa = Pessoa::find($id);
        if (!$pessoa) {
            return (object) [
                'message' => 'Pessoa não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        Pessoa::where('pessoa_id', $id)
                ->update([
                    'Validado' =>  $request['validado'],
                    'Motivo' => $request['motivo']
                ]);

        $pessoa = Pessoa::find($id);
        return (object) [
            'message' => 'Pessoa alterada com sucesso!!',
            'model' => $pessoa,
            'status_code' => 200,
        ];
    }

    public function ValidacaoSolicitacao(Request $request,$id)
    {
        $pessoaSolicitacao = PessoaSolicitacao::find($id);
        if (!$pessoaSolicitacao) {
            return (object) [
                'message' => 'Solicitacao não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $pessoa = Pessoa::find($request->input('idPessoa'));
        if (!$pessoa) {
            return (object) [
                'message' => 'Pessoa não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }
        PessoaSolicitacao::where('pessoa_id_solicitacao', $id)
                ->update([
                    'Validacao' =>  $request['validado'],
                    'Motivo' => $request['motivo']
                ]);

        if($request->input('validado') !== 2)
        {
            return (object) [
                'message' => 'Pessoa validada.',
                'model' => $pessoaSolicitacao,
                'status_code' => 200,
            ];
        }

        Pessoa::where('pessoa_id', $request->input('idPessoa'))
        ->update([
            'nome' => $pessoaSolicitacao->Nome,
            'sexo' => $pessoaSolicitacao->Sexo,
            'data_nascimento' => $pessoaSolicitacao->Data_nascimento,
            'data_casamento' => $pessoaSolicitacao->Data_casamento,
            'data_obito' => $pessoaSolicitacao->Data_obito,
            'local_nascimento' => $pessoaSolicitacao->Local_nascimento,
            'local_sepultamento' => $pessoaSolicitacao->Local_sepultamento,
            'resumo' => $pessoaSolicitacao->Resumo,
            'colonizador' => $pessoaSolicitacao->Colonizador,
            'validado' => $request->input('validado'),
            'motivo' => $request->input('motivo')
        ]);
        $pessoa = Pessoa::find($request->input('idPessoa'));
        return (object) [
            'message' => 'Pessoa alterada com sucesso.',
            'model' => $pessoa,
            'status_code' => 200,
        ];
    }

    public function Parentesco($id)
    {
        $descendencia = Descendencia::where('Filho_id',$id)->first();
        $pessoa = Pessoa::find($id);
        $mae = new Pessoa();
        $pai = new Pessoa();
        $conjuge = new Pessoa();
        $descendentes = [];
        if($descendencia)
        {
            $casal = Casal::find($descendencia->Casal_id);
            if($casal)
            {
                $mae = Pessoa::find($casal->Esposa_id);
                $pai = Pessoa::find($casal->Marido_id);
            }
        }

        $casal = Casal::where('Esposa_id', $id)->first();
        if($casal)
        {
            $conjuge = Pessoa::find($casal->Marido_id);
            $filhos = Descendencia::where('Casal_id', $casal->Casal_id)->get();
            if($filhos){
                foreach($filhos as $filho)
                {
                    $filhoEntidade = Pessoa::find($filho->Filho_id);
                    if($filhoEntidade)
                    {
                        array_push($descendentes, $filhoEntidade);
                    }
                }
            }
        }else{
            $casal = Casal::where('Marido_id', $id)->first();
            if($casal)
            {
                $conjuge = Pessoa::find($casal->Esposa_id);
                $filhos = Descendencia::where('Casal_id',$casal->Casal_id)->get();
                if($filhos){
                    foreach($filhos as $filho)
                    {
                        $filhoEntidade = Pessoa::find($filho->Filho_id);
                        if($filhoEntidade)
                        {
                            array_push($descendentes, $filhoEntidade);
                        }
                    }
                }
            }
        }

        $pessoaParentesto = (object) [
            'pessoa' => $pessoa,
            'mae' => $mae,
            'pai' => $pai,
            'conjuge' => $conjuge,
            'descendentes' => $descendentes,
            'solicitante' => Usuario::find($pessoa->Usuario_id),
        ];

        return $pessoaParentesto;
    }
}