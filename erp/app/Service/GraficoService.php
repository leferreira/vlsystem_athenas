<?php
namespace App\Service;

use App\Models\FinPagamento;
use App\Models\FinRecebimento;

class GraficoService{
    public static function gerarEntradas($ano){
        $lista= array();
        for($i=0; $i<=11; $i++){
            $qtde = FinRecebimento::filtroPorMes($i+1, $ano)->sum("valor_recebido");            
            $lista[$i] = $qtde;
        }
        return $lista;
    }
    
    public static function gerarSaidas($ano){
        $lista= array();
        for($i=0; $i<=11; $i++){
            $qtde = FinPagamento::filtroPorMes($i+1 , $ano)->sum("valor_pago");
            $lista[$i] = $qtde;
        }
        return $lista;
    }
    
    public static function gerarVendasDiaria($mes){
        $lista= array();
        for($i=0; $i<=30; $i++){
            $data = date('Y') . "-". zeroEsquerda($mes,2) ."-".zeroEsquerda(($i+1), 2) ;
            $qtde = FinRecebimento::where("data_recebimento", $data)->sum("valor_recebido");
            $lista[$i] = $qtde;
        }
        return $lista;
    }
}

