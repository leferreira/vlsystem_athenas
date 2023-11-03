<?php

namespace App\Http\Controllers\Admin\Assinatura;

use App\Http\Controllers\Controller;
use App\Models\RequisicaoPagamento;
use Illuminate\Http\Request;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\SDK;
use Str;

class PagamentoAssinaturaController extends Controller
{

    public function __construct()
    {
        SDK::setAccessToken(env('MP_ACCESS_TOKEN'));
    }

    public function cartao(Request $r)
    {
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
    
    public function pix(Request $r){
        try {
            $uuid = Str::uuid();

            $u = auth()->user();
            $p = new Payment();
            $p->transaction_amount = 0.1;//(float) $r->preco;
            $p->description = $r->descricao;
            $p->payment_method_id = "pix";
            $p->date_of_expiration = now()->addMinutes(10)->format("Y-m-d\\TH:i:s.z-03:00");
            $p->external_reference = $uuid; //IDENTIFICADOR DA VENDA
            $p->notification_url = env('APP_URL') . "/api/webhook/pix";
            $p->payer = [
                "email" => "antoniomarcio@mirante.com.br", //$u->email,
                "first_name" => $u->name,
                "last_name" => "",
                "identification" => [
                    "type" => "CPF",
                    "number" => "78589452387"
                ]
            ];
            $p->save();
            if($p->error){
                return response()->json($p->error, 400);
            }

            $dados = [
                "code"=>$p->point_of_interaction->transaction_data->qr_code,
                "qr_code"=>$p->point_of_interaction->transaction_data->qr_code_base64,
                "identificador"=>$uuid
            ];

            $rp = new RequisicaoPagamento();
            $rp->identificador = $uuid;
            $rp->tipo_pagamento = 2; //2 = PIX
            $rp->produto = $r->descricao;
            $rp->save();

            return response()->json($dados);
        }catch (\Exception $e){
            return response()->json($e->getMessage(), 400);
        }
    }
}
