<?php

namespace App\Observers;

use App\Models\ItemVendaRecorrente;
use App\Models\VendaRecorrente;

class ItemVendaRecorrenteObserver
{
    public function created(ItemVendaRecorrente $item){         
        VendaRecorrente::somarTotal($item->venda_recorrente_id);
    }
    
    public function deleted(ItemVendaRecorrente $item){
        VendaRecorrente::somarTotal($item->venda_recorrente_id);
        
    }
}
