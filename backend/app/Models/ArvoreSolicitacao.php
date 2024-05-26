<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArvoreSolicitacao extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'arvore_solicitacao';

    protected $primaryKey = 'arvore_id_solicitacao';


    protected $fillable = [
        'Descendencia_id',
        'Familia_id',
        'Descendencia_id_solicitacao',
        'Familia_id_solicitacao',
        'Data_criacao',
        'Data_alteracao',
        'Validacao',
        'Motivo',
        'usuario_id',
    ];
}
