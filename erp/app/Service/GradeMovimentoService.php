<?php
namespace App\Service;

use App\Models\GradeMovimento;

class GradeMovimentoService{
    
    public static function inserir($mov ){
        $saldo_anterior = GradeMovimento::saldoEstoque($mov->produto_id);
        $qtde           = ($mov->ent_sai=="E") ? $mov->qtde_movimento : - $mov->qtde_movimento;
        $saldo          =  $saldo_anterior + ($qtde) ;
        
        //Se for transferência
        $saldo_atual = ($mov->tipo_movimento_id==config('constantes.tipo_movimento.ENTRADA_TRANSFERENCIA_ESTOQUE') || $mov->tipo_movimento_id==config('constantes.tipo_movimento.SAIDA_TRANSFERENCIA_ESTOQUE')) ? $saldo_anterior : $saldo;
        $mov->saldoestoque = $saldo_atual ;
        GradeMovimento::create(objToArray($mov));
    }
    
   
    
}

