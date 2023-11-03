<?php

namespace App\Observers;

use App\Models\Compra;
use App\Models\ItemCompra;

class ItemCompraObserver
{
    public function created(ItemCompra $item){         
        Compra::somarTotal($item->compra_id);
    }
    
    public function deleted(ItemCompra $item){
        Compra::somarTotal($item->compra_id);
        
        
    }
}
