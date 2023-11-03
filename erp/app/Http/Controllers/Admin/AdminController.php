<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinFatura;
use App\Models\FinPagamento;
use App\Models\FinRecebimento;
use App\Models\LojaPedido;
use App\Models\NaturezaOperacao;
use App\Models\PedidoCliente;
use App\Models\Produto;
use App\Service\GraficoService;
use App\Service\AssinaturaService;


class AdminController extends Controller{   
    
    public function index(){
      //  i(auth()->user()->permissoesFuncao());     
        $empresa                    = auth()->user()->empresa; 
  
        
        $dados["empresa"]           = $empresa;
        $dados["naturezaoperacao"]  = NaturezaOperacao::first();
        $dados["certificado_arquivo_binario"] = $empresa->certificado_digital->certificado_arquivo_binario ?? null;       
        $dados["certificado_senha"] = $empresa->certificado_digital->certificado_senha ?? null;       
        $dados["produto"]           = Produto::first();
        $dados["pedidos_loja"]      = LojaPedido::where(["status_id" =>config('constantes.status.FINALIZADO'), "status_entrega_id" => config("constantes.status_entrega.PAGAMENTO_CONFIRMADO")])->get();
        
        $dados["pedidos_pendentes"] = PedidoCliente::where('status_id', config("constantes.status.ABERTO"))->get();
       // $dados["config_loja"]       = LojaConfiguracao::first();
        $dados["fatura_aberta"]     = FinFatura::where("status_id", config("constantes.status.ABERTO"))->first();
        
        $dados["entradas"]          = GraficoService::gerarEntradas(date("Y"));
        $dados["saidas"]            = GraficoService::gerarSaidas(date("Y"));
        $dados["diarias"]           = GraficoService::gerarVendasDiaria(date("m"));
        
        $dados["pagamentos"]        = FinPagamento::where("data_pagamento", hoje())->sum("valor_pago");
        $dados["recebimentos"]      = FinRecebimento::where("data_recebimento", hoje())->sum("valor_recebido");
        $dados["proximo_vencimento"]= AssinaturaService::data_vencimento();
       
        $dados["graficoJs"]         = true;
        return view("Admin.home", $dados);
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
    
    public function cadastrarPlano($id_plano){
        session(["plano_id"=>$id_plano]);
        return redirect()->route("register");
    }
}
