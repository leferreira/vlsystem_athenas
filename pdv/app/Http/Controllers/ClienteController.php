<?php

namespace App\Http\Controllers;

use App\Service\PdvService;
use Illuminate\Http\Request;

class ClienteController extends Controller{  
   
    public function buscaCliente(Request $request){
        $req        = $request->all();
        $retorno    = new \stdClass();
        try {
            $lista              = PdvService::buscaCliente($req);                  
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = $lista;
            return response()->json($retorno);                     
           
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            $retorno->retorno   = "";
            return response()->json($retorno);
        }        
        
    }    
    
    public function vincularCliente(Request $request){
        $req        = $request->all();
        $retorno    = new \stdClass();
        try {
            $lista              = PdvService::vincularCliente($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = $lista;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            $retorno->retorno   = "";
            return response()->json($retorno);
        }         
    }
    

}
