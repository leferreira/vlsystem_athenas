<?php
namespace App\Services;


use App\Models\Cobranca;
use App\Models\FinFatura;
use App\Models\LogMercadoPago;
use App\Models\LojaPedido;
use App\Models\MercadoPagoTransacao;
use App\Models\Parametro;
use App\Models\PdvDuplicata;
use App\Models\PdvVenda;
use MercadoPago\Payer;
use MercadoPago\Payment;

class MercadoPagoService
{
    public static function buscarTransacaoMercadoPago($id, $empresa_id){
        $parametro = Parametro::where("empresa_id", $empresa_id)->first();
        $MP_ACCESS_TOKEN = $parametro->mercadopago_access_token;

        if(!$MP_ACCESS_TOKEN){
            $retorno = new \stdClass();
            $retorno->tem_erro = true;
            $retorno->erro     = "Configure primeiramente o campo Mercado Pago Access Token no seu ERP";
            return $retorno;
        }

        \MercadoPago\SDK::setAccessToken($MP_ACCESS_TOKEN);

        $payment =  Payment::find_by_id($id);

		$pagamento = new \stdClass();
		if($payment->description){
			if($payment->description=="loja_virtual" && $payment->external_reference){
				$pagamento->loja_pedido_id = $payment->external_reference;
			}

			if($payment->description=="pdv" && $payment->external_reference){
				$pagamento->pdv_venda_id = $payment->external_reference;
			}

			if($payment->description=="cobranca" && $payment->external_reference){
				$pagamento->cobranca_id = $payment->external_reference;
			}

			if($payment->description=="fatura" && $payment->external_reference){
				$pagamento->fatura_id = $payment->external_reference;
			}
		}

		$tipo_pagamento                 = $payment->payment_type_id  ?? null;
        $pagamento->transacao_id        = $payment->id ?? null;
        $pagamento->status              = $payment->status ?? null;
        $pagamento->descricao           = $payment->description ?? null;
        $pagamento->data_criacao        = $payment->date_created ?? null;
        $pagamento->data_ultima_modificacao   = $payment->date_last_updated ?? null;
        $pagamento->data_expiracao      = $payment->date_of_expiration ?? null;
        $pagamento->data_aprovacao      = $payment->date_approved ?? null;
        $pagamento->valor               = $payment->transaction_amount ?? null;
        $pagamento->metodo_pagamento    = $tipo_pagamento == "credit_card" ? "cartao_credito" : "cartao_debito";
        $pagamento->referencia_externa  = $payment->external_reference ?? null;

        MercadoPagoTransacao::Create(objToArray($pagamento));


        return $pagamento;


    }

    public static function verificaSeCobrancaPagaNoPix($cobranca_id){
        $cobranca = MercadoPagoTransacao::where(["cobranca_id"=>$cobranca_id, "status"=>"approved"])->first();
        return ($cobranca) ? 1: -1;
    }

	public static function verificaSePedidoPagoNoPix($pedido_id){
        $pedido = MercadoPagoTransacao::where(["loja_pedido_id"=>$pedido_id, "status"=>"approved"])->first();
        return ($pedido) ? 1: -1;
    }

	public static function verificaSeFaturaPagaNoPix($fatura_id){
        $fatura = MercadoPagoTransacao::where(["fatura_id"=>$fatura_id, "status"=>"approved"])->first();
        return ($fatura) ? 1: -1;
    }

    public static function verificaPagamentoPix($id_venda){
        $duplicata = PdvDuplicata::where(["venda_id"=>$id_venda, "tPag" => config("constantes.forma_pagto.CHECKOUT_PIX")])->first();
        return ($duplicata) ? 1: -1;
    }

    public static function pix($dados){
        $empresa_id = $dados->empresa_id;
        $parametro = Parametro::where("empresa_id", $empresa_id)->first();
        $MP_ACCESS_TOKEN = $parametro->mercadopago_access_token;

        if(!$MP_ACCESS_TOKEN){
            $retorno = new \stdClass();
            $retorno->tem_erro = true;
            $retorno->erro     = "Configure primeiramente o campo Mercado Pago Access Token no seu ERP";
            return $retorno;
        }

        $log_MP = new LogMercadoPago();
        if($dados->origem=="loja_virtual"){
            $pedido         = LojaPedido::find($dados->codigo);
            $valor          = $pedido->valor_liquido;
            $log_MP->loja_pedido_id = $dados->codigo;
        }else if($dados->origem=="pdv"){
            $pedido = PdvVenda::find($dados->codigo);
            $valor      = $pedido->valor_liquido;
            $log_MP->pdv_venda_id = $dados->codigo;
        }if($dados->origem=="cobranca"){
            $pedido = Cobranca::find($dados->codigo);
            $valor      = $pedido->valor;
            $log_MP->cobranca_id = $dados->codigo;
        }if($dados->origem=="fatura"){
            $pedido = FinFatura::find($dados->codigo);
            $valor              = $pedido->valor;
            $log_MP->fatura_id  = $dados->codigo;
        }
        $retorno    = new \stdClass();
		$valor = 0.3;
        try {
            \MercadoPago\SDK::setAccessToken($MP_ACCESS_TOKEN);
            $payment                     = new \MercadoPago\Payment();
            $payment->transaction_amount = (float) $valor;
            $payment->description 		 = $dados->origem ;
            $payment->payment_method_id  = "pix";
            $payment->date_of_expiration = now()->addMinutes(30)->format("Y-m-d\\TH:i:s.z-03:00");
            $payment->external_reference = $dados->codigo; //IDENTIFICADOR DA VENDA
            $payment->notification_url 	 = url("api/webhook/escuta") ;
            //$payment->notification_url 	 = "https://athenas-api.flexnfe.com.br/api/webhook/escuta" ;
            $payment->payer = [
                "email"         => $dados->email,
                "first_name"    => $dados->nome,
                "last_name"     => $dados->sobrenome,
                "identification" => [
                    "type" => "CPF",
                    "number" => tira_mascara($dados->cpf)
                ]
            ];

            $payment->save();
            if($payment->error){
                $retorno->tem_erro = true;
                $retorno->erro      = $payment->error->message ?? $payment->error;
                return $retorno;
            }


            $log_MP->empresa_id = $empresa_id;
            $log_MP->forma_pagto= "pix";
            $log_MP->cliente_id = $dados->cliente_id ?? null;
            $log_MP->transacao  = $payment->id;
            $log_MP->save();


            $retorno->tem_erro      = false;
            $retorno->qr_code       = $payment->point_of_interaction->transaction_data->qr_code;
            $retorno->qr_code_base64= $payment->point_of_interaction->transaction_data->qr_code_base64;
            $retorno->ticket_url    = $payment->point_of_interaction->transaction_data->ticket_url;
            $retorno->id            = $payment->id;

            return $retorno;
        } catch (\Exception $e){
            $retorno->tem_erro = true;
            $retorno->erro     = $e->getMessage();
            return $retorno;
        }

    }

    public static function cartao($dados){
        $empresa_id         = $dados->empresa_id;
        $parametro          = Parametro::where("empresa_id", $empresa_id)->first();
        $MP_ACCESS_TOKEN    = $parametro->mercadopago_access_token;
        if(!$MP_ACCESS_TOKEN){
            $retorno = new \stdClass();
            $retorno->tem_erro = true;
            $retorno->erro     = "Configure primeiramente o campo Mercado Pago Access Tokenno seu ERP";
            return $retorno;
        }

        $log_MP             = new LogMercadoPago();
        $retorno            = new \stdClass();
        try {
            \MercadoPago\SDK::setAccessToken($MP_ACCESS_TOKEN);
            $p = new Payment();
            $p->transaction_amount  = (float)$dados->transaction_amount;
            $p->token               = $dados->token;
            $p->description         = $dados->origem ;
            $p->installments        = (int)$dados->installments;
            $p->payment_method_id   = $dados->payment_method_id;
            $p->issuer_id           = $dados->issuer_id;
            $p->external_reference  = $dados->codigo;
            $p->notification_url 	= url("api/webhook/escuta") ;

            $payer                  = new Payer();
            $payer->email           = $dados->payer['email'];
            $payer->identification  = $dados->payer['identification'];
            $payer->first_name      = $dados->cardholderName ?? null;
            $p->payer               = $payer;
            $p->save();

            if($p->error){
                $retorno->tem_erro 	= true;
                $retorno->erro 		="Erro: " .$p->error->message ?? "Não foi possível concluir a compra, valores inválidos informado";
				$retorno->retorno 	= $p->error;
                return response()->json($retorno);
            }else{
               //se for aprovado gera a tranasação do Mercado Pago
                if($p->status_detail=="accredited"){

                    $payment = Payment::find_by_id($p->id);
                    $pagamento = new \stdClass();
                    if($payment->description){
                        if($payment->description=="loja_virtual" && $payment->external_reference){
                            $pagamento->loja_pedido_id = $payment->external_reference;
                            $log_MP->loja_pedido_id = $dados->codigo;
                        }

                        if($payment->description=="pdv" && $payment->external_reference){
                            $pagamento->pdv_venda_id = $payment->external_reference;
                            $log_MP->pdv_venda_id    = $dados->codigo;
                        }

                        if($payment->description=="cobranca" && $payment->external_reference){
                            $pagamento->cobranca_id = $payment->external_reference;
                            $log_MP->cobranca_id    = $dados->codigo;
                        }

                        if($payment->description=="fatura" && $payment->external_reference){
                            $pagamento->fatura_id   = $payment->external_reference;
                            $log_MP->fatura_id      = $dados->codigo;
                        }
                    }

                    //Salvar o log fo MP
                    $log_MP->empresa_id = $empresa_id;
                    $log_MP->forma_pagto= "cartao";
                    $log_MP->cliente_id = $dados->cliente_id ?? null;
                    $log_MP->transacao  = $payment->id;
                    $log_MP->save();


                    $tipo_pagamento = $payment->payment_type_id  ?? null;
                    $pagamento->transacao_id        = $payment->id ?? null;
                    $pagamento->status              = $payment->status ?? null;
                    $pagamento->descricao           = $payment->description ?? null;
                    $pagamento->data_criacao        = $payment->date_created ?? null;
                    $pagamento->data_ultima_modificacao   = $payment->date_last_updated ?? null;
                    $pagamento->data_expiracao      = $payment->date_of_expiration ?? null;
                    $pagamento->data_aprovacao      = $payment->date_approved ?? null;
                    $pagamento->valor               = $payment->transaction_amount ?? null;
                    $pagamento->metodo_pagamento    = $tipo_pagamento == "credit_card" ? "cartao_credito" : "cartao_debito";
                    $pagamento->referencia_externa  = $payment->external_reference ?? null;
                    MercadoPagoTransacao::Create(objToArray($pagamento));

					$retorno->tem_erro 		= false;
					$retorno->titulo		= "";
					$retorno->erro			= retornoCartao($p->status_detail);
					$retorno->status		= $p->status;
					$retorno->status_detail	= $p->status_detail;
					$retorno->id			= $p->id;

                }else{
					$retorno->tem_erro 		= true;
					$retorno->erro			= retornoCartao($p->status_detail);
					$retorno->status		= $p->status;
					$retorno->status_detail	= $p->status_detail;
					$retorno->id			= $p->id;
				}

            }

            return response()->json($retorno);
        }catch (\Exception $e){
            $retorno->tem_erro 	= true;
            $retorno->titulo    = "Erro aqui";
            $retorno->erro 		= $e->getMessage();
            return response()->json($retorno, 400);
        }
    }

    public static function boleto($dados){
        $empresa_id         = $dados->empresa_id;
        $parametro          = Parametro::where("empresa_id", $empresa_id)->first();
        $MP_ACCESS_TOKEN    = $parametro->mercadopago_access_token;
        $log_MP             = new LogMercadoPago();
        $retorno            = new \stdClass();

        if($dados->origem=="loja_virtual"){
            $pedido         = LojaPedido::find($dados->codigo);
            $titulo         = "Pedido Numero: " . $pedido->id;
            $valor          = $pedido->valor_liquido;
            $log_MP->loja_pedido_id = $dados->codigo;
        }else if($dados->origem=="pdv"){
            $pedido = PdvVenda::find($dados->codigo);
            $titulo         = "Venda Numero: " . $pedido->id;
            $valor      = $pedido->valor_liquido;
            $log_MP->pdv_venda_id = $dados->codigo;
        }if($dados->origem=="cobranca"){
            $pedido     = Cobranca::find($dados->codigo);
            $titulo     = "Cobrança Numero: " . $pedido->id;
            $valor      = $pedido->valor;
            $log_MP->cobranca_id = $dados->codigo;
        }if($dados->origem=="fatura"){
            $pedido       = FinFatura::find($dados->codigo);
            $titulo       = "Fatura Numero: " . $pedido->id;
            $valor              = $pedido->valor;
            $log_MP->fatura_id  = $dados->codigo;
        }
        $valor = 10;
        try {
            \MercadoPago\SDK::setAccessToken($MP_ACCESS_TOKEN);
            $payment                        = new Payment();
            $payment->transaction_amount = (float) $valor;
            $payment->description        = $titulo;
            $payment->payment_method_id  = "bolbradesco";
            $payment->external_reference = $dados->codigo;
            $payment->notification_url 	 = "https://athenas-api.flexnfe.com.br/api/webhook/escuta" ;
           // $payment->notification_url 	 = url("api/webhook/escuta") ;
            $payment->description 		 = $dados->origem ;
            $payment->payer = array(
                "email" => $dados->email,
                "first_name" => $dados->nome,
                "last_name" => $dados->sobrenome,
                "identification" => array(
                    "type" => "CPF",
                    "number" => tira_mascara($dados->cpf)
                ),
                "address"=>  array(
                    "zip_code" => tira_mascara($dados->cep),
                    "street_name" => $dados->logradouro,
                    "street_number" => $dados->numero,
                    "neighborhood" => $dados->complemento,
                    "city" => $dados->cidade,
                    "federal_unit" => $dados->uf
                )
            );

            $payment->save();
            if($payment->error){
                $retorno->tem_erro = true;
                $retorno->erro      = $payment->error->message ?? $payment->error;
                return $retorno;
            }

            $log_MP->empresa_id = $empresa_id;
            $log_MP->forma_pagto= "boleto";
            $log_MP->cliente_id = $dados->cliente_id ?? null;
            $log_MP->link_boleto= $payment->transaction_details->external_resource_url;
            $log_MP->transacao  = $payment->id;
            $log_MP->save();

            $retorno->tem_erro      = false;
            $retorno->link          = $payment->transaction_details->external_resource_url;
            $retorno->status        = $payment->status;
            $retorno->referencia_id = $payment->transaction_details->payment_method_reference_id;
            $retorno->id            = $payment->id;

            return $retorno;
        } catch (\Exception $e){
            $retorno->tem_erro = true;
            $retorno->erro     = $e->getMessage();
            return $retorno;
        }
    }

}

