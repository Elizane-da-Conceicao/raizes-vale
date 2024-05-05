<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    public $timestamps = false;
    protected $table = 'pessoa';

    protected $primaryKey = 'pessoa_id';

    protected $fillable = [
        'Nome',
        'Sexo',
        'Data_nascimento',
        'Data_casamento',
        'Data_obito',
        'Local_nascimento',
        'Local_sepultamento',
        'Resumo',
    ];

    public function casais()
    {
        return $this->hasMany(Casal::class, 'Marido_id');
    }

    public function esposa()
    {
        return $this->belongsTo(Pessoa::class, 'Esposa_id');
    }

    public function filhos()
    {
        return $this->hasManyThrough(Pessoa::class, Descendencia::class, 'Filho_id', 'Pessoa_id');
    }
}
