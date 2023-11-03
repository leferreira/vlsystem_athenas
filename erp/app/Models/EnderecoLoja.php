<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnderecoLoja extends Model
{
    protected $fillable = [
        'rua', 'numero', 'bairro', 'cep', 'cidade', 'uf', 'complemento', 'cliente_id'
    ];
        
    
}
