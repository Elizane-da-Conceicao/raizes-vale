<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DocumentoSolicitacao extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'documento_solicitacao';

    protected $primaryKey = 'documento_id_solicitacao';

    protected $fillable = [
        'Documento_id',
        'pessoa_id',
        'Descricao',
        'Caminho',
        'Tipo_arquivo',
        'Data_criacao',
        'Data_alteracao',
        'Validacao',
        'Motivo',
        'usuario_id',
        'privado'
    ];
}
