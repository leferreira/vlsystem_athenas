<?php

namespace App\Http\Controllers;

use App\Service\LojaService;

class SubCategoriaController extends Controller{    
    public function index($id){
        try {
            $home                   = LojaService::home("subcategoria", $id, null, null) ;    
      
          
            if(!$home->configuracao->nome){
                throw new \Exception("Esta loja ainda não está configurada, por favor entre no admitrativo do ERP para configurá-la");
            }
            $dados["configuracao"]  = $home->configuracao;
            $dados["produtos"]      = $home->produtos;
            $dados["carrinho"]      = array();
            $dados["lista_banner"]  = array();
            $dados["categorias"]    = $home->categorias;            
            $dados["banner"]        = true;
            $dados["mostraMenu"]    = true;
            $dados["subcategoria"]  = $home->subcategoria;
            if(!$home->subcategoria){
                return view("NaoEncontrado", $dados);
            }
            return view("SubCategoria.Index", $dados);
        } catch (\Exception $e) {      
            $mensagem = $e->getMessage();
          
            return redirect()->route('erro')->with('msg_erro', $mensagem);            
        }
        
    }    
 
      
}
