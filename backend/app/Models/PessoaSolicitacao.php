<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PessoaSolicitacao extends Model
{
    public $timestamps = false;
    protected $table = 'pessoa_solicitacao';

    protected $primaryKey = 'pessoa_id_solicitacao';

    protected $fillable = [
        'Pessoa_id',
        'Nome',
        'Sexo',
        'Data_nascimento',
        'Data_casamento',
        'Data_obito',
        'Data_criacao',
        'Local_nascimento',
        'Local_sepultamento',
        'Resumo',
        'Validacao',
        'Colonizador',
        'Motivo',
        'usuario_id',
        'Religiao'
    ];
}
