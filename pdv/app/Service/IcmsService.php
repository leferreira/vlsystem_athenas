<?php
namespace App\Service;

class IcmsService
{
    public static function calculoIcms($item, $tributacao){        
        //ICMS         
        $item->orig              = $tributacao->icms_origem;
        $item->cstICMS           = $tributacao->cstICMS;
        $item->modBC             = $tributacao->icms_modalidadeBC;
        $item->pICMS             = $tributacao->pICMS;
        $item->modBCST           = $tributacao->icms_modalidadeBC_ST;
        $item->pMVAST            = $tributacao->pMargem_Valor_Add_ST;
        $item->pRedBCST          = $tributacao->pReducao_Base_Calc_ST;
        $item->pICMSST           = $tributacao->pICMS_ST;
        $item->pFCPST            = $tributacao->pFCP_ST;
        $item->pST 			     = $tributacao->pST 			;
        $item->pFCP              = $tributacao->pFCP;
        $item->pRedBC            = $tributacao->pReducao_Base_Calc;
        $item->motDesICMS        = $tributacao->motivo_Desoneracao_ICMS;
        $item->pFCPSTRet         = $tributacao->pFCPSTRet;
        $item->pRedBCEfet        = $tributacao->pRedBCEfet;
        $item->pICMSEfet         = $tributacao->pICMSEfet;
        $item->motDesICMSST      = $tributacao->motDesICMSST; //NT 2020.005 v1.20
        $item->pFCPDif           = $tributacao->pFCPDif; //NT 2020.005 v1.20
        
        
        
        $item->vBCICMS          = $item->vProd  ;
        
        if($item->cstICMS=="00"){
            $item->vICMS    = $item->vBCICMS * ($item->pICMS / 100);
            $item->vFCP     = $item->vBCICMS * ($item->pFCP / 100);
            
        }else if($item->cstICMS=="10"){
            $item->vICMS    = $item->vBCICMS * ($item->pICMS / 100);
            
            //Cálculo da Substituição Tributária
            $result_mva = $item->vBCICMS + ($item->vBCICMS *  $item->pMVAST/100);
            $result_mva_redbc = $result_mva - ($result_mva *  $item->pRedBCST/100);
            $result = $result_mva_redbc * ($item->pICMSST /100);
            
            $vICMSST = $result - $item->vICMS;
            
            if($vICMSST<=0){
                $vICMSSTTot = 0;
            }else{
                $vICMSSTTot = $vICMSST;
            }
            
            $item->vICMSST = $vICMSSTTot;
            $item->vFCP    = $item->vBCICMS * ($item->pFCPST / 100);
            
        }else if($item->cstICMS=="20"){
            $item->vICMS    = $item->vBCICMS * ($item->pICMS / 100);
            $item->vFCP     = $item->vBCICMS * ($item->pFCP / 100);
            
        }else if($item->cstICMS=="30"){
            //Cálculo da Substituição Tributária
            $result_mva = $item->vBCICMS + ($item->vBCICMS *  $item->pMVAST/100);
            $result_mva_redbc = $result_mva - ($result_mva *  $item->pRedBCST/100);
            $result = $result_mva_redbc * ($item->pICMSST /100);
            
            $vICMSST = $result ;
            
            if($vICMSST<=0){
                $vICMSSTTot = 0;
            }else{
                $vICMSSTTot = $vICMSST;
            }            
            $item->vICMSST = $vICMSSTTot;
            $item->vFCPST  = $item->vBCICMS * ($item->pFCPST / 100);
        }else if($item->cstICMS=="40" || $item->cstICMS=="41" || $item->cstICMS=="50" ){
            $item->vICMSDeson = null;
        }else if($item->cstICMS=="51"){
            $item->vICMS    = $item->vBCICMS * ($item->pICMS / 100);
            $item->vFCP     = $item->vBCICMS * ($item->pFCP / 100);
            $item->vICMSOp  = $item->vICMS;
            
        }else if($item->cstICMS=="70"){
            $item->vICMS    = $item->vBCICMS * ($item->pICMS / 100);
            $item->vFCP     = $item->vBCICMS * ($item->pFCP / 100);
            
            //Cálculo da Substituição Tributária
            $result_mva = $item->vBCICMS + ($item->vBCICMS *  $item->pMVAST/100);
            $result_mva_redbc = $result_mva - ($result_mva *  $item->pRedBCST/100);
            $result = $result_mva_redbc * ($item->pICMSST /100);
            
            $vICMSST = $result - $item->vICMS;
            
            if($vICMSST<=0){
                $vICMSSTTot = 0;
            }else{
                $vICMSSTTot = $vICMSST;
            }
            $item->vICMSST = $vICMSSTTot;
            $item->vFCPST  = $item->vBCICMS * ($item->pFCPST / 100);
        
        }else{
            $item->vBCICMSICMS = null;
        }       
    }
    
    public static function calculoIcmsSn($item, $tributacao){
        
        $item->orig 			= $tributacao->icms_origem  ;
        $item->CSOSN 			= $tributacao->cstICMS      ;
        $item->modBC 			= ($tributacao->modBC) ?? null 		;
        $item->modBCST 			= ($tributacao->modBCST) ?? null	    ;
        $item->pCredSN 			= $tributacao->pCredSN 		;
        $item->pICMS 			= $tributacao->pICMS 		;
        $item->pMVAST 			= ($tributacao->pMVAST) ?? null 		;
        $item->pRedBCST 		= ($tributacao->pRedBCST) ?? null 		;
        $item->pICMSST 			= ($tributacao->pICMSST) ?? null 		;
        $item->pFCPST 			= ($tributacao->pFCPST) ?? null 		; //incluso no layout 4.00
        $item->pRedBC 			= ($tributacao->pRedBC) ?? null 		;
        $item->pST 				= ($tributacao->pST) ?? null 			;
        $item->pFCPSTRet 		= ($tributacao->pFCPSTRet) ?? null 	;//incluso no layout 4.00        
        
        $item->pRedBCEfet 		= ($tributacao->pRedBCEfet) ?? null 	;
        $item->pICMSEfet 		= ($tributacao->pICMSEfet) ?? null 	;        
        
        $item->vBCICMS      = $item->vProd  ;
        
        if($item->CSOSN=="101"){
            $item->vCredICMSSN = $item->vBCICMS * ($item->pCredSN / 100);
        }else if($item->CSOSN=="201"){
            
            $item->vCredICMSSN = $item->vBCICMS * ($item->pCredSN / 100);
            
            //Cálculo da Substituição Tributária
            $result_mva = $item->vBCICMS + ($item->vBCICMS *  $item->pMVAST/100);
            $result_mva_redbc = $result_mva - ($result_mva *  $item->pRedBCST/100);
            $result = $result_mva_redbc * ($item->pICMSST /100);
            
            $vICMSST = $result ;
            
            if($vICMSST<=0){
                $vICMSSTTot = 0;
            }else{
                $vICMSSTTot = $vICMSST;
            }
            $item->vICMSST = $vICMSSTTot;
            $item->vFCPST  = $item->vBCICMS * ($item->pFCPST / 100);
        }else if($item->CSOSN=="202" || $item->CSOSN=="203" ){
            //Cálculo da Substituição Tributária
            $result_mva = $item->vBCICMS + ($item->vBCICMS *  $item->pMVAST/100);
            $result_mva_redbc = $result_mva - ($result_mva *  $item->pRedBCST/100);
            $result = $result_mva_redbc * ($item->pICMSST /100);
            
            $vICMSST = $result;
            
            if($vICMSST<=0){
                $vICMSSTTot = 0;
            }else{
                $vICMSSTTot = $vICMSST;
            }
            $item->vICMSST = $vICMSSTTot;
            $item->vFCPST  = $item->vBCICMS * ($item->pFCPST / 100);
        }else if($item->CSOSN=="900"){
            $item->vICMS    = $item->vBCICMS * ($item->pICMS / 100);
            $item->vFCP     = $item->vBCICMS * ($item->pFCP / 100);
            $item->vCredICMSSN = $item->vBCICMS * ($item->pCredSN / 100);
            
            //Cálculo da Substituição Tributária
            $result_mva = $item->vBCICMS + ($item->vBCICMS *  $item->pMVAST/100);
            $result_mva_redbc = $result_mva - ($result_mva *  $item->pRedBCST/100);
            $result = $result_mva_redbc * ($item->pICMSST /100);
            
            $vICMSST = $result - $item->vICMS;
            
            if($vICMSST<=0){
                $vICMSSTTot = 0;
            }else{
                $vICMSSTTot = $vICMSST;
            }
            
            $item->vICMSST = $vICMSSTTot;
            $item->vFCPST  = $item->vBCICMS * ($item->pFCPST / 100);
        }else{
            $item->vBCICMS     = null;
        }
        
        
    }
}

