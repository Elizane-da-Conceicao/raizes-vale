<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Casal extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'casal';

    protected $primaryKey = 'casal_id';

    protected $fillable = [
        'Marido_id',
        'Esposa_id',
        'Data_casamento',
        'Validado',
        'Data_criacao',
        'Motivo',
        'Usuario_id'
    ];

    public static function obtemCasalValidacao()
    {
        return DB::select('SELECT distinct c.* FROM casal c join pessoa p on (p.Pessoa_id = c.Marido_id or p.Pessoa_id = c.Esposa_id) WHERE c.Validado = ? and p.Validado != ? order by c.Data_criacao', ['1','3']);
    }
}
