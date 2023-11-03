<?php
namespace App\Service;

use App\Models\NfeDestinatario;

class NfeDestinatarioService{
    public static function criar($nfe_id, $cliente){
        $dest                   = new \stdClass();
        $dest->nfe_id           = $nfe_id;
        $dest->dest_xNome    	= tiraAcento($cliente->nome_razao_social);
        
        $dest->dest_indIEDest	= $cliente->tipo_contribuinte;
        $dest->dest_ISUF     	= $cliente->suframa;
        $dest->dest_IM       	= $cliente->im;
        $dest->dest_email    	= $cliente->email;
        $cnpj_cpf               = tira_mascara($cliente->cpf_cnpj);
        
        if(strlen($cnpj_cpf) == 14){
            $dest->dest_CNPJ = $cnpj_cpf;
            $dest->dest_IE   = tira_mascara($cliente->rg_ie);
        }
        else{
            $dest->dest_CPF  = $cnpj_cpf;
        }
        
        $dest->dest_idEstrangeiro=null;
        $dest->dest_xLgr     	= tiraAcento($cliente->logradouro);
        $dest->dest_nro      	= $cliente->numero;
        $dest->dest_xCpl     	= tiraAcento($cliente->complemento);
        $dest->dest_xBairro  	= tiraAcento($cliente->bairro);
        $dest->dest_cMun     	= $cliente->ibge;
        $dest->dest_xMun     	= strtoupper(tiraAcento($cliente->cidade));
        $dest->dest_UF       	= $cliente->uf;
        $dest->dest_CEP      	= tira_mascara($cliente->cep);
        $dest->dest_cPais       = "1058";
        $dest->dest_xPais       = "Brasil";
        $dest->dest_fone     	= ($cliente->telefone) ? tira_mascara($cliente->telefone) : null ;
        
        $destinatario           = NfeDestinatario::where("nfe_id", $nfe_id)->first();
        if(!$destinatario){
            NfeDestinatario::create(objToArray($dest));
        }else{
            $destinatario->update(objToArray($dest));
        } 
    }
}

