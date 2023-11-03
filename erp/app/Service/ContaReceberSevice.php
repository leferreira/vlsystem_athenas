<?php
namespace App\Service;

use App\Models\FinContaReceber;
use App\Models\Duplicata;
use App\Models\NfeDuplicata;
use App\Models\Cliente;

class ContaReceberSevice{    
    
    public static function novoContaReceber($conta){      
        for ($i=0; $i< $conta->qtde_parcela; $i++) {
                $con = new \stdClass();
                $con->cliente_id	 = $conta->cliente_id;
                $con->num_parcela	 = $i+1;
                $con->ult_parcela	 = $conta->qtde_parcela;
                $con->data_emissao	 = $conta->data_emissao;
                $con->data_vencimento= somarData($conta->primeiro_vencimento, $i * 30);
                $con->data_previsao	 = $con->data_vencimento ;
                $con->descricao	     = $conta->descricao ;
                $con->valor	         = $conta->valor  ;
                $con->origem	     = $conta->origem;           
            
                FinContaReceber::Create(objToArray($con));
        }
        
    }
    
    public static function salvarContaReceber($venda, $fatura){
        $i = 1;
        foreach ($fatura as $f) {
            $valorParcela = str_replace(",", ".", $f['valor']);
            FinContaReceber::create([                
                "cliente_id"		=> $venda->cliente_id,
                "venda_id"			=> $venda->id,
                "forma_pagto_id"	=> $f["forma_pagto_id"],
                "num_parcela"		=> $f['numero'],
                "ult_parcela"		=> count($fatura),
                "data_emissao"		=> $venda->data_emissao,
                "data_vencimento"	=> $f['data'],
                "descricao"	        =>"Venda #".$venda->id ."Parc#".$i ,
                "origem"	        => "Venda ERP",
                "valor"	            => $valorParcela,
            ]);
            $i++;
        }
    }
    
    public static function salvarContaReceberPelaVenda($venda){        
        $duplicatas = Duplicata::where("venda_id", $venda->id)->get();
        $i =1;
        if(count($duplicatas) > 0){
        foreach ($duplicatas as $duplicata){
            $dup = new \stdClass();
            $dup->cliente_id		= $venda->cliente_id;
            $dup->venda_id			= $venda->id;
            $dup->forma_pagto_id	= $duplicata->tPag;
            $dup->num_parcela		= $i;
            $dup->ult_parcela		= count($duplicatas);
            $dup->data_emissao		= $venda->data_venda;
            $dup->data_vencimento	= $duplicata->dVenc;
            $dup->data_previsao	    = $duplicata->dVenc;
            $dup->descricao	        = "Venda #".$venda->id . "#Parc#" .$i  ;
            $dup->origem	        = "Venda ERP";
            $dup->valor	            = $duplicata->vDup;
            
            FinContaReceber::create(objToArray($dup));
            $i++;
        }
        }
    }
    
    public static function cancelarContaReceber($id_venda){
        $contas = FinContaReceber::where("venda_id", $id_venda)->get();
        if(count($contas) > 0){
        foreach($contas as $c){
            if($c->recebimento){
                $c->recebimento->status_id =config("constantes.status.DELETADO") ;
                $c->recebimento->save();
            }            
            $c->status_id =config("constantes.status.DELETADO") ;
            $c->save();
        }
        }
    }
    
    public static function inserirPelCobranca($cobranca){
        $receber                    = new \stdClass();
        $receber->cliente_id		= $cobranca->cliente_id;
        $receber->cobranca_id	    = $cobranca->id;
        $receber->num_parcela		= $cobranca->num_parcela;
        $receber->ult_parcela		= $cobranca->ult_parcela;
        $receber->data_emissao	    = hoje();
        $receber->data_vencimento	= $cobranca->data_vencimento;
        $receber->data_previsao	    = $cobranca->data_vencimento;
        $receber->descricao	        = "Cobrança #" . $cobranca->venda_id;
        $receber->valor	            = $cobranca->valor;
        $receber->origem	        = "Cobrança";
        return FinContaReceber::Create(objToArray($receber));
        
    }
    
    public static function salvarContaReceberPelaNfe($nfe){
        $duplicatas = NfeDuplicata::where("nfe_id", $nfe->id)->get();
        $cliente = Cliente::where("cpf_cnpj", $nfe->destinatario->dest_CNPJ)->first();
        FinContaReceber::where("nfe_id", $nfe->id)->delete();
        $i =1;
        if(count($duplicatas) > 0){
            foreach ($duplicatas as $duplicata){
                $dup = new \stdClass();
                $dup->cliente_id		= $cliente->id;
                $dup->nfe_id			= $nfe->id;
                $dup->forma_pagto_id	= $duplicata->tPag;
                $dup->num_parcela		= $i;
                $dup->ult_parcela		= count($duplicatas);
                $dup->data_emissao		= hoje();
                $dup->data_vencimento	= $duplicata->dVenc;
                $dup->data_previsao	    = $duplicata->dVenc;
                $dup->descricao	        ="Nfe #".$nfe->id . "#Parc#" .$i  ;
                $dup->valor	            = $duplicata->vDup;
                $dup->origem	        = "NFE";
                FinContaReceber::Create(objToArray($dup));
                $i++;
            }          
                
                
            }
        }
        
        public static function estornarContaReceber($id_venda){
            $contas = FinContaReceber::where("venda_id", $id_venda)->get();
            if(count($contas) > 0){
                foreach($contas as $c){
                    if($c->recebimento){
                        $c->recebimento->delete();
                    }
                    $c->delete();
                }
            }
        }
    
}

