<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedidoLoja extends Model
{
    protected $fillable = [
        'pedido_id', 'produto_id', 'quantidade', 'status', 'tamanho_pizza_id', 'observacao', 'valor', 'impresso', 'usuario_id'
    ];
        
    
    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }    
    
    
    public function itensAdicionais(){
        return $this->hasMany(ItemPedidoComplementoLocal::class, 'item_pedido', 'id');
    }
    
    public function sabores(){
        return $this->hasMany(ItemPizzaPedidoLocal::class, 'item_pedido', 'id');
    }
    
    public function nomeDoProduto(){
        if(count($this->sabores) == 0){
            $nome = $this->produto->nome;
            if($this->observacao != ''){
                $nome .= " | obs: " .$this->observacao;
            }
            
            if(sizeof($this->itensAdicionais) > 0){
                $nome .= " | Adicional: ";
                
                $str = "";
                foreach($this->itensAdicionais as $key => $a){
                    if($a->adicional->categoria->adicional){
                        $str .= $a->adicional->nome . ", ";
                    }
                }
                
                if(strlen($str) > 0){
                    $str = substr($str, 0, strlen($str)-2);
                    $nome .= $str;
                }
                
                $str = "";
                $nome .= " | Complemento: ";
                foreach($this->itensAdicionais as $key => $a){
                    if(!$a->adicional->categoria->adicional){
                        $str .= $a->adicional->nome . ", ";
                    }
                }
                
                if(strlen($str) > 0){
                    $str = substr($str, 0, strlen($str)-2);
                    $nome .= $str;
                }
            }
            
            return $nome;
        }else{
            $cont = 1;
            $nome = "";
            foreach($this->sabores as $s){
                $nome .= $cont."/".count($this->sabores) . " " . $s->produto->produto->nome;
            }
            $nome .= " | Tamanho: " . $this->tamanho->nome();
            
            if(sizeof($this->itensAdicionais) > 0){
                $nome .= " | Adicional: ";
                foreach($this->itensAdicionais as $a){
                    $nome .= $a->adicional->nome();
                }
            }
            
            if($this->observacao != ''){
                $nome .= " | " .$this->observacao;
            }
            return $nome;
        }
    }
    
    public function nomeDoProduto2(){
        if(count($this->sabores) == 0){
            $nome = $this->produto->nome;
            if($this->observacao != ''){
                $nome .= " | obs: " .$this->observacao;
            }
            
            if(sizeof($this->itensAdicionais) > 0){
                $str = "\nAdicional: ";
                
                // $str = "";
                $add = false;
                foreach($this->itensAdicionais as $key => $a){
                    if($a->adicional->categoria->adicional){
                        $str .= $a->adicional->nome . ", ";
                        $add = true;
                        
                    }
                }
                
                if($add){
                    $str = substr($str, 0, strlen($str)-2);
                    $nome .= $str;
                }
                
                
                $str = "";
                $nome .= "\nComplemento: ";
                foreach($this->itensAdicionais as $key => $a){
                    if(!$a->adicional->categoria->adicional){
                        $str .= "\n* ".$a->adicional->nome;
                    }
                }
                
                if(strlen($str) > 0){
                    $str = substr($str, 0, strlen($str)-2);
                    $nome .= $str;
                }
            }
            
            return $nome;
        }else{
            $cont = 1;
            $nome = "";
            foreach($this->sabores as $key => $s){
                $nome .= $cont."/".count($this->sabores) . " " . $s->produto->produto->nome . ($key == (sizeof($this->sabores)-1) ? "" : ", ");
            }
            $nome .= " | Tamanho: " . $this->tamanho->nome();
            
            if(sizeof($this->itensAdicionais) > 0){
                $nome .= " | Adicional: ";
                foreach($this->itensAdicionais as $a){
                    $nome .= $a->adicional->nome();
                }
            }
            
            if($this->observacao != ''){
                $nome .= " | " .$this->observacao;
            }
            return $nome;
        }
    }
    
}
