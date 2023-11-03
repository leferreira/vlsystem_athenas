<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinParcelaPagamento extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "parcela_pagar_id",
        "forma_pagto_id",
        "data_pagamento",
        "valor_pago",
        "historico"
    ];
    
    public function parcela(){
        return $this->belongsTo(FinParcelaPagar::class,"parcela_pagar_id","id");
    }
    
    public function formaPagto(){
        return $this->belongsTo(FormaPagto::class,"forma_pagto_id","id");
    }
}
