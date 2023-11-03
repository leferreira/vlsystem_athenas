<?php
namespace App\Service;


use App\Models\Ibpt;
use App\Models\IcmsEstado;
use App\Models\NaturezaOperacao;
use App\Models\Nfe;
use App\Models\NfeItem;
use App\Models\Produto;
use App\Models\Tributacao;
use App\Models\TributacaoIva;
use App\Models\TributacaoProduto;

class ItemNotafiscalService{
    
    public static function refazTodosCalculos($nfe){
        $itens              = NfeItem::where("nfe_id", $nfe->id)->get();
        $qtdeItem           = count($itens);
        $natureza_operacao  = NaturezaOperacao::where("id", $nfe->natureza_operacao_id)->first();
        $tributacao_geral   = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
    ;
        $j                  = 1;
        $total_desc_item    = 0;
        if($qtdeItem > 0){
            foreach($itens as $item){
                $item->proporcao = $item->vProd/$nfe->vProd * 100;
                
                $desconto_rateio = 0;
                if($nfe->vDesc){
                    $desconto_rateio = ($item->proporcao/100)* $nfe->vDesc;
                    $desconto_rateio = number_format($desconto_rateio,2);
                    if($qtdeItem==$j){
                        $desconto_rateio = $nfe->vDesc - $total_desc_item;
                    }
                    $total_desc_item += $desconto_rateio;
                }
                
                
                $rateio_frete = 0;
                if($nfe->vFrete){
                    $rateio_frete  = ($item->proporcao/100)* $nfe->vFrete;
                }
                
                $rateio_seg = 0;
                if($nfe->vSeg){
                    $rateio_seg    = ($item->proporcao/100)* $nfe->vSeg;
                }
                
                $rateio_outro = 0;
                if($nfe->vOutro){
                    $rateio_outro  = ($item->proporcao/100)* $nfe->vOutro;
                }
                
                $item->vFrete           = $rateio_frete ;
                $item->vSeg             = $rateio_seg;
                $item->vOutro           = $rateio_outro;
                $item->desconto_rateio  = $desconto_rateio;
                $item->vDesc            = $item->desconto_rateio ;
                $id_produto             = $item->produto_id ? $item->produto_id : $item->cProd;
                $produto                = Produto::find($id_produto);             
                $tributaProduto = TributacaoProduto::where(["natureza_operacao_id"=>$nfe->natureza_operacao_id,"produto_id"=>$produto->id])->first();
                
                if($tributaProduto){
                    $tributacao =  $tributaProduto->tributacao;
                }else{
                    $tributacao = $tributacao_geral;
                }
                
                $item->cfop         = self::buscaCfop($nfe, $tributacao);    
                
                $item->cstICMS  = $tributacao->cstICMS;                
				
                $item->numero_item  = $j++;
               
                ItemNotafiscalService::calcularImposto($nfe, $item, $tributacao, $produto);
            }
        }
    }
    
    public static function buscaCfop($nfe, $tributacao){       
        $cfop = $tributacao->cfop;
        //se for estado diferente
        if($nfe->em_UF != $nfe->destinatario->dest_UF){          
            //se é consumidor final
            if($nfe->indFinal==1){
                if($tributacao->cfop_fora_consumidor_final) {
                    $cfop = $tributacao->cfop_fora_consumidor_final ;
                }elseif($tributacao->cfop_fora){
                    $cfop = $tributacao->cfop_fora ;
                }else{
                    $cfop = intval($tributacao->cfop) + 1000;
                }
            }else{
                if($tributacao->cfop_fora){
                    $cfop = $tributacao->cfop_fora ;
                }else{
                    $cfop = intval($tributacao->cfop) + 1000;
                }
            }
        }
        
        if($nfe->idDest==3){
            $cfop = ($tributacao->cfop_exportacao) ? $tributacao->cfop_exportacao : $cfop ;
        }
        
       return $cfop;
    }
    
    
    public static function calcularImposto($nfe, $item, $tributacao, $produto){        
        //IPI
        if($item->cstIPI=="50"){
            $vBCIPI = BaseCalculoService::calculoVbcIpi($item, $tributacao);
            IpiService::calculo($item, $vBCIPI, $tributacao, $produto)  ;
        }
        
        //PIS
        $vBCPIS = BaseCalculoService::calculoVbcPis($item, $tributacao);
        PisService::calculo($item, $vBCPIS, $tributacao, $produto);
        
        // Confins
        $vBCCOFINS = BaseCalculoService::calculoVbcCofins($item, $tributacao, $produto);
        CofinsService::calculo($item, $vBCCOFINS, $tributacao, $produto);
        
        //ICMS
        $vBCICMS    = BaseCalculoService::calculoVbcIcms($item, $tributacao);
        $icms_estado= IcmsEstado::where(["uf_origem"=>$nfe->em_UF,"uf_destino"=>$nfe->destinatario->dest_UF])->first();
        $pICMS      = $icms_estado->aliquota_destino;
        if($nfe->em_UF == $nfe->destinatario->dest_UF){
            if($produto->pICMS){
                $pICMS  = $produto->pICMS;
            }else if($tributacao->pICMS){
                $pICMS  = $tributacao->pICMS;
            }
        }
		
       
        if($tributacao->cstICMS=="10" || $tributacao->cstICMS=="30" || $tributacao->cstICMS=="70" || $tributacao->cstICMS=="201"
            || $tributacao->cstICMS=="202" || $tributacao->cstICMS=="203" || $tributacao->cstICMS=="900" || $tributacao->cstICMS=="500"){
                $iva = TributacaoIva::where(["tributacao_id" => $tributacao->id, "uf_origem"=>$nfe->em_UF,"uf_destino"=>$nfe->destinatario->dest_UF])->first();	                
                if(!$iva){
                    $iva = TributacaoIva::where(["tributacao_id" => $tributacao->id, "uf_origem"=>$nfe->em_UF,"uf_destino"=>'TD'])->first();
                }
                //Se tiver o iva
                if($iva){
                    $item->cstICMS = $iva->cstIcms ? $iva->cstIcms : $tributacao->cstICMS;
                }                
                
                IcmsService::calculoICMS($item, $vBCICMS, $tributacao, $pICMS , $nfe->destinatario, $produto, $icms_estado, $iva);
        }else{
            IcmsService::calculoICMS($item, $vBCICMS, $tributacao, $pICMS , $nfe->destinatario, $produto);
        }		
	   
   
        self::calcularIbpt($item, $nfe->em_UF);
        $item->save();
    }
    
    public static function calcularIbpt($item, $uf){
        $ibpt = Ibpt::where(["ncm" => tira_mascara($item->NCM), "uf"=> $uf])->first();
        if($ibpt != null){
            $vProd = $item->vProd;
            $item->nacionalfederal  = $vProd*($ibpt->nacionalfederal/100);
            $item->estadual         = $vProd*($ibpt->estadual/100);
            $item->municipal        = $vProd*($ibpt->municipal/100);
            $item->vTotTrib         = $item->nacionalfederal + $item->estadual + $item->municipal;
        }
    }
    
    public static function atualizarTotaisImpostosDaNota($id){
        $itens      = NfeItem::where("nfe_id",$id);
        $nfe        = Nfe::find($id);
        $total_itens= $itens->sum("vProd");     
        $nfe->vProd = $total_itens;
        
        $nfe->vFCP  = $itens->sum("vFCP");
        $nfe->vIPI  = $itens->sum("vIPI");
        $nfe->vPIS  = $itens->sum("vPIS");
        $nfe->vCOFINS  = $itens->sum("vCOFINS");
        $nfe->vBCST  = $itens->sum("vBCST");
        $nfe->vST    = $itens->sum("vICMSST");
        $nfe->vNF   = $nfe->vProd - $nfe->vDesc + $nfe->vST + $nfe->vFrete + $nfe->vSeg + $nfe->vOutro + $nfe->vII + $nfe->vIPI + $nfe->vServ;
        $nfe->vOrig = $nfe->vNF;
        $nfe->vLiq  = $nfe->vOrig ;
        $nfe->estadual          = $itens->sum("estadual");
        $nfe->municipal         = $itens->sum("municipal");
        $nfe->nacionalfederal   = $itens->sum("nacionalfederal");
        $nfe->vTotTrib          = $itens->sum("vTotTrib");
        
        $nfe->vBC   = $itens->where("destaca_icms","S")->sum("vBCICMS");
        $nfe->vICMS = $itens->where("destaca_icms","S")->sum("vICMS");
       
        $nfe->save();
    }
    
    //Quando mudar algum valor
    public static function atualizarTodosCalculos($id_nfe){
        //Verificar tributação
        $nfe                = Nfe::find($id_nfe);
        $itens              = NfeItem::where("nfe_id", $nfe->id)->get();
        $qtdeItem           = count($itens);        //rateio
        $j                  = 1;
        $total_desc_item    = 0;
        if($qtdeItem > 0){
            foreach($itens as $item){
                $item->proporcao = $item->vProd/$nfe->vProd * 100;
                $desconto_rateio = 0;
                if($nfe->vDesc){
                    $desconto_rateio = ($item->proporcao/100)* $nfe->vDesc;
                    $desconto_rateio = number_format($desconto_rateio,2);
                    if($qtdeItem==$j){
                        $desconto_rateio = $nfe->vDesc - $total_desc_item;
                    }
                    $total_desc_item += $desconto_rateio;
                }
                
                $rateio_frete = 0;
                if($nfe->vFrete){
                    $rateio_frete  = ($item->proporcao/100)* $nfe->vFrete;
                }
                
                $rateio_seg = 0;
                if($nfe->vSeg){
                    $rateio_seg    = ($item->proporcao/100)* $nfe->vSeg;
                }
                
                $rateio_outro = 0;
                if($nfe->vOutro){
                    $rateio_outro  = ($item->proporcao/100)* $nfe->vOutro;
                }                
                
                $item->vFrete           = $rateio_frete ;
                $item->vSeg             = $rateio_seg;
                $item->vOutro           = $rateio_outro;
                $item->desconto_rateio  = $desconto_rateio;
                $item->vDesc            = $item->desconto_rateio ;
                $item->numero_item      = $j++;
                ItemNotafiscalService::reCalcularImposto($item);
            }
        }
    }
    
    public static function reCalcularImposto($item){
        //IPI
        if($item->cstIPI=="50"){
            $vBCIPI =BaseCalculoService::reCalculaVbcIpi($item);
            IpiService::recalculo($item, $vBCIPI)  ;
        }
        //PIS
        $vBCPIS = BaseCalculoService::reCalculaVbcPis($item);
        PisService::recalculo($item, $vBCPIS);
        
        // Confins
        $vBCCOFINS = BaseCalculoService::reCalculaVbcCofins($item);
        CofinsService::recalculo($item, $vBCCOFINS);
        
        //ICMS
        $vBCICMS = BaseCalculoService::reCalculaVbcIcms($item);
        IcmsService::recalculoICMS($item, $vBCICMS);
        $item->save();        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public static function atualizarTotaisDaNota($id){
        $itens      = NfeItem::where("nfe_id",$id);
        $nfe        = Nfe::find($id);
        $total_itens= $itens->sum("vProd");
        
        $nfe->vProd = $total_itens;
        
        $nfe->desconto_itens   = $itens->sum("desconto_item");
        $nfe->vFCP  = $itens->sum("vFCP");
        $nfe->vIPI  = $itens->sum("vIPI");
        $nfe->vPIS  = $itens->sum("vPIS");
        $nfe->vCOFINS  = $itens->sum("vCOFINS");
        $nfe->vBCST  = $itens->sum("vBCST");
        $nfe->vST    = $itens->sum("vICMSST");
        $nfe->vNF   = $nfe->vProd - $nfe->vDesc + $nfe->vST + $nfe->vFrete + $nfe->vSeg + $nfe->vOutro + $nfe->vII + $nfe->vIPI + $nfe->vServ;
        $nfe->vOrig = $nfe->vNF;
        $nfe->vLiq  = $nfe->vOrig ;
        $nfe->vBC   = $itens->where("destaca_icms","S")->sum("vBCICMS");
        $nfe->vICMS = $itens->where("destaca_icms","S")->sum("vICMS");
        $nfe->save();
    }
    
    
    
    

    
    
    
    
  
    
    
    
    
     
    
    
    
    
    
    //quando for inserido um novo item
    
    
  
    
    public static function inserir($i){
        $tributacao     = Tributacao::getTributacaoPadrao($nfe->natureza_operacao_id, $i->produto_id);
        if(!$tributacao){
            throw new \Exception('Por favor, Cadastre uma Tributação Primeiramente');
        }
        
        $item           = new \stdClass();
        $item->orig     = $produto->origem ;;
        $item->cProd    = $produto->id;
        
        NfeItem::Create(objToArray($item));      
        
    }
    
    
    
    
    
   
    
    
    
}

