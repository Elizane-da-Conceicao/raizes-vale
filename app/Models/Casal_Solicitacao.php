<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casal extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'casal_solicitacao';

    protected $primaryKey = 'casal_id_solicitacao';

    protected $fillable = [
        'Marido_id',
        'Esposa_id',
        'Marido_id_solicitacao',
        'Esposa_id_solicitacao',
        'Data_casamento',
        'Validacao',
        'Motivo',
        'usuario_id',
    ];
}
