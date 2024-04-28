<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function store(Request $request)
    {
        $pessoa = new Pessoa();
        $pessoa->nome = $request->input('nome');
        $pessoa->sexo = $request->input('sexo');
        $pessoa->data_nascimento = $request->input('data_nascimento');
        $pessoa->data_casamento = $request->input('data_casamento');
        $pessoa->data_obito = $request->input('data_obito');
        $pessoa->local_nascimento = $request->input('local_nascimento');
        $pessoa->local_sepultamento = $request->input('local_sepultamento');
        $pessoa->resumo = $request->input('resumo');
        $pessoa->validacao = $request->input('validacao');
        $pessoa->colonizador = $request->input('colonizador', '2');
        $pessoa->save();

        return response()->json(['message' => 'Pessoa criada com sucesso', 'pessoa' => $pessoa], 201);
    }

    public function index()
    {
        $pessoas = Pessoa::all();
        return response()->json(['pessoas' => $pessoas], 200);
    }

    public function update(Request $request, $id)
    {
        $pessoa = Pessoa::find($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        $pessoa->nome = $request->input('nome', $pessoa->nome);
        $pessoa->sexo = $request->input('sexo', $pessoa->sexo);
        $pessoa->data_nascimento = $request->input('data_nascimento', $pessoa->data_nascimento);
        $pessoa->data_casamento = $request->input('data_casamento', $pessoa->data_casamento);
        $pessoa->data_obito = $request->input('data_obito', $pessoa->data_obito);
        $pessoa->local_nascimento = $request->input('local_nascimento', $pessoa->local_nascimento);
        $pessoa->local_sepultamento = $request->input('local_sepultamento', $pessoa->local_sepultamento);
        $pessoa->resumo = $request->input('resumo', $pessoa->resumo);
        $pessoa->validacao = $request->input('validacao', $pessoa->validacao);
        $pessoa->colonizador = $request->input('colonizador', $pessoa->colonizador);
        $pessoa->save();

        return response()->json(['message' => 'Pessoa atualizada com sucesso', 'pessoa' => $pessoa], 200);
    }

    public function destroy($id)
    {
        $pessoa = Pessoa::find($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        $pessoa->delete();

        return response()->json(['message' => 'Pessoa excluída com sucesso'], 200);
    }
}
