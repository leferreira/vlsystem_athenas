<?php

namespace App\Observers;

use App\Models\OrdemServico;
use App\Models\ProdutoOs;

class ProdutoOsObserver
{
    public function created(ProdutoOs $item){ 
        OrdemServico::somarTotal($item->os_id);
    }
    
    public function deleted(ProdutoOs $item){
        OrdemServico::somarTotal($item->os_id);
    }
}
