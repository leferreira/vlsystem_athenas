<?php

namespace App\Listeners;

use App\Events\ContaReceberEvent;
use App\Models\FinContaReceber;
use App\Service\ContaReceberSevice;

class InserirContaReceber
{
    
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ContaReceberEvent  $event
     * @return void
     */
    public function handle(ContaReceberEvent $event)
    {
        //Lançando no financeiro
        foreach ($fatura as $f) {
            $valorParcela = str_replace(",", ".", $f['valor']);
            FinContaReceber::create([
                "cliente_id"		=> $conta->cliente_id,
                "venda_id"			=> $conta->id,
                "forma_pagto_id"	=> $f["forma_pagto_id"],
                "num_parcela"		=> $f['numero'],
                "ult_parcela"		=> count($fatura),
                "data_emissao"		=> $conta->data_emissao,
                "data_vencimento"	=> $f['data'],
                "descricao"	        =>"Venda #".$conta->id ,
                "valor"	            => $valorParcela,
                "status_id"         => config("constantes.status.ABERTO")
            ]);
        }
        
        //aqui vai disparar o evento
        // FinContaReceber::where("venda_id", $vendaCadastrada->id)->delete(); //Excluindo os itens para incluir de novo
         ContaReceberSevice::salvarContaReceber($venda, $venda['fatura']);
        
    }
}
