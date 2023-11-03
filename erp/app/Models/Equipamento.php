<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;
    protected $fillable =[
        'cliente_id',
        'equipamento',
        'num_serie',
        'modelo',
        'cor',
        'descricao',
        'tensao',
        'potencia',
        'voltagem',
        'data_fabricacao',
    ];
    
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
