<?php
namespace App\Service;

class CofinsService
{
    public static function calculo($item, $tributacao){
        $item->cstCOFINS	        = $tributacao->cstCOFINS		    ;
        $item->pCOFINS              = $tributacao->pCOFINS              ;
        $item->tipo_calc_cofins     = $tributacao->tipo_calc_cofins     ;
        $item->vAliqProd_cofins     = $tributacao->vAliqProd_cofins     ;
        $item->qBCProdConfis        = $item->qCom                       ;
        $item->vAliqProd_cofinsst   = $tributacao->vAliqProd_cofinsst   ;
        $item->tipo_calc_cofinsst   = $tributacao->tipo_calc_cofinsst   ;
        $item->pCOFINSST            = $tributacao->pCOFINSST  ;         ;
        $item->vBCCOFINS            = $item->vProd     ;
        $item->vCOFINS              = null;        
        
        if(($item->cstCOFINS =='01') || ($item->cstCOFINS =='02')) {
            $item->vCOFINS = $item->vBCCOFINS * ($item->pCOFINS/100);
        }else if($item->cstCOFINS =='03'){
            $item->vCOFINS = $item->vAliqProd_cofins * $item->qBCProd;
        }else if($item->cstCOFINS =='99'){
            if($item->tipo_calc_cofins == '1'){
                $item->vCOFINS = $item->vBCCOFINS * ($item->pCOFINS/100);
            }else if($item->tipo_calc_cofins == '2'){
                $item->vCOFINS = $item->vAliqProd_cofins * $item->qBCProd;
            }else{
                $item->vBCCOFINS = null;
            }
        }else{
            $item->vBCCOFINS = null;
            $item->vCOFINS  = null;            
        }        
    }
    
   /* public static function calculoCofinsST($cofins, $item->vCOFINS){
        $item->vCOFINSST = 0;       
        
        if($tipo_calculost == '0'){
            $item->vCOFINSST = 0; 
        }else if($tipo_calculost == '1'){
            $valor_calculado = ($item->vBC * ($item->pCOFINSST /100) - $item->vCOFINS);
            if($valor_calculado<=0){
                $item->vCOFINSST = 0;
            }else{
                $item->vCOFINSST = $valor_calculado;
            }
        }else{
            $valor_calculado = (($item->vAliqProdst * $item->qCom) - $item->vCOFINS);
            if($valor_calculado<=0){
                $item->vCOFINSST = 0;
            }else{
                $item->vCOFINSST = $valor_calculado;
            }
        }
        
        
        return $item->vCOFINSST;
    }*/
}

