<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\PessoaSolicitacao;
use App\Services\UsuarioService;
use App\Services\PessoaService;

class ValidacaoController extends Controller
{
    
    protected $usuarioService;
    protected $pessoaService;

    public function __construct(UsuarioService $usuarioService, PessoaService $pessoaService)
    {
        $this->usuarioService = $usuarioService;
        $this->pessoaService = $pessoaService;
    }
    
    //Lista validacoes
    public function index()
    {
        $pessoas = Pessoa::where('validado','1')->orderby('Data_criacao','asc')->get();
        $pessoasSolicitacao = PessoaSolicitacao::where('validacao','1')->orderby('Data_criacao','asc')->get();
        $pessoaValidacoes = [];
        foreach($pessoas as $pessoa)
        {
            array_push($pessoaValidacao, $this->pessoaService->Parentesco($pessoa->Pessoa_id));
        }

        $insertValidacoes = [
            'pessoas' => $pessoaValidacoes,
        ];

        $updateValidacoes = [
            'pessoas' => $pessoasSolicitacao,
        ];

        return response()->json(['insert' => $insertValidacoes,'update' => $updateValidacoes], 200);
    }
}
