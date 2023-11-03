<?php

namespace App\Http\Controllers;

use App\Service\PedidoClienteService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class PedidoController extends Controller
{
    public function filtro(){    
        
        $filtro             = new \stdClass();
        $filtro->data1      = $_GET["data1"];
        $filtro->data2      = $_GET["data2"];
        $filtro->token      = session("usuario_logado")->token;
        $filtro->uuid       = session("usuario_logado")->uuid;
        $dados["lista"]     = PedidoClienteService::filtro($filtro);
        $dados["filtro"]    = $filtro;
        return view("home", $dados);
    }
    
    public function create(){
        $dados["pedidoJs"]      = true;
        return view("Pedido.Create", $dados);
    }
    
    public function detalhe($id){
        $dados["pedido"] = PedidoClienteService::show($id);       
        if($dados["pedido"]->status->id==config("constantes.status.ABERTO")){
            return view("Pedido.Edit", $dados);
        }else{
            return view("Pedido.Detalhe", $dados);
        }        
    }
    
    public function salvar(Request $request){  
        $retorno = new \stdClass();
        $itens			    = $request->venda;
       
        try {
            
            $pedido             = new \stdClass();
            $pedido->cliente_uuid = session("usuario_logado")->uuid;
            $pedido->origem     = "web";
            $pedido->token      = session("usuario_logado")->token;
            $pedido->observacao = $request->observacao;
            
            $produtos = [];
            foreach($itens as $i){
                $item               = new \stdClass();
                $item->produto_uuid = $i['codigo'];
                $item->qtde         = $i['quantidade'];
                array_push($produtos, $item);
            }  
            
            $pedido->itens  = $produtos;    
            
            
            $retorno->tem_erro = false;            
            $retorno->retorno  = PedidoClienteService::salvar($pedido);
            
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
        
    }
}
