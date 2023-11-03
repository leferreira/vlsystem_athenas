<?php
namespace App\Service;

class FrenteService{
    public  static function home($acao){     
        $dados                    = new \stdClass();
        $dados->usuario_uuid      = session("usuario_pdv_logado")->uuid;
        $dados->caixa_id          = session("usuario_pdv_logado")->caixa_id;
        $dados->acao              = $acao;       
 
        $url        = getenv("APP_URL_API"). "frente/home";        
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);

        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    public  static function inserirItem($dados){       
        $dados["empresa_id"]      = session("usuario_pdv_logado")->empresa_id;
        $dados["usuario_uuid"]    = session("usuario_pdv_logado")->uuid;
        $dados["caixa_id"]        = session("usuario_pdv_logado")->caixa_id;       
        
        $url        = getenv("APP_URL_API"). "pdv/inserirItem";      
    
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);

        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    public static function abrirCaixa($caixa){
        $url        = getenv("APP_URL_API"). "pdv/abrirCaixa";  
       
        $resultado  = enviarPostJsonCurl($url,json_encode($caixa));
        $retorno    = json_decode($resultado);  

        $usuario    = $retorno->data;
        session()->forget('usuario_pdv_logado');
        session(['usuario_pdv_logado' => $usuario]);
        return $usuario;
    }
    
    public static function fecharCaixa(){
        $dados                    = new \stdClass();
        $dados->usuario_abriu_uuid = session("usuario_pdv_logado")->uuid;
        $dados->caixa_id          = session("usuario_pdv_logado")->caixa_id;
        
        $url        = getenv("APP_URL_API"). "pdv/fecharCaixa";
     /*   echo $url;
        echo json_encode($dados);
        exit;*/
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        $usuario    = $retorno->data;
        session()->forget('usuario_pdv_logado');
        session(['usuario_pdv_logado' => $usuario]);
        return $usuario;
    }
    
    public  static function buscaCliente($dados){        
        $url        = getenv("APP_URL_API"). "pdv/buscaCliente";
       
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    
    public  static function vincularCliente($dados){
        $url        = getenv("APP_URL_API"). "pdv/vincularCliente";
      
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    public  static function gerarCrediario($dados){
        $url        = getenv("APP_URL_API"). "pdv/gerarCrediario";
       /* echo $url;
        echo json_encode($dados);
        exit;*/
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));       
        $retorno    = json_decode($resultado);
        
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    public  static function gerarPagamentoCartao($dados){
        $url        = getenv("APP_URL_API"). "pdv/gerarPagamentoCartao";
        /*echo $url;
        echo json_encode($dados);
        exit;*/
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
        
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
}

