<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamiliaColonizadora extends Model
{
    use HasFactory;

    protected $table = 'familia_colonizadora';

    protected $primaryKey = null; // Como esta tabela tem uma chave primária composta, não precisamos especificá-la aqui

    public $incrementing = false; // Desativa a auto-incrementação, já que não temos uma chave primária simples

    protected $fillable = [
        'Colonizador_id',
        'Familia_id',
        'Data_chegada',
        'Comentarios',
    ];
}
