<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    public $timestamps = false;
    protected $table = 'pessoa_solicitacao';

    protected $primaryKey = 'pessoa_id_solicitacao';

    protected $fillable = [
        'Nome',
        'Sexo',
        'Data_nascimento',
        'Data_casamento',
        'Data_obito',
        'Local_nascimento',
        'Local_sepultamento',
        'Resumo',
        'Validacao',
        'Colonizador',
        'Motivo',
        'usuario_id',
    ];
}
