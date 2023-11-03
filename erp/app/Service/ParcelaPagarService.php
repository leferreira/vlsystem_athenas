<?php
namespace App\Service;

use App\Models\FinParcelaPagar;

class ParcelaPagarService{
    public static function gerarParcela($lancamento){
        $soma = 0;
        for($i=0; $i<$lancamento->qtde_parcela; $i++){
            $parcela = new FinParcelaPagar();
            $parcela->lancamento_pagar_id = $lancamento->id;
            $parcela->numero_parcela      = $i+1;
            $parcela->data_emissao        = $lancamento->data_lancamento;
            $parcela->data_vencimento     = somarData($lancamento->primeiro_vencimento, $lancamento->intervalo_entre_parcela * $i);
            $parcela->valor_parcela       = floor($lancamento->valor_a_pagar/$lancamento->qtde_parcela);
            $parcela->saldo_devedor       = $parcela->valor_parcela;
            $parcela->valor_total_pagar   = $parcela->valor_parcela;
            $soma += $parcela->valor_parcela;            
            $parcela->save();
        }        
    }
}

