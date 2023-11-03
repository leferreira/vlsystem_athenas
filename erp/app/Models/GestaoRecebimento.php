<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestaoRecebimento extends Model{
    use HasFactory;
    protected $fillable = [
        "forma_pagto_id",
        "gestao_receber_id",
        "data_recebimento",
        "valor_recebido"
    ];
    
    public function conta_receber(){
        return $this->belongsTo(GestaoReceber::class,"gestao_receber_id","id");
    }
    public function forma_pagto(){
        return $this->belongsTo(FormaPagto::class,"forma_pagto_id","id");
    }
}
