<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FamiliaColonizadora extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'familia_colonizadora';

    protected $primaryKey = null; // Como esta tabela tem uma chave primária composta, não precisamos especificá-la aqui

    public $incrementing = false; // Desativa a auto-incrementação, já que não temos uma chave primária simples

    protected $fillable = [
        'Colonizador_id',
        'Familia_id',
        'Data_chegada',
        'Comentarios',
        'Validado',
        'Data_criacao',
        'Motivo',
        'Usuario_id'
    ];
    
    public static function obtemFamiliaColonizadoraValidacao()
    {
        return DB::select('SELECT fc.* FROM familia_colonizadora fc join pessoa p on p.Pessoa_id = fc.Colonizador_id join familia f on f.Familia_id = fc.Familia_id WHERE fc.Validado = ? and p.Validado != ? and f.Validado != ? order by fc.Data_criacao', ['1','3','3']);
    }
}
