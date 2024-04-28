<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'pessoa';

    protected $primaryKey = 'pessoa_id';

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
    ];
}
