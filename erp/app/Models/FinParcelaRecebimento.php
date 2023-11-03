<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinParcelaRecebimento extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "parcela_receber_id",
        "tipo_recebimento_id",
        "data_recebimento",
        "valor_recebido",
        "historico"
    ];
    
    public function parcela(){
        return $this->belongsTo(FinParcelaReceber::class,"parcela_receber_id","id");
    }
    
    public function formaPagto(){
        return $this->belongsTo(FinParcelaReceber::class,"tipo_recebimento_id","id");
    }
}
