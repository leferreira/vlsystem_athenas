<?php

namespace App\Observers;

use App\Models\OrdemServico;
use App\Models\ServicoOs;

class ServicoOsObserver
{
    public function created(ServicoOs $item){         
        OrdemServico::somarTotal($item->os_id);
    }
    
    public function deleted(ServicoOs $item){
        OrdemServico::somarTotal($item->os_id);
    }
}
