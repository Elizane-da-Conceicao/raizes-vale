<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descendencia extends Model
{
    use HasFactory;

    protected $table = 'descendencia';

    protected $primaryKey = 'descendencia_id';

    protected $fillable = [
        'Filho_id',
        'Casal_id',
        'Data_criacao',
    ];
}
