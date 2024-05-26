<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Documento extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'documento';

    protected $primaryKey = 'documento_id';

    protected $fillable = [
        'pessoa_id',
        'Descricao',
        'Caminho',
        'Tipo_arquivo',
        'Data_criacao',
        'Data_alteracao',
        'Validado',
        'Motivo',
        'Usuario_id'
    ];

    public static function obtemDocumentoValidacao()
    {
        return DB::select('SELECT d.* FROM documento d join pessoa p on p.Pessoa_id = d.Pessoa_id WHERE d.Validado = ? and p.Validado != ? order by d.Data_criacao', ['1','3']);
    }
}
