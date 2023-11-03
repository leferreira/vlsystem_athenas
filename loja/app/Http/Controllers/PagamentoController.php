<?php

namespace App\Http\Controllers;

use App\Service\LojaService;
use App\Service\PedidoService;

class PagamentoController extends Controller{
    
    public function escolher($uuid){
        $pedido = PedidoService::detalhe($uuid);
     
        session()->forget("pedido");
        session(["pedido"=>$pedido->id]);
     
        
        if(!(session()->has('pedido'))  ){
            return redirect()->route('home')->with('msg_erro', "Não existe nenhum pedido selecionado");
        }
        
        $carrinho               = LojaService::home("escolher_pagamento",null,null, $uuid) ; 
       
        
        
        
        $dados["carrinho"]      = $carrinho->carrinho;
        $dados["pedido"]        = $carrinho->carrinho;
        $dados["itens"]         = $carrinho->itens;
        $dados["cliente"]       = $carrinho->cliente;
        $dados["endereco"]      = $carrinho->endereco;
        $dados["configuracao"]  = $carrinho->configuracao;
        $dados["pagamentoJs"]   = true;
        return view("Pagamento.Index", $dados);
    }
    
    public function index(){
        $carrinho                = LojaService::carrinho() ;
        
        $dados["carrinho"]      = $carrinho->carrinho;
        $dados["cliente"]       = $carrinho->cliente;
        $dados["configuracao"]  = $carrinho->configuracao;
        $dados["pagamentoJs"]   = true;
        return view("Pagamento.Index", $dados);
    }
    
    
    public function finalizar($uuid, $forma_pagto){
        $carrinho                = LojaService::finalizarPedido($uuid, $forma_pagto) ;     
        if(isset($carrinho->erro)){
            return redirect()->back()->with("msg_erro", $carrinho->erro);
        }
        
        if(isset($carrinho->id)){
            return redirect()->route('carrinho.finalizado', $carrinho->uuid);
        }
    }
 
    
      
}
