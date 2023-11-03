<?php
namespace App\Service;

use App\Models\PdvPagamento;
use App\Models\FormaPagto;
use App\Models\PdvCaixa;
use App\Models\PdvSangria;
use App\Models\PdvSuplemento;

class CaixaService
{
    public static function listaSomaPorFormaPagto($id_caixa){
        $formas = FormaPagto::get();
        foreach($formas as $forma){
            $soma = PdvPagamento::where(["forma_pagto_id"=>$forma->id, "caixa_id"=>$id_caixa])->sum("valor"); 
            $forma->total =$soma;
        }
        return $formas;
    }
    
    public static function valores($id_caixa){
        $retorno = new \stdClass();
        
        $caixa                = PdvCaixa::find($id_caixa);
        $retorno->faturamento = PdvPagamento::where("caixa_id", $id_caixa)->sum("valor");
        $retorno->sangria     = PdvSangria::where("caixa_id", $id_caixa)->sum("valor");
        $retorno->suplemento  = PdvSuplemento::where("caixa_id", $id_caixa)->sum("valor");
        $retorno->troco       = $caixa->valor_abertura;
        $retorno->total       = $retorno->faturamento - $retorno->sangria + $retorno->suplemento + $retorno->troco ;
        
        return $retorno;
    }
}

