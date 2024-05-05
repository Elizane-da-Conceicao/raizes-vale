<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamiliaColonizadora extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'familia_colonizadora_solicitacao';

    protected $primaryKey = 'familia_colonizadora_id_solicitacao'; 

    protected $fillable = [
        'Colonizador_id',
        'Colonizador_id_solicitacao',
        'Familia_id',
        'Data_chegada',
        'Comentarios',
        'Validacao',
        'Motivo',
        'usuario_id',
    ];
}
