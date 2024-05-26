<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FamiliaColonizadoraSolicitacao extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'familia_colonizadora_solicitacao';

    protected $primaryKey = 'familia_colonizadora_id_solicitacao'; 

    protected $fillable = [
        'Familia_colonizadora_id',
        'Colonizador_id',
        'Familia_id',
        'Data_chegada',
        'Comentarios',
        'Data_criacao',
        'Validacao',
        'Motivo',
        'usuario_id',
    ];

    
}
