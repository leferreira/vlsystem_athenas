<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class LojaPedido extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'id', 'empresa_id', 'cliente_id', 'endereco_id', 'status_id', 'status_financeiro_id',  'codigo_rastreio',
        'valor_venda', 'valor_liquido','valor_frete','desconto_valor','desconto_per','valor_desconto',
        'valor_frete', 'tipo_frete', 'venda_id','numero_nfe', 'observacao', 'rand_pedido',
        'link_boleto', 'qr_code_base64', 'qr_code','transacao_id', 'forma_pagto_id', 'status_pagamento',
        'status_detalhe','hash','uuid','url','estorno','data_pagamento','data_separacao','data_envio','data_entrega', 'status_entrega_id'
    ];
    
    public function itens(){
        return $this->hasMany(LojaItemPedido::class, 'pedido_id', 'id');
    }
    
    public function nfe(){
        return $this->hasOne(Nfe::class, 'loja_pedido_id');
    }
    public function duplicatas(){
        return $this->hasMany(FinContaReceber::class, 'loja_pedido_id', 'id');
    }
    
    public function venda(){
        return $this->hasOne(Venda::class, 'pedido_loja_id', 'id');
    }
    
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    
    public function status_financeiro(){
        return $this->belongsTo(Status::class, 'status_financeiro_id');
    }
    
    
    public function forma_pagamento(){
        return $this->belongsTo(FormaPagto::class, 'forma_pagto_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function endereco(){
        return $this->belongsTo(EnderecoCliente::class, 'endereco_id');
    }
    
    public function somaItens(){
        $soma = 0;
        foreach($this->itens as $i){
            $soma += $i->quantidade * $i->valor;
        }
        return $soma;
    }
    
    public static function filtro($filtro){
        $retorno = LojaPedido::orderBy('loja_pedidos.data_pedido', 'asc');
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
                $retorno->where("data_pedido",">=", $filtro->data1)->where("data_pedido","<=", $filtro->data2);
            }else{
                $retorno->where("data_pedido", $filtro->data1);
            }
        }
        
        
        return $retorno->get();
    }
    
    public static function consulta($filtro){
        $retorno = LojaPedido::orderBy($filtro->ordem, $filtro->tipo_ordem);
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
    
    public function somaItensPorCep($cep){
        $itensPedido = LojaItemPedido::
        select('loja_item_pedidos.*')
        ->join('loja_produtos', 'loja_produtos.id', '=',
            'loja_item_pedidos.produto_id')
            ->where('loja_item_pedidos.pedido_id', $this->id)
            ->where('loja_produtos.cep', $cep)
            ->get();
            $soma = 0;
            foreach($itensPedido as $i){
                $soma += $i->quantidade * $i->valor;
            }
            return $soma;
    }
    
    public function somaPeso(){
        $soma = 0;
        foreach($this->itens as $i){
            
            $soma += $i->quantidade * $i->produto->peso_bruto;
        }
        return $soma;
    }
    
    public function somaPesoPorCep($cep){
        $itensPedido = LojaItemPedido::
        select('loja_item_pedidos.*')
        ->join('loja_produtos', 'loja_produtos.id', '=',
            'loja_item_pedidos.produto_id')
            ->where('loja_item_pedidos.pedido_id', $this->id)
            ->where('loja_produtos.cep', $cep)
            ->get();
            $soma = 0;
            foreach($itensPedido as $i){
                
                $soma += $i->quantidade * $i->produto->peso_bruto;
            }
            return $soma;
    }
    
    public function somaDimensoes(){
        $data = [
            'comprimento' => 0,
            'altura' => 0,
            'largura' => 0
        ];
        foreach($this->itens as $key => $i){
            if($i->produto->comprimento > $data['comprimento']){
                $data['comprimento'] = $i->produto->comprimento;
            }
            
            // if($i->produto->produto->altura > $data['altura']){
            $data['altura'] += $i->produto->altura;
            // }
            
            if($i->produto->largura > $data['largura']){
                $data['largura'] = $i->produto->largura;
            }
            
            $data['largura'] = $data['largura'];
        }
        return $data;
    }
    
    public function somaDimensoesPorCep($cep){
        $data = [
            'comprimento' => 0,
            'altura' => 0,
            'largura' => 0
        ];
        
        $itensPedido = LojaItemPedido::
        select('loja_item_pedidos.*')
        ->join('loja_produtos', 'loja_produtos.id', '=',
            'loja_item_pedidos.produto_id')
            ->where('loja_item_pedidos.pedido_id', $this->id)
            ->where('loja_produtos.cep', $cep)
            ->get();
            foreach($itensPedido as $key => $i){
                if($i->produto->comprimento > $data['comprimento']){
                    $data['comprimento'] = $i->produto->comprimento;
                }
                
                // if($i->produto->produto->altura > $data['altura']){
                $data['altura'] += $i->produto->altura;
                // }
                
                if($i->produto->largura > $data['largura']){
                    $data['largura'] = $i->produto->largura;
                }
                
                $data['largura'] = $data['largura'];
            }
            return $data;
    }
    
    public function getCepsDoPedido($cepOrigem){
        $ceps = [];
        foreach($this->itens as $key => $i){
            if(!in_array($i->produto->cep, $ceps)){
                if($i->produto->cep != ""){
                    array_push($ceps, $i->produto->cep);
                }
            }
        }
        
        return $ceps;
    }
}
