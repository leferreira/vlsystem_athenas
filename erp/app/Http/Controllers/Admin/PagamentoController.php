<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequisicaoPagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\SDK;

class PagamentoController extends Controller{

    public function __construct(){
        SDK::setAccessToken(env('MP_ACCESS_TOKEN'));
    }

    public function cartao(Request $r){
        try {
            $p = new Payment();
            $p->transaction_amount  = (float)$r->transaction_amount;
            $p->token               = $r->token;
            $p->description         = $r->description;
            $p->installments        = (int)$r->installments;
            $p->payment_method_id   = $r->payment_method_id;
            $p->issuer_id           = $r->issuer_id;

            $payer                  = new Payer();
            $payer->email           = $r->payer['email'];
            $payer->identification  = $r->payer['identification'];
            $payer->first_name      = $r->cardholderName;
            $p->payer               = $payer;
            i($p);
            $p->save();

            if($p->error){
                return response()->json($p->error, 400);
            }

            $response = [
                'status' => $p->status,
                'status_detail' => $p->status_detail,
                'id' => $p->id
            ];

            return response()->json($response);
        }catch (\Exception $e){
            return response()->json($e->getMessage(), 400);
        }
    }
   // $p->notification_url = "https://homologacaoapibbpv2.ibombordo.com.br/api/mp";//env('APP_URL') . "/api/webhook/pix";
    
    public function pix(Request $request){
        $pedido = PedidoService::getPedidoPorPedidoCliente($request->pedido_id,$request->cliente_id);
        
        try {
            $uuid = Str::uuid();
            \MercadoPago\SDK::setAccessToken(getenv("MP_ACCESS_TOKEN"));
            $payment = new \MercadoPago\Payment();
            $payment->transaction_amount = (float) $pedido->valor_total ;
            $payment->description 		 = "Venda Loja Virtual #" . $request->pedido_id ;
            $payment->payment_method_id  = "pix";
            $payment->date_of_expiration = now()->addMinutes(10)->format("Y-m-d\\TH:i:s.z-03:00");
            $payment->external_reference = $request->pedido_id; //IDENTIFICADOR DA VENDA
            $payment->notification_url 	 = url("") . "/api/lojawebhook/pix";
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
}
