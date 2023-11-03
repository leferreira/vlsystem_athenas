<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frete extends Model
{
    use HasFactory;
    protected $fillable = [
        'valor',
        'placa',
        'modfrete',
        'uf',
        'numeracaoVolumes',
        'peso_liquido',
        'peso_bruto',
        'especie',
        'qtdVolumes'
    ];
}
