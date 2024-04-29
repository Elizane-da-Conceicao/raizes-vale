<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arvore extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'arvore';

    protected $primaryKey = null; // Como esta tabela tem uma chave primária composta, não precisamos especificá-la aqui

    public $incrementing = false; // Desativa a auto-incrementação, já que não temos uma chave primária simples

    protected $fillable = [
        'Descendencia_id',
        'Familia_id',
        'Data_criacao',
        'Data_alteracao',
    ];
}
