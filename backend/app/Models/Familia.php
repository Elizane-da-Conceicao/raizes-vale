<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Familia extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'familia';

    protected $primaryKey = 'familia_id';

    protected $fillable = [
        'Nome',
        'Data_criacao',
        'Data_alteracao',
        'Resumo',
        'Colonizador',
        'Validado',
        'Motivo',
        'Usuario_id'
    ];

     public function familiaColonizadora()
    {
        return $this->hasOne(FamiliaColonizadora::class, 'Familia_id');
    }

    public function pessoas()
    {
        return $this->belongsToMany(Pessoa::class, 'arvore', 'Familia_id', 'Descendencia_id');
    }
}
