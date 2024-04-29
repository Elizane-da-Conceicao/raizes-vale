<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'Validacao',
    ];
}
