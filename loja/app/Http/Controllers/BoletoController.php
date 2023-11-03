<?php

namespace App\Http\Controllers;

use App\Service\PedidoService;
use Illuminate\Routing\Controller;

class BoletoController extends Controller
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
        return view("Pagamento.Boleto", $dados);

    }


 }
