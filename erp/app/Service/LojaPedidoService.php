<?php
namespace App\Service;

class LojaPedidoService
{
    public static function gerarNfe($pedido, $natureza_operacao, $tributacao){
        inserirNfePelaPedidoDaLoja($pedido, $natureza_operacao, $tributacao);
        $pedido->enviou_nfe = "S";
        $pedido->save();
    }
    
   
}

