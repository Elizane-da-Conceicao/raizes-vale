<?php

namespace App\Services;

use App\Models\Arvore;
use App\Models\Casal;
use App\Models\Descendencia;
use App\Models\Familia;
use App\Models\FamiliaColonizadora;
use App\Models\Pessoa;
use Illuminate\Http\Request;

class ArvoreService
{
    protected $usuarioService;
    protected $arvoreSolicitacaoService;    

    public function __construct(
                                UsuarioService $usuarioService,
                                ArvoreSolicitacaoService $arvoreSolicitacaoService
                               )
    {
        $this->usuarioService = $usuarioService;
        $this->arvoreSolicitacaoService = $arvoreSolicitacaoService;
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

        $arvore = new Arvore();
        $arvore->descendencia_id = $request->input('descendencia_id');
        $arvore->familia_id = $request->input('familia_id');
        $arvore->data_criacao = now();
        $arvore->save();

        return (object) [
            'message' => 'Arvore criado com sucesso',
            'model' => $arvore,
            'status_code' => 201,
        ];
    }

    public function update($request, $id)
    {
        $usuario = $this->usuarioService->ObterUsuarioPorId($request->input('usuario_id'));
        if ($usuario->model->administrador === '1') 
        {
            return $this->arvoreSolicitacaoService->update($request);
        }

        $arvore = Arvore::find($id);
        if (!$arvore) {
            return (object) [
                'message' => 'Arvore não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        Arvore::where('arvore_id', $id)
                ->update([
                    'descendencia_id' => $descendencia_id,
                    'familia_id' => $familia_id,
                    'data_alteracao' => now()
                ]);
                
        $arvore = Arvore::find($id);
        return (object) [
            'message' => 'Casal atualizado com sucesso',
            'model' => $arvore,
            'status_code' => 200,
        ];
    }

    public function delete($id)
    {
        $arvore = Arvore::find($id);

        if (!$arvore) {
            return (object) [
                'message' => 'Arvore não encontrada.',
                'model' => null,
                'status_code' => 404,
            ];
        }

        $arvore->delete();

        return (object) [
            'message' => 'Arvore excluída com sucesso',
            'model' => $arvore,
            'status_code' => 200,
        ];
    }

    public function MontaArvore($id)
    {
        $familia = Familia::find($id);

        if (!$familia) {
            return (object) [
                'message' => 'Familia não encontrada.',
                'model' => $familia,
                'status_code' => 404,
            ];
        }


        $familiaColonizadora = FamiliaColonizadora::where('Familia_id' ,$familia->Familia_id)->first();

        if (!$familiaColonizadora) {
            return (object) [
                'message' => 'Familia Colonizadora não encontrada.',
                'model' => $arvore,
                'status_code' => 404,
            ];
        }

        $ramo = 0;
        $retorno = ArvoreService::PegaPessoaFilho($familiaColonizadora->Colonizador_id,0);

        return (object) [
            'message' => 'Arvore montada com sucesso',
            'model' => $retorno,
            'status_code' => 200,
        ];
    }

    public function MontaArvorePessoa($id)
    {
        $pessoa = Pessoa::find($id);
        if($pessoa->Colonizador === "1")
        {
            $casal = Casal::where('Marido_id', $pessoa->Pessoa_id)
              ->orWhere('Esposa_id', $pessoa->Pessoa_id)
              ->first(); 
            if($casal)
            {
                if($casal->Marido_id === $id)
                {
                    $id = $casal->Esposa_id;
                }else{
                    $id = $casal->Marido_id;
                }
            }
        }
        $arvoreDescendentes = ArvoreService::PegaPessoaFilho($id, 0);
        $arvorePais =  ArvoreService::PegaPessoaPais($id,0,$arvoreDescendentes);

        return (object) [
            'message' => 'Arvore montada com sucesso',
            'model' => $arvorePais,
            'status_code' => 200,
        ];
    }

    public function PegaPessoaFilho($id,$ramo)
    {
        $pessoa = Pessoa::find($id);
        if($pessoa)
        {
            if($pessoa->Validado !== '2')
            {
                $pessoa = null;
            }
        }

        $conjuge = new Pessoa();
        $arvore = [];
        $filhos = [];
        if ($pessoa) {
            $casal = Casal::where('Marido_id', $pessoa->Pessoa_id)
              ->orWhere('Esposa_id', $pessoa->Pessoa_id)
              ->first(); 
            $ramo = $ramo + 1;
            if ($casal) {
                $descendencias = Descendencia::where('Casal_id', $casal->Casal_id)->get();
                foreach ($descendencias as $desc) {
                    $filho = Pessoa::find($desc->Filho_id);
                    if($filho)
                    {
                        if($filho->Validado !== '2')
                        {
                            $filho = null;
                        }
                    }
                    if ($filho) {
                        array_push($filhos, $this->PegaPessoaFilho($filho->Pessoa_id,$ramo));
                    }
                }
                $idPessoa = $casal->Marido_id == $pessoa->Pessoa_id ? $casal->Esposa_id : $casal->Marido_id;
                $conjuge = Pessoa::find($idPessoa);
                if($conjuge)
                    {
                        if($conjuge->Validado !== '2')
                        {
                            $conjuge = null;
                        }
                    }
            }
        }

        $arvore = [
            'ramo' => $ramo,
            'pessoa' => $pessoa,
            'conjuge' => $conjuge,
            'descendentes' => $filhos,
        ];
    
        return $arvore;
    }

    public function PegaPessoaPais($id,$ramo,$arvoreFilho)
    {
        $pessoaFilho = Pessoa::find($id);
        $arvore = (object) [];
        if ($pessoaFilho) {
            $descendencia = Descendencia::where('Filho_id', $pessoaFilho->Pessoa_id)->first();
            $ramo = $ramo + 1;
            if ($descendencia) {
                $casal = Casal::find($descendencia->Casal_id);
                $pai = Pessoa::find($casal->Marido_id);
                $mae = Pessoa::find($casal->Esposa_id);
                  
                if(ArvoreService::ValidaSePertenceAFamiliaColonizadora($pai->Pessoa_id))
                {
                    $arvoreSecao = (object) [
                        'ramo' => $ramo,
                        'pessoa' => $pai,
                        'conjuge' => $mae,
                        'descendentes' => [$arvoreFilho],
                    ];
                    $arvore = $this->PegaPessoaPais($pai->Pessoa_id,$ramo,$arvoreSecao);

                }else if (ArvoreService::ValidaSePertenceAFamiliaColonizadora($mae->Pessoa_id))
                {
                    $arvoreSecao = (object) [
                        'ramo' => $ramo,
                        'pessoa' => $mae,
                        'conjuge' => $pai,
                        'descendentes' => [$arvoreFilho],
                    ];
                    $arvore =$this->PegaPessoaPais($mae->Pessoa_id,$ramo, $arvoreSecao);
                }                
            }
        }

        if($id != 1)
            return $arvore;
        else 
            return $arvoreFilho;
    }

    public function ValidaSePertenceAFamiliaColonizadora($id)
    {
        $familiaColonizadora = FamiliaColonizadora::where('Colonizador_id',$id)->get() ?? collect([]);
        if(($familiaColonizadora->count() ?? 0) > 0)
            return true;

        $descendencia = Descendencia::where('Filho_id', $id)->first() ?? collect([]);
        if(($descendencia->count() ?? 0) <= 0)
            return false;

        $arvores = Arvore::where('Descendencia_id',$descendencia->Descendencia_id)->get() ?? collect([]);
        if(($arvores->count() ?? 0) <= 0)
            return false;

        foreach($arvores as $arvore)
        {
            $familiaColonizadora = FamiliaColonizadora::where('Familia_id',$arvore->Familia_id)->get();
            if($familiaColonizadora)
            {
                return true;
            }
        }
        return false;
    }
}
