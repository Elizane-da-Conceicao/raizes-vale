<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamiliaSolicitacao extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'familia_solicitacao';

    protected $primaryKey = 'familia_id_solicitacao';

    protected $fillable = [
        'Nome',
        'Data_criacao',
        'Data_alteracao',
        'Resumo',
        'Colonizador',
        'Validacao',
        'Motivo',
        'usuario_id',
    ];
}
