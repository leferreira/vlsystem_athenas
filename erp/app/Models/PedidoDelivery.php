<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoDelivery extends Model
{
    protected $fillable = [
        'cliente_id','status_id', 'valor_total', 'status_pedido_id','origem','forma_pagamento', 'observacao',
        'telefone', 'estado', 'endereco_id', 'motivoEstado', 'troco_para', 'cupom_id',
        'desconto', 'app'
    ];
    
    public function itens(){
        return $this->hasMany(ItemPedidoDelivery::class, 'pedido_id', 'id');
    }
    
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    
  
    
    public function endereco(){
        return $this->belongsTo(EnderecoCliente::class, 'endereco_id');
    }
    
    public function pagseguro(){
        return $this->hasOne(PedidoPagSeguro::class, 'pedido_delivery_id', 'id');
    }
        
    public function somaItens(){
        
        $config = DeliveryConfig::first();
        $total = 0;
        
        if($this->valor_total > 0){
            return $this->valor_total;
        } else{
            
            foreach($this->itens as $i){
                
                if(count($i->sabores) > 0){
                    $maiorValor = 0;
                    $somaValores = 0;
                    foreach($i->sabores as $sb){
                        $v = $sb->maiorValor($sb->sabor_id, $i->tamanho_id);
                        $somaValores += $v;
                        if($v > $maiorValor) $maiorValor = $v;
                    }
                    if(getenv("DIVISAO_VALOR_PIZZA") == 1){
                        $maiorValor = number_format(($somaValores/sizeof($i->sabores)),2);
                    }
                    $total += $i->quantidade * $maiorValor;
                }else{
                    $total += $i->quantidade * $i->produto->valor;
                }
                
                foreach($i->itensAdicionais as $a){
                    $total += $a->quantidade * $a->adicional->valor;
                }
                
            }
            
            if($this->cupom_id != null){
                $total -= $this->desconto;
            }
            
            if($this->endereco_id != null)
                $total += $config != null ? $config->valor_entrega : 0;
                return $total;
        }
    }
    
    public function somaItensSemFrete(){
        $total = 0;
        foreach($this->itens as $i){
            
            if(count($i->sabores) > 0){
                $maiorValor = 0;
                $somaValores = 0;
                foreach($i->sabores as $sb){
                    $v = $sb->maiorValor($sb->sabor_id, $i->tamanho_id);
                    $somaValores += $v;
                    if($v > $maiorValor) $maiorValor = $v;
                }
                if(getenv("DIVISAO_VALOR_PIZZA") == 1){
                    $maiorValor = number_format(($somaValores/sizeof($i->sabores)),2);
                }
                $total += $i->quantidade * $maiorValor;
            }else{
                $total += $i->quantidade * $i->produto->valor;
            }
            
            foreach($i->itensAdicionais as $a){
                $total += $a->quantidade * $a->adicional->valor;
            }
            
        }
        return $total;
    }
    
    public function somaCarrinho(){
        $config = DeliveryConfig::first();
        $total = 0;
        if($this->valor_total == 0){
            foreach($this->itens as $i){
                if(count($i->sabores) > 0){
                    $maiorValor = 0;
                    foreach($i->sabores as $sb){
                        $sb->produto->produto;
                        $v = $sb->maiorValor($sb->sabor_id, $i->tamanho_id);
                        if($v > $maiorValor) $maiorValor = $v;
                    }
                    
                    $total += $i->quantidade * $maiorValor;
                }else{
                    $total += $i->quantidade * $i->produto->valor;
                }
                foreach($i->itensAdicionais as $a){
                    $total += $a->quantidade * $a->adicional->valor;
                }
            }
        }
        
        return $total;
    }
    
    public function calculaFrete(){
        return $this->valor_total - $this->somaItensSemFrete() + $this->desconto;
    }
    
    public function itensOrdenadosPorPizza(){
        $temp = [];
        foreach($this->itens as $i){
            if(count($i->sabores) > 0){
                array_push($temp, $i);
            }
        }
        
        foreach($this->itens as $i){
            if(count($i->sabores) == 0){
                array_push($temp, $i);
            }
        }
        return $temp;
    }
}
