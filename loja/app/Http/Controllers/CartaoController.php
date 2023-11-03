<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Service\PedidoService;

class CartaoController extends Controller
{

    public function ver($uuid){
        $pedido = PedidoService::detalhe($uuid);
        session()->forget("pedido");
        session(["pedido"=>$pedido->id]);

        if(!$pedido){
            return redirect()->route('carrinho')->with('msg_erro', "Cobrança Não encontrada.");
        }

        $dados["pedido"] = $pedido;
        $dados["configuracao"]  = $pedido->empresa->loja_configuracao ?? null;
        $dados["pagamentoJs"]       = true;
        return view("Pagamento.Cartao", $dados);
    }


 }
