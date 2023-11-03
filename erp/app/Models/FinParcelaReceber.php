<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinParcelaReceber extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "lancamento_receber_id",
        "numero_parcela",
        "data_emissao",
        "data_vencimento",
        "valor_parcela",
        "valor_juro",
        "valor_multa",
        "valor_desconto",
        "valor_recebido",
        "saldo_devedor",
        "valor_total_receber",
        "quitado"
    ];
    
    public function lancamento(){
        return $this->belongsTo(FinLancamentoReceber::class,"lancamento_receber_id","id");
    }
}
