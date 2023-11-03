<?php

namespace App\Observers;

use App\Models\ContaReceberPrevisao;
use App\Models\FinContaReceber;


class PrevisaoPagamentoObserver
{
   
    public function created(ContaReceberPrevisao $previsao){     
       $conta = FinContaReceber::find($previsao->conta_receber_id);
       $conta->data_previsao = $previsao->data_previsao;
       $conta->save();
  
    }
    
   
}
