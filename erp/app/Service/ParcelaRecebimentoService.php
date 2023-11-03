<?php
namespace App\Service;


use App\Models\FinLancamentoReceber;
use App\Models\FinParcelaReceber;
use App\Models\FinParcelaRecebimento;

class ParcelaRecebimentoService{
    public static function baixar($recebimento, $parcela){
        $p = FinParcelaReceber::find($recebimento->parcela_receber_id);
        $total_a_receber = $p->saldo_devedor + $parcela->valor_juro + $parcela->valor_multa - $parcela->valor_desconto;
        
        if($parcela->tipo_baixa=="T"){
            if($recebimento->valor_recebido != $total_a_receber){
                return false;
            }
        }else{
            if($recebimento->valor_recebido > $total_a_receber){
                return false;
            }
        }
        //atualizar os valores da parcela
        $parc = new \stdClass();
        $parc->valor_juro      = $p->valor_juro +  $parcela->valor_juro;
        $parc->valor_multa     = $p->valor_multa + $parcela->valor_multa;
        $parc->valor_desconto  = $p->valor_desconto +  $parcela->valor_desconto;
        $parc->valor_total_receber = $p->valor_parcela + $p->valor_juro + $p->valor_multa - $p->valor_desconto;
        $parc->valor_recebido  =$p->valor_recebido + $recebimento->valor_recebido;
        $parc->saldo_devedor   =$p->valor_total_receber - $p->valor_recebido;
        $parc->quitado         = ($p->saldo_devedor<=0) ? "S" : "N";
        
        //Atualização no lançamento
        $l = FinLancamentoReceber::find($p->lancamento_receber_id );
        
        $lancamento                  = new \stdClass();
        $lancamento->valor_recebido  = $l->valor_recebido + $recebimento->valor_recebido;
        $lancamento->acrescimo       = $l->acrescimo +  $parcela->valor_juro + $parcela->valor_multa - $parcela->valor_desconto;
        $lancamento->valor_a_receber = $l->valor_total + $lancamento->acrescimo + $l->juros + $l->multa - $l->desconto;
        $lancamento->saldo_restante  = $lancamento->valor_a_receber - $lancamento->valor_recebido;
        $lancamento->pago = ($lancamento->saldo_restante<=0) ? "S" : "N";
        
        $pago = FinParcelaRecebimento::create(objToArray($recebimento));
        if($pago){
            FinParcelaReceber::where("id",$recebimento->parcela_receber_id)->update(objToArray($parc));
            FinLancamentoReceber::where("id",$p->lancamento_receber_id)->update(objToArray($lancamento));
           // Flash::setMsg("Registro Inserido com sucesso");
            return true;
        }else{
            //Flash::setErro(["Não foi possível salvar os dados"]);
            return false;
        }
        
    }
}

