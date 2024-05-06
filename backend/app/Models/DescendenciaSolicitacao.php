<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescendenciaSolicitacao extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'descendencia_solicitacao';

    protected $primaryKey = 'descendencia_id_solicitacao';

    protected $fillable = [
        'Filho_id',
        'Casal_id',
        'Filho_id_solicitacao',
        'Casal_id_solicitacao',
        'Data_criacao',
        'Validacao',
        'Motivo',
        'usuario_id',
    ];
}
