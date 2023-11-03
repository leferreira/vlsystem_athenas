<?php
namespace App\Service;

use App\Models\MovimentoConta;
use App\Models\NfeDuplicata;
use App\Models\Fornecedor;

class MovimentoContaSevice{    
    
    public static function salvarMovimentoConta($compra, $fatura){      
        foreach ($fatura as $f) {
            $valorParcela       = str_replace(",", ".", $f['valor']);
            MovimentoConta::create([
            "fornecedor_id"		=> $compra->fornecedor_id,
            "compra_id"			=> $compra->id,
            "num_parcela"	    => $f['numero'],
            "ult_parcela"		=> count($fatura),
            "data_emissao"		=> hoje(),
            "data_vencimento"	=> $f['data'],
            "descricao"	        => "Compra #".$compra->id ,
             "valor"	        => $valorParcela,
            "status_id"         => config("constantes.status.ABERTO")
        ]);
        }
    }
    
    public static function novoMovimentoConta($conta){
        for($i=0; $i<$conta->qtde_parcela; $i++){
            MovimentoConta::create([
                "fornecedor_id"		=> $conta->fornecedor_id,
                "num_parcela"		=> $i+1,
                "ult_parcela"		=> $conta->qtde_parcela,
                "data_emissao"		=> $conta->data_emissao,
                "data_vencimento"	=> somarData($conta->primeiro_vencimento,$i*30),
                "descricao"	        => $conta->descricao ,
                "valor"	            => $conta->valor,
                "status_id"         => config("constantes.status.ABERTO")
            ]);
        }
    }
    
    public static function salvarMovimentoContaPelaCompra($compra, $duplicatas){
        foreach ($duplicatas as $duplicata) {
            MovimentoConta::create([
                "fornecedor_id"		=> $compra->fornecedor_id,
                "compra_id"			=> $compra->id,
                "num_parcela"	    => (int) $duplicata->nDup,
                "ult_parcela"		=> count($duplicatas),
                "data_emissao"		=> hoje(),
                "data_vencimento"	=> $duplicata->dVenc,
                "descricao"	        => "Compra Importada #".$compra->id ,
                "valor"	            => $duplicata->vDup,
                "status_id"         => config("constantes.status.ABERTO")
            ]);
        }
    }
    
    public static function salvarMovimentoContaPelaNfe($nfe){
        $duplicatas = NfeDuplicata::where("nfe_id", $nfe->id)->get();
        $fornecedor = Fornecedor::where("cnpj", $nfe->destinatario->dest_CNPJ)->first();
        MovimentoConta::where("nfe_id", $nfe->id)->delete();
        $i =1;
        foreach ($duplicatas as $duplicata) {
            MovimentoConta::create([
                "fornecedor_id"		=> $fornecedor->id,
                "nfe_id"			=> $nfe->id,
                "num_parcela"	    => (int) $duplicata->nDup,
                "ult_parcela"		=> count($duplicatas),
                "data_emissao"		=> hoje(),
                "data_vencimento"	=> $duplicata->dVenc,
                "descricao"	        => "Nfe #".$nfe->id . "#Parc#" .$i  ,
                "valor"	            => $duplicata->vDup,
                "status_id"         => config("constantes.status.ABERTO")
            ]);
            $i++;
        }
    }
 
    
}

