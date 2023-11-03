<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class GradeMovimentoTemp extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        "id",
        "empresa_id",
        "grade_id",
        "status_id",
        "estorno",
        "tipo_movimento_id",
        "produto_id",
        "orcamento_id",
        "item_orcamento_id",
        "pedido_cliente_id",
        "item_pedido_cliente_id",
        "loja_pedido_id",
        "item_loja_pedido_id",
        "item_loja_pedido_id",
        "saida_avulsa_id",
        "ordem_producao_id",
        "ent_sai",
        "data_movimento",
        "qtde_movimento",
        "valor_movimento",
        "subtotal_movimento",
        "descricao",
        "saldoestoque",
        "item_nfe_id"
    ];
    
    
    public function tipoMovimento(){
        return $this->belongsTo(TipoMovimento::class,"tipo_movimento_id","id");
    }
    
    public function grade(){
        return $this->belongsTo(GradeProduto::class,"grade_id","id");
    }
    
    public function saida(){
        return $this->belongsTo(Saida::class,"saida_id","id");
    }
}
