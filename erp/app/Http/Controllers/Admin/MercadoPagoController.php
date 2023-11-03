<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\CarrinhoService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MercadoPago\Payer;
use MercadoPago\Payment;
use App\Models\FinFatura;

class MercadoPagoController extends Controller{    
    public function index(){ 
       $dados["carrinho"]       = CarrinhoService::getCarrinho();  
       $dados["jsCarrinho"]     = true;
       $dados["pag"]            = "detalhe";      
        return view("Carrinho.Index", $dados);
    }    
    
    public function transferencia($id_pedido){
        $pedido = new \stdClass();     
      
        $pedido->id                 = $id_pedido;
        $pedido->transacao_id       = "121212121";
        $pedido->status_pagamento   = "approved";
        $pedido->forma_pagto_id     = "16";
        $pedido->status_detalhe     = "1";
        $pedido->hash               = Str::random(20);  
        $pedido->status_id          = config("constantes.status.PAGO");
        
        //PedidoService::pagarPorTransferencia($pedido);
        
       // PagamentoService::gerarVenda($id_pedido);
        return redirect()->route('pagar.finalizado', $id_pedido);
    }
    
    public function pix(Request $request){      
        
		$fatura = FinFatura::find($request->fatura_id);      
        $valor = 1;
        try {
            $uuid = Str::uuid();
            \MercadoPago\SDK::setAccessToken(getenv("MP_ACCESS_TOKEN"));
            $payment                     = new \MercadoPago\Payment();
            $payment->transaction_amount = (float) $valor;
            $payment->description 		 = "Pagamento Fatura #" . $fatura->id ;
            $payment->payment_method_id  = "pix";
            $payment->date_of_expiration = now()->addMinutes(10)->format("Y-m-d\\TH:i:s.z-03:00");
            $payment->external_reference = $request->pedido_id; //IDENTIFICADOR DA VENDA
            $payment->notification_url 	 = "https://erp.cybertronica.com.br/admin/api/lojawebhook/pix";
           // $payment->notification_url 	 = "http://api.erpmjailton.com.br/api/lojawebhook/pix";
            $payment->payer = [
                "email" => $request->email, //$u->email,
                "first_name" => $request->nome,
                "last_name" => $request->sobrenome,
                "identification" => [
                    "type" => "CPF",
                    "number" => tira_mascara($request->cpf)
                ]
            ];
			
           
            $payment->save();
            if($payment->error){
                return response()->json($payment->error, 400);
            }
            
            $dados = [
                "code"=>$payment->point_of_interaction->transaction_data->qr_code,
                "qr_code"=>$payment->point_of_interaction->transaction_data->qr_code_base64,
                "identificador"=>$uuid
            ];
            
           /* $rp = new RequisicaoPagamento();
            $rp->identificador = $uuid;
            $rp->tipo_pagamento = 2; //2 = PIX
            $rp->produto = $r->descricao;
            $rp->save();*/
            
            return response()->json($dados);
        }catch (\Exception $e){
            return response()->json($e->getMessage(), 400);
        }
    }
    
    
    public function cartao(Request $request){
		$retorno = new \stdClass();
        try {
            \MercadoPago\SDK::setAccessToken(getenv("MP_ACCESS_TOKEN"));
            $payment = new Payment();
            $payment->transaction_amount    = (float)$request->transaction_amount;
            $payment->token                 = $request->token;
            $payment->description           = $request->description;
            $payment->installments          = (int)$request->installments;
            $payment->payment_method_id     = $request->payment_method_id;
            $payment->issuer_id             = (int)$request->issuer_id;
            
            $payer                          = new Payer();
            $payer->email           		= $request->payer['email'];
            $payer->identification  		= $request->payer['identification'];
            $payer->first_name      		= $request->cardholderName;
            $payment->payer             	= $payer;   
            
            i($payment);
            $payment->save();
            
            if($payment->error){
				$retorno->erro 	= true;
				$retorno->titulo= "Erro";
				$retorno->erro 	= $payment->error;
                return response()->json($retorno, 400);
            }else{
				$retorno->erro 			= false;
				$retorno->titulo		= "";
				$retorno->retorno		= retornoCartao($payment->status_detail);
				$retorno->status		= $payment->status;
				$retorno->status_detail	= $payment->status_detail;
				$retorno->id			= $payment->id;
			}  
			
            return response()->json($retorno);
        }catch (\Exception $e){
			$retorno->erro 	= true;
			$retorno->titulo= "Erro";
			$retorno->erro 	= $e->getMessage();				
            return response()->json($retorno, 400);
        }
    }
    
    public function boleto(Request $request){
        
        \MercadoPago\SDK::setAccessToken(getenv("MP_ACCESS_TOKEN"));
        
        $payment = new Payment();
        $payment->transaction_amount = 100;
        $payment->description = "Título do produto";
        $payment->payment_method_id = "bolbradesco";
        $payment->payer = array(
            "email" => "test@test.com",
            "first_name" => "Test",
            "last_name" => "User",
            "identification" => array(
                "type" => "CPF",
                "number" => "19119119100"
            ),
            "address"=>  array(
                "zip_code" => "06233200",
                "street_name" => "Av. das Nações Unidas",
                "street_number" => "3003",
                "neighborhood" => "Bonfim",
                "city" => "Osasco",
                "federal_unit" => "SP"
            )
        );
        
        $payment->save();
    }
    
    public function finalizado($id){         
        CarrinhoService::delRandPedido();
        $dados["carrinho"]      = CarrinhoService::getCarrinho(); 
        $dados["id_pedido"]     = $id;
        return view("Carrinho.Obrigado", $dados);
    }
    
}
