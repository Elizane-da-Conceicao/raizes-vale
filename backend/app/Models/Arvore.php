<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Arvore extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'arvore';

    protected $primaryKey = null; // Como esta tabela tem uma chave primária composta, não precisamos especificá-la aqui

    public $incrementing = false; // Desativa a auto-incrementação, já que não temos uma chave primária simples

    protected $fillable = [
        'Descendencia_id',
        'Familia_id',
        'Data_criacao',
        'Data_alteracao',
        'Validado',
        'Motivo',
        'Usuario_id'
    ];

    public static function obtemArvoreValidacao()
    {
        return DB::select('SELECT a.* FROM arvore a join descendencia d on d.Descendencia_id = a.Descendencia_id join familia f on f.Familia_id = a.Familia_id WHERE a.Validado = ? and d.Validado != ? and f.Validado != ? order by a.Data_criacao', ['1','3','3']);
    }
}
