<?php


use App\Models\Cliente;
use App\Models\Emitente;
use App\Models\Fornecedor;
use App\Models\NaturezaOperacao;
use App\Models\Nfe;
use App\Models\NfeDestinatario;
use App\Models\NfeEntrada;
use App\Models\NfeEntradaDuplicata;
use App\Models\NfeEntradaItem;
use App\Models\NfeItem;
use App\Models\NfeReferenciado;
use App\Models\Produto;
use App\Models\ProdutoFornecedor;
use App\Models\Tributacao;
use App\Models\TributacaoProduto;
use App\Service\ConstanteService;
use App\Service\ItemNotafiscalService;
use App\Service\NotaFiscalOperacaoService;

function lerXml($xmlOrigem){
    $xml     = simplexml_load_file($xmlOrigem);
    if(isset($xml->NFe)){
        $xml_nfe = $xml->NFe->infNFe;
    }elseif($xml->infNFe){
        $xml_nfe = $xml->infNFe;
    }
    
    
    $identificacao      = $xml_nfe->ide;
    $emitenteXml        = $xml_nfe->emit;
    $produtosXml        = $xml_nfe->det ;
    $totais             = $xml_nfe->total ;
    $transportadoraNfe  = $xml_nfe->transp;
    
    $intermediarioXml   = $xml_nfe->Intermed ?? null;
    $infAdicXml         = $xml_nfe->infAdic ?? null;
    $duplicataXml       = $xml_nfe->cobr->dup ?? null;
    $pagamentoXml       = $xml_nfe->pag ?? null;
    $totalXml           = ($totais->ICMSTot) ?? null;
    
    $chaveNfe=  $xml_nfe->attributes()->Id;
    $chave   = substr($chaveNfe, 3, 44);     
    
    //Dados de Identificação
    $nfe            = new \stdClass();
    $nfe->cUF       = $identificacao->cUF;
    $nfe->chave     = $chave;
    $nfe->cNF       = $identificacao->cNF;
    $nfe->natOp     = $identificacao->natOp;
    $nfe->modelo	= $identificacao->mod 			;
    $nfe->serie 	= $identificacao->serie 		;
    $nfe->nNF 		= $identificacao->nNF 			;
    $nfe->dhEmi 	= $identificacao->dhEmi 		;
    $nfe->dhSaiEnt 	= $identificacao->dhSaiEnt 		;
    $nfe->tpNF 		= $identificacao->tpNF 			;
    $nfe->idDest 	= $identificacao->idDest 		;
    $nfe->cMunFG 	= $identificacao->cMunFG 		;
    $nfe->tpImp 	= $identificacao->tpImp 		;
    $nfe->tpEmis 	= $identificacao->tpEmis 		;
    $nfe->cDV 		= $identificacao->cDV 			;
    $nfe->tpAmb 	= $identificacao->tpAmb 		;
    $nfe->finNFe 	= $identificacao->finNFe 		;
    $nfe->indFinal 	= $identificacao->indFinal 		;
    $nfe->indPres 	= $identificacao->indPres 		;
    $nfe->indIntermed = $identificacao->indIntermed 	;
    $nfe->procEmi 	= $identificacao->procEmi 		;
    $nfe->verProc 	= $identificacao->verProc 		;
    $nfe->dhCont 	= ($identificacao->dhCont) ?? null 		;
    $nfe->xJust 	= ($identificacao->xJust) ?? null 		;
    $nfe->modFrete 	= ($transportadoraNfe->modFrete) ?? null 		;
    
    $emitente               = new \stdClass();
    $emitente->CNPJ         = ($emitenteXml->CNPJ) ? $emitenteXml->CNPJ : $emitenteXml->CPF;
    $emitente->xNome        = $emitenteXml->xNome;
    $emitente->xFant        = $emitenteXml->xFant;
    $emitente->xLgr         = $emitenteXml->enderEmit->xLgr;
    $emitente->nro          = $emitenteXml->enderEmit->nro;
    $emitente->xBairro      = $emitenteXml->enderEmit->xBairro;
    $emitente->UF           = $emitenteXml->enderEmit->UF;
    $emitente->xCpl         = ($emitenteXml->xCpl) ?? null;
    $emitente->fone         = ($emitenteXml->enderEmit->fone) ?? null;
    $emitente->CEP          = $emitenteXml->enderEmit->CEP;
    $emitente->cMun         = $emitenteXml->enderEmit->cMun;
    $emitente->IE           = ($emitenteXml->IE) ?? null;
    $emitente->email        = ($emitenteXml->email) ?? null;
    $emitente->xMun         = $emitenteXml->enderEmit->xMun;    
        
    //Tranportadora
    $transportadora = new stdClass();
    $transportadora->CNPJ        = $transportadoraNfe->transporta->CNPJ ?? null ;
    $transportadora->xNome       = $transportadoraNfe->transporta->xNome ?? null;
    $transportadora->xEnder      = $transportadoraNfe->transporta->xEnder ?? null;
    $transportadora->xMun        = $transportadoraNfe->transporta->xMun ?? null;
    $transportadora->UF          = $transportadoraNfe->transporta->UF ?? null;
    $transportadora->IE          = $transportadoraNfe->transporta->IE ?? null;
    
    //Volume
    $volume = new stdClass();
    $volume->qVol               = $transportadoraNfe->vol->qVol ?? null;
    $volume->esp                = $transportadoraNfe->vol->esp ?? null;
    $volume->marca              = $transportadoraNfe->vol->marca ?? null;
    $volume->pesoL              = $transportadoraNfe->vol->pesoL ?? null;
    $volume->pesoB              = $transportadoraNfe->vol->pesoB ?? null;
    
    //Veículo
    $veiculo = new stdClass();
    $veiculo->placa             = $transportadoraNfe->veicTransp->placa ?? null;
    $veiculo->UF                = $transportadoraNfe->veicTransp->UF ?? null;
    $veiculo->RNTC              = $transportadoraNfe->veicTransp->RNTC  ?? null;
    
    //Reboque
    $reboque = new stdClass();
    $reboque->placa = $transportadoraNfe->reboque->placa ?? null;
    $reboque->UF    = $transportadoraNfe->reboque->UF ?? null;
    $reboque->RNTC  = $transportadoraNfe->reboque->RNTC  ?? null;
    
    //Vagão
    $vagaoBalsa = new stdClass();
    $vagaoBalsa->vagao         = $transportadoraNfe->vagao->vagao  ?? null;
    $vagaoBalsa->balsa         = $transportadoraNfe->vagao->balsa  ?? null;
    $vagaoBalsa->nLacre        = $transportadoraNfe->lacres->nLacre   ?? null;
    
   
    
    $intermediario = new stdClass();
    $intermediario->CNPJ                = $intermediarioXml->CNPJ    ?? null;
    $intermediario->idCadIntTran        = $intermediarioXml->idCadIntTran    ?? null;
   
    $observacao             = new stdClass();
    $observacao->infAdFisco = $infAdicXml->infAdFisco ?? null;
    $observacao->infCpl     = $infAdicXml->infCpl  ?? null;  
      
    
    //Totais da Nota
    $total = new stdClass();
    $total->vFrete        = ($totalXml->vFrete) ?? null 	;
    $total->vSeg          = ($totalXml->vSeg) ?? null 	;
    $total->vNF           = ($totalXml->vNF) ?? null 	;
    $total->vOrig         = ($totalXml->vOrig) ?? null 	;
    $total->vLiq          = ($totalXml->vLiq) ?? null 	;
    $total->vBC           = ($totalXml->vBC) ?? null 	;
    $total->vICMS         = ($totalXml->vICMS) ?? null 	;
    $total->vICMSDeson    = ($totalXml->vICMSDeson) ?? null 	;
    $total->vFCP          = ($totalXml->vFCP) ?? null 	;
    $total->vBCST         = ($totalXml->vBCST) ?? null 	;
    $total->vST           = ($totalXml->vST) ?? null 	;
    $total->vFCPST        = ($totalXml->vFCPST) ?? null 	;
    $total->vFCPSTRet     = ($totalXml->vFCPSTRet) ?? null 	;
    $total->vProd         = ($totalXml->vProd) ?? null 	;
    $total->vFrete        = ($totalXml->vFrete) ?? null 	;
    $total->vSeg          = ($totalXml->vSeg) ?? null 	;
    $total->vDesc         = ($totalXml->vDesc) ?? null 	;
    $total->vII           = ($totalXml->vII) ?? null 	;
    $total->vIPI          = ($totalXml->vIPI) ?? null 	;
    $total->vIPIDevol     = ($totalXml->vIPIDevol) ?? null 	;
    $total->vPIS          = ($totalXml->vPIS) ?? null 	;
    $total->vCOFINS       = ($totalXml->vCOFINS) ?? null 	;
    $total->vOutro        = ($totalXml->vOutro) ?? null 	;
    $total->vNF           = ($totalXml->vNF) ?? null 	;
    $total->vTotTrib      = ($totalXml->vTotTrib) ?? null 	;
    
    
    //Produtos
    $produtos = array() ;
    foreach($produtosXml as $item) {
        $produto            = new \stdClass();
        $produto->item      = $item->attributes()->nItem;
        $produto->cProd     =   $item->prod->cProd;
        $produto->xProd		=	str_replace("'", "", $item->prod->xProd);
        $produto->cEAN		=	($item->prod->cEAN) ?? null;
        $produto->cBarra	=	($item->prod->cBarra) ?? null;
        $produto->xProd		=	$item->prod->xProd;
        $produto->NCM		=	$item->prod->NCM;
        $produto->cBenef	=	($item->prod->cBenef) ?? null;
        $produto->EXTIPI	=	($item->prod->EXTIPI) ?? null;
        $produto->CFOP		=	$item->prod->CFOP;
        $produto->uCom		=	$item->prod->uCom;
        $produto->qCom		=	$item->prod->qCom;
        $produto->vUnCom	=	$item->prod->vUnCom;
        $produto->vProd		=	$item->prod->vProd;
        $produto->CEST		=	$item->prod->CEST ?? null;
        $produto->cEANTrib	=	($item->prod->cEANTrib) ?? null;
        $produto->cBarraTrib=	($item->prod->cBarraTrib) ?? null;
        $produto->uTrib		=	$item->prod->uTrib;
        $produto->qTrib		=	$item->prod->qTrib;
        $produto->vUnTrib	=	$item->prod->vUnTrib;
        $produto->vFrete	=	($item->prod->vFrete) ? $item->prod->vFrete : 0;
        $produto->vSeg		=	($item->prod->vSeg) ? $item->prod->vSeg : 0;
        $produto->vDesc		=	($item->prod->vDesc) ? $item->prod->vDesc : 0;
        $produto->vOutro	=	($item->prod->vOutro) ? $item->prod->vOutro : 0;
        $produto->indTot	=	($item->prod->indTot) ?? null;
        $produto->xPed		=	($item->prod->xPed) ?? null;
        $produto->nItemPed	=	($item->prod->nItemPed) ?? null;
        $produto->nFCI		=	($item->prod->nFCI) ?? null;
              
        //IMPOSTOS
        $icms00 = $item->imposto->ICMS->ICMS00 ?? null;
        $icms10 = $item->imposto->ICMS->ICMS10 ?? null;
        $icms20 = $item->imposto->ICMS->ICMS20 ?? null;
        $icms30 = $item->imposto->ICMS->ICMS30 ?? null;
        $icms40 = $item->imposto->ICMS->ICMS40 ?? null;
        $icms50 = $item->imposto->ICMS->ICMS50 ?? null;
        $icms51 = $item->imposto->ICMS->ICMS51 ?? null;
        $icms60 = $item->imposto->ICMS->ICMS60 ?? null;
        $icms70 = $item->imposto->ICMS->ICMS70 ?? null;
        $icms90 = $item->imposto->ICMS->ICMS90 ?? null;
        $ICMSST = $item->imposto->ICMS->ICMSST ?? null;
        $ICMSSN101 = $item->imposto->ICMS->ICMSSN101 ?? null;
        $ICMSSN102 = $item->imposto->ICMS->ICMSSN102 ?? null;
        $ICMSSN900 = $item->imposto->ICMS->ICMSSN900 ?? null;
        $IPI      = $item->imposto->IPI ?? null;
        $PIS      = $item->imposto->PIS ?? null;
        $PISST    = $item->imposto->PISST ?? null;
        $COFINS   = $item->imposto->COFINS ?? null;
        $COFINSST = $item->imposto->COFINSST ?? null;
        
        $icms       = new stdClass();
        $ipi        = new stdClass();
        $pis        = new stdClass();
        $pisSt      = new stdClass();
        $cofins     = new stdClass();
        $cofinsSt   = new stdClass();
        
        
        if($icms00){
            $icms->orig    = $item->imposto->ICMS->ICMS00->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMS00->CST;
            $icms->modBC   = $item->imposto->ICMS->ICMS00->modBC ?? null;
            $icms->vBCICMS = $item->imposto->ICMS->ICMS00->vBC;
            $icms->pICMS   = $item->imposto->ICMS->ICMS00->pICMS;
            $icms->vICMS   = $item->imposto->ICMS->ICMS00->vICMS;
            
            $icms->pFCP    = $item->imposto->ICMS->ICMS00->pFCP ?? null;
            $icms->vFCP    = $item->imposto->ICMS->ICMS00->vFCP ?? null;
        }
        
        if($icms10){
            $icms->orig    = $item->imposto->ICMS->ICMS10->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMS10->CST;
            $icms->modBC   = $item->imposto->ICMS->ICMS00->modBC ?? null;
            $icms->vBCICMS = $item->imposto->ICMS->ICMS10->vBC;
            $icms->pICMS   = $item->imposto->ICMS->ICMS10->pICMS;
            $icms->vICMS   = $item->imposto->ICMS->ICMS10->vICMS;
            
            $icms->vBCFCP  = $item->imposto->ICMS->ICMS10->vBCFCP ?? null;
            $icms->pFCP    = $item->imposto->ICMS->ICMS10->pFCP ?? null;
            $icms->vFCP    = $item->imposto->ICMS->ICMS10->vFCP ?? null;
            $icms->modBCST = $item->imposto->ICMS->ICMS10->modBCST ?? null;
            $icms->pMVAST  = $item->imposto->ICMS->ICMS10->pMVAST ?? null;
            $icms->pRedBCST= $item->imposto->ICMS->ICMS10->pRedBCST ?? null;
            $icms->vBCST   = $item->imposto->ICMS->ICMS10->vBCST ?? null;
            $icms->pICMSST = $item->imposto->ICMS->ICMS10->pICMSST ?? null;
            $icms->vBCFCPST= $item->imposto->ICMS->ICMS10->vBCFCPST ?? null;
            $icms->pFCPST  = $item->imposto->ICMS->ICMS10->pFCPST ?? null;
            $icms->vFCPST  = $item->imposto->ICMS->ICMS10->vFCPST ?? null;
        }
        
        if($icms20){
            $icms->orig    = $item->imposto->ICMS->ICMS20->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMS20->CST;
            $icms->modBC   = $item->imposto->ICMS->ICMS20->modBC ?? null;
            $icms->pRedBC  = $item->imposto->ICMS->ICMS20->pRedBC ?? null;
            $icms->vBCICMS = $item->imposto->ICMS->ICMS20->vBC;
            $icms->pICMS   = $item->imposto->ICMS->ICMS20->pICMS;
            $icms->vICMS   = $item->imposto->ICMS->ICMS20->vICMS;
            
            $icms->vBCFCP  = $item->imposto->ICMS->ICMS20->vBCFCP ?? null;
            $icms->pFCP    = $item->imposto->ICMS->ICMS20->pFCP ?? null;
            $icms->vFCP    = $item->imposto->ICMS->ICMS20->vFCP ?? null;
            
            $icms->vICMSDeson = $item->imposto->ICMS->ICMS20->vICMSDeson ?? null;
            $icms->motDesICMS = $item->imposto->ICMS->ICMS20->motDesICMS ?? null;
        }
        
        if($icms30){
            $icms->orig    = $item->imposto->ICMS->ICMS30->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMS30->CST;
            $icms->modBCST   = $item->imposto->ICMS->ICMS30->modBCST ?? null;
            $icms->pMVAST  = $item->imposto->ICMS->ICMS30->pMVAST ?? null;
            $icms->pRedBCST = $item->imposto->ICMS->ICMS30->pRedBCST;
            $icms->vBCST   = $item->imposto->ICMS->ICMS30->vBCST;
            $icms->pICMSST   = $item->imposto->ICMS->ICMS30->pICMSST;
            $icms->vICMSST  = $item->imposto->ICMS->ICMS30->vICMSST ?? null;
            
            $icms->vBCFCPST    = $item->imposto->ICMS->ICMS30->vBCFCPST ?? null;
            $icms->pFCPST    = $item->imposto->ICMS->ICMS30->pFCPST ?? null;
            $icms->vFCPST    = $item->imposto->ICMS->ICMS30->vFCPST ?? null;
            
            $icms->vICMSDeson = $item->imposto->ICMS->ICMS30->vICMSDeson ?? null;
            $icms->motDesICMS = $item->imposto->ICMS->ICMS30->motDesICMS ?? null;
        }
        
        if($icms40){
            $icms->cstICMS = $item->imposto->ICMS->ICMS40->CST;
            
            $icms->vICMSDeson = $item->imposto->ICMS->ICMS40->vICMSDeson ?? null;
            $icms->motDesICMS = $item->imposto->ICMS->ICMS40->motDesICMS ?? null;
        }
        
        if($icms50){
            $icms->cstICMS = $item->imposto->ICMS->ICMS50->CST;
            
            $icms->vICMSDeson = $item->imposto->ICMS->ICMS50->vICMSDeson ?? null;
            $icms->motDesICMS = $item->imposto->ICMS->ICMS50->motDesICMS ?? null;
        }
        
        if($icms51){
            $icms->orig    = $item->imposto->ICMS->ICMS51->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMS51->CST;
            $icms->modBC   = $item->imposto->ICMS->ICMS51->modBC ?? null;
            $icms->pRedBC   = $item->imposto->ICMS->ICMS51->pRedBC ?? null;
            $icms->vBC   = $item->imposto->ICMS->ICMS51->vBC ?? null;
            $icms->pICMS   = $item->imposto->ICMS->ICMS51->pICMS ?? null;
            $icms->vICMSOp   = $item->imposto->ICMS->ICMS51->vICMSOp ?? null;
            $icms->pDif   = $item->imposto->ICMS->ICMS51->pDif ?? null;
            $icms->vICMSDif   = $item->imposto->ICMS->ICMS51->vICMSDif ?? null;
            $icms->vICMS   = $item->imposto->ICMS->ICMS51->vICMS ?? null;
            
            $icms->vBCFCP   = $item->imposto->ICMS->ICMS51->vBCFCP ?? null;
            $icms->pFCP   = $item->imposto->ICMS->ICMS51->pFCP ?? null;
            $icms->vFCP   = $item->imposto->ICMS->ICMS51->vFCP ?? null;
        }
        
        if($icms60){
            $icms->orig    = $item->imposto->ICMS->ICMS60->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMS60->CST;
            
            $icms->vBCSTRet = $item->imposto->ICMS->ICMS60->vBCSTRet ?? null;
            $icms->pST = $item->imposto->ICMS->ICMS60->pST ?? null;
            $icms->vICMSSubstituto = $item->imposto->ICMS->ICMS60->vICMSSubstituto ?? null;
            $icms->vICMSSTRet = $item->imposto->ICMS->ICMS60->vICMSSTRet ?? null;
            
            $icms->vBCFCPSTRet = $item->imposto->ICMS->ICMS60->vBCFCPSTRet ?? null;
            $icms->pFCPSTRet = $item->imposto->ICMS->ICMS60->pFCPSTRet ?? null;
            $icms->vFCPSTRet = $item->imposto->ICMS->ICMS60->vFCPSTRet ?? null;
            
            $icms->pRedBCEfet = $item->imposto->ICMS->ICMS60->pRedBCEfet ?? null;
            $icms->vBCEfet = $item->imposto->ICMS->ICMS60->vBCEfet ?? null;
            $icms->pICMSEfet = $item->imposto->ICMS->ICMS60->pICMSEfet ?? null;
            $icms->vICMSEfet = $item->imposto->ICMS->ICMS60->vICMSEfet ?? null;
            
        }
        
        if($icms70){
            $icms->orig    = $item->imposto->ICMS->ICMS70->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMS70->CST;
            
            $icms->modBC = $item->imposto->ICMS->ICMS70->modBC ?? null;
            $icms->pRedBC = $item->imposto->ICMS->ICMS70->pRedBC ?? null;
            $icms->vBC = $item->imposto->ICMS->ICMS70->vBC ?? null;
            $icms->pICMS = $item->imposto->ICMS->ICMS70->pICMS ?? null;
            $icms->vICMS = $item->imposto->ICMS->ICMS70->vICMS ?? null;
            
            $icms->vBCFCP = $item->imposto->ICMS->ICMS70->vBCFCP ?? null;
            $icms->pFCP = $item->imposto->ICMS->ICMS70->pFCP ?? null;
            $icms->vFCP = $item->imposto->ICMS->ICMS70->vFCP ?? null;
            $icms->modBCST = $item->imposto->ICMS->ICMS70->modBCST ?? null;
            $icms->pMVAST = $item->imposto->ICMS->ICMS70->pMVAST ?? null;
            $icms->pRedBCST = $item->imposto->ICMS->ICMS70->pRedBCST ?? null;
            $icms->vBCST = $item->imposto->ICMS->ICMS70->vBCST ?? null;
            $icms->pICMSST = $item->imposto->ICMS->ICMS70->pICMSST ?? null;
            $icms->vICMSST = $item->imposto->ICMS->ICMS70->vICMSST ?? null;
            
            $icms->vBCFCPST = $item->imposto->ICMS->ICMS70->vBCFCPST ?? null;
            $icms->pFCPST = $item->imposto->ICMS->ICMS70->pFCPST ?? null;
            $icms->vFCPST = $item->imposto->ICMS->ICMS70->vFCPST ?? null;
            
            $icms->vICMSDeson = $item->imposto->ICMS->ICMS70->vICMSDeson ?? null;
            $icms->motDesICMS = $item->imposto->ICMS->ICMS70->motDesICMS ?? null;
            
        }
        
        if($icms90){
            $icms->orig    = $item->imposto->ICMS->ICMS90->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMS90->CST;
            
            $icms->modBC = $item->imposto->ICMS->ICMS90->modBC ?? null;
            $icms->vBC = $item->imposto->ICMS->ICMS90->vBC ?? null;
            $icms->pRedBC = $item->imposto->ICMS->ICMS90->pRedBC ?? null;
            $icms->pICMS = $item->imposto->ICMS->ICMS90->pICMS ?? null;
            $icms->vICMS = $item->imposto->ICMS->ICMS90->vICMS ?? null;
            
            $icms->modBCST = $item->imposto->ICMS->ICMS90->modBCST ?? null;
            $icms->pMVAST = $item->imposto->ICMS->ICMS90->pMVAST ?? null;
            $icms->pRedBCST = $item->imposto->ICMS->ICMS90->pRedBCST ?? null;
            $icms->vBCST = $item->imposto->ICMS->ICMS90->vBCST ?? null;
            $icms->pICMSST = $item->imposto->ICMS->ICMS90->pICMSST ?? null;
            $icms->vICMSST = $item->imposto->ICMS->ICMS90->vICMSST ?? null;
            
            $icms->vBCFCPST = $item->imposto->ICMS->ICMS90->vBCFCPST ?? null;
            $icms->pFCPST = $item->imposto->ICMS->ICMS90->pFCPST ?? null;
            $icms->vFCPST = $item->imposto->ICMS->ICMS90->vFCPST ?? null;
            
            $icms->vICMSDeson = $item->imposto->ICMS->ICMS90->vICMSDeson ?? null;
            $icms->motDesICMS = $item->imposto->ICMS->ICMS90->motDesICMS ?? null;
            
        }
        if($ICMSST){
            $icms->orig    = $item->imposto->ICMS->ICMSST->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMSST->CST;
            $icms->vBCSTRet   = $item->imposto->ICMS->ICMSST->vBCSTRet ?? null;
            $icms->pST   = $item->imposto->ICMS->ICMSST->pST ?? null;
            $icms->vICMSSubstituto   = $item->imposto->ICMS->ICMSST->vICMSSubstituto ?? null;
            $icms->vICMSSTRet   = $item->imposto->ICMS->ICMSST->vICMSSTRet ?? null;
            
            $icms->vBCFCPSTRet   = $item->imposto->ICMS->ICMSST->vBCFCPSTRet ?? null;
            $icms->pFCPSTRet   = $item->imposto->ICMS->ICMSST->pFCPSTRet ?? null;
            $icms->vFCPSTRet   = $item->imposto->ICMS->ICMSST->vFCPSTRet ?? null;
            $icms->vBCSTDest   = $item->imposto->ICMS->ICMSST->vBCSTDest ?? null;
            $icms->vICMSSTDest   = $item->imposto->ICMS->ICMSST->vICMSSTDest ?? null;
            
            $icms->pRedBCEfet   = $item->imposto->ICMS->ICMSST->pRedBCEfet ?? null;
            $icms->vBCEfet   = $item->imposto->ICMS->ICMSST->vBCEfet ?? null;
            $icms->pICMSEfet   = $item->imposto->ICMS->ICMSST->pICMSEfet ?? null;
            $icms->vICMSEfet   = $item->imposto->ICMS->ICMSST->vICMSEfet ?? null;
            
        }
        
        if($ICMSSN101){
            $icms->orig    = $item->imposto->ICMS->ICMSSN101->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMSSN101->CSOSN;
            $icms->pCredSN = $item->imposto->ICMS->ICMSSN101->pCredSN ?? null;
            $icms->vCredICMSSN = $item->imposto->ICMS->ICMSSN101->vCredICMSSN ?? null;
        }
        
        if($ICMSSN102){
            $icms->orig    = $item->imposto->ICMS->ICMSSN102->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMSSN102->CSOSN;
        }
        
        if($ICMSSN900){
            $icms->orig    = $item->imposto->ICMS->ICMSSN900->orig;
            $icms->cstICMS = $item->imposto->ICMS->ICMSSN900->CSOSN;
            
            $icms->modBC   = $item->imposto->ICMS->ICMSSN900->modBC ?? null;
            $icms->vBCICMS = $item->imposto->ICMS->ICMSSN900->vBC ?? null;
            $icms->pRedBC   = $item->imposto->ICMS->ICMSSN900->pRedBC ?? null;
            $icms->pICMS   = $item->imposto->ICMS->ICMSSN900->pICMS ?? null;
            $icms->vICMS   = $item->imposto->ICMS->ICMSSN900->vICMS ?? null;
            
            $icms->modBCST   = $item->imposto->ICMS->ICMSSN900->modBCST ?? null;
            $icms->pMVAST   = $item->imposto->ICMS->ICMSSN900->pMVAST ?? null;
            $icms->pRedBCST   = $item->imposto->ICMS->ICMSSN900->pRedBCST ?? null;
            $icms->vBCST   = $item->imposto->ICMS->ICMSSN900->vBCST ?? null;
            $icms->pICMSST   = $item->imposto->ICMS->ICMSSN900->pICMSST ?? null;
            $icms->vICMSST   = $item->imposto->ICMS->ICMSSN900->vICMSST ?? null;
            
            $icms->vBCFCPST   = $item->imposto->ICMS->ICMSSN900->vBCFCPST ?? null;
            $icms->pFCPST   = $item->imposto->ICMS->ICMSSN900->pFCPST ?? null;
            $icms->vFCPST   = $item->imposto->ICMS->ICMSSN900->vFCPST ?? null;
            
            $icms->pCredSN   = $item->imposto->ICMS->ICMSSN900->pCredSN ?? null;
            $icms->vCredICMSSN   = $item->imposto->ICMS->ICMSSN900->vCredICMSSN ?? null;
        }
        
        if($IPI){
            $ipi->CNPJProd = $item->imposto->IPI->CNPJProd ?? null;
            $ipi->cSelo = $item->imposto->IPI->cSelo ?? null;
            $ipi->qSelo = $item->imposto->IPI->qSelo ?? null;
            $ipi->cEnq = $item->imposto->IPI->cEnq ?? null;
            
            if(isset($item->imposto->IPI->IPITrib)){
                $ipi->cstIPI = $item->imposto->IPI->IPITrib->CST ?? null;
                $ipi->vBCIPI = $item->imposto->IPI->IPITrib->vBC ?? null;
                $ipi->pIPI   = $item->imposto->IPI->IPITrib->pIPI ?? null;
                $ipi->vIPI   = $item->imposto->IPI->IPITrib->vIPI ?? null;
                
                $ipi->qUnid   = $item->imposto->IPI->IPITrib->qUnid ?? null;
                $ipi->vUnid   = $item->imposto->IPI->IPITrib->vUnid ?? null;
                $ipi->vIPI   = $item->imposto->IPI->IPITrib->vIPI ?? null;
                $ipi->vIPI   = $item->imposto->IPI->IPITrib->vIPI ?? null;
            }
            
            if(isset($item->imposto->IPI->IPINT)){
                $ipi->cstIPI = $item->imposto->IPI->IPINT->CST;
            }
        }
        
        if($PIS){
            if(isset($item->imposto->PIS->PISAliq)){
                $pis->cstPIS = $item->imposto->PIS->PISAliq->CST ?? null;
                $pis->vBCPIS = $item->imposto->PIS->PISAliq->vBC ?? null;
                $pis->pPIS   = $item->imposto->PIS->PISAliq->pPIS ?? null;
                $pis->vPIS   = $item->imposto->PIS->PISAliq->vPIS ?? null;
            }
            
            if(isset($item->imposto->PIS->PISQtde)){
                $pis->cstPIS = $item->imposto->PIS->PISQtde->CST ?? null;
                $pis->qBCProdPis = $item->imposto->PIS->PISQtde->qBCProd ?? null;
                $pis->vAliqProd_pis   = $item->imposto->PIS->PISQtde->vAliqProd ?? null;
                $pis->vPIS   = $item->imposto->PIS->PISQtde->vPIS ?? null;
            }
            
            if(isset($item->imposto->PIS->PISNT)){
                $pis->cstPIS = $item->imposto->PIS->PISNT->CST ?? null;
            }
            
            if(isset($item->imposto->PIS->PISOutr)){
                $pis->cstPIS    = $item->imposto->PIS->PISOutr->CST ?? null;
                $pis->vBCPIS    = $item->imposto->PIS->PISOutr->vBC ?? null;
                $pis->pPIS      = $item->imposto->PIS->PISOutr->pPIS ?? null;
                $pis->qBCProdPis   = $item->imposto->PIS->PISOutr->qBCProd ?? null;
                $pis->vAliqProd_pis = $item->imposto->PIS->PISOutr->vAliqProd ?? null;
                $pis->vPIS      = $item->imposto->PIS->PISOutr->vIPI ?? null;
            }
            
        }
        
        if($PISST){
            $pisSt->vBCPISST = $item->imposto->PISST->vBC ?? null;
            $pisSt->pPISST = $item->imposto->PISST->pPIS ?? null;
            $pisSt->qBCProdPisST = $item->imposto->PISST->qBCProd ?? null;
            $pisSt->vAliqProd_pisst = $item->imposto->PISST->vAliqProd ?? null;
            $pisSt->vPISST = $item->imposto->PISST->vPIS ?? null;
        }
        
        if($COFINS){
            if(isset($item->imposto->COFINS->COFINSAliq)){
                $cofins->cstCOFINS = $item->imposto->COFINS->COFINSAliq->CST ?? null;
                $cofins->vBCCOFINS = $item->imposto->COFINS->COFINSAliq->vBC ?? null;
                $cofins->pCOFINS   = $item->imposto->COFINS->COFINSAliq->pCOFINS ?? null;
                $cofins->vCOFINS   = $item->imposto->COFINS->COFINSAliq->vCOFINS ?? null;
            }
            
            if(isset($item->imposto->COFINS->COFINSQtde)){
                $cofins->cstCOFINS = $item->imposto->COFINS->COFINSQtde->CST ?? null;
                $cofins->qBCProdConfis = $item->imposto->COFINS->COFINSQtde->qBCProd ?? null;
                $cofins->vAliqProd_cofins   = $item->imposto->COFINS->COFINSQtde->vAliqProd ?? null;
                $cofins->vCOFINS   = $item->imposto->COFINS->COFINSQtde->vCOFINS ?? null;
            }
            
            if(isset($item->imposto->COFINS->COFINSNT)){
                $cofins->cstCOFINS = $item->imposto->COFINS->COFINSNT->CST ?? null;
            }
            
            if(isset($item->imposto->COFINS->COFINSOutr)){
                $cofins->cstCOFINS    = $item->imposto->COFINS->COFINSOutr->CST ?? null;
                $cofins->vBCCOFINS    = $item->imposto->COFINS->COFINSOutr->vBC ?? null;
                $cofins->pCOFINS      = $item->imposto->COFINS->COFINSOutr->pCOFINS ?? null;
                $cofins->qBCProdConfis       = $item->imposto->COFINS->COFINSOutr->qBCProd ?? null;
                $cofins->vAliqProd_cofins     = $item->imposto->COFINS->COFINSOutr->vAliqProd ?? null;
                $cofins->vCOFINS      = $item->imposto->COFINS->COFINSOutr->vCOFINS ?? null;
            }
            
        }
        
        if($COFINSST){
            $cofinsSt->vBCCOFINSST     = $item->imposto->COFINSST->vBC ?? null;
            $cofinsSt->pCOFINSST       = $item->imposto->COFINSST->pCOFINS ?? null;
            $cofinsSt->qBCProdConfisST = $item->imposto->COFINSST->qBCProd ?? null;
            $cofinsSt->vAliqProd_cofinsst = $item->imposto->COFINSST->vAliqProd ?? null;
            $cofinsSt->vCOFINSST       = $item->imposto->COFINSST->vCOFINS ?? null;
        } 
        
        $produtos[]   = (object) array(
            "produto"   => $produto,
            "icms"      => $icms,
            "ipi"       => $ipi,
            "pis"      => $pis,
            "pisSt"      => $pisSt,
            "cofins"      => $cofins,
            "cofinsSt"      => $cofinsSt,
        );
    }    
  
    //Duplicatas
    
    $duplicatas = array();
    if($duplicataXml){
        foreach ($duplicataXml as $dup){
            $duplicata          = new \stdClass();
            $duplicata->nDup    = ($dup->nDup) ?? null;
            $duplicata->dVenc   = ($dup->dVenc) ?? null;
            $duplicata->vDup    = ($dup->vDup) ?? null;
            $duplicatas[]       = $duplicata;
        }
    }
    
  
    $nota = new stdClass();
    $nota->identificacao    = $nfe;
    $nota->emitente         = $emitente;
    $nota->transportadora   = $transportadora;
    $nota->volume           = $volume;
    $nota->veiculo          = $veiculo;
    $nota->reboque          = $reboque;
    $nota->vagaoBalsa       = $vagaoBalsa;
    $nota->intermediario    = $intermediario;
    $nota->observacao       = $observacao;
    $nota->total            = $total;
    $nota->produtos         = $produtos;
    $nota->duplicatas       = $duplicatas;
    $nota->tPag             = $pagamentoXml->detPag->tPag ?? null;
    
    
    return $nota;   
}

function salvarNfePeloXml($dados, $natureza_operacao, $id , $tipo="C"){
    $tributacao_geral   = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
   ;
    if($tipo=="C"){
        $destinatario               = Cliente::find($id);
        $destinatario->razao_social = $destinatario->nome_razao_social;
        $destinatario->cnpj         = $destinatario->cpf_cnpj;
    }else{
        $destinatario = Fornecedor::find($id);
    }
    
    
    $identificacaoXml  = $dados->identificacao ?? null;
    $transportadoraXml = $dados->transportadora ?? null;
    $totalXml          = $dados->total ?? null;
    $volumeXml         = $dados->volume ?? null;
    $veiculoXml        = $dados->veiculo ?? null;
    $reboqueXml        = $dados->reboque ?? null;
    $vagaoBalsaXml     = $dados->vagaoBalsa ?? null;
    $intermediarioXml  = $dados->intermediario ?? null;
    $observacaoXml     = $dados->observacao ?? null;
    
   
    $produtosXml       = $dados->produtos ?? null;
    $identificacaoXml  = $dados->identificacao ?? null;
   
    $empresa            = auth()->user()->empresa;
    $emitente           = Emitente::where("empresa_id", $empresa->id)->first();
  
    //Salvar a NFE
    $nota               = new \stdClass();
    $nota->empresa_id   = $empresa->id;
    $nota->importado    =   "S";
    $nota->status_id    = config('constantes.status.DIGITACAO');
    $nota->natureza_operacao_id = $natureza_operacao->id;
    $nota->cUF          = ConstanteService::getUf($destinatario->uf);
  
    $nota->natOp        = $natureza_operacao->descricao;
    $nota->modelo       = config("constanteNota.mod.NFE");
    $nota->nNF          = $emitente->ultimo_numero_nfe + 1;
    $nota->serie        = $emitente->numero_serie_nfe;
    $nota->cNF          = rand($nota->nNF,99999999);
    $nota->dhEmi        = hoje(). 'T'.date("H:i:s").'-03:00';
    $nota->dhSaiEnt     = hoje(). 'T'.date("H:i:s").'-03:00';
    $nota->tpNF         = ($natureza_operacao->tipo == "S") ? config("constanteNota.tpNf.SAIDA") : config("constanteNota.tpNf.ENTRADA");  //0 - Entrada / 1 - Saida
    
    //Verifica o destino da operação
    if ($emitente->uf != "EX"){
        if($emitente->uf == $destinatario->uf ){
            $nota->idDest = config("constanteNota.idDest.INTERNA");
        }else{
            $nota->idDest = config("constanteNota.idDest.INTERESTADUAL");
        }
    }else{
        $nota->idDest       = config("constanteNota.idDest.INTERESTADUAL");
    }
    
    $nota->cMunFG       = $emitente->ibge;
    $nota->tpImp        = config("constanteNota.tpImp.RETRATO"); //formato do danfe
    $nota->tpEmis       = config("constanteNota.tpEmis.NORMAL") ; //tipo emissão - 1 - normal
    
    $nota->tpAmb        = $emitente->ambiente_nfe;
    $nota->finNFe       = $natureza_operacao->finNFe; //Finalidade emissão 1 - Normal
    
    $nota->indFinal     = 1; // consumidor final
    $nota->indPres      = $natureza_operacao->indPres; //presença do comprador
    $nota->procEmi      = config("constanteNota.procEmi.APLICATIVO_CONTRIBUINTE");
    $nota->verProc      = '3.10.31';
    $nota->dhCont       = null;
    $nota->xJust        = null;
    
    //Dados do emitente
    $nota->em_xNome    = tiraAcento($emitente->razao_social);
    $nota->em_xFant    = tiraAcento($emitente->nome_fantasia);
    $nota->em_IE       = ($emitente->ie) ? tira_mascara($emitente->ie) : null ;
    $nota->em_IEST     = ($emitente->iest) ? tira_mascara($emitente->iest) : null;
    $nota->em_IM       = $emitente->im;
    $nota->em_CNAE     = $emitente->cnae;
    $nota->em_CRT      = $emitente->crt;
    $nota->modFrete    = $identificacaoXml->modFrete ?? '9';
   
    $cnpj  = ($emitente->cnpj) ? tira_mascara($emitente->cnpj) : null;
    if(strlen($cnpj) == 14){
        $nota->em_CNPJ = $cnpj;
    }else{
        $nota->em_CPF = $cnpj;
    }
    
    $nota->em_xLgr     = tiraAcento($emitente->logradouro);
    $nota->em_nro      = $emitente->numero;
    $nota->em_xCpl     = tiraAcento($emitente->complemento);
    $nota->em_xBairro  = tiraAcento($emitente->bairro);
    $nota->em_cMun     = $emitente->ibge;
    $nota->em_xMun     = tiraAcento($emitente->cidade);
    $nota->em_UF       = $emitente->uf;
    $nota->em_CEP      = ($emitente->cep) ? tira_mascara($emitente->cep) : null;
    $nota->em_cPais    = "1058";
    $nota->em_xPais    = "Brasil";
    $nota->em_fone     = ($emitente->fone) ? tira_mascara($emitente->fone): null;
    
    $nota->resp_CNPJ    = $emitente->resp_CNPJ;
    $nota->resp_xContato= $emitente->resp_xContato;
    $nota->resp_email   = $emitente->resp_email;
    $nota->resp_fone    = $emitente->resp_fone;
    $nota->resp_CSRT    = $emitente->resp_CSRT;
    $nota->resp_idCSRT  = $emitente->resp_idCSRT;
    $nota->status_id    = config("constantes.status.DIGITACAO"); 

    
    //$nota->nFat          = $cobranca->fat->nFat ?? '1';
    $nota->vFrete        = ($totalXml->vFrete) ?? null 	;
    $nota->vSeg          = ($totalXml->vSeg) ?? null 	;
    $nota->vNF           = ($totalXml->vNF) ?? null 	;
    $nota->vOrig         = ($totalXml->vOrig) ?? null 	;
    $nota->vLiq          = ($totalXml->vLiq) ?? null 	;
    $nota->vBC           = ($totalXml->vBC) ?? null 	;
    $nota->vICMS         = ($totalXml->vICMS) ?? null 	;
    $nota->vICMSDeson    = ($totalXml->vICMSDeson) ?? null 	;
    $nota->vFCP          = ($totalXml->vFCP) ?? null 	;
    $nota->vBCST         = ($totalXml->vBCST) ?? null 	;
    $nota->vST           = ($totalXml->vST) ?? null 	;
    $nota->vFCPST        = ($totalXml->vFCPST) ?? null 	;
    $nota->vFCPSTRet     = ($totalXml->vFCPSTRet) ?? null 	;
    $nota->vProd         = ($totalXml->vProd) ?? null 	;
    $nota->vFrete        = ($totalXml->vFrete) ?? null 	;
    $nota->vSeg          = ($totalXml->vSeg) ?? null 	;
    $nota->vDesc         = ($totalXml->vDesc) ?? null 	;
    $nota->vII           = ($totalXml->vII) ?? null 	;
    $nota->vIPI          = ($totalXml->vIPI) ?? null 	;
    $nota->vIPIDevol     = ($totalXml->vIPIDevol) ?? null 	;
    $nota->vPIS          = ($totalXml->vPIS) ?? null 	;
    $nota->vCOFINS       = ($totalXml->vCOFINS) ?? null 	;
    $nota->vOutro        = ($totalXml->vOutro) ?? null 	;
    $nota->vNF           = ($totalXml->vNF) ?? null 	;
    $nota->vTotTrib      = ($totalXml->vTotTrib) ?? null 	;
   
    //Transportadora
    $nota->transp_CNPJ        = $transportadoraXml->CNPJ ?? null ;
    $nota->transp_xNome       = $transportadoraXml->xNome ?? null;
    $nota->transp_xEnder      = $transportadoraXml->xEnder ?? null;
    $nota->transp_xMun        = $transportadoraXml->xMun ?? null;
    $nota->transp_UF          = $transportadoraXml->UF ?? null;
    $nota->transp_IE          = $transportadoraXml->IE ?? null;    
    
    //Volume
    $nota->qVol               = $volumeXml->qVol ?? null;
    $nota->esp                = $volumeXml->esp ?? null;
    $nota->marca              = $volumeXml->marca ?? null;
    $nota->pesoL              = $volumeXml->pesoL ?? null;
    $nota->pesoB              = $volumeXml->pesoB ?? null;
    
    //Veículo
    $nota->transp_veic_placa    = $veiculoXml->placa ?? null;
    $nota->transp_veic_UF       = $veiculoXml->UF ?? null;
    $nota->transp_veic_RNTC     = $veiculoXml->RNTC  ?? null;
    
    //Reboque
    $nota->transp_reboque_placa = $reboqueXml->placa ?? null;
    $nota->transp_reboque_UF    = $reboqueXml->UF ?? null;
    $nota->transp_reboque_RNTC  = $reboqueXml->RNTC  ?? null;
    
    //Vagão
    $nota->transp_vagao         = $vagaoBalsaXml->vagao  ?? null;
    $nota->transp_balsa         = $vagaoBalsaXml->balsa  ?? null;
    $nota->nLacre               = $vagaoBalsaXml->nLacre   ?? null;
    
    //$nota->indIntermed          = $intermediario->lacres->nLacre   ?? null;
    $nota->cnpjIntermed         = $intermediarioXml->CNPJ    ?? null;
    $nota->idCadIntTran         = $intermediarioXml->idCadIntTran    ?? null;
    
    $nota->infAdFisco           = $observacaoXml->infAdFisco ?? null;
    $nota->infCpl               = $observacaoXml->infCpl  ?? null;   
    //Referencia
   
    
     $nfe                        =  NotaFiscalOperacaoService::salvarDadosNota($nota, Null);

     $nfe_id = $nfe->id;
    
    
    //Destinatario
    $dest                   = new \stdClass();
    $dest->nfe_id           = $nfe_id;
    $dest->dest_xNome    	= tiraAcento($destinatario->razao_social);
    
    $dest->dest_indIEDest	= $destinatario->tipo_contribuinte;
    $dest->dest_email    	= $destinatario->email;
    $cnpj_cpf               = tira_mascara($destinatario->cnpj);
    
    if(strlen($cnpj_cpf) == 14){
        $dest->dest_CNPJ = $cnpj_cpf;
        $dest->dest_IE   = tira_mascara($destinatario->rg_ie);
    }
    else{
        $dest->dest_CPF  = $cnpj_cpf;
    }
    
    $dest->dest_idEstrangeiro=null;
    $dest->dest_xLgr     	= tiraAcento($destinatario->logradouro);
    $dest->dest_nro      	= $destinatario->numero;
    $dest->dest_xCpl     	= tiraAcento($destinatario->complemento);
    $dest->dest_xBairro  	= tiraAcento($destinatario->bairro);
    $dest->dest_cMun     	= $destinatario->ibge;
    $dest->dest_xMun     	= strtoupper(tiraAcento($destinatario->cidade));
    $dest->dest_UF       	= $destinatario->uf;
    $dest->dest_CEP      	= tira_mascara($destinatario->cep);
    $dest->dest_cPais       = "1058";
    $dest->dest_xPais       = "Brasil";
    $dest->dest_fone     	= ($destinatario->telefone) ? tira_mascara($destinatario->telefone) : null ;
    
 
    $nfeDestinatario         = NfeDestinatario::where("nfe_id", $nfe_id)->first();
    if(!$nfeDestinatario){
        NfeDestinatario::create(objToArray($dest));
    }else{
        $destinatario->update(objToArray($dest));
    } 
    
  
    foreach($produtosXml as $item) {       
        $produto               = new \stdClass();
        $produto->nfe_id       =   $nfe_id;
        $produto->importado    =   "S";
        $produto->sku		   = $item->produto->cProd;
       // $nfe->fornecedor_id   = $fornecedor_id;
        $produto->numero_item  = $item->produto->item ?? null;
        $produto->cProd        = $item->produto->cProd;
        $produto->xProd		   = str_replace("'", "", $item->produto->xProd);
        $produto->cEAN		   = ($item->produto->cEAN) ?? null;
        $produto->cBarra	   = ($item->produto->cBarra) ?? null;
        $produto->xProd		   = $item->produto->xProd;
        $produto->NCM		   = $item->produto->NCM;
        $produto->cBenef	   = ($item->produto->cBenef) ?? null;
        $produto->EXTIPI	   = ($item->produto->EXTIPI) ?? null;        
        $produto->uCom		   = $item->produto->uCom;
        $produto->qCom		   = $item->produto->qCom;
        $produto->vUnCom	   = $item->produto->vUnCom;
        $produto->vProd		   = $item->produto->vProd;
        $produto->cEANTrib	   = ($item->produto->cEANTrib) ?? null;
        $produto->cBarraTrib   = ($item->produto->cBarraTrib) ?? null;
        $produto->uTrib		   = $item->produto->uTrib;
        $produto->qTrib		   = $item->produto->qTrib;
        $produto->vUnTrib	   = $item->produto->vUnTrib;
        $produto->vFrete	   = ($item->produto->vFrete) ? $item->produto->vFrete : 0;
        $produto->vSeg		   = ($item->produto->vSeg) ? $item->produto->vSeg : 0;
        $produto->vDesc		   = ($item->produto->vDesc) ? $item->produto->vDesc : 0;
        $produto->vOutro	   = ($item->produto->vOutro) ? $item->produto->vOutro : 0;
        $produto->indTot	   = ($item->produto->indTot) ?? null;
        $produto->xPed		   = ($item->produto->xPed) ?? null;
        $produto->nItemPed	   = ($item->produto->nItemPed) ?? null;
        $produto->nFCI		   = ($item->produto->nFCI) ?? null;
     
        $produto->desconto_item         = 0;
        $produto->desconto_por_unidade  = 0;
        $produto->total_desconto_item   = 0;
        $produto->desconto_percentual   = 0;
        $produto->desconto_por_valor    = 0;
        $produto->subtotal_liquido      = $item->produto->vProd;
        
        
        
        $produto->tipo_produto_id = config("constantes.tipo_produto.PRODUTO");
        $temProduto = Produto::where(["ncm" =>$produto->NCM, "referencia" =>$produto->cProd ])->first();
        if($temProduto){
               $produto->produto_id = $temProduto->id;
               
               //verificar a CFOP
              
               $tributaProduto = TributacaoProduto::where(["natureza_operacao_id"=>$nfe->natureza_operacao_id,"produto_id"=>$temProduto->id])->first();
               
               if($tributaProduto){
                   $tributacao =  $tributaProduto->tributacao;
               }else{
                   $tributacao = $tributacao_geral;
               }
               
               $produto->CFOP          = ItemNotafiscalService::buscaCfop($nfe, $tributacao);
        }        
        
      
        //Icms        
        $produto->orig          = $item->icms->orig ?? null;
        $produto->cstICMS       = $item->icms->cstICMS ?? null;
        $produto->modBC         = $item->icms->modBC ?? null;
        $produto->vBCICMS       = $item->icms->vBCICMS ?? null;
        $produto->pICMS         = $item->icms->pICMS ?? null;
        $produto->vICMS         = $item->icms->vICMS ?? null;
        $produto->pFCP          = $item->icms->pFCP ?? null;
        $produto->vFCP          = $item->icms->vFCP ?? null;
        $produto->vBCFCP        = $item->icms->vBCFCP ?? null;
        $produto->modBCST       = $item->icms->modBCST ?? null;
        $produto->pMVAST        = $item->icms->pMVAST ?? null;
        $produto->pRedBCST      = $item->icms->pRedBCST ?? null;
        $produto->vBCST         = $item->icms->vBCST ?? null;
        $produto->pICMSST       = $item->icms->pICMSST ?? null;
        $produto->vICMSST       = $item->icms->vICMSST ?? null;
        $produto->vBCFCPST      = $item->icms->vBCFCPST ?? null;
        $produto->pFCPST        = $item->icms->pFCPST ?? null;
        $produto->vFCPST        = $item->icms->vFCPST ?? null;
        $produto->vICMSDeson    = $item->icms->vICMSDeson ?? null;
        $produto->motDesICMS    = $item->icms->motDesICMS ?? null;
        $produto->pRedBC        = $item->icms->pRedBC ?? null;
        $produto->vICMSOp       = $item->icms->vICMSOp ?? null;
        $produto->pDif          = $item->icms->pDif ?? null;
        $produto->vICMSDif      = $item->icms->vICMSDif ?? null;
        $produto->vBCSTRet      = $item->icms->vBCSTRet ?? null;
        $produto->pST           = $item->icms->pST ?? null;
        $produto->vICMSSTRet    = $item->icms->vICMSSTRet ?? null;
        $produto->vBCFCPSTRet   = $item->icms->vBCFCPSTRet ?? null;
        $produto->pFCPSTRet     = $item->icms->pFCPSTRet ?? null;
        $produto->vFCPSTRet     = $item->icms->vFCPSTRet ?? null;
        $produto->pRedBCEfet    = $item->icms->pRedBCEfet ?? null;
        $produto->vBCEfet       = $item->icms->vBCEfet ?? null;
        $produto->pICMSEfet     = $item->icms->pICMSEfet ?? null;
        $produto->vICMSEfet     = $item->icms->vICMSEfet ?? null;
        $produto->vICMSSubstituto = $item->icms->vICMSSubstituto ?? null;
        $produto->vICMSSTDeson  = $item->icms->vICMSSTDeson ?? null;
        $produto->motDesICMSST  = $item->icms->motDesICMSST ?? null;
        $produto->pFCPDif       = $item->icms->pFCPDif ?? null;
        $produto->vFCPDif       = $item->icms->vFCPDif ?? null;
        $produto->vFCPEfet      = $item->icms->vFCPEfet ?? null;        
        
       
        
        //IPI
        $produto->clEnq         = $item->ipi->clEnq ?? null; 
        $produto->CNPJProd      = $item->ipi->CNPJProd ?? null; 
        $produto->cSelo         = $item->ipi->cSelo ?? null; 
        $produto->qSelo         = $item->ipi->qSelo ?? null; 
        $produto->cEnq          = $item->ipi->cEnq ?? null; 
        $produto->cstIPI        = $item->ipi->cstIPI ?? null; 
        $produto->vIPI          = $item->ipi->vIPI ?? null; 
        $produto->vBCIPI        = $item->ipi->vBCIPI ?? null; 
        $produto->pIPI          = $item->ipi->pIPI ?? null; 
        $produto->qUnidIPI      = $item->ipi->qUnid ?? null; 
        $produto->vUnidIPI      = $item->ipi->vUnid ?? null; 
        
        
        $produto->cstPIS        = $item->pis->cstPIS ?? null;
        $produto->vBCPIS        = $item->pis->vBCPIS ?? null;
        $produto->pPIS          = $item->pis->pPIS ?? null;
        $produto->vPIS          = $item->pis->vPIS ?? null;
        $produto->qBCProdPis    = $item->pis->qBCProd ?? null;
        $produto->vAliqProd_pis = $item->pis->vAliqProd ?? null;
        
        $produto->cstCOFINS     = $item->cofins->cstCOFINS ?? null;
        $produto->vBCCOFINS     = $item->cofins->vBCCOFINS ?? null;
        $produto->pCOFINS       = $item->cofins->pCOFINS ?? null;
        $produto->vCOFINS       = $item->cofins->vCOFINS ?? null;
        $produto->qBCProdConfis = $item->cofins->qBCProd ?? null;
        $produto->vAliqProd_cofins = $item->cofins->vAliqProd ?? null;        
       
       // i(objToArray($produto));
        $item = NfeItem::Create(objToArray($produto)); 
        
    }
    
    //Referencia
    if($nota->finNFe==config("constanteNota.finNFe.DEVOLUCAO")){
        NfeReferenciado::Create(["nfe_id"=>$nfe_id,"ref_NFe"=>$identificacaoXml->chave, "tipo_nota_referenciada" => 1]);
    }    
    return $nfe_id;
    
}

function salvarNfeEntradaPeloXml($dados, $fornecedor_id, $transportadora_id){
    $identificacao     = $dados->identificacao ?? null;
    $total             = $dados->total ?? null;
    $produtos          = $dados->produtos ?? null;
    $duplicatas        = $dados->duplicatas ?? null;
    $observacaoXml     = $dados->observacao ?? null;
   
   
    $nf             = null;
    $nfe            = new \stdClass();
    $nfe->fornecedor_id= $fornecedor_id;
    $nfe->transportadora_id= $transportadora_id;
    $nfe->data_cadastro  = hoje();
    $nfe->cUF       = $identificacao->cUF;
    $nfe->chave     = $identificacao->chave;
    $nfe->cNF       = $identificacao->cNF;
    $nfe->natOp     = $identificacao->natOp;
    $nfe->modelo	= $identificacao->modelo;
    $nfe->serie 	= $identificacao->serie 		;
    $nfe->nNF 		= $identificacao->nNF 			;
    $nfe->dhEmi 	= $identificacao->dhEmi 		;
    $nfe->dhSaiEnt 	= $identificacao->dhSaiEnt 		;
    $nfe->tpNF 		= $identificacao->tpNF 			;
    $nfe->idDest 	= $identificacao->idDest 		;
    $nfe->cMunFG 	= $identificacao->cMunFG 		;
    $nfe->tpImp 	= $identificacao->tpImp 		;
    $nfe->tpEmis 	= $identificacao->tpEmis 		;
    $nfe->cDV 		= $identificacao->cDV 			;
    $nfe->tpAmb 	= $identificacao->tpAmb 		;
    $nfe->finNFe 	= $identificacao->finNFe 		;
    $nfe->indFinal 	= $identificacao->indFinal 		;
    $nfe->indPres 	= $identificacao->indPres 		;
    $nfe->indIntermed = $identificacao->indIntermed ;
    $nfe->procEmi 	= $identificacao->procEmi 		;
    $nfe->verProc 	= $identificacao->verProc 		;
    $nfe->dhCont 	= ($identificacao->dhCont) ?? null 		;
    $nfe->xJust 	= ($identificacao->xJust) ?? null 		;
    $nfe->vProd     = ($total->vProd) ?? null 	;
    
    $nfe->tPag 	    = $dados->tPag ?? null; 		;
    
    
    $nfe->vFrete        = ($total->vFrete) ?? null 	;
    $nfe->vOrig         = ($total->vOrig) ?? null 	;
    $nfe->vLiq          = ($total->vLiq) ?? null 	;
    $nfe->vBC           = ($total->vBC) ?? null 	;
    $nfe->vICMS         = ($total->vICMS) ?? null 	;
    $nfe->vICMSDeson    = ($total->vICMSDeson) ?? null 	;
    $nfe->vFCP          = ($total->vFCP) ?? null 	;
    $nfe->vBCST         = ($total->vBCST) ?? null 	;
    $nfe->vST           = ($total->vST) ?? null 	;
    $nfe->vFCPST        = ($total->vFCPST) ?? null 	;
    $nfe->vFCPSTRet     = ($total->vFCPSTRet) ?? null 	;
    $nfe->vProd         = ($total->vProd) ?? null 	;
    $nfe->vFrete        = ($total->vFrete) ?? null 	;
    $nfe->vSeg          = ($total->vSeg) ?? null 	;
    $nfe->vDesc         = ($total->vDesc) ?? null 	;
    $nfe->vII           = ($total->vII) ?? null 	;
    $nfe->vIPI          = ($total->vIPI) ?? null 	;
    $nfe->vIPIDevol     = ($total->vIPIDevol) ?? null 	;
    $nfe->vPIS          = ($total->vPIS) ?? null 	;
    $nfe->vCOFINS       = ($total->vCOFINS) ?? null 	;
    $nfe->vOutro        = ($total->vOutro) ?? null 	;
    $nfe->vNF           = ($total->vNF) ?? null 	;
    $nfe->vTotTrib      = ($total->vTotTrib) ?? null 	;
    
    $nfe->infAdFisco           = $observacaoXml->infAdFisco ?? null;
    $nfe->infCpl               = $observacaoXml->infCpl  ?? null; 
    
    $temNfe         = NfeEntrada::where("chave", $nfe->chave)->first();
    if(!$temNfe){
        $nfe->status_id = config("constantes.status.DIGITACAO");
        $nf = NfeEntrada::Create(objToArray($nfe));
    }
    
    if($nf){
        //Itens
        foreach($produtos as $item) {
           
            $produto            = new \stdClass();
            $produto->nfe_id    =   $nf->id;
            $produto->fornecedor_id= $fornecedor_id;
            $produto->cProd     =   $item->produto->cProd;
            $produto->xProd		=	str_replace("'", "", $item->produto->xProd);
            $produto->cEAN		=	($item->produto->cEAN) ?? null;
            $produto->cBarra	=	($item->produto->cBarra) ?? null;
            $produto->xProd		=	$item->produto->xProd;
            $produto->NCM		=	$item->produto->NCM;
            $produto->cBenef	=	($item->produto->cBenef) ?? null;
            $produto->EXTIPI	=	($item->produto->EXTIPI) ?? null;
            $produto->CFOP		=	$item->produto->CFOP;
            $produto->CEST		=	$item->produto->CEST;
            $produto->uCom		=	$item->produto->uCom;
            $produto->qCom		=	$item->produto->qCom;
            $produto->vUnCom	=	$item->produto->vUnCom;
            $produto->vProd		=	$item->produto->vProd;
            $produto->cEANTrib	=	($item->produto->cEANTrib) ?? null;
            $produto->cBarraTrib=	($item->produto->cBarraTrib) ?? null;
            $produto->uTrib		=	$item->produto->uTrib;
            $produto->qTrib		=	$item->produto->qTrib;
            $produto->vUnTrib	=	$item->produto->vUnTrib;
            $produto->vFrete	=	($item->produto->vFrete) ? $item->produto->vFrete : 0;
            $produto->vSeg		=	($item->produto->vSeg) ? $item->produto->vSeg : 0;
            $produto->vDesc		=	($item->produto->vDesc) ? $item->produto->vDesc : 0;
            $produto->vOutro	=	($item->produto->vOutro) ? $item->produto->vOutro : 0;
            $produto->indTot	=	($item->produto->indTot) ?? null;
            $produto->xPed		=	($item->produto->xPed) ?? null;
            $produto->nItemPed	=	($item->produto->nItemPed) ?? null;
            $produto->nFCI		=	($item->produto->nFCI) ?? null;
            $produto->orig      = $item->icms->orig ?? 0;
            
            $produto->fragmentacao_qtde		=	 null;
            $produto->fragmentacao_unidade	=	 null;
            $produto->fragmentacao_valor	=	 null;
            
            
            //Icms
            $produto->orig          = $item->icms->orig ?? null;
            $produto->cstICMS       = $item->icms->cstICMS ?? null;
            $produto->modBC         = $item->icms->modBC ?? null;
            $produto->vBCICMS       = $item->icms->vBCICMS ?? null;
            $produto->pICMS         = $item->icms->pICMS ?? null;
            $produto->vICMS         = $item->icms->vICMS ?? null;
            $produto->pFCP          = $item->icms->pFCP ?? null;
            $produto->vFCP          = $item->icms->vFCP ?? null;
            $produto->vBCFCP        = $item->icms->vBCFCP ?? null;
            $produto->modBCST       = $item->icms->modBCST ?? null;
            $produto->pMVAST        = $item->icms->pMVAST ?? null;
            $produto->pRedBCST      = $item->icms->pRedBCST ?? null;
            $produto->vBCST         = $item->icms->vBCST ?? null;
            $produto->pICMSST       = $item->icms->pICMSST ?? null;
            $produto->vICMSST       = $item->icms->vICMSST ?? null;
            $produto->vBCFCPST      = $item->icms->vBCFCPST ?? null;
            $produto->pFCPST        = $item->icms->pFCPST ?? null;
            $produto->vFCPST        = $item->icms->vFCPST ?? null;
            $produto->vICMSDeson    = $item->icms->vICMSDeson ?? null;
            $produto->motDesICMS    = $item->icms->motDesICMS ?? null;
            $produto->pRedBC        = $item->icms->pRedBC ?? null;
            $produto->vICMSOp       = $item->icms->vICMSOp ?? null;
            $produto->pDif          = $item->icms->pDif ?? null;
            $produto->vICMSDif      = $item->icms->vICMSDif ?? null;
            $produto->vBCSTRet      = $item->icms->vBCSTRet ?? null;
            $produto->pST           = $item->icms->pST ?? null;
            $produto->vICMSSTRet    = $item->icms->vICMSSTRet ?? null;
            $produto->vBCFCPSTRet   = $item->icms->vBCFCPSTRet ?? null;
            $produto->pFCPSTRet     = $item->icms->pFCPSTRet ?? null;
            $produto->vFCPSTRet     = $item->icms->vFCPSTRet ?? null;
            $produto->pRedBCEfet    = $item->icms->pRedBCEfet ?? null;
            $produto->vBCEfet       = $item->icms->vBCEfet ?? null;
            $produto->pICMSEfet     = $item->icms->pICMSEfet ?? null;
            $produto->vICMSEfet     = $item->icms->vICMSEfet ?? null;
            $produto->vICMSSubstituto = $item->icms->vICMSSubstituto ?? null;
            $produto->vICMSSTDeson  = $item->icms->vICMSSTDeson ?? null;
            $produto->motDesICMSST  = $item->icms->motDesICMSST ?? null;
            $produto->pFCPDif       = $item->icms->pFCPDif ?? null;
            $produto->vFCPDif       = $item->icms->vFCPDif ?? null;
            $produto->vFCPEfet      = $item->icms->vFCPEfet ?? null;
            
            
            
            //IPI
            $produto->clEnq         = $item->ipi->clEnq ?? null;
            $produto->CNPJProd      = $item->ipi->CNPJProd ?? null;
            $produto->cSelo         = $item->ipi->cSelo ?? null;
            $produto->qSelo         = $item->ipi->qSelo ?? null;
            $produto->cEnq          = $item->ipi->cEnq ?? null;
            $produto->cstIPI        = $item->ipi->cstIPI ?? null;
            $produto->vIPI          = $item->ipi->vIPI ?? null;
            $produto->vBCIPI        = $item->ipi->vBCIPI ?? null;
            $produto->pIPI          = $item->ipi->pIPI ?? null;
            $produto->qUnidIPI      = $item->ipi->qUnid ?? null;
            $produto->vUnidIPI      = $item->ipi->vUnid ?? null;
            
            
            $produto->cstPIS        = $item->pis->cstPIS ?? null;
            $produto->vBCPIS        = $item->pis->vBCPIS ?? null;
            $produto->pPIS          = $item->pis->pPIS ?? null;
            $produto->vPIS          = $item->pis->vPIS ?? null;
            $produto->qBCProdPis    = $item->pis->qBCProd ?? null;
            $produto->vAliqProd_pis = $item->pis->vAliqProd ?? null;
            
            $produto->cstCOFINS     = $item->cofins->cstCOFINS ?? null;
            $produto->vBCCOFINS     = $item->cofins->vBCCOFINS ?? null;
            $produto->pCOFINS       = $item->cofins->pCOFINS ?? null;
            $produto->vCOFINS       = $item->cofins->vCOFINS ?? null;
            $produto->qBCProdConfis = $item->cofins->qBCProd ?? null;
            $produto->vAliqProd_cofins = $item->cofins->vAliqProd ?? null; 
            
            $temFornecedor = null;
            if($nfe->fornecedor_id){
                
                if($produto->cProd!="" && $produto->cProd!=NULL && $produto->cEAN != "SEM GTIN" && $produto->cEAN != "" && $produto->cEAN != NULL){
                    $temFornecedor = ProdutoFornecedor::where(["cProd" => $produto->cProd, "fornecedor_id" =>$nfe->fornecedor_id ])->first();
                }
                
                if(!$temFornecedor){
                    if($produto->cProd!="" && $produto->cProd!=NULL){
                        $temFornecedor = ProdutoFornecedor::where(["cProd" => $produto->cProd, "fornecedor_id" =>$nfe->fornecedor_id ])->first();
                    }
                }
                
                if(!$temFornecedor){
                    if($produto->cEAN != "SEM GTIN" && $produto->cEAN != "" && $produto->cEAN != NULL ){
                        $temFornecedor = ProdutoFornecedor::where(["codigo_barra" => $produto->cEAN, "fornecedor_id" =>$nfe->fornecedor_id ])->first();
                    }
                }
                
                if($temFornecedor){
                    $produto->unidade       = $produto->uCom;
                    $produto->produto_id    = $temFornecedor->produto_id;
                }
            }                          
           
            NfeEntradaItem::Create(objToArray($produto));
        }
    }
    
    //Duplicatas
    if(count($duplicatas) > 0){
        foreach ($duplicatas as $dup){
            $duplicata          = new \stdClass();
            $duplicata->nfe_id  = $nf->id;
            $duplicata->nDup    = ($dup->nDup) ?? null;
            $duplicata->dVenc   = ($dup->dVenc) ?? null;
            $duplicata->vDup    = ($dup->vDup) ?? null;
            NfeEntradaDuplicata::Create(objToArray($duplicata));
            
        }
    }
   
}

function cadastrarProdutoDoXml($dados, $tipo){
    
    if($tipo=="nfe"){
        $nfeItem            = NfeItem::find($dados->nfe_item_id);       
        $nfe                = Nfe::find($nfeItem->nfe_id);       
        $natureza_operacao  = NaturezaOperacao::find($nfe->natureza_operacao_id);
        $tributacao_geral   = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
        $origem             = $nfeItem->orig;
        $sku                = null;
        
    }else{
        $nfeItem                        = NfeEntradaItem::find($dados->nfe_item_id); 
        $nfeItem->unidade               = $dados->unidade;
        $nfeItem->categoria_id          = $dados->categoria_id;
        $nfeItem->subcategoria_id       = $dados->subcategoria_id;
        $nfeItem->subsubcategoria_id    = $dados->subsubcategoria_id;
        $nfeItem->valor_venda	        = $dados->valor_venda ? $dados->valor_venda : null;
        $sku                            = $dados->sku ?? null ;
        $origem                         = $nfeItem->origem;
    }
           
    $prod                       = new \stdClass();
    $prod->nome			        = $nfeItem->xProd;
    $prod->sku			        = $sku ? $sku : $nfeItem->cProd;
    $prod->categoria_id	        = $dados->categoria_id ?? null ;
    $prod->subcategoria_id      = $dados->subcategoria_id ?? null ;
    $prod->subsubcategoria_id   = $dados->subsubcategoria_id ?? null ;
    $prod->unidade		        = $dados->unidade;
    $prod->status_id	        = config("constantes.status.ATIVO");
    $prod->valor_venda	        = $dados->valor_venda;   
    $prod->valor_custo	        = $nfeItem->vUnCom;
    $prod->margem_lucro	        = $dados->margem_lucro ?? 0;
    $prod->ncm			        = $nfeItem->NCM;
    $prod->codigo_barra	        = ($nfeItem->cEAN !="SEM GTIN") ? $nfeItem->cEAN : null;
    $prod->referencia	        = $nfeItem->cProd;
    $prod->CEST	                = $nfeItem->CEST;
    
    $prod->origem	            = $origem;
    $prod->controlar_estoque    = "S";
    
    $prod->estoque_minimo       = $dados->estoque_minimo ?? 5;
    $prod->estoque_maximo       = $dados->estoque_maximo ?? 100;
    $prod->estoque_inicial      = $dados->estoque_inicial ?? 0;
    
    $prod->produto_loja 	    = "N";
    $prod->descricao 		    = "";
    $prod->destaque 		    = "N";
    $prod->usa_grade 		    = "N";
    
    $prod->tipo_produto_id = config("constantes.tipo_produto.PRODUTO");    
    
    
    $produto = Produto::Create(objToArray($prod));    
    if($nfeItem->fornecedor_id){
        if($nfeItem->cProd!="" && $nfeItem->cProd!=NULL){
            $temFornecedor = ProdutoFornecedor::where(["produto_id" => $produto->id, "cProd" => $nfeItem->cProd, "fornecedor_id" =>$nfeItem->fornecedor_id ])->first();
        }
        
        if(!$temFornecedor){
            if($nfeItem->cEAN != "SEM GTIN" && $nfeItem->cEAN != "" && $nfeItem->cEAN != NULL ){
                $temFornecedor = ProdutoFornecedor::where(["produto_id" => $produto->id, "codigo_barra" => $nfeItem->cEAN, "fornecedor_id" =>$nfeItem->fornecedor_id ])->first();
            }
        }
        
        if(!$temFornecedor){
            $forn = new \stdClass();
            $forn->fornecedor_id= $nfeItem->fornecedor_id;
            $forn->produto_id   = $produto->id;
            $forn->codigo_barra = $nfeItem->cEAN;
            $forn->cProd        = $nfeItem->cProd;            
            ProdutoFornecedor::Create(objToArray($forn));
            
        }
    }
    
    
    if($tipo=="nfe"){
        $tributaProduto = TributacaoProduto::where(["natureza_operacao_id"=>$natureza_operacao->id,"produto_id"=>$produto->id])->first();        
        if($tributaProduto){
            $tributacao =  $tributaProduto->tributacao;
        }else{
            $tributacao = $tributacao_geral;
        }        
        $nfeItem->CFOP          = ItemNotafiscalService::buscaCfop($nfe, $tributacao);
    }
    $nfeItem->produto_id = $produto->id;
    $nfeItem->save();
   
    
}
