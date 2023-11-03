<?php
namespace App\Service;

use App\Models\DuplicataCompra;
use App\Models\FinContaPagar;
use App\Models\Fornecedor;
use App\Models\NfeDuplicata;

class ContaPagarSevice{    
    public static function inserirPelaDespesa($despesa){
        $receber                    = new \stdClass();
        $receber->fornecedor_id		= $despesa->fornecedor_id;
        $receber->despesa_id	    = $despesa->id;
        $receber->num_parcela		= 1;
        $receber->ult_parcela		= 1;
        $receber->data_emissao	    = hoje();
        $receber->data_vencimento	= $despesa->data_vencimento;
        $receber->descricao	        = "Despesa #" . $despesa->venda_id;
        $receber->valor	            = $despesa->valor_despesa;
        return FinContaPagar::Create(objToArray($receber));
        
    }    

    
    public static function salvarContaPagar($compra, $fatura){      
        foreach ($fatura as $f) {
            $valorParcela       = str_replace(",", ".", $f['valor']);
            FinContaPagar::create([
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
    
    public static function novoContaPagar($conta){
        for($i=0; $i<$conta->qtde_parcela; $i++){
            FinContaPagar::create([
                "fornecedor_id"		=> $conta->fornecedor_id,
                "num_parcela"		=> $i+1,
                "ult_parcela"		=> $conta->qtde_parcela,
                "data_emissao"		=> $conta->data_emissao,
                "data_vencimento"	=> somarData($conta->primeiro_vencimento,$i*30),
                "descricao"	        => $conta->descricao ,
                "valor"	            => $conta->valor,
                "origem"	        => $conta->origem,
                "status_id"         => config("constantes.status.ABERTO")
            ]);
        }
    }
    
    public static function salvarContaPagarPelaCompraManual($compra){
        $duplicatas = DuplicataCompra::where("compra_id", $compra->id)->get();
        foreach ($duplicatas as $duplicata) {
            FinContaPagar::create([
                "fornecedor_id"		=> $compra->fornecedor_id,
                "compra_id"			=> $compra->id,
                "num_parcela"	    => (int) $duplicata->nDup,
                "ult_parcela"		=> count($duplicatas),
                "data_emissao"		=> hoje(),
                "data_vencimento"	=> $duplicata->dVenc,
                "descricao"	        => "Compra Manual #".$compra->id ,
                "valor"	            => $duplicata->vDup,
                "origem"	        => "Compra Manual",
                "status_id"         => config("constantes.status.ABERTO")
            ]);
        }
    }
    
    public static function salvarContaPagarPelaCompra($compra, $duplicatas){
        $i = 1;
        foreach ($duplicatas as $duplicata) {
            FinContaPagar::create([
                "fornecedor_id"		=> $compra->fornecedor_id,
                "compra_id"			=> $compra->id,
                "num_parcela"	    => (int) $duplicata->nDup,
                "ult_parcela"		=> count($duplicatas),
                "data_emissao"		=> hoje(),
                "data_vencimento"	=> $duplicata->dVenc,
                "descricao"	        => "Compra Importada#".$compra->id ."Parc#".$i ,
                "valor"	            => $duplicata->vDup,
                "origem"	        => "Compra Importada",
                "status_id"         => config("constantes.status.ABERTO")
            ]);
            $i++;
        }
    }
    
    public static function salvarContaPagarPelaNfe($nfe){
        $duplicatas = NfeDuplicata::where("nfe_id", $nfe->id)->get();
        $fornecedor = Fornecedor::where("cnpj", $nfe->destinatario->dest_CNPJ)->first();
        FinContaPagar::where("nfe_id", $nfe->id)->delete();
        $i =1;
        foreach ($duplicatas as $duplicata) {
            FinContaPagar::create([
                "fornecedor_id"		=> $fornecedor->id,
                "nfe_id"			=> $nfe->id,
                "num_parcela"	    => (int) $duplicata->nDup,
                "ult_parcela"		=> count($duplicatas),
                "data_emissao"		=> hoje(),
                "data_vencimento"	=> $duplicata->dVenc,
                "descricao"	        => "Nfe #".$nfe->id . "#Parc#" .$i  ,
                "valor"	            => $duplicata->vDup,
                "origem"	        => "NFE",
                "status_id"         => config("constantes.status.ABERTO")
            ]);
            $i++;
        }
    }
 
    
}

