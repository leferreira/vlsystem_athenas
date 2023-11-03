<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class Movimento extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        "id",
        "empresa_id",
        "status_id",
        "estorno",
        "tipo_movimento_id",
        "produto_id",
        "compra_id",
        "venda_id",
        "pdvvenda_id",
        "pedido_id",
        "entrada_avulsa_id",
        "saida_avulsa_id",
        "ordem_producao_id",
        "ent_sai",
        "data_movimento",
        "qtde_movimento",
        "valor_movimento",
        "subtotal_movimento",
        "descricao",
        "saldoestoque",
        "nfe_id"
    ];
    
  
    
    public function tipoMovimento(){
        return $this->belongsTo(TipoMovimento::class,"tipo_movimento_id","id");
    }
    
    public function produto(){
        return $this->belongsTo(Produto::class,"produto_id","id");
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,"empresa_id","id");
    }
    
    public function ordemCompra(){
        return $this->belongsTo(OrdemCompra::class,"ordem_compra_id","id");
    }
    
    public function pedido(){
        return $this->belongsTo(Pedido::class,"pedido_id","id");
    }
    public function entrada(){
        return $this->belongsTo(Entrada::class,"entrada_avulsa_id","id");
    }
    public function saida(){
        return $this->belongsTo(Saida::class,"saida_avulsa_id","id");
    }   
    
    public static function saldoEstoque($produto_id){
        $resultado = Movimento::where("produto_id", $produto_id)
        ->select("saldoestoque as saldo")
        ->orderBy("id","Desc")
        ->limit(1)
        ->first() ;
        
        return ($resultado) ? $resultado->saldo : 0;
    }
    
    public static function consulta($filtro){
        $retorno = Movimento::orderBy($filtro->ordem, $filtro->tipo_ordem);
        if($filtro->produto_id){
            $retorno->where("produto_id", $filtro->produto_id);
        }
       
        
        if($filtro->data1){
            if($filtro->data2){
                $retorno->where("data_movimento",">=", $filtro->data1)->where("data_movimento","<=", $filtro->data2);
            }else{
                $retorno->where("data_movimento", $filtro->data1);
            }
        }
        
        
        return $retorno->get();
    }
    
    public static function relatorio($filtro){
     
        $lista = array();
        if($filtro->tipo_relatorio=="historico"){
            $produto            = Produto::find($filtro->produto_id);
            $lista              = Movimento::where("produto_id", $filtro->produto_id)->get();
            $retorno            = new \stdClass();
            $retorno->produto   = $produto;
            $retorno->lista     = $lista;
           
        }
        
        
        return $retorno;
    }
}
