<?php

namespace App\Observers;

use App\Models\ItemOrcamento;
use App\Models\Orcamento;

class ItemOrcamentoObserver
{
    public function created(ItemOrcamento $item){         
        Orcamento::somarTotal($item->orcamento_id);
    }
    
    public function deleted(ItemOrcamento $item){
        Orcamento::somarTotal($item->orcamento_id);
    }
}
