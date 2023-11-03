<?php
namespace App\Service;

class PisService
{
    public static function calculo($item, $tributacao){
        
        $item->cstPIS               = $tributacao->cstPIS  			   ;
        $item->pPIS                 = $tributacao->pPIS                ;
        $item->tipo_calc_pis        = $tributacao->tipo_calc_pis       ;
        $item->pPISST               = $tributacao->pPISST              ;
        $item->qBCProdPis           = $item->qCom                      ;
        $item->vAliqProd_pisst      = $tributacao->vAliqProd_pisst     ;
        $item->vAliqProd_pis        = $tributacao->vAliqProd_pis       ;
        $item->tipo_calc_pisst      = $tributacao->tipo_calc_pisst     ;
        $item->vBCPIS               = $item->vProd                     ;
        
        $item->tipo_calc_pis        = $tributacao->tipo_calc_pis                     ;
        $item->vPIS                 = null;    
        
        
        if(($item->cstPIS =='01') || ($item->cstPIS =='02')) {
            $item->vPIS = $item->vBC * ($item->pPIS/100);
        }else if($item->cstPIS =='03'){
            $item->vPIS == $item->vAliqProd_pis  * $item->qBCProdPis ;
        }else if($item->cstPIS =='99'){
            if($item->tipo_calc_pis == '1'){
                $item->vPIS = $item->vBC * ($item->pPIS/100);
            }else if($item->tipo_calc_pis == '2'){
                $item->vPIS = $item->vAliqProd_pis  * $item->qBCProdPis ;
            }else {
                $item->vBC = null;
            }                
        }else{
            $item->vBC = null;
            $item->vPIS = null;
        }               
    }
    
   /* public static function calculoPisST($item, $tributacao){
        $item->vPISST = 0;       
        
        if($item->tipo_calc_pis_st == '0'){
            $item->vPISST = 0; 
        }else if($item->tipo_calc_pis_st == '1'){
            $valor_calculado = ($item->vBCPIS * ($item->pPISST /100) - $item->vPIS);
            if($valor_calculado<=0){
                $item->vPISST = 0;
            }else{
                $item->vPISST = $valor_calculado;
            }
        }else{
            $valor_calculado = (($item->vAliqProd_pis * $item->qCom) - $item->vPIS);
            if($valor_calculado<=0){
                $item->vPISST = 0;
            }else{
                $item->vPISST = $valor_calculado;
            }
        }
        
        
        return $item->vPISST;
    }*/
}

