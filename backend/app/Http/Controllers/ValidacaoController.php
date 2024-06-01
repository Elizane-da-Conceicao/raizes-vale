<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Usuario;
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
            $parentesco = $this->pessoaService->Parentesco($pessoa->Pessoa_id);
            if($parentesco)
            {
                array_push($pessoaValidacoes, $parentesco);
            }else{
                $pessoaVa = (object) [
                    'pessoa' => $pessoa,
                    'mae' => "",
                    'pai' => "",
                    'conjuge' => "",
                    'solicitante' => Usuario::find($pessoa->Usuario_id),
                ];
                array_push($pessoaValidacoes, $pessoaVa);
            }
        }
        $pessoasValidacoesSolicitacoes = [];
        foreach($pessoasSolicitacao as $pessoaSoli)
        {
            $pessoaVaS = (object) [
                'pessoa' => $pessoaSoli,
                'solicitante' => Usuario::find($pessoaSoli->Usuario_id),
            ];
            array_push($pessoasValidacoesSolicitacoes, $pessoaVaS);

        }

        $insertValidacoes = [
            'pessoas' => $pessoaValidacoes,
        ];

        $updateValidacoes = [
            'pessoas' => $pessoasValidacoesSolicitacoes,
        ];

        return response()->json(['insert' => $insertValidacoes,'update' => $updateValidacoes], 200);
    }
}
