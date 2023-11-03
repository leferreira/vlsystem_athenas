<?php

namespace App\Http\Controllers;

use App\Service\LojaService;

class HomeController extends Controller{
    public function index(){
        try {

            $home              = LojaService::home("home", null, null, null) ;

            if(!$home->configuracao->nome){
                throw new \Exception("Esta loja ainda não está configurada, por favor entre no admitrativo do ERP para configurá-la");
            }

            if($home->carrinho){
                if($home->carrinho->status_financeiro_id==config("constantes.status.PAGO")){
                    return redirect()->route('carrinho.finalizado', $home->carrinho->uuid);
                }
            }

            $cupom_desconto = $_GET["cupom"] ?? null;
            if($cupom_desconto){
                session()->forget('sessao_cupom_desconto');
                session(["sessao_cupom_desconto"=>$cupom_desconto]);
            }

            $dados["configuracao"]  = $home->configuracao;
            $dados["produtos"]      = $home->produtos;
            $dados["carrinho"]      = $home->carrinho;
            $dados["itens"]         = $home->itens;
            $dados["lista_banner"]  = $home->lista_banner;
            $dados["categorias"]    = $home->categorias;
            $dados["banner"]        = true;
            $dados["mostraMenu"]    = true;
            $dados["mostraCarrinhoTopo"]    = true;


            return view("home", $dados);
        } catch (\Exception $e) {
            $mensagem = $e->getMessage();

            return redirect()->route('erro')->with('msg_erro', $mensagem);
        }

    }


}
