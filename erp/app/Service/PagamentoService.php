<?php
namespace App\Service;

use App\Models\FinFatura;
use App\Models\FinPagamento;
use App\Models\GestaoRecebimento;
use App\Models\PlanoPreco;

class PagamentoService
{
    public function pagarComPix(){
        
    }
    
    public function pagarComCartao(){
        
    }
    
    public function pagarComBoleto(){
        
    }
    
    public static function pagarPorTransferência($id){
        $planopreco = PlanoPreco::find($id);
        
        //Gerar Fatura        
        $fat = new \stdClass();
        $fat->descricao         = "Aquisição do Plano: " . $planopreco->plano->nome ;
        $fat->forma_pagto_id    = 16;
        $fat->status_id         = config("constantes.status.PAGO");
        $fat->data_emissao      = hoje();
        $fat->data_vencimento   = hoje();
        $fat->valor             = $planopreco->preco;
        $fatura                 = FinFatura::Create(objToArray($fat));
        
        //gerar pagamento para a Empresa
        $pag = new \stdClass();
        $pag->usuario_id              = 1;
        $pag->descricao_pagamento     = "Pagamento da Fatura #" .$fatura->id;
        $pag->forma_pagto_id          = 16 ;
        $pag->tipo_documento          = config("constantes.tipo_recorrencia.FATURA") ;
        $pag->documento_id            = $fatura->id;        
        $pag->data_pagamento          = hoje();
        $pag->numero_documento        = $fatura->id;
        $pag->observacao              = "Pagamento de fatura";
        $pag->valor_original          = $planopreco->preco;
        $pag->juros                   = 0;
        $pag->desconto                = 0;
        $pag->multa                   = 0;
        $pag->valor_pago              = $planopreco->preco;
        $pagamento                    = FinPagamento::Create(objToArray($pag));      
        
        
        //gerar Recebimento para o Gestor
        $gestor_receb = new \stdClass();
        $gestor_receb->usuario_id              = 1;
        $gestor_receb->descricao_recebimento   = "Recebimento da Fatura #" .$fatura->id;
        $gestor_receb->forma_pagto_id          = 16 ;
        $gestor_receb->tipo_documento          = config("constantes.tipo_recorrencia.FATURA") ;
        $gestor_receb->documento_id            = $fatura->id;
        $gestor_receb->data_recebimento        = hoje();
        $gestor_receb->numero_documento        = $fatura->id;
        $gestor_receb->observacao              = "Pagamento de fatura";
        $gestor_receb->valor_original          = $planopreco->preco;
        $gestor_receb->juros                   = 0;
        $gestor_receb->desconto                = 0;
        $gestor_receb->multa                   = 0;
        $gestor_receb->valor_recebido          = $planopreco->preco;
        $gestor_recebimento                    = GestaoRecebimento::Create(objToArray($gestor_receb));
        
        $fatura->pagamento_id                  = $pagamento->id;
        $fatura->recebimento_id                = $gestor_recebimento->id;
        $fatura->save();
        
        //Alterar o status da empresa
        $empresa                = auth()->user()->empresa;
        
        if($empresa->plano_preco_id   ==1){
            $empresa->data_aquisicao            = hoje();
            $empresa->data_inicial_vencimento   = hoje();
        }        
        $empresa->plano_preco_id    = $planopreco->id;
        $empresa->forma_pagto_id    = 16;
        $empresa->valor_recorrente  = $planopreco->preco;
        $empresa->valor_contrato    = $planopreco->preco;
        $empresa->status_id         = config("constantes.status.ATIVO");
        $empresa->status_plano_id   = config("constantes.status.EM_DIAS");
        $empresa->data_vencimento   = somarData(hoje(),30 * $planopreco->recorrencia );
        $empresa->save();
        
    }
}

