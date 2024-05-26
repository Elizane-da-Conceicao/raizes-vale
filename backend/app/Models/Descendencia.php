<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Descendencia extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'descendencia';

    protected $primaryKey = 'descendencia_id';

    protected $fillable = [
        'Filho_id',
        'Casal_id',
        'Data_criacao',
        'Validado',
        'Motivo',
        'Usuario_id'
    ];
    
    public static function obtemDescendenciaValidacao()
    {
        return DB::select('SELECT d.* FROM descendencia d join pessoa p on p.Pessoa_id = d.Filho_id join casal c on c.Casal_id = d.Casal_id WHERE d.Validado = ? and p.Validado != ? and c.Validado != ? order by c.Data_criacao', ['1','3','3']);
    }
}
