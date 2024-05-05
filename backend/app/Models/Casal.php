<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casal extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'casal';

    protected $primaryKey = 'casal_id';

    protected $fillable = [
        'Marido_id',
        'Esposa_id',
        'Data_casamento',
    ];

    public function marido()
    {
        return $this->belongsTo(Pessoa::class, 'Marido_id');
    }

    public function esposa()
    {
        return $this->belongsTo(Pessoa::class, 'Esposa_id');
    }

    public function descendencia()
    {
        return $this->hasMany(Descendencia::class, 'Casal_id');
    }
}
