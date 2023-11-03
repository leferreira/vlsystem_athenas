<?php

namespace App\Http\Controllers;

use App\Service\ProdutoService;

class ProdutoController extends Controller{  
   
    public function buscaProduto($id_produto, $tipo){
        $retorno = new \stdClass();
        try {
            $produto            = ProdutoService::buscaProduto($id_produto, $tipo);  
        
            if(isset($produto->tem_erro)){
                $retorno->tem_erro  = true;
                $retorno->erro      = "Produto não encontrado";
                return response()->json($retorno);
            }else{               
                $retorno->tem_erro  = false;
                $retorno->erro      = "";
                $retorno->retorno   = $produto;
                return response()->json($retorno);
            }            
           
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            $retorno->retorno   = "";
            return response()->json($retorno);
        }        
        
    }    
    
    public function pesquisarProdutoPorNome(){
        $q          = $_GET["q"];
        $resultado  = ProdutoService::pesquiserProdutoPorNome($q);
        return response()->json($resultado);
    }
    
    
    public function pesquisar($q){
        $produtos = ProdutoService::listaProdutoPorNome($q);       
        return response()->json($produtos);
    }

}
