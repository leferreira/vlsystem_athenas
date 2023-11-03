<?php
namespace App\Services;

use App\Models\Cobranca;
use App\Models\FinFatura;
use App\Models\LojaPedido;
use App\Models\PdvDuplicata;
use App\Models\PdvVenda;
use App\Models\FinContaReceber;


class  WebHookService
{          
    
    
    //Confirma o pagamento vindo do webhook
    public static function confirmarPagamentoPdv($dados){
        
        $pdvVenda           = PdvVenda::find($dados->id);
        
        $pag                = new \stdClass();
        $pag->venda_id      = $dados->id;
        $pag->caixa_id      = $pdvVenda->caixa_id;
        $pag->tPag          = $dados->forma_pagto;
        $pag->nDup          = 1;
        $pag->dVenc         = hoje();
        $pag->vDup          = $dados->valor;
        $pag->transacao_id  = $dados->transacao_id;
        PdvDuplicata::Create(objToArray($pag));
        
    }
    
    public static function confirmarPagamentoPedidoLoja($dados){
		$lojaPedido 	= LojaPedido::find($dados->id);
        $contaReceber   = ContaReceberSevice::inserirPeloPedidoDaLoja($lojaPedido);
        if($contaReceber){
            RecebimentoService::inserirPelaLojaPedido($contaReceber, $dados->forma_pagto);
        }
       
        $tipo_movimento         = config("constantes.tipo_movimento.SAIDA_VENDA_LOJA_VIRTUAL");
        $descricao              = "Saida Loja Virutal - Pedido: #" . $lojaPedido->id;
        MovimentoService::lancarEstoqueDoPedidoDaLoja($lojaPedido->id, $tipo_movimento, $descricao, $lojaPedido->empresa_id);
        $lojaPedido->data_pagamento         = hoje();
        $lojaPedido->transacao_id           = $dados->transacao_id;
        $lojaPedido->status_financeiro_id   = config("constantes.status.PAGO");
        $lojaPedido->status_id              = config("constantes.status.FINALIZADO");
        $lojaPedido->save();
    }
        
    public static function confirmarPagamentoFatura($dados){
        $fatura = FinFatura::find($dados->id);
        $contaReceber   = ContaReceberSevice::inserirPelaFatura($fatura);
        if($contaReceber){
            RecebimentoService::inserirPelaLojaPedido($contaReceber);
        }
        
        $tipo_movimento         = config("constantes.tipo_movimento.SAIDA_VENDA_LOJA_VIRTUAL");
        $descricao              = "Saida Loja Virutal - Pedido: #" . $fatura->id;
        MovimentoService::lancarEstoqueDoPedidoDaLoja($fatura->id, $tipo_movimento, $descricao, $fatura->empresa_id);
        
        $fatura->status_id  = config("constantes.status.FINALIZADO");;
        $fatura->save();
    }
        
    public static function confirmarPagamentoCobranca($dados){
        $cobranca       = Cobranca::find($dados->id);
        if($cobranca){
            $contaReceber   = FinContaReceber::where("cobranca_id", $cobranca->id)->first();
          
            if($contaReceber){
                RecebimentoService::inserirPelaCobranca($contaReceber, $dados->forma_pagto);
            }
            
            $cobranca->status_financeiro_id = config("constantes.status.PAGO");
            $cobranca->status_id            = config("constantes.status.FINALIZADO");
            $cobranca->data_pagamento       = hoje();
            $cobranca->save();
        }
        
    }
    
    
  
}

