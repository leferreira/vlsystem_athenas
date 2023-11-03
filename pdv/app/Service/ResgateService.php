<?php
namespace App\Service;


class ResgateService{    
    
    public static function lista(){        
        $url         = getenv("APP_URL_API"). "resgate/lista/".session("usuario_pdv_logado")->empresa_uuid;
        $resultado   = enviarGetCurl($url);
        return $resultado;
    }
    
    public static function buscar($dados){
        $url        = getenv("APP_URL_API"). "resgate";
        echo $url;
        echo json_encode($dados);
        exit;
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);    
        return $retorno;
    }    
    
    public static function resgatar($dados){           
        $dados["empresa_id"]  = session("usuario_pdv_logado")->empresa_id;
        $dados["caixa_id"]    = session("usuario_pdv_logado")->caixa_id;
        $dados["vendedor_id"] = 1;
        $dados["usuario_uuid"]= session("usuario_pdv_logado")->uuid; 
        
        if($dados["plataforma"]=="loja"){
            $url        = getenv("APP_URL_API"). "resgate/criarPdvVendaPelaLoja";
        }else if($dados["plataforma"]=="venda"){
            $url        = getenv("APP_URL_API"). "resgate/criarPdvVendaPelVenda";
        }else if($dados["plataforma"]=="orcamento"){
            $url        = getenv("APP_URL_API"). "resgate/criarPdvVendaPeloOrcamento";
        }else if($dados["plataforma"]=="balcao"){
            $url        = getenv("APP_URL_API"). "resgate/criarPdvVendaPeloBalcao";
        }elseif($dados["plataforma"]=="os"){
            $url        = getenv("APP_URL_API"). "resgate/criarPdvVendaPelOrdemServico";
        }elseif($dados["plataforma"]=="pedido"){
            $url        = getenv("APP_URL_API"). "resgate/criarPdvVendaPeloPedido";
        } 
       /* echo $url;
        echo json_encode($dados);
        exit;*/
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);        
        return $retorno;
    }   
    
    public static function excluirBalcao($id){
        $dados      = new \stdClass();
        $dados->venda_id = $id;
        
        $url        = getenv("APP_URL_API"). "vendabalcao/excluirBalcao";    
      
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        return $retorno->data;
    }
    
    
}

