<?php
namespace  App\Service;

class IpiService{
    
    public static function calculo($item, $tributacao){  
       
        $item->cstIPI 		= $tributacao->cstIPI 	;
        $item->clEnq 		= $tributacao->clEnq 	;
        $item->CNPJProd 	= $tributacao->CNPJProd;
        $item->cSelo 		= $tributacao->cSelo 	;
        $item->qSelo 		= $tributacao->qSelo 	;
        $item->cEnq 		= $tributacao->cEnq 	;
        $item->pIPI 		= $tributacao->pIPI 	;
        $item->qUnidIpi 	= $item->qCom 	;
        $item->vUnidIPI		= $item->vUnCom  	;  
        
        $item->tipo_calc_ipi= $tributacao->tipo_calc_ipi  	;
        
        $item->vIPI         = null;
        
        if($item->tipo_calc_ipi == '1'){
            $item->vIPI = $item->vBCIPI * ($item->pIPI/100);
        }else if($item->tipo_calc_ipi == '2'){
            $item->vIPI = $item->vUnidIPI * $item->qUnidIpi;            
        }         
    }
}

