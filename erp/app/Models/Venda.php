<?php

namespace App\Models;

use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venda extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id', 'cliente_id', 'vendedor_id', 'orcamento_id', 'usuario_id','frete_id','transportadora_id','status_id','status_financeiro_id',
        'data_venda', 'xml_path', 'chave', 'nf', 'situacao','valor_liquido', 'valor_frete',
        'valor_imposto', 'valor_desconto', 'valor_venda','unidade', 'forma_pagamento','enviou_financeiro','enviou_nfe','enviou_estoque',
        'qtde_parcela', 'primeiro_vencimento', 'tPag', 'observacao', 'observacao_interna',
        'pedido_loja_id', 'bandeira_cartao', 'cnpj_cartao', 'cAut_cartao', 'estornou_estoque',
        'descricao_pag_outros','total_desconto_item','total_seguro','despesas_outras','desconto_valor','desconto_per','tabela_preco_id'
    ]; 
    
    public function duplicatas(){
        return $this->hasMany(Duplicata::class, 'venda_id', 'id');
    }
    
    public function contas(){
        return $this->hasMany(FinContaReceber::class, 'venda_id', 'id');
    }
    public function nfe(){
        return $this->hasOne(Nfe::class, 'venda_id');
    }
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function status_financeiro(){
        return $this->belongsTo(Status::class, 'status_financeiro_id');
    }
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }    
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    
    public function vendedor(){
        return $this->belongsTo(Vendedor::class, 'vendedor_id');
    }
    
    public function natureza(){
        return $this->belongsTo(NaturezaOperacao::class, 'natureza_id');
    }
    
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function frete(){
        return $this->belongsTo(Frete::class, 'frete_id');
    }
    
    public function transportadora(){
        return $this->belongsTo(Transportadora::class, 'transportadora_id');
    }
    
    public function itens(){
        return $this->hasMany(ItemVenda::class, 'venda_id', 'id');
    }
    
    public function qtde_paga(){
        return FinContaReceber::where("recebimento_id",">",0)->where("venda_id", $this->id)->count();
    }
    
    public function foiPaga(){
        return ($this->qtde_paga() >= count($this->duplicatas));
    }
    
    public static function atualizarStatus($venda_id){
        $venda        = Venda::find($venda_id);
        $venda->status_financeiro_id  = config("constantes.status.ABERTO");
        $parcialmente   = FinContaReceber::where(["status_id" => config("constantes.status.PARCIALMENTE_PAGO"), "venda_id" => $venda_id ])->first();
        if($parcialmente){
            $venda->status_financeiro_id  = config("constantes.status.PARCIALMENTE_PAGO");
        }else{
            $qtde_conta     = FinContaReceber::where("venda_id",$venda_id )->count("*");
            $pago   = FinContaReceber::where(["status_id" => config("constantes.status.PAGO"), "venda_id" => $venda_id ])->count("*");
            if($pago == $qtde_conta){
                $venda->status_financeiro_id  = config("constantes.status.PAGO");
            }
        }
        $venda->save();
    }
    
    public static function somarTotal($id){
        $venda          = Venda::find($id);
        $valor_venda    = ItemVenda::where("venda_id", $id)->sum("subtotal_liquido");
        $venda->valor_desconto = 0;
        if($venda->desconto_valor > 0){
            $venda->valor_desconto = $venda->desconto_valor;
        }
        if($venda->desconto_per > 0){
            $venda->valor_desconto = $venda->desconto_per * $valor_venda * 0.01;
        }      
       
        $venda->valor_venda = $valor_venda;
        $venda->valor_liquido = $venda->valor_venda  +  $venda->valor_frete + $venda->despesas_outras + $venda->total_seguro - $venda->valor_desconto;        
        $venda->save();
    }
    
    
    public static function filtro($filtro){
        $retorno = Venda::orderBy('vendas.data_venda', 'asc');
        if($filtro->cliente_id){
            $retorno->where("cliente_id", $filtro->cliente_id);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }else{
            $retorno->where("status_id", "!=", config("constantes.status.DELETADO"));
        }
        
        if($filtro->status_financeiro_id){
            $retorno->where("status_financeiro_id", $filtro->status_financeiro_id);
        }
        
        if($filtro->data2){
            if($filtro->data2){
                $retorno->where("data_venda",">=", $filtro->data1)->where("data_venda","<=", $filtro->data2);
            }else{
                $retorno->where("data_venda", $filtro->data1);
            }
        }        
       
        
        return $retorno->get();
    }
    
    public static function consulta($filtro){
        $retorno = Venda::orderBy($filtro->ordem, $filtro->tipo_ordem);
        if($filtro->cliente_id){
            $retorno->where("cliente_id", $filtro->cliente_id);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }else{
            $retorno->where("status_id", "!=", config("constantes.status.DELETADO"));
        }
        
        if($filtro->status_financeiro_id){
            $retorno->where("status_financeiro_id", $filtro->status_financeiro_id);
        }
        
        if($filtro->vendedor_id){
            $retorno->where("vendedor_id", $filtro->vendedor_id);
        }
        
        if($filtro->data1){
            if($filtro->data2){
                $retorno->where("data_venda",">=", $filtro->data1)->where("data_venda","<=", $filtro->data2);
            }else{
                $retorno->where("data_venda", $filtro->data1);
            }
        }
        
        
        return $retorno->get();
    }
    
    public static function relatorio($filtro){
        
        $lista = array();
        if($filtro->tipo_relatorio=="resumo_diario"){
            $datas = listaIntevaloData($filtro->data1, $filtro->data2);
            for($i=0; $i<count($datas); $i++){
                $venda      = Venda::where("data_venda", $datas[$i])->sum("valor_venda");
                $desconto   = Venda::where("data_venda", $datas[$i])->sum("valor_desconto");
                $liquido    = Venda::where("data_venda", $datas[$i])->sum("valor_liquido");
                if($venda > 0){
                    $retorno = new \stdClass();
                    $retorno->data      = $datas[$i];
                    $retorno->venda     = $venda;
                    $retorno->desconto  = $desconto;
                    $retorno->liquido   = $liquido;
                    $lista[]            = $retorno;
                }
                
            }
        }
        
       
        return $lista;
    }
    
    public static function relatorio_antigo($filtro){
        $retorno = Venda::orderBy('vendas.data_venda', 'asc');
        
        
        if($filtro->cliente_id){
            $retorno->where("cliente_id", $filtro->cliente_id);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
        if($filtro->status_financeiro_id){
            $retorno->where("status_financeiro_id", $filtro->status_financeiro_id);
        }
        
        if($filtro->usuario_id){
            $retorno->where("usuario_id", $filtro->usuario_id);
        }
        
        if($filtro->data2){
            if($filtro->data2){
                $retorno->where("data_venda",">=", $filtro->data1)->where("data_venda","<=", $filtro->data2);               
            }else{
                $retorno->where("data_venda", $filtro->data1);
            }
            
        }
        
        
        return $retorno->get();
    }
    
   
    
}
