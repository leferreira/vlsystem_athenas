<?php
namespace App\Service;

class NfeTagService{
    public static function infNfe($nfe){
        $std = new \stdClass();
        $std->versao = '4.00'; //versão do layout (string)
        $std->Id = ''; //se o Id de 44 digitos não for passado será gerado automaticamente
        $std->pk_nItem = null; //deixe essa variavel sempre como NULL
        
        $nfe->taginfNFe($std);
    }
    
    public static function identificacao($nfe, $notafiscal){   
        $nota = $notafiscal->nota;        
        $std = new \stdClass();
        $std->cUF       = getCodUF($notafiscal->emitente->UF);
        $std->cNF       = rand(11111,99999);
        $std->natOp     = $nota->natOp;        
        //$std->indPag    = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00        
        $std->mod       = 55;
        $std->serie     = $nota->serie;
        $std->nNF       = $nota->nNF;
        $std->dhEmi     = date("Y-m-d\TH:i:sP");
        $std->dhSaiEnt  = null;
        $std->tpNF      = $nota->tpNF;
        $std->idDest    = $nota->idDest;
        $std->cMunFG    = $notafiscal->emitente->cMun;
        $std->tpImp     = $nota->tpImp;
        $std->tpEmis    = $nota->tpEmis;
        $std->cDV       = null;
        $std->tpAmb     = $nota->tpAmb;
        $std->finNFe    = $nota->finNFe;
        $std->indFinal  = $nota->indFinal;
        $std->indPres   = $nota->indPres;
        $std->indIntermed = $nota->indIntermed;
        $std->procEmi   = $nota->procEmi;
        $std->verProc   = $nota->verProc;
        $std->dhCont    = null;
        $std->xJust     = null;
        
        //Emitente
        
        
        $nfe->tagide($std);
    }
    
    public static function emitente($nfe,$emitente){
        $std = new \stdClass();
        $std->xNome	= tiraAcento(limita_caracteres($emitente->xNome,45))	;
        $std->xFant	= tiraAcento($emitente->xFant)	;
        $std->IE	= tira_mascara($emitente->IE)	    ;
        $std->IEST	= $emitente->IEST	;
        $std->IM	= $emitente->IM	    ;
        $std->CNAE	= $emitente->CNAE	;
        $std->CRT	= $emitente->CRT	;
        
        if($emitente->CNPJ):
            $std->CNPJ = tira_mascara($emitente->CNPJ);
            $std->CPF = null;
        elseif($emitente->CPF):
            $std->CNPJ = NULL;
            $std->CPF  = tira_mascara($emitente->CPF);
        else:
            $std->CNPJ = null;
            $std->CPF = null;
        endif;
        
        $nfe->tagemit($std);
        
        //endereço do emitente
        $std = new \stdClass();
        $std->xLgr		= tiraAcento(limita_caracteres($emitente->xLgr,45))	;
        $std->nro		= $emitente->nro	    ;
        $std->xCpl		= tiraAcento($emitente->xCpl)	;
        $std->xBairro   = tiraAcento(limita_caracteres($emitente->xBairro,45))	;
        $std->cMun		= $emitente->cMun	;
        $std->xMun		= tiraAcento($emitente->xMun)	;
        $std->UF		= $emitente->UF		;
        $std->CEP		= $emitente->CEP	    ;
        $std->cPais		= $emitente->cPais	;
        $std->xPais		= tiraAcento($emitente->xPais)	;
        $std->fone		= $emitente->fone    ;
        
        $nfe->tagenderEmit($std);
    }
    
    public static function destinatario($nfe,$destinatario){
        //destinatário
        $std = new \stdClass();
        $std->xNome = tiraAcento(limita_caracteres($destinatario->xNome,56 )) 	;
        $std->indIEDest	= $destinatario->indIEDest	;
        $std->IE	= $destinatario->IE		;
        $std->ISUF	= $destinatario->ISUF		;
        $std->IM	= $destinatario->IM		;
        $std->email	= $destinatario->email		;
        $std->idEstrangeiro= $destinatario->idEstrangeiro;
        
        if($destinatario->CNPJ):
            $std->CNPJ = tira_mascara($destinatario->CNPJ);
            $std->CPF = null;
        elseif($destinatario->CPF):
            $std->CNPJ = NULL;
            $std->CPF  = tira_mascara($destinatario->CPF);
        else:
            $std->CNPJ = null;
            $std->CPF = null;
        endif;
        
        $nfe->tagdest($std);
        
        //Endereço do destinatário
        $std = new \stdClass();
        $std->xLgr	= tiraAcento($destinatario->xLgr)		;
        $std->nro	= $destinatario->nro		;
        $std->xCpl	= tiraAcento($destinatario->xCpl)		;
        $std->xBairro= tiraAcento($destinatario->xBairro)	;
        $std->cMun	= $destinatario->cMun		;
        $std->xMun	= tiraAcento($destinatario->xMun)		;
        $std->UF	= $destinatario->UF		;
        $std->CEP	= $destinatario->CEP		;
        $std->cPais	= $destinatario->cPais		;
        $std->xPais	= tiraAcento($destinatario->xPais)		;
        $std->fone	= $destinatario->fone		;
        
        $nfe->tagenderDest($std);
    }
    
    public function dadosProduto($cont, $nfe, $item){
        $std            = new \stdClass();
        $std->item      = $cont; //item da NFe
        $std->cProd     = $item->cProd;
        $std->cEAN      = $item->cEAN;
        $std->xProd     = tiraAcento($item->xProd);
        $std->NCM       = $item->NCM;
        $std->cBenef    = $item->cBenef; //incluido no layout 4.00
        $std->EXTIPI    = $item->EXTIPI;
        $std->CFOP      = $item->CFOP;
        $std->uCom      = $item->uCom;
        $std->qCom      = $item->qCom;
        $std->vUnCom    = formataNumero($item->vUnCom);
        $std->vProd     = formataNumero($item->vProd);
        $std->cEANTrib  = $item->cEANTrib;
        $std->uTrib     = $item->uTrib;
        $std->qTrib     = $item->qTrib;
        $std->vUnTrib   = formataNumero($item->vUnTrib);        ;
        $std->vFrete    = ($item->vOutro) ? formataNumero($item->vFrete) : null;
        $std->vSeg      = ($item->vSeg) ? formataNumero($item->vSeg) : null  ;
        $std->vDesc     = ($item->vDesc) ? formataNumero($item->vDesc) : null;
        $std->vOutro    = ($item->vOutro) ? formataNumero($item->vOutro) : null ;
        $std->indTot    = $item->indTot;
        $std->xPed      = $item->xPed;
        $std->nItemPed  = $item->nItemPed;
        $std->nFCI      = $item->nFCI;
        $nfe->tagprod($std);
    }
    public function observacao($cont, $nfe, $item){
        $std = new \stdClass();
        $std->item = $cont; //item da NFe
        
        $std->infAdProd = $item->infAdProd;        
        $nfe->taginfAdProd($std);
    }
    public function imposto($cont, $nfe, $item){
        $std = new \stdClass();
        $std->item  = $cont; //item da NFe
        $std->vTotTrib = $item->vTotTrib;
        
        $nfe->tagimposto($std);
    }
    public static function icms($cont, $nfe, $item){
        $std                    = new \stdClass();
        $std->item              = $cont; //item da NFe
        $std->orig              = $item->orig;
        $std->CST               = $item->CST;
        $std->modBC             = $item->modBC;
        $std->vBC               = $item->vBC;
        $std->pICMS             = $item->pICMS;
        $std->vICMS             = $item->vICMS;
        $std->pFCP              = $item->pFCP;
        $std->vFCP              = $item->vFCP;
        $std->vBCFCP            = $item->vBCFCP;
        $std->modBCST           = $item->modBCST;
        $std->pMVAST            = $item->pMVAST;
        $std->pRedBCST          = $item->pRedBCST;
        $std->vBCST             = $item->vBCST;
        $std->pICMSST           = $item->pICMSST;
        $std->vICMSST           = $item->vICMSST;
        $std->vBCFCPST          = $item->vBCFCPST;
        $std->pFCPST            = $item->pFCPST;
        $std->vFCPST            = $item->vFCPST;
        $std->vICMSDeson        = $item->vICMSDeson;
        $std->motDesICMS        = $item->motDesICMS;
        $std->pRedBC            = $item->pRedBC;
        $std->vICMSOp           = $item->vICMSOp;
        $std->pDif              = $item->pDif;
        $std->vICMSDif          = $item->vICMSDif;
        $std->vBCSTRet          = $item->vBCSTRet;
        $std->pST               = $item->pST;
        $std->vICMSSTRet        = $item->vICMSSTRet;
        $std->vBCFCPSTRet       = $item->vBCFCPSTRet;
        $std->pFCPSTRet         = $item->pFCPSTRet;
        $std->vFCPSTRet         = $item->vFCPSTRet;
        $std->pRedBCEfet        = $item->pRedBCEfet;
        $std->vBCEfet           = $item->vBCEfet;
        $std->pICMSEfet         = $item->pICMSEfet;
        $std->vICMSEfet         = $item->vICMSEfet;
        $std->vICMSSubstituto   = $item->vICMSSubstituto; //NT 2020.005 v1.20
        $std->vICMSSTDeson      = $item->vICMSSTDeson; //NT 2020.005 v1.20
        $std->motDesICMSST      = $item->motDesICMSST; //NT 2020.005 v1.20
        $std->pFCPDif           = $item->pFCPDif; //NT 2020.005 v1.20
        $std->vFCPDif           = $item->vFCPDif; //NT 2020.005 v1.20
        $std->vFCPEfet          = $item->vFCPEfet; //NT 2020.005 v1.20
        
        $nfe->tagICMS($std);
    }
    public static function icmsSn($cont, $nfe, $item){
        $std                    = new \stdClass();
        $std->item              = $cont; //item da NFe
        $std->orig 				= $item->orig 			;
        $std->CSOSN 			= $item->CSOSN 		    ;
        $std->pCredSN 			= $item->pCredSN 		;
        $std->vCredICMSSN 		= $item->vCredICMSSN 	;
        $std->modBCST 			= $item->modBCST 		;
        $std->pMVAST 			= $item->pMVAST 		;
        $std->pRedBCST 			= $item->pRedBCST 		;
        $std->vBCST 			= $item->vBCST 		    ;
        $std->pICMSST 			= $item->pICMSST 		;
        $std->vICMSST 			= $item->vICMSST 		;
        $std->vBCFCPST 			= $item->vBCFCPST 		; //incluso no layout 4.00
        $std->pFCPST 			= $item->pFCPST 		; //incluso no layout 4.00
        $std->vFCPST 			= $item->vFCPST 		; //incluso no layout 4.00
        $std->vBCSTRet 			= $item->vBCSTRet 		;
        $std->pST 				= $item->pST 			;
        $std->vICMSSTRet 		= $item->vICMSSTRet 	;
        $std->vBCFCPSTRet 		= $item->vBCFCPSTRet 	; //incluso no layout 4.00
        $std->pFCPSTRet 		= $item->pFCPSTRet 	; //incluso no layout 4.00
        $std->vFCPSTRet 		= $item->vFCPSTRet 	; //incluso no layout 4.00
        $std->modBC 			= $item->modBC 		;
        $std->vBC 				= $item->vBC 			;
        $std->pRedBC 			= $item->pRedBC 		;
        $std->pICMS 			= $item->pICMS 		;
        $std->vICMS 			= $item->vICMS 		;
        $std->pRedBCEfet 		= $item->pRedBCEfet 	;
        $std->vBCEfet 			= $item->vBCEfet 		;
        $std->pICMSEfet 		= $item->pICMSEfet 	;
        $std->vICMSEfet 		= $item->vICMSEfet 	;
        $std->vICMSSubstituto 	= $item->vICMSSubstituto;
        // i($std);
        $nfe->tagICMSSN($std);
    }
    
    public static function ipi($cont, $nfe, $item){
        $std = new \stdClass();
        $std->item = $cont; //item da NFe
        $std->clEnq 			= $item->clEnq 	;
        $std->CNPJProd 			= $item->CNPJProd 	;
        $std->cSelo 			= $item->cSelo 	;
        $std->qSelo 			= $item->qSelo 	;
        $std->cEnq 				= $item->cEnq 		;
        $std->CST 				= $item->CST 		;
        $std->vIPI 				= $item->vIPI 		;
        $std->vBC  				= $item->vBC  		;
        $std->pIPI 				= $item->pIPI 		;
        $std->qUnid 			= $item->qUnid 	;
        $std->vUnid  			= $item->vUnid  	;
        
        $nfe->tagIPI($std);
    }
    
    public static function pis($cont, $nfe, $item){
        $std = new \stdClass();
        $std->item              = $cont; //item da NFe
        $std->CST 				= $item->CST;
        $std->vBC 				= $item->vBC;
        $std->pPIS 				= $item->pPIS;
        $std->vPIS 				= $item->vPIS;
        $std->qBCProd 			= $item->qBCProd;
        $std->vAliqProd 		= $item->vAliqProd;
        
        $nfe->tagPIS($std);;
    }
    
    public static function cofins($cont, $nfe, $item){
        $std = new \stdClass();
        $std->item              = $cont; //item da NFe
        $std->CST 				= $item->CST;
        $std->vBC 				= $item->vBC;
        $std->pCOFINS 			= $item->pCOFINS;
        $std->vCOFINS 			= $item->vCOFINS;
        $std->qBCProd 			= $item->qBCProd;
        $std->vAliqProd 		= $item->vAliqProd;
        
        $nfe->tagCOFINS($std);
    }
    
    public static function totais($nfe,$notafiscal){
        $std = new \stdClass();
        $std->vBC           = ($notafiscal->vBC)		? formataNumero($notafiscal->vBC)	    : 0.00;
        $std->vICMS         = ($notafiscal->vICMS)      ? formataNumero($notafiscal->vICMS)     : 0.00;
        $std->vICMSDeson    = ($notafiscal->vICMSDeson) ? formataNumero($notafiscal->vICMSDeson): 0.00;
        $std->vFCP          = ($notafiscal->vFCP)       ? formataNumero($notafiscal->vFCP)      : 0.00;
        $std->vBCST         = ($notafiscal->vBCST)      ? formataNumero($notafiscal->vBCST)     : 0.00;
        $std->vST           = ($notafiscal->vST)        ? formataNumero($notafiscal->vST)       : 0.00;
        $std->vFCPST        = ($notafiscal->vFCPST)     ? formataNumero($notafiscal->vFCPST)    : 0.00;
        $std->vFCPSTRet     = ($notafiscal->vFCPSTRet)  ? formataNumero($notafiscal->vFCPSTRet) : 0.00;
        $std->vProd         = ($notafiscal->vProd )     ? formataNumero($notafiscal->vProd)     : 0.00;
        $std->vFrete        = ($notafiscal->vFrete )    ? formataNumero($notafiscal->vFrete)    : 0.00;
        $std->vSeg          = ($notafiscal->vSeg  )     ? formataNumero($notafiscal->vSeg)      : 0.00;
        $std->vDesc         = ($notafiscal->vDesc )     ? formataNumero($notafiscal->vDesc)     : 0.00;
        $std->vII           = ($notafiscal->vII)        ? formataNumero($notafiscal->vII)       : 0.00;
        $std->vIPI          = ($notafiscal->vIPI)       ? formataNumero($notafiscal->vIPI)      : 0.00;
        $std->vIPIDevol     = ($notafiscal->vIPIDevol)  ? formataNumero($notafiscal->vIPIDevol) : 0.00;
        $std->vPIS          = ($notafiscal->vPIS)       ? formataNumero($notafiscal->vPIS)      : 0.00;
        $std->vCOFINS       = ($notafiscal->vCOFINS)    ? formataNumero($notafiscal->vCOFINS)   : 0.00;
        $std->vOutro        = ($notafiscal->vOutro)     ? formataNumero($notafiscal->vOutro)    : 0.00;
        $std->vNF           = ($notafiscal->vNF)        ? formataNumero($notafiscal->vNF)       : 0.00;
        $std->vTotTrib      = ($notafiscal->vTotTrib)   ? formataNumero($notafiscal->vTotTrib)  : 0.00;
        
        $nfe->tagICMSTot($std);
    }
    
    public static function transp($nfe,$notafiscal){
        $std           = new \stdClass();
        $std->modFrete = $notafiscal->modFrete ;
        
        $nfe->tagtransp($std);
    }
    public static function transportadora($nfe,$notafiscal){
        $std            = new \stdClass();
        $std->xNome 	= $notafiscal->xNome ;
        $std->IE 		= $notafiscal->IE 	;
        $std->xEnder 	= $notafiscal->xEnder;
        $std->xMun 		= $notafiscal->xMun 	;
        $std->UF  		= $notafiscal->UF  	;
        $std->CNPJ 		= $notafiscal->CNPJ 	;//só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
        $std->CPF  		= $notafiscal->CPF  	;
        i($std);
        $nfe->tagtransporta($std);       
        
    }
    
    public static function fatura($nfe, $notafiscal){
        $std = new \stdClass();
        $std->nFat  = $notafiscal->nFat;
        $std->vOrig = $notafiscal->vOrig;
        $std->vDesc = $notafiscal->vDesc;
        $std->vLiq  = $notafiscal->vLiq;
        
        $nfe->tagfat($std);
    }
    
    public static function duplicatas($nfe,$duplicatas){        
        
        foreach ($duplicatas as $duplicata) {
            $std        = new \stdClass();
            $std->nDup  = str_pad($duplicata["nDup"],3, "0", STR_PAD_LEFT) ;
            $std->dVenc = $duplicata["dVenc"] ;
            $std->vDup  = formataNumero($duplicata["vDup"])  ;           
            $nfe->tagdup($std);            
        }
        
        
    }
    
    public static function pag($nfe,$pag){
        $std                    = new \stdClass();
        $std->vTroco            = $pag->vTroco   ;
        $nfe->tagpag($std);
    }
    
    public static function detalhePagamento($nfe, $pagamento){
        
        $std            = new \stdClass();
        $std->tPag      = $pagamento->tPag;
        $std->vPag      = $pagamento->vPag; //Obs: deve ser informado o valor pago pelo cliente
        $std->CNPJ      = isset($pagamento->CNPJ) ? $pagamento->CNPJ : null;
        $std->tBand     = isset($pagamento->tBand) ? $pagamento->tBand : "";
        $std->cAut      = isset($pagamento->cAut) ? $pagamento->cAut : null;
        $std->tpIntegra = isset($pagamento->tpIntegra) ? $pagamento->tpIntegra : null; //incluso na NT 2015/002
        $std->indPag    = isset($pagamento->indPag) ? $pagamento->indPag : null; //0= Pagamento à Vista 1= Pagamento à Prazo
        
        $nfe->tagdetPag($std);
     
    }
    
    public static function intermed($nfe,$notafiscal){
        $std                    = new \stdClass();
        $std->CNPJ              = $notafiscal->CNPJ   ;
        $std->idCadIntTran      = $notafiscal->idCadIntTran    ;
        $nfe->tagIntermed($std);
    }
    
    public static function infRespTec($nfe,$notafiscal){
        $std                  = new \stdClass();
        $std->CNPJ            = isset($notafiscal->CNPJ) ? $notafiscal->CNPJ :null     ;
        $std->xContato        = isset($notafiscal->xContato) ? $notafiscal->xContato :null     ;
        $std->email           = isset($notafiscal->email) ? $notafiscal->email :null     ;
        $std->fone            = isset($notafiscal->fone) ? $notafiscal->fone :null      ;
        $std->CSRT            = isset($notafiscal->CSRT) ? $notafiscal->CSRT :null     ;
        $std->idCSRT          = isset($notafiscal->idCSRT) ? $notafiscal->idCSRT  :null     ;
        
        $nfe->taginfRespTec($std);
    }
}

