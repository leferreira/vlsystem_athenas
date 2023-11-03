<?php

namespace App\Observers;

use App\Models\ItemVenda;
use App\Models\Venda;
use App\Models\GradeMovimento;

class ItemVendaObserver
{
    public function created(ItemVenda $item){         
        Venda::somarTotal($item->venda_id);
    }
    
    public function deleted(ItemVenda $item){
        Venda::somarTotal($item->venda_id);
        GradeMovimento::where("item_venda_id", $item->id)->detete();
        
    }
}
