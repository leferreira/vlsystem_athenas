<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\UtilService;

class UtilController extends Controller{
    
    public function buscarCNPJ($cnpj){ 
        $retorno = new \stdClass();
        try {            
            
            $valido = validarCpfCnpj($cnpj);
            if(!$valido){
                throw(new \Exception(' CPF/CNPJ Inválido.'));                
            }
            $empresa            = UtilService::buscarCNPJ(tira_mascara($cnpj));
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = $empresa;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro   = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
}
