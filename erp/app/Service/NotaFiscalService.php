<?php
namespace App\Service;
use App\Models\Emitente;
use App\Models\NaturezaOperacao;
use App\Models\Nfe;
use App\Models\NfeDestinatario;
use App\Models\NfeDuplicata;
use App\Models\NfeItem;
use App\Models\NfeTransporte;
use App\Models\Tributacao;
use Illuminate\Support\Facades\Auth;
use App\Models\NfeReferenciado;

class NotaFiscalService{      
    public static function rateio($id_nfe){
        
    }
    public static function podeGerarNfe(){
        $retorno = new \stdClass();
        $natureza_operacao  = NaturezaOperacao::where("padrao", config('constantes.padrao_natureza.VENDA'))->first();
        if(!$natureza_operacao){
            $retorno->tem_erro  = true;
            $retorno->erro      = "Não é possível gerar a NFE. Antes de gerar uma NFE, cadastre uma Natureza de Operação Padrão de Venda Primeiramente";
            return $retorno;
        }      
        $tributacao      = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
        if(!$tributacao){
            $retorno->tem_erro  = true;
            $retorno->erro      = "Não é possível gerar a NFE. Antes de gerar uma NFE, cadastre uma tributação";
            return $retorno;
        } 
        
        $emitente = Emitente::where("empresa_id",Auth::user()->empresa_id)->first();
        if(!$emitente->cnpj){
            $retorno->tem_erro  = true;
            $retorno->erro      = "Não é possível gerar a NFE. Antes de gerar uma NFE, Configure o Emitente primeiramente";
            return $retorno;
        }
        
        $retorno->tem_erro  = false;
        $retorno->erro      = "Sem erro";
        return $retorno;
    }
    
    public static function clonarNfe($novosDados){        
        $natureza_operacao          = NaturezaOperacao::where("id", $novosDados->natureza_operacao_id)->first(); 
        $nfe_original               = Nfe::find($novosDados->nfe_id);
        $destinatario_original      = NfeDestinatario::where("nfe_id", $novosDados->nfe_id)->first();
        $itens_original             = NfeItem::where("nfe_id", $novosDados->nfe_id)->get();
        $duplicatas_original        = NfeDuplicata::where("nfe_id", $novosDados->nfe_id)->get();
        $transporte_original        = NfeTransporte::where("nfe_id", $novosDados->nfe_id)->get();       
        
        
        $emitente                   = Emitente::where("empresa_id", $nfe_original->empresa_id)->first();       
        $novo_nfe                   = $nfe_original->replicate();
        $novo_nfe->venda_id         = null;
        $novo_nfe->compra_id        = null;
       // $novo_nfe->tipo_nfe_id    = $novosDados->tipo_nfe_id;
        $novo_nfe->nota_referencia_id= $nfe_original->id;
        $novo_nfe->status_id        = config("constantes.status.DIGITACAO");
        $novo_nfe->natureza_operacao_id = $natureza_operacao->id ;
        $novo_nfe->chave            = null;
        $novo_nfe->recibo           = null;
        $novo_nfe->protocolo        = null;
        $novo_nfe->nNF              = $emitente->ultimo_numero_nfe + 1;
        $novo_nfe->cNF              = rand($novo_nfe->nNF,99999999);
        $novo_nfe->natOp            = $natureza_operacao->descricao;
        $novo_nfe->tpNF             = ($natureza_operacao->tipo == "S") ? '1' : '0' ; //0 - Entrada / 1 - Saida
        $novo_nfe->finNFe           = $novosDados->finNFe;
        $novo_nfe->save();
        
        //destinatário        
        $destinatario               = $destinatario_original->replicate();
        $destinatario->nfe_id       = $novo_nfe->id;
        $destinatario->save();
        
        //Itens
        foreach($itens_original as $i){ 
            $tributacao             = Tributacao::getTributacaoPadrao($novo_nfe->natureza_operacao_id, $i->id);  
            $novo_item              = $i->replicate();
            $novo_item->nfe_id      = $novo_nfe->id;   
            $novo_item->importado   = "S"; //Para não entrar no creating 
            $novo_item->CFOP        = ItemNotafiscalService::buscaCfop($novo_nfe, $tributacao);
            $novo_item->save();
        }
        
      //Itens
        if(count($duplicatas_original)>0){
            foreach($duplicatas_original as $d){
                $nova_dup = $d->replicate();
                $nova_dup->nfe_id = $novo_nfe->id;
                $nova_dup->save();
            }
        }
        
        //Transporate
        if(count($transporte_original)>0){
            foreach($transporte_original as $t){
                $novo_transp = $t->replicate();
                $novo_transp->nfe_id = $novo_nfe->id;
                $novo_transp->save();
            }
        }
       
        if($novo_nfe->finNFe==config("constanteNota.finNFe.DEVOLUCAO")){
            NfeReferenciado::Create(["nfe_id"=>$novo_nfe->id,"ref_NFe"=>$nfe_original->chave]);
        }
        
        return $novo_nfe->id;
        
        
    }
    

    
    public static function excluirNfe($id_nfe){
        NfeItem::where("nfe_id", $id_nfe)->delete();
        NfeTransporte::where("nfe_id", $id_nfe)->delete();
        NfeDuplicata::where("nfe_id", $id_nfe)->delete();
        NfeDestinatario::where("nfe_id", $id_nfe)->delete();
        Nfe::where("id", $id_nfe)->delete();
    }
}

