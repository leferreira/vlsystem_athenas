<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionamentoDelivery extends Model
{
    use HasFactory;
    protected $fillable = [
        'ativo', 'dia', 'inicio_expediente', 'fim_expediente'
    ];
    
    public static function dias(){
        return [
            'DOMINGO',
            'SEGUNDA',
            'TERÇA',
            'QUARTA',
            'QUINTA',
            'SEXTA',
            'SABADO'
        ];
    }
}
