<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descendencia extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'descendencia';

    protected $primaryKey = 'descendencia_id';

    protected $fillable = [
        'Filho_id',
        'Casal_id',
        'Data_criacao',
    ];
    
    public function filho()
    {
        return $this->belongsTo(Pessoa::class, 'Filho_id');
    }

    public function casal()
    {
        return $this->belongsTo(Casal::class, 'Casal_id');
    }
}
