<?php
namespace App\Service;

use App\Models\MovimentoConta;

class MovimentoContaBancariaService{
    public static function inserirMovimentoRecebimento($recebimento ){
        $origem =null;
        if(isset($recebimento->conta_receber)){
            if($recebimento->conta_receber->venda_id){
                $origem = "Venda ERP";   
            }
            
            if($recebimento->conta_receber->pdvduplicata_id ){
                $origem = "Venda PDV";
            }
            
            if($recebimento->conta_receber->loja_pedido_id ){
                $origem = "Venda Loja Virtual";
            }
            
            if($recebimento->conta_receber->loja_pedido_id ){
                $origem = "Venda Loja Virtual";
            }
        }
        $mov                                = new \stdClass();
        $mov->recebimento_id                = $recebimento->id;
        $mov->conta_id                      = $recebimento->conta_corrente_id ;
        $mov->documento                     = "Recebimento #".$recebimento->id;
        $mov->data_emissao                  = hoje();
        $mov->data_compensacao              = hoje();
        $mov->tipo_movimento                = "C";
        $mov->origem                        = $origem;
        $mov->historico                     = "Entrada de Valor via Recebimento #".$recebimento->id;
        $mov->valor                         = $recebimento->valor_recebido;
        $mov->classificacao_financeira_id   = $recebimento->classificacao_financeira_id;        
        MovimentoConta::Create(objToArray($mov));
    }
    
    public static function inserirMovimentoPagamento($pagamento ){
        $origem =null;
        if(isset($pagamento->conta_pagar)){
            if($pagamento->conta_pagar->compra_id){
                $origem = "Compra ERP";
            }
            
            if($pagamento->conta_pagar->fatura_id ){
                $origem = "Fatura";
            }
            
            if($pagamento->conta_pagar->nfe_id ){
                $origem = "Compra por XML";
            }           
          
        }
        
        $mov                                = new \stdClass();
        $mov->pagamento_id                  = $pagamento->id;
        $mov->conta_id                      = $pagamento->conta_corrente_id ;
        $mov->documento                     = "Pagamento #".$pagamento->id;
        $mov->data_emissao                  = hoje();
        $mov->data_compensacao              = hoje();
        $mov->tipo_movimento                = "D";
        $mov->origem                        = $origem;
        $mov->historico                     = "Saída de Valor via Pagamento #".$pagamento->id;
        $mov->valor                         = $pagamento->valor_pago;
        $mov->classificacao_financeira_id   = $pagamento->classificacao_financeira_id;
        
        MovimentoConta::Create(objToArray($mov));
    }
   

}

