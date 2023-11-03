<?php

namespace App\Listeners;

use App\Events\NotaFiscalEvent;
use App\Service\ItemNotafiscalService;
use App\Service\NotaFiscalOperacaoService;

class InserirNotaFiscalPelaVenda
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    
    public function handle(NotaFiscalEvent $event){
        $venda              = $event->venda;
        $natureza           = $event->natureza;
        $tributacao         = $event->tributacao;        
        inserirNfePelaVenda($venda, $natureza, $tributacao);
        $venda->enviou_nfe = "S";
        $venda->save();
    }
}
