<?php

namespace App\Observers;

use App\Models\Cobranca;
use App\Models\FinContaReceber;
use App\Service\ContaReceberSevice;
use Str;

class CobrancaObserver
{
    public function creating(Cobranca $cobranca)
    {
        $cobranca->uuid = Str::uuid();
    }
    public function created(Cobranca $cobranca){
        ContaReceberSevice::inserirPelCobranca($cobranca);
    }
   
    public function deleted(Cobranca $cobranca){
        FinContaReceber::where("cobranca_id", $cobranca->id)->delete();
    }
    
    public function updated(Cobranca $cobranca){
        $receber                          = new \stdClass();
        $receber->valor                   = $cobranca->valor;
        $receber->data_vencimento         = $cobranca->data_vencimento;
        $receber->total_juros             = 0;
        $receber->total_multa             = 0;
        $receber->total_desconto          = 0;
        $receber->total_liquido           = $receber->valor;
        $receber->total_recebido          = 0;
        $receber->total_restante          = $receber->valor;
        FinContaReceber::where("cobranca_id", $cobranca->id)->update(objToArray($receber));
    }
}
