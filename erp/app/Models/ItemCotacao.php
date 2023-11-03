<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class ItemCotacao extends Model
{
    use HasFactory;
    protected $fillable = ["id",
        "cotacao_id",
        "fornecedor_id",
        "solicitacao_id",
        "status_item_cotacao_id",
        "ordem_compra_id",
        "produto_id",
        "qtde",
        "data_entrega",
        "limite_entrega",
        "valor_cotacao",
        "subtotal"
        
    ];
    
    
    public function cotacao(){
        return $this->belongsTo(Cotacao::class,"cotacao_id","id");
    }
    
    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class,"fornecedor_id","id");
    }
    
    public function solicitacao(){
        return $this->belongsTo(Solicitacao::class,"solicitacao_id","id");
    }
    public function status(){
        return $this->belongsTo(StatusItemCotacao::class,"status_item_cotacao_id","id");
    }
    public function ordemCompta(){
        return $this->belongsTo(OrdemCompra::class,"ordem_compra_id","id");
    }
    public function produto(){
        return $this->belongsTo(Produto::class,"produto_id","id");
    }
    
    public static function agrupaMenorPreco($cotacao_id){
        $itens = DB::table('item_cotacaos')
        ->select(DB::raw('solicitacao_id, min(valor_cotacao) as menor'))
        ->where('cotacao_id',  $cotacao_id)
        ->groupBy('solicitacao_id')
        ->get();
        
        return $itens;
    }
}
