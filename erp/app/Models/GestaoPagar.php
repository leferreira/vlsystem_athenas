<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestaoPagar extends Model
{
    use HasFactory;
    protected $fillable = [
        "fornecedor_id",
        "descricao",
        "data_lancamento",
        "data_pagamento",
        "data_vencimento",
        "valor_a_pagar",
        "valor_pago",
        "juros",
        "desconto",
        "multa",
        "acrescimo",
        "pago"
    ];   
   
    
    public function fornecedor(){
        return $this->belongsTo(GestaoFornecedor::class,"fornecedor_id","id");
    }
  
}
