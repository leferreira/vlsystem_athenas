<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\CategoriaAdicional;
use App\Models\FuncionamentoDelivery;
use App\Models\ProdutoDelivery;
use App\Models\TamanhoPizza;
use App\Models\DeliveryConfig;


class ProdutoDeliveryController extends Controller{
    
    public function detalhe($id){
        $value = session('cliente_delivery_log');
        $dados["config"] = DeliveryConfig::first();        
        if($value){
            $produto = ProdutoDelivery::where('id', $id)->first();            
            $funcionamento = $this->funcionamento();
            if(!$funcionamento['status']){
                if($funcionamento['funcionamento'] != null){
                    session()->flash("message_erro", "Delivery das " .$funcionamento['funcionamento']->inicio_expediente. " às ".$funcionamento['funcionamento']->fim_expediente);
                }else{
                    session()->flash("message_erro", "Não haverá delivery no dia de hoje!");
                }
                return redirect()->route('delivery.home');
            }
            
            if(strpos(strtolower($produto->categoria->nome), 'izza') !== false){                
                $tamanhos = TamanhoPizza::all();
                
                $dados["produto"] = $produto;
                $dados["tamanhos"] = $tamanhos;
                $dados["categoria"] = $produto->categoria;
                $dados["produto"] = $produto;
                $dados["produto"] = $produto;
                return view("Delivery.Produto.tipoPizza", $dados);
            }else{                
                $categorias = $this->preparaCategorias($produto->adicionais);                
                $adicionaisTemp = [];
                foreach($produto->adicionais as $p){
                    array_push($adicionaisTemp, $p->complemento_id);
                    $p->complemento->categoria;
                }
                
                $dados["produto"] = $produto;
                $dados["categorias"] = $categorias;
                $dados["acompanhamento"] = true;
                $dados["historico"] = true;
                $dados["adicionaisTemp"] = $adicionaisTemp;
                $dados["adicionais"] = $produto->adicionais;
                $dados["adicionaisTemp"] = $adicionaisTemp;                
                
                return view("Delivery.Produto.Detalhe", $dados);
            }
        }else{
            session()->flash("message_erro", "Voce precisa estar logado para comprar nossos produtos");
            return redirect()->route('delivery.login');
        }
        
        
    }
    
    private function funcionamento(){
        $atual = strtotime(date('H:i'));
        $dias = FuncionamentoDelivery::dias();
        $hoje = $dias[date('w')];
        $func = FuncionamentoDelivery::where('dia', $hoje)->first();        
        if($func){
            if($atual >= strtotime($func->inicio_expediente) && $atual < strtotime($func->fim_expediente) && $func->ativo){
                return ['status' => true, 'funcionamento' => $func];
            }else{
                return ['status' => false, 'funcionamento' => $func];
            }
        }else{
            return ['status' => false, 'funcionamento' => null];
        }
        
    }
    
    private function preparaCategorias($adicionais){
        $categorias = [];
        $categoriasAdicional = CategoriaAdicional::all();
        
        foreach($adicionais as $a){
            foreach($categoriasAdicional as $c){                
                if($a->complemento->categoria_id == $c->id){
                    if(!in_array($c, $categorias))
                        array_push($categorias, $c);
                }
            }
        }        
        return $categorias;
    }
 
}
