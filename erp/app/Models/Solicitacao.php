<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitacao extends Model
{
   
    protected $fillable =["id",
        "produto_id",
        "status_solicitacao_id",
        "ordem_compra_id",
        "fornecedor_id", "qtde",
        "data_entrega", "data_solicitacao",
        "hora_solicitacao"];
    
    public function produto(){
        return $this->belongsTo(Produto::class,"produto_id","id");
    }
        
    public function status(){
        return $this->belongsTo(StatusSolicitacao::class,"status_solicitacao_id","id");
    }
    
    public function ordemCompra(){
        return $this->belongsTo(OrdemCompra::class,"ordem_compra_id","id");
    }
    
    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class,"fornecedor_id","id");
    }
}
