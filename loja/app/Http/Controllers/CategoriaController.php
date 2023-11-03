<?php

namespace App\Http\Controllers;

use App\Service\LojaService;

class CategoriaController extends Controller{    
    public function index(){ 
        try {
            $home                   = LojaService::home("subcategoria") ;            
          
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
            return view("Categoria.Index", $dados);
        } catch (\Exception $e) {      
            $mensagem = $e->getMessage();
          
            return redirect()->route('erro')->with('msg_erro', $mensagem);            
        }
        
    }    
 
      
}
