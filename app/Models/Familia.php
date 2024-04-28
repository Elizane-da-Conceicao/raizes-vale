<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    use HasFactory;

    protected $table = 'familia';

    protected $primaryKey = 'familia_id';

    protected $fillable = [
        'Nome',
        'Data_criacao',
        'Data_alteracao',
        'Resumo',
        'Colonizador',
    ];
}
