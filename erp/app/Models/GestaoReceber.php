<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestaoReceber extends Model
{
    use HasFactory;
    protected $fillable = [
        "empresa_id",
        "lancamento_original_id",
        "descricao",
        "data_lancamento",
        "data_recebimento",
        "data_vencimento",
        "valor_a_receber",
        "valor_recebido",
        "juros",
        "desconto",
        "multa",
        "acrescimo",
        "saldo_restante",
        "valor_total",
        "pago"
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class,"empresa_id","id");
    }
    
    public function LancamentoOriginal(){
        return $this->belongsTo(GestaoReceber::class,"lancamento_original_id","id");
    }
}
