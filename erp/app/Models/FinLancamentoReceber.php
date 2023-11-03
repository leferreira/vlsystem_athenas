<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinLancamentoReceber extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "cliente_id",
        "pedido_id",
        "documento_origem_id",
        "qtde_parcela",
        "valor_total",
        "valor_a_receber",
        "valor_recebido",
        "data_lancamento",
        "numero_documento",
        "primeiro_vencimento",
        "data_ult_parcela",
        "juros",
        "desconto",
        "multa",
        "acrescimo",
        "saldo_restante",
        "intervalo_entre_parcela",
        "finalizado",
        "pago"
    ];
    
    public function cliente(){
        return $this->belongsTo(Cliente::class,"cliente_id","id");
    }
    
    public function pedido(){
        return $this->belongsTo(Pedido::class,"pedido_id","id");
    }
    
    public function documento(){
        return $this->belongsTo(FinDocumentoOrigem::class,"documento_origem_id","id");
    }
    
}
