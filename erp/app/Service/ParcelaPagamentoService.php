<?php
namespace App\Service;


use App\Models\FinLancamentoPagar;
use App\Models\FinParcelaPagamento;
use App\Models\FinParcelaPagar;

class ParcelaPagamentoService{
    public static function baixar($pagamento, $parcela){
        $p = FinParcelaPagar::find($pagamento->parcela_pagar_id);
        $total_a_pagar = $p->saldo_devedor + $parcela->valor_juro + $parcela->valor_multa - $parcela->valor_desconto;
        
        if($parcela->tipo_baixa=="T"){
            if($pagamento->valor_pago != $total_a_pagar){
                return false;
            }
        }else{
            if($pagamento->valor_pago > $total_a_pagar){
                return false;
            }
        }
        //atualizar os valores da parcela
        $parc = new \stdClass();
        $parc->valor_juro      = $p->valor_juro +  $parcela->valor_juro;
        $parc->valor_multa     = $p->valor_multa + $parcela->valor_multa;
        $parc->valor_desconto  = $p->valor_desconto +  $parcela->valor_desconto;
        $parc->valor_total_pagar = $p->valor_parcela + $p->valor_juro + $p->valor_multa - $p->valor_desconto;
        $parc->valor_pago  =$p->valor_pago + $pagamento->valor_pago;
        $parc->saldo_devedor   =$p->valor_total_pagar - $p->valor_pago;
        $parc->quitado         = ($p->saldo_devedor<=0) ? "S" : "N";
        
        //Atualização no lançamento
        $l = FinLancamentoPagar::find($p->lancamento_pagar_id );
        
        $lancamento                  = new \stdClass();
        $lancamento->valor_pago  = $l->valor_pago + $pagamento->valor_pago;
        $lancamento->acrescimo       = $l->acrescimo +  $parcela->valor_juro + $parcela->valor_multa - $parcela->valor_desconto;
        $lancamento->valor_a_pagar = $l->valor_total + $lancamento->acrescimo + $l->juros + $l->multa - $l->desconto;
        $lancamento->saldo_restante  = $lancamento->valor_a_pagar - $lancamento->valor_pago;
        $lancamento->pago = ($lancamento->saldo_restante<=0) ? "S" : "N";
        
        $pago = FinParcelaPagamento::create(objToArray($pagamento));
        if($pago){
            FinParcelaPagar::where("id",$pagamento->parcela_pagar_id)->update(objToArray($parc));
            FinLancamentoPagar::where("id",$p->lancamento_pagar_id)->update(objToArray($lancamento));
           // Flash::setMsg("Registro Inserido com sucesso");
            return true;
        }else{
            //Flash::setErro(["Não foi possível salvar os dados"]);
            return false;
        }
        
    }
}

