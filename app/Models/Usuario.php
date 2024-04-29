<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'usuario'; // Define o nome da tabela

    protected $primaryKey = 'usuario_id'; // Define a chave primária

    protected $fillable = [ // Define os campos que podem ser preenchidos em massa
        'Nome',
        'CPF',
        'Email',
        'data_criacao',
        'data_alteracao',
        'administrador',
        'senha',
    ];
}
