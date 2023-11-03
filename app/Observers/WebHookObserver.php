<?php

namespace App\Observers;

use App\Models\MercadoPagoTransacao;
use App\Services\WebHookService;

class WebHookObserver
{
    public function created(MercadoPagoTransacao $transacao)
    {   
        
        if($transacao->status=="approved"){
            $forma_pagto = null;
            
            if($transacao->metodo_pagamento == "pix"){
                $forma_pagto = config("constantes.forma_pagto.PIX");
            }
            
            if($transacao->metodo_pagamento == "cartao_credito"){
                $forma_pagto = config("constantes.forma_pagto.CARTAO_CREDITO");
            }
            
            if($transacao->metodo_pagamento == "cartao_debito"){
                $forma_pagto = config("constantes.forma_pagto.CARTAO_DEBITO");
            }
            
            $pedido = new \stdClass();
            $pedido->forma_pagto        = $forma_pagto;
            $pedido->valor              = $transacao->valor;
            $pedido->transacao_id       = $transacao->transacao_id;
           // $pedido->status_pagamento   = $transacao->status;
            
       
            if($transacao->cobranca_id){
                $pedido->id =$transacao->cobranca_id;
                WebHookService::confirmarPagamentoCobranca($pedido);
            }
            
            if($transacao->fatura_id){
                $pedido->id =$transacao->fatura_id;
                WebHookService::confirmarPagamentoFatura($pedido);
            }
            
            if($transacao->loja_pedido_id){
               $pedido->id =$transacao->loja_pedido_id;
               WebHookService::confirmarPagamentoPedidoLoja($pedido);
              
            }
            
            if($transacao->pdv_venda_id){
                $pedido->id = $transacao->pdv_venda_id;                
                WebHookService::confirmarPagamentoPdv($pedido);
            }
            
            
        }       
        
    }
    
    
}
