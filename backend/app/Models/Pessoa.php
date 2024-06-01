<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pessoa extends Model
{
    public $timestamps = false;
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
        'Data_criacao',
        'Colonizador',
        'Usuario_id',
        'Resumo',
        'Validado',
        'Motivo',
    ];

    public static function consultaPessoaPorNome($nome)
    {
        $nomePesquisa = '%' . $nome . '%';
        return DB::select('SELECT p.* FROM pessoa p WHERE p.Validado = ?  and LOWER(p.Nome) like LOWER(?) order by p.Data_criacao', ['2', $nomePesquisa]);
    }

}
