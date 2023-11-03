<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parametro extends Model
{
    use HasFactory;
    protected $fillable = [
        'empresa_id', 'num_casas_decimais', 'num_paginacao', 'num_casas_decimais', 'margem_lucro',
        'estoque_minimo_padrao','estoque_maximo_padrao','mercadopago_public_key','mercadopago_access_token'
    ];
}
