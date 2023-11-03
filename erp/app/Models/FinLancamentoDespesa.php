<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinLancamentoDespesa extends Model
{
    use HasFactory;
    protected $fillable     = [
        "id",
        "fornecedor_id",
        "despesa_id",
        "valor",
        "data_lancamento",
        "data_vencimento",
        "data_pagamento",
        "pago"
    ];
    
    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class,"fornecedor_id","id");
    }
    
    public function despesa(){
        return $this->belongsTo(FinDespesa::class,"despesa_id","id");
    }
}
