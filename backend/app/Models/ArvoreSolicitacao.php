<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArvoreSolicitacao extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'arvore_solicitacao';

    protected $primaryKey = 'arvore_id_solicitacao'; // Como esta tabela tem uma chave primária composta, não precisamos especificá-la aqui


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
