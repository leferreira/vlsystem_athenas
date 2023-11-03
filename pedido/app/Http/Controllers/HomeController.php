<?php

namespace App\Http\Controllers;

use App\Service\PedidoClienteService;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index(){        
        $filtro             = new \stdClass();       
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->token      = session("usuario_logado")->token;
        $filtro->uuid       = session("usuario_logado")->uuid;       
        $retorno             = PedidoClienteService::filtro($filtro);   
        $dados["assinaturas"]   = $retorno->assinaturas;
        $dados["pedidos"]    = $retorno->pedidos;
        $dados["filtro"]    = $filtro;
        return view("home", $dados);
    }
    
    public function testeapi(){
        try {
            $url         = getenv("APP_URL_API"). "testeapi";
            
            $resultado   = enviarGetCurl($url);
        } catch (\Exception $e) {
            $resultado =  "Nao";
        }
        
        if($resultado =="OK"){
            echo "Api configurado com sucesso";
        }else{
            echo "API Não configurada";
        }
    }
}
