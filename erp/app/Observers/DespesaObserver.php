<?php

namespace App\Observers;

use App\Models\FinContaPagar;
use App\Models\FinDespesa;
use App\Service\ContaPagarSevice;
use Illuminate\Support\Facades\Auth;

class DespesaObserver
{
    public function creating(FinDespesa $despesa)
    {   
        
        $despesa->valor_despesa       = $despesa->valor_despesa != null ? getFloat($despesa->valor_despesa) : 0;
        $despesa->valor_frete         = $despesa->valor_frete != null ? getFloat($despesa->valor_frete) : 0;
        $despesa->valor_liquido       = $despesa->valor_despesa != null ? getFloat($despesa->valor_despesa) : 0;
        $despesa->desconto_valor       = $despesa->desconto_valor != null ? getFloat($despesa->desconto_valor) : 0;
        $despesa->desconto_per       = $despesa->desconto_per != null ? getFloat($despesa->desconto_per) : 0;

        $despesa->status_financeiro_id= config("constantes.status.ABERTO");
        $despesa->status_id           = config("constantes.status.ABERTO");
        $despesa->usuario_id          = Auth::user()->getAuthIdentifier();        
        
    } 
    
    public function created(FinDespesa $despesa){
        ContaPagarSevice::inserirPelaDespesa($despesa);
    }
   
    public function deleted(FinDespesa $despesa){
        FinContaPagar::where("despesa_id", $despesa->id)->delete();
    }
    
    public function updated(FinDespesa $despesa){
    /*    $pagar                          = new \stdClass();
        $pagar->valor                   = $despesa->valor;
        $pagar->data_vencimento         = $despesa->data_vencimento;
        $pagar->total_juros             = 0;
        $pagar->total_multa             = 0;
        $pagar->total_desconto          = 0;
        $pagar->total_liquido           = $despesa->valor;
        $pagar->total_recebido          = 0;
        $pagar->total_restante          = $despesa->valor;
        FinContaReceber::where("cobranca_id", $despesa->id)->update(objToArray($pagar));*/
    }
}
