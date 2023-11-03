<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinParcelaPagar extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "lancamento_pagar_id",
        "numero_parcela",
        "data_emissao",
        "data_vencimento",
        "valor_parcela",
        "valor_juro",
        "valor_multa",
        "valor_desconto",
        "valor_pago",
        "saldo_devedor",
        "valor_total_pagar",
        "quitado"
    ];
    
    public function lancamento(){
        return $this->belongsTo(FinLancamentoPagar::class,"lancamento_pagar_id","id");
    }
}
