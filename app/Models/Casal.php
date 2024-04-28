<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casal extends Model
{
    use HasFactory;
    
    protected $table = 'casal';

    protected $primaryKey = 'casal_id';

    protected $fillable = [
        'Marido_id',
        'Esposa_id',
        'Data_casamento',
    ];
}
