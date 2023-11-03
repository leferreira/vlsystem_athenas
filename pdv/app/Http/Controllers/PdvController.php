<?php

namespace App\Http\Controllers;

use App\Service\PdvService;
use App\Service\VendaService;
use Illuminate\Http\Request;



class PdvController extends Controller{
    public function index(){

        $caixa_id =  session("usuario_pdv_logado")->caixa_id;
        $conta_corrente_id =  session("usuario_pdv_logado")->conta_corrente_id;
        if(!$caixa_id){
            return redirect()->route("caixa.create")->with("msg_erro", "Você precisa Abrir um Caixa Primeiramente");
        }

        if(!$conta_corrente_id){
            return redirect()->back()->with("msg_erro", "Antes de realizar vendas, você precisa configurar uma conta corrente para o emitente,
                                                        Para isso entre no ERP em: configurações->emitente.");
        }

        $dados["caixa_id"]          = $caixa_id;
        $dados["padrao_busca"]      = session("usuario_pdv_logado")->padrao_busca;
        $dados["num_caixa"]         = session("usuario_pdv_logado")->num_caixa;
        $dados["venda"]             = PdvService::home("verificar_venda_aberta");

        $dados["vendaEditJs"]       = true;
        return view("Pdv.Create", $dados);

    }

    public function pagamento($id){
      //  i(session("usuario_pdv_logado"));
      try {
          $caixa_id =  session("usuario_pdv_logado")->caixa_id;
          $dados["venda"] = VendaService::getVenda($id);
          if(!$dados["venda"]){
              return redirect()->route("pdv.index")->with("msg_erro", "Venda Não encontrada.");
          }

          $dados["caixa_id"] = $caixa_id;
          $dados["tem_pendencia"] = session("usuario_pdv_logado")->pendencias->tem_erro;
          $dados["transmite_nfce"] = session("usuario_pdv_logado")->transmite_nfce;
          $dados["pagamentoJs"]       = true;
          return view("Pdv.Pagamento", $dados);
      } catch (\Exception $e) {
          return redirect()->route("pdv.index")->with("msg_erro", $e->getMessage());
      }

    }

    public function gerarCrediario(Request $request){
        $req        = $request->all();
        $retorno    = new \stdClass();
        try {
            $req["valor"]       = getFloat($request->valor);
            $lista              = PdvService::gerarCrediario($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = $lista;
            return response()->json($retorno);

        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            $retorno->retorno   = "";
            return response()->json($retorno);
        }
    }

    public function gerarPagamentoCartao(Request $request){
        $req        = $request->all();
        $retorno    = new \stdClass();
        try {
            $lista              = PdvService::gerarPagamentoCartao($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = $lista;
            return response()->json($retorno);

        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            $retorno->retorno   = "";
            return response()->json($retorno);
        }
    }

    public function livre(){
        return view("Pdv.Livre");
    }
 }
