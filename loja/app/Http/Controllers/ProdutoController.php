<?php

namespace App\Http\Controllers;

use App\Service\LojaService;
use Illuminate\Http\Request;

class ProdutoController extends Controller{    
    public function detalhe($url){
        $detalhe                   = LojaService::home("detalhe_produto", null, $url, null) ;
   
        if(!$detalhe->configuracao){
            return redirect()->route('configurar')->with('msg_erro', "Faça a Configuração de sua loja primeiramente.");
        }
        $dados["configuracao"]  = $detalhe->configuracao;
        $dados["carrinho"]      = array();
        $dados["lista_banner"]  = array();
        $dados["categorias"]    = $detalhe->categorias;
        $dados["produto"]       = $detalhe->produto;
        $dados["semelhantes"]   = $detalhe->semelhantes;
        $dados["imagens"]       = $detalhe->imagens;
       // i($dados["imagens"]);
        $dados["grade"]         = $detalhe->grade;
        $dados["jsProduto"]     = true;
        $dados["pag"]           = "detalhe";
        return view("Produto.Detalhe", $dados);
    }
 
    public function pesquisar(Request $request){
        $pesquisa = LojaService::home("pesquisa", null, null, null, $request->q);
      
        if(!$pesquisa->configuracao){
            return redirect()->route('configurar')->with('msg_erro', "Faça a Configuração de sua loja primeiramente.");
        }
        $dados["configuracao"]  = $pesquisa->configuracao;
        $dados["carrinho"]      = array();
        $dados["lista_banner"]  = array();
        $dados["categorias"]    = $pesquisa->categorias;
        $dados["produtos"]       = $pesquisa->produtos;
        $dados["mostraMenu"]    = true;
        $dados["q"]             = $request->q;
        $dados["pag"]           = "detalhe";
        return view("Produto.Pesquisa", $dados);
    }
    
    public function aplicarCupom(Request $request){
        $dados      = $request->all();
        $url        = getenv("APP_URL_API"). "loja/aplicarCupom";
       /*  echo $url;
         echo json_encode($dados);
         exit;
        */
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));       
        $retorno    = json_decode($resultado);
        echo json_encode($retorno->data);
        
    }
      
}
