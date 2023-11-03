<?php

namespace App\Http\Controllers;

use App\Service\LojaService;

class VendaPdvController extends Controller{        
    
    public function index(){
        echo "veio";
    }
    public function vercarrinho($uuid){         
        try {            
            $pedido          = LojaService::retormarPedidoPeloPdv($uuid) ; 
            if(isset($pedido->id)){
                session()->forget('pedido');
                session(["pedido"=>$pedido->id]);
                return redirect()->route('carrinho');
            }            
            return redirect()->route('home')->with('msg_erro', "Nenhum Pedido foi Localizado");
        } catch (\Exception $e) {
            $mensagem = $e->getMessage();
            return redirect()->route('erro')->with('msg_erro', $mensagem);
        }
        
    }
    
    public function modelo($uuid){
        try {
            $pedido          = LojaService::criarPedidoPeloPdv($uuid) ;
            if($pedido){
                session()->forget('pedido');
                session(["pedido"=>$pedido->id]);
                return redirect()->route('carrinho');
            }
        } catch (\Exception $e) {
            $mensagem = $e->getMessage();
            return redirect()->route('erro')->with('msg_erro', $mensagem);
        }
        
    }
      
}
