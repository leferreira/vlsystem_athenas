<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motoboy extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome', 'telefone1', 'telefone2', 'telefone3', 'cpf', 'rg', 'endereco', 'tipo_transporte'
    ];
    
    public static function tiposTransporte(){
        return [
            'Moto',
            'Bicicleta'
        ];
    }
}
