<?php

namespace App\Observers;

use App\Models\Nfe;
use App\Service\ItemNotafiscalService;


class NotaFiscalObserver{   
    
    public function updating(Nfe $nfe){
       
       
    }
    public function updated(Nfe $nfe){ 
       
        if($nfe->getOriginal('livre') == $nfe->livre){        
            if((($nfe->getOriginal('vSeg') != $nfe->vSeg ||  $nfe->getOriginal('vFrete') != $nfe->vFrete ||
                $nfe->getOriginal('vOutro') != $nfe->vOutro ||    $nfe->getOriginal('vDesc') != $nfe->vDesc))  ){
                    ItemNotafiscalService::atualizarTodosCalculos($nfe->id);
                    ItemNotafiscalService::atualizarTotaisImpostosDaNota($nfe->id );                   
            }
        }
        
    }    
   
}

