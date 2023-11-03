<?php
namespace App\Service;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Emitente;
use App\Models\Fornecedor;
use App\Models\NaturezaOperacao;
use App\Models\Nfe;
use App\Models\NfeDestinatario;
use App\Models\NfeDuplicata;
use App\Models\NfeDuplicataTemp;
use App\Models\NfeItem;
use App\Models\NfeItemTemp;
use App\Models\NfeTemp;
use App\Models\NfeTransporte;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Models\Tributacao;
use App\Models\TributacaoProduto;
use App\Models\NfeAutorizado;

class NotaFiscalOperacaoService{  
    public static function criarNotaNova($nota){
        $emitente           = Emitente::where("empresa_id", $nota->empresa_id)->first();
        $cliente            = Cliente::find($nota->cliente_id);
        $natureza_operacao  = NaturezaOperacao::where("id", $nota->natureza_operacao_id)->first();
        $nota->cUF          = ConstanteService::getUf($cliente->uf);
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
            if($emitente->uf == $cliente->uf ){
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
        
        $nota->indFinal     = $cliente->indFinal; // consumidor final
        $nota->indPres      = $natureza_operacao->indPres; //presença do comprador
        $nota->procEmi      = config("constanteNota.procEmi.APLICATIVO_CONTRIBUINTE");      
        $nota->verProc      = '3.10.31';
        $nota->dhCont       = null;
        $nota->xJust        = null;
        
        $nota->em_xNome    = tiraAcento($emitente->razao_social);
        $nota->em_xFant    = tiraAcento($emitente->nome_fantasia);
        $nota->em_IE       = ($emitente->ie) ? tira_mascara($emitente->ie) : null ;
        $nota->em_IEST     = ($emitente->iest) ? tira_mascara($emitente->iest) : null;
        $nota->em_IM       = $emitente->im;
        $nota->em_CNAE     = $emitente->cnae;
        $nota->em_CRT      = $emitente->crt;
        
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
        
        //Responsavel técnioco
        $nota->resp_CNPJ    = $emitente->resp_CNPJ;
        $nota->resp_xContato= $emitente->resp_xContato;
        $nota->resp_email   = $emitente->resp_email;
        $nota->resp_fone    = $emitente->resp_fone;
        $nota->resp_CSRT    = $emitente->resp_CSRT;
        $nota->resp_idCSRT  = $emitente->resp_idCSRT;
        $nota->status_id    = config("constantes.status.DIGITACAO");
        
        
        $nota->infAdFisco   = $emitente->infAdFisco;        
        $nota->infcpl       = $emitente->infcpl;
        
        $nota->vProd        = 0.00;
        $nota->vNF          = 0.00;
        $nota->nFat         = 1;
        $nota->vOrig        = 0.00;
        $nota->vDesc        = 0.00;
        $nota->vLiq         = 0.00;
        return self::salvarDadosNota($nota, null);
    }
    
    
    
    public static function setarDadosNota($dados){
        $nota = new \stdClass();
        if(($dados->venda_id ?? null) != null){
            $nota->venda_id	= $dados->venda_id;
        }
        
        if(($dados->compra_id ?? null) != null){
            $nota->compra_id= $dados->compra_id;
        }
        
        if(($dados->importado ?? null) != null){
            $nota->importado= $dados->importado;
        }
        
        if(($dados->nota_referencia_id ?? null) != null){
            $nota->nota_referencia_id= $dados->nota_referencia_id;
        }
        
        if(($dados->status_id ?? null) != null){
            $nota->status_id= $dados->status_id;
        }
        
        if(($dados->natureza_operacao_id ?? null) != null){
            $nota->natureza_operacao_id= $dados->natureza_operacao_id;
        }
        
        if(($dados->chave ?? null) != null){
            $nota->chave= $dados->chave;
        }
        
        if((($dados->procEmi ?? null ) != null) || $dados->procEmi ==0){
            $nota->procEmi= $dados->procEmi;
        }
        
        if(($dados->recibo ?? null) != null){
            $nota->recibo= $dados->recibo;
        }
        
        if(($dados->protocolo ?? null) != null){
            $nota->protocolo= $dados->protocolo;
        }
        
        if(($dados->cUF ?? null) != null){
            $nota->cUF= $dados->cUF;
        }
        
        if(($dados->cNF ?? null) != null){
            $nota->cNF= $dados->cNF;
        }
        
        if(($dados->natOp ?? null) != null){
            $nota->natOp= $dados->natOp;
        }
        
        if(($dados->modelo ?? null) != null){
            $nota->modelo= $dados->modelo;
        }
        
        if(($dados->serie ?? null) != null){
            $nota->serie= $dados->serie;
        }
        
        if(($dados->nNF ?? null) != null){
            $nota->nNF= $dados->nNF;
        }
        
        if(($dados->sequencia_cce ?? null) != null){
            $nota->sequencia_cce= $dados->sequencia_cce;
        }
         if(($dados->dhEmi ?? null) != null){
                $nota->dhEmi= $dados->dhEmi;
            }
            
            if(($dados->dhSaiEnt ?? null) != null){
                $nota->dhSaiEnt= $dados->dhSaiEnt;
            }
            
            if((($dados->tpNF ?? null ) != null) || $dados->tpNF ==0){
                $nota->tpNF= $dados->tpNF;
            }
            
            if(($dados->idDest ?? null) != null){
                $nota->idDest= $dados->idDest;
            }
            
            if(($dados->cMunFG ?? null) != null){
                $nota->cMunFG= $dados->cMunFG;
            }
            
            if(($dados->tpImp ?? null) != null){
                $nota->tpImp= $dados->tpImp;
            }
            
            if(($dados->tpEmis ?? null) != null){
                $nota->tpEmis= $dados->tpEmis;
            }
            
            if(($dados->tpAmb ?? null) != null){
                $nota->tpAmb= $dados->tpAmb;
            }
            
            if(($dados->finNFe ?? null) != null){
                $nota->finNFe= $dados->finNFe;
            }
            
            if((($dados->indFinal ?? null ) != null) || $dados->indFinal ==0){
                $nota->indFinal= $dados->indFinal;
            }
            
            if(($dados->indPres ?? null) != null){
                $nota->indPres= $dados->indPres;
            }
            
            if(($dados->indIntermed ?? null) != null){
                $nota->indIntermed= $dados->indIntermed;
            }
            
            if(($dados->cnpjIntermed ?? null) != null){
                $nota->cnpjIntermed= $dados->cnpjIntermed;
            }
            
            if(($dados->idCadIntTran ?? null) != null){
                $nota->idCadIntTran= $dados->idCadIntTran;
            }
            
            if(($dados->tipo_nota_referenciada ?? null) != null){
                $nota->tipo_nota_referenciada= $dados->tipo_nota_referenciada;
            }
            
            if(($dados->ref_NFe ?? null) != null){
                $nota->ref_NFe= $dados->ref_NFe;
            }
            
            if(($dados->ref_ano_mes ?? null) != null){
                $nota->ref_ano_mes= $dados->ref_ano_mes;
            }
            
            if(($dados->ref_num_nf ?? null) != null){
                $nota->ref_num_nf= $dados->ref_num_nf;
            }
            
            if(($dados->ref_serie ?? null) != null){
                $nota->ref_serie= $dados->ref_serie;
            }
            
            if(($dados->procEmi ?? null) != null){
                $nota->procEmi= $dados->procEmi;
            }
            
            if(($dados->verProc ?? null) != null){
                $nota->verProc= $dados->verProc;
            }
            
            
            if(($dados->dhCont ?? null) != null){
                $nota->dhCont= $dados->dhCont;
            }
            
            if(($dados->xJust ?? null) != null){
                $nota->xJust= $dados->xJust;
            }
            
            if(($dados->em_xNome ?? null) != null){
                $nota->em_xNome= $dados->em_xNome;
            }
            
            if(($dados->em_xFant ?? null) != null){
                $nota->em_xFant= $dados->em_xFant;
            }
            
            if(($dados->em_IE ?? null) != null){
                $nota->em_IE= $dados->em_IE;
            }
            
            if(($dados->em_IEST ?? null) != null){
                $nota->em_IEST= $dados->em_IEST;
            }
            
            if(($dados->em_IM ?? null) != null){
                $nota->em_IM= $dados->em_IM;
            }
            
            if(($dados->em_CNAE ?? null) != null){
                $nota->em_CNAE= $dados->em_CNAE;
            }
            
            if(($dados->em_CRT ?? null) != null){
                $nota->em_CRT= $dados->em_CRT;
            }
            
            if(($dados->em_CNPJ ?? null) != null){
                $nota->em_CNPJ= $dados->em_CNPJ;
            }
            
            if(($dados->em_xLgr ?? null) != null){
                $nota->em_xLgr= $dados->em_xLgr;
            }
            
            if(($dados->em_nro ?? null) != null){
                $nota->em_nro= $dados->em_nro;
            }
            
            if(($dados->em_xCpl ?? null) != null){
                $nota->em_xCpl= $dados->em_xCpl;
            }
            
            if(($dados->em_xBairro ?? null) != null){
                $nota->em_xBairro= $dados->em_xBairro;
            }
            
            if(($dados->em_cMun ?? null) != null){
                $nota->em_cMun= $dados->em_cMun;
            }
            
            if(($dados->em_xMun ?? null) != null){
                $nota->em_xMun= $dados->em_xMun;
            }
            
            if(($dados->em_UF ?? null) != null){
                $nota->em_UF= $dados->em_UF;
            }
            
            if(($dados->em_CEP ?? null) != null){
                $nota->em_CEP= $dados->em_CEP;
            }
            
            if(($dados->em_cPais ?? null) != null){
                $nota->em_cPais= $dados->em_cPais;
            }
            
            if(($dados->em_xPais ?? null) != null){
                $nota->em_xPais= $dados->em_xPais;
            }
            
            if(($dados->em_fone ?? null) != null){
                $nota->em_fone= $dados->em_fone;
            }
            
            if(($dados->em_EMAIL ?? null) != null){
                $nota->em_EMAIL= $dados->em_EMAIL;
            }
            
            if(($dados->em_SUFRAMA ?? null) != null){
                $nota->em_SUFRAMA= $dados->em_SUFRAMA;
            }           
            
            
            if(($dados->vBC ?? null) != null){
                $nota->vBC = ($dados->vBC) ? getFloat($dados->vBC) : null;
            }
            
            if(($dados->vICMS ?? null) != null){
                $nota->vICMS= $dados->vICMS ? getFloat($dados->vICMS) : null;
            }
            
            if(($dados->vICMSDeson ?? null) != null){
                $nota->vICMSDeson= $dados->vICMSDeson ? getFloat($dados->vICMSDeson) : null;
            }
            
            if(($dados->vFCP ?? null) != null){
                $nota->vFCP= $dados->vFCP ? getFloat($dados->vFCP) : null;
            }
            
            if(($dados->vBCST ?? null) != null){
                $nota->vBCST= $dados->vBCST ? getFloat($dados->vBCST) : null;
            }
            
            if(($dados->vST ?? null) != null){
                $nota->vST= $dados->vST ? getFloat($dados->vST) : null;
            }
            
            if(($dados->vFCPST ?? null) != null){
                $nota->vFCPST= $dados->vFCPST ? getFloat($dados->vFCPST) : null;
            }
            
            if(($dados->vFCPSTRet ?? null) != null){
                $nota->vFCPSTRet= $dados->vFCPSTRet ? getFloat($dados->vFCPSTRet) : null;
            }
            
            if(($dados->vProd ?? null) != null){
                $nota->vProd= $dados->vProd ? getFloat($dados->vProd) : null;
            }
            
            if(($dados->vFrete ?? null) != null){
                $nota->vFrete= $dados->vFrete ? getFloat($dados->vFrete) : null;
            }
            
            if(($dados->vSeg ?? null) != null){
                $nota->vSeg= $dados->vSeg ? getFloat($dados->vSeg) : null;
            }
            
            if(($dados->desconto_nota ?? null) != null){
                $nota->desconto_nota= $dados->desconto_nota ? getFloat($dados->desconto_nota) : null;
            }
            
            if(($dados->vDesc ?? null) != null){
                $nota->vDesc= $dados->vDesc ? getFloat($dados->vDesc) : null;
            }
            
            if(($dados->vII ?? null) != null){
                $nota->vII= $dados->vII ? getFloat($dados->vII) : null;
            }
            
            if(($dados->vIPI ?? null) != null){
                $nota->vIPI= $dados->vIPI ? getFloat($dados->vIPI) : null;
            }
            
            if(($dados->vIPIDevol ?? null) != null){
                $nota->vIPIDevol= $dados->vIPIDevol ? getFloat($dados->vIPIDevol) : null;
            }
            
            if(($dados->vPIS ?? null) != null){
                $nota->vPIS= $dados->vPIS ? getFloat($dados->vPIS) : null;
            }
            
            if(($dados->vCOFINS ?? null) != null){
                $nota->vCOFINS= $dados->vCOFINS ? getFloat($dados->vCOFINS) : null;
            }
            
            if(($dados->vOutro ?? null) != null){
                $nota->vOutro= $dados->vOutro ? getFloat($dados->vOutro) : null;
            }
            
            if(($dados->vNF ?? null) != null){
                $nota->vNF= $dados->vNF ? getFloat($dados->vNF) : null;
            }
            
            if(($dados->vTotTrib ?? null) != null){
                $nota->vTotTrib= $dados->vTotTrib ? getFloat($dados->vTotTrib) : null;
            }
            
            if(($dados->vOrig ?? null) != null){
                $nota->vOrig= $dados->vOrig ? getFloat($dados->vOrig) : null;
            }
            
            if(($dados->vLiq ?? null) != null){
                $nota->vLiq= $dados->vLiq ? getFloat($dados->vLiq) : null;
            }
            
            if(($dados->vTroco ?? null) != null){
                $nota->vTroco= $dados->vTroco ? getFloat($dados->vTroco) : null;
            }
            
            if(($dados->nFat ?? null) != null){
                $nota->nFat= $dados->nFat;
            }
            
            
            
            if(($dados->em_xNome ?? null) != null){
                $nota->em_xNome= $dados->em_xNome;
            }
            
            if(($dados->em_xFant ?? null) != null){
                $nota->em_xFant= $dados->em_xFant;
            }
            
            if(($dados->em_IE ?? null) != null){
                $nota->em_IE= $dados->em_IE;
            }
            
            if(($dados->em_IEST ?? null) != null){
                $nota->em_IEST= $dados->em_IEST;
            }
            
            if(($dados->em_IM ?? null) != null){
                $nota->em_IM= $dados->em_IM;
            }
            
            if(($dados->em_CNAE ?? null) != null){
                $nota->em_CNAE= $dados->em_CNAE;
            }
            
            if(($dados->em_CRT ?? null) != null){
                $nota->em_CRT= $dados->em_CRT;
            }
            
            if(($dados->em_CNPJ ?? null) != null){
                $nota->em_CNPJ= $dados->em_CNPJ;
            }
            
            if(($dados->em_CPF ?? null) != null){
                $nota->em_CPF= $dados->em_CPF;
            }
            
            if(($dados->em_xLgr ?? null) != null){
                $nota->em_xLgr= $dados->em_xLgr;
            }
            
            if(($dados->em_nro ?? null) != null){
                $nota->em_nro= $dados->em_nro;
            }
            
            if(($dados->em_xCpl ?? null) != null){
                $nota->em_xCpl= $dados->em_xCpl;
            }
            
            if(($dados->em_xBairro ?? null) != null){
                $nota->em_xBairro= $dados->em_xBairro;
            }
            
            if(($dados->em_cMun ?? null) != null){
                $nota->em_cMun= $dados->em_cMun;
            }
            
            if(($dados->em_xMun ?? null) != null){
                $nota->em_xMun= $dados->em_xMun;
            }
            
            if(($dados->em_UF ?? null) != null){
                $nota->em_UF= $dados->em_UF;
            }
            
            if(($dados->em_CEP ?? null) != null){
                $nota->em_CEP= $dados->em_CEP;
            }
            
            if(($dados->em_cPais ?? null) != null){
                $nota->em_cPais= $dados->em_cPais;
            }
            
            if(($dados->em_xPais ?? null) != null){
                $nota->em_xPais= $dados->em_xPais;
            }
            
            if(($dados->em_fone ?? null) != null){
                $nota->em_fone= $dados->em_fone;
            }
            
            if(($dados->em_EMAIL ?? null) != null){
                $nota->em_EMAIL= $dados->em_EMAIL;
            }
            
            if(($dados->em_SUFRAMA ?? null) != null){
                $nota->em_SUFRAMA= $dados->em_SUFRAMA;
            }
            
            if((($dados->modFrete ?? null ) != null) || $dados->modFrete ==0){
                $nota->modFrete= $dados->modFrete;
            }
            
            if(($dados->tPag ?? null) != null){
                $nota->tPag= $dados->tPag;
            }
            
            if(($dados->vPag ?? null) != null){
                $nota->vPag= $dados->vPag;
            }
            
            if(($dados->CNPJ_pag ?? null) != null){
                $nota->CNPJ_pag= $dados->CNPJ_pag;
            }
            
            if(($dados->tBand ?? null) != null){
                $nota->tBand= $dados->tBand;
            }
            
            if(($dados->cAut ?? null) != null){
                $nota->cAut= $dados->cAut;
            }
            
            if(($dados->tpIntegra ?? null) != null){
                $nota->tpIntegra= $dados->tpIntegra;
            }
            
            if(($dados->indPag ?? null) != null){
                $nota->indPag= $dados->indPag;
            }
            
            if(($dados->infAdFisco ?? null) != null){
                $nota->infAdFisco= $dados->infAdFisco;
            }
            
            if(($dados->infcpl ?? null) != null){
                $nota->infcpl= $dados->infcpl;
            }
            
            if(($dados->infCpl ?? null) != null){
                $nota->infCpl = $dados->infCpl;
            }
            
            if(($dados->resp_CNPJ ?? null) != null){
                $nota->resp_CNPJ= $dados->resp_CNPJ;
            }
            
            if(($dados->resp_xContato ?? null) != null){
                $nota->resp_xContato= $dados->resp_xContato;
            }
            
            if(($dados->resp_email ?? null) != null){
                $nota->resp_email= $dados->resp_email;
            }
            
            if(($dados->resp_fone ?? null) != null){
                $nota->resp_fone= $dados->resp_fone;
            }
            
            if(($dados->resp_CSRT ?? null) != null){
                $nota->resp_CSRT= $dados->resp_CSRT;
            }
            
            if(($dados->resp_idCSRT ?? null) != null){
                $nota->resp_idCSRT= $dados->resp_idCSRT;
            }            
   
            if(($dados->transp_xNome ?? null) != null  ){
                $nota->transp_xNome= $dados->transp_xNome;
            }
            
            if(($dados->transp_IE ?? null) != null ){
                $nota->transp_IE= $dados->transp_IE;
            }
            
            if(($dados->transp_xEnder ?? null) != null ){
                $nota->transp_xEnder= $dados->transp_xEnder;
            }
            
            if(($dados->transp_xMun ?? null) != null ){
                $nota->transp_xMun= $dados->transp_xMun;
            }
        
            if(($dados->transp_UF ?? null) != null ){
            $nota->transp_UF= $dados->transp_UF;
        }
        
        if(($dados->transp_CNPJ ?? null) != null ){
            $nota->transp_CNPJ= $dados->transp_CNPJ;
        }
        
        if(($dados->transp_vagao ?? null) != null){
            $nota->transp_vagao= $dados->transp_vagao;
        }
        
        if(($dados->transp_balsa ?? null) != null){
            $nota->transp_balsa= $dados->transp_balsa;
        }
        
        if(($dados->transp_ret_vServ ?? null) != null){
            $nota->transp_ret_vServ= $dados->transp_ret_vServ;
        }
        
        if(($dados->transp_ret_vBCRet ?? null) != null){
            $nota->transp_ret_vBCRet= $dados->transp_ret_vBCRet;
        }
        
        if(($dados->transp_ret_pICMSRet ?? null) != null){
            $nota->transp_ret_pICMSRet= $dados->transp_ret_pICMSRet;
        }
        
        if(($dados->transp_ret_vICMSRet ?? null) != null){
            $nota->transp_ret_vICMSRet= $dados->transp_ret_vICMSRet;
        }
        
        if(($dados->transp_ret_CFOP ?? null) != null){
            $nota->transp_ret_CFOP= $dados->transp_ret_CFOP;
        }
        
        if(($dados->transp_ret_cMunFG ?? null) != null){
            $nota->transp_ret_cMunFG= $dados->transp_ret_cMunFG;
        }
        
        
        if(($dados->transp_veic_placa ?? null) != null){
            $nota->transp_veic_placa= $dados->transp_veic_placa;
        }
        
        if(($dados->transp_veic_UF ?? null) != null){
            $nota->transp_veic_UF= $dados->transp_veic_UF;
        }
        
        if(($dados->transp_veic_RNTC ?? null) != null){
            $nota->transp_veic_RNTC= $dados->transp_veic_RNTC;
        }
        
        if(($dados->transp_reboque_placa ?? null) != null){
            $nota->transp_reboque_placa= $dados->transp_reboque_placa;
        }
        
        if(($dados->transp_reboque_UF ?? null) != null){
            $nota->transp_reboque_UF= $dados->transp_reboque_UF;
        }
        
        if(($dados->transp_reboque_RNTC ?? null) != null){
            $nota->transp_reboque_RNTC= $dados->transp_reboque_RNTC;
        }
        
        if(($dados->transp_placa ?? null) != null){
            $nota->transp_placa= $dados->transp_placa;
        }
        
        if(($dados->UF_placa ?? null) != null){
            $nota->UF_placa= $dados->UF_placa;
        }
        
        if(($dados->RNTC ?? null) != null){
            $nota->RNTC= $dados->RNTC;
        }
        
        if(($dados->qVol ?? null) != null){
            $nota->qVol= $dados->qVol;
        }
        
        if(($dados->esp ?? null) != null){
            $nota->esp= $dados->esp;
        }
        
        if(($dados->marca ?? null) != null){
            $nota->marca= $dados->marca;
        }
        
        if(($dados->nVol ?? null) != null){
            $nota->nVol= $dados->nVol;
        }
        
        if(($dados->pesoL ?? null) != null){
            $nota->pesoL= $dados->pesoL;
        }
        
        if(($dados->pesoB ?? null) != null){
            $nota->pesoB= $dados->pesoB;
        }
        
        if(($dados->nLacre ?? null) != null){
            $nota->nLacre= $dados->nLacre;
        }
        
        
        return $nota;
        
    }
    
    public static function salvarDadosNota($dados, $id){       
        $nota = self::setarDadosNota($dados);
       
        if($id){           
            Nfe::find($id)->update(objToArray($nota));
            $nfe = Nfe::find($id);
        }else{
            $nfe = Nfe::Create(objToArray($nota));
            $emitente = Emitente::where("empresa_id", $dados->empresa_id)->first();
            $emitente->ultimo_numero_nfe = $nota->nNF;
            $emitente->save();
            
            if($emitente->autorizados){
                foreach ($emitente->autorizados as $autorizado){
                    NfeAutorizado::Create(["nfe_id"=>$nfe->id,"aut_contato"=>$autorizado->aut_contato, "aut_cnpj"=>$autorizado->aut_cnpj]);
                }
            }
           
        }         
        
        return $nfe;       
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
    
    public static function atualizarValoresDaNota($nfe_id){
        $nfe                = Nfe::find($nfe_id);
        $emitente           = Emitente::where("empresa_id", $nfe->empresa_id)->first();
        $tributacao_geral   = Tributacao::where(["natureza_operacao_id" =>$nfe->natureza_operacao_id,"padrao"=>"S"])->first();
        $itens              = NfeItem::where("nfe_id", $nfe_id);
        
        foreach($itens->get() as $item){
            $tributaProduto = TributacaoProduto::where(["natureza_operacao_id"=>$nfe->natureza_operacao_id,"produto_id"=>$item->produto_id])->first();
            
            if($tributaProduto){
                $tributacao =  $tributaProduto->tributacao;
            }else{
                $tributacao = $tributacao_geral;
            }
            $vBC      = $item->qCom * $item->vUnCom;
            //IPI
            IpiService::calculo($item, $vBC, $tributacao)  ;
            //PIS
            PisService::calculo($item, $vBC, $tributacao);
            // Confins
            CofinsService::calculo($item,$vBC, $tributacao);
            //ICMS
            IcmsService::calculoIcmsSn($item, $tributacao, $emitente);
           
        }
        $total_itens= $itens->sum("vProd");
        $nfe->vOrig = $total_itens;
        $nfe->vLiq  = $nfe->vOrig - $nfe->vDesc;
        $nfe->vOrig = $total_itens;
        $nfe->vProd = $total_itens;
        $nfe->vNF   = $nfe->vOrig - $nfe->vDesc + $nfe->vST + $nfe->vFrete + $nfe->vSeg + $nfe->vOutro + $nfe->vII + $nfe->vIP + $nfe->vServ;
        $nfe->save();
    }
    
    public static function importarXML($xml_nfe, $cliente_id=2, $natureza_operacao_id=2 ){   
        $empresa            = auth()->user()->empresa;
        $emitente           = Emitente::where("empresa_id", $empresa->id)->first();
        $cliente            = Cliente::find($cliente_id);
        $natureza_operacao  = NaturezaOperacao::find($natureza_operacao_id);
        //Nfe        
      
        $produtos           = $xml_nfe->det ;
        $totais             = $xml_nfe->total ;
        $transp             = $xml_nfe->transp ?? null;        
        $infAdic            = $xml_nfe->infAdic ?? null;
        $cobranca           = $xml_nfe->cobr ?? null;    
        $intermediario      = $xml_nfe->Intermed ?? null; 
        $total              = ($totais->ICMSTot) ?? null;           
        
        
        $nota               = new \stdClass();
        $nota->empresa_id   = $empresa->id;
        //$nota->tipo_nota_referenciada = 1;
        $nota->status_id    = config('constantes.status.DIGITACAO');
        $nota->natureza_operacao_id = $natureza_operacao_id;
        $nota->cUF          = ConstanteService::getUf($cliente->uf);
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
            if($emitente->uf == $cliente->uf ){
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
        $nota->finNFe       = config("constanteNota.finNFe.NORMAL"); //Finalidade emissão 1 - Normal
        
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
        $nota->modFrete    = $transp->modFrete ?? '9';
        
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
        
        
        $nota->nFat          = $cobranca->fat->nFat ?? '1';        
        $nota->vFrete        = ($total->vFrete) ?? null 	;
        $nota->vSeg          = ($total->vSeg) ?? null 	;
        $nota->vNF           = ($total->vNF) ?? null 	;
        $nota->vOrig         = ($total->vOrig) ?? null 	;
        $nota->vLiq          = ($total->vLiq) ?? null 	;        
        $nota->vBC           = ($total->vBC) ?? null 	;
        $nota->vICMS         = ($total->vICMS) ?? null 	;
        $nota->vICMSDeson    = ($total->vICMSDeson) ?? null 	;
        $nota->vFCP          = ($total->vFCP) ?? null 	;
        $nota->vBCST         = ($total->vBCST) ?? null 	;
        $nota->vST           = ($total->vST) ?? null 	;
        $nota->vFCPST        = ($total->vFCPST) ?? null 	;
        $nota->vFCPSTRet     = ($total->vFCPSTRet) ?? null 	;
        $nota->vProd         = ($total->vProd) ?? null 	;
        $nota->vFrete        = ($total->vFrete) ?? null 	;
        $nota->vSeg          = ($total->vSeg) ?? null 	;
        $nota->vDesc         = ($total->vDesc) ?? null 	;
        $nota->vII           = ($total->vII) ?? null 	;
        $nota->vIPI          = ($total->vIPI) ?? null 	;
        $nota->vIPIDevol     = ($total->vIPIDevol) ?? null 	;
        $nota->vPIS          = ($total->vPIS) ?? null 	;
        $nota->vCOFINS       = ($total->vCOFINS) ?? null 	;
        $nota->vOutro        = ($total->vOutro) ?? null 	;
        $nota->vNF           = ($total->vNF) ?? null 	;
        $nota->vTotTrib      = ($total->vTotTrib) ?? null 	;
        
  
        $nota->transp_CNPJ        = $transp->transporta->CNPJ ?? null ;
        $nota->transp_xNome       = $transp->transporta->xNome ?? null;
        $nota->transp_xEnder      = $transp->transporta->xEnder ?? null;
        $nota->transp_xMun        = $transp->transporta->xMun ?? null;
        $nota->transp_UF          = $transp->transporta->UF ?? null;
        $nota->transp_IE          = $transp->transporta->IE ?? null;
        
        $nota->qVol               = $transp->vol->qVol ?? null;
        $nota->esp                = $transp->vol->esp ?? null;
        $nota->marca              = $transp->vol->marca ?? null;
        $nota->pesoL              = $transp->vol->pesoL ?? null;
        $nota->pesoB              = $transp->vol->pesoB ?? null;        
        
        $nota->transp_veic_placa    = $transp->veicTransp->placa ?? null;
        $nota->transp_veic_UF       = $transp->veicTransp->UF ?? null;
        $nota->transp_veic_RNTC     = $transp->veicTransp->RNTC  ?? null;
        
        $nota->transp_reboque_placa = $transp->reboque->placa ?? null;
        $nota->transp_reboque_UF    = $transp->reboque->UF ?? null;
        $nota->transp_reboque_RNTC  = $transp->reboque->RNTC  ?? null;
        
        $nota->transp_vagao         = $transp->vagao->vagao  ?? null;
        $nota->transp_balsa         = $transp->vagao->balsa  ?? null;
        $nota->nLacre               = $transp->lacres->nLacre   ?? null;
        
        //$nota->indIntermed          = $intermediario->lacres->nLacre   ?? null;
        $nota->cnpjIntermed         = $intermediario->CNPJ    ?? null;
        $nota->idCadIntTran         = $intermediario->idCadIntTran    ?? null;
        
        $nota->infAdFisco = $infAdic->infAdFisco ?? null;
        $nota->infCpl     = $infAdic->infCpl  ?? null;     
        
                     
        $nfe                =  self::salvarDadosNota($nota, null); 
        $produtos           = $xml_nfe->det ;
       
        //$fatura             = $cobranca->fat ?? null;
        //$duplicatas         = $cobranca->dup ?? null;
        //$pagamento          = $xml_nfe->pag ?? null;
    
      /*
        //Duplicada
        if($duplicatas){
            i($duplicatas);
            if(is_array($duplicatas)){
               
                foreach($duplicatas as $d){
                    $duplicata          = new \stdClass();
                    $duplicata->nfe_id  = $nfe->id;
                    $duplicata->nDup    = $d->nDup;
                    $duplicata->dVenc   = $d->dVenc;
                    $duplicata->vDup    = $d->vDup;
                    NfeDuplicata::Create(objToArray($duplicata));
                }
            }else{
                $duplicata          = new \stdClass();
                $duplicata->nfe_id  =  $nfe->id;
                $duplicata->nDup    = $duplicatas->nDup;
                $duplicata->dVenc   = $duplicatas->dVenc;
                $duplicata->vDup    = $duplicatas->vDup;
                NfeDuplicata::Create(objToArray($duplicata));
            }
        }
        //Pagamento
        i($duplicatas);
        //Destinatário*/
        if($nfe){
            NfeDestinatarioService::criar($nfe->id, $cliente);
        } 
        
        
        //Omserção dos itens
        foreach($produtos as $item) {
            $produto            = new \stdClass();
            //$cfop               = $nfe->em_UF == $dest->dest_UF  ? $tributacao->cfop : intval($tributacao->cfop) + 1000;
            $cfop               =  $item->prod->CFOP;    
            $cProd              =   $item->prod->cProd ? tira_mascara($item->prod->cProd) : null;
            $produto->nfe_id    =   $nfe->id;
            $produto->numero_item =   $item->attributes()->nItem ?? null;            
            
            $produto->xProd		=	str_replace("'", "", $item->prod->xProd);
            $produto->cEAN		=	($item->prod->cEAN) ?? null;
            $produto->cBarra	=	($item->prod->cBarra) ?? null;
            $produto->NCM		=	$item->prod->NCM;
            $produto->cBenef	=	($item->prod->cBenef) ?? null;
            $produto->EXTIPI	=	($item->prod->EXTIPI) ?? null;
            $produto->CFOP		=	$cfop;
            $produto->uCom		=	$item->prod->uCom;
            $produto->qCom		=	$item->prod->qCom;
            $produto->vUnCom	=	$item->prod->vUnCom;
            $produto->vProd		=	$item->prod->vProd;
            $produto->cEANTrib	=	($item->prod->cEANTrib) ?? null;
            $produto->cBarraTrib=	($item->prod->cBarraTrib) ?? null;
            $produto->uTrib		=	$item->prod->uTrib;
            $produto->qTrib		=	$item->prod->qTrib;
            $produto->vUnTrib	=	$item->prod->vUnTrib;
            $produto->vFrete	=	($item->prod->vFrete) ? $item->prod->vFrete : null;
            $produto->vSeg		=	($item->prod->vSeg) ? $item->prod->vSeg : null;
            $produto->vDesc		=	($item->prod->vDesc) ? $item->prod->vDesc : null;
            $produto->vOutro	=	($item->prod->vOutro) ? $item->prod->vOutro : null;
            $produto->indTot	=	($item->prod->indTot) ?? null;
            $produto->xPed		=	($item->prod->xPed) ?? null;
            $produto->nItemPed	=	($item->prod->nItemPed) ?? null;
            $produto->nFCI		=	($item->prod->nFCI) ?? null;           
            
            $temProduto = Produto::where(["ncm" =>$produto->NCM, "referencia" =>$cProd])->first();
            if(!$temProduto){
                $novoProduto                = new \stdClass();
                $novoProduto->referencia    =	$cProd ;
                $novoProduto->nome          =	$produto->xProd ;
                $novoProduto->gtin          =	$produto->cEAN ;
                $novoProduto->origem        =	0 ;
                $novoProduto->unidade       =	$produto->uCom ;
                $novoProduto->valor_venda   =	$produto->vUnCom ;
                $novoProduto->valor_custo   =	$produto->vUnCom ;
                $novoProduto->ncm           =	$produto->NCM ;                
                
                $prod = Produto::Create(objToArray($novoProduto)); 
                $produto->cProd = $prod->id;
            }else{
                $produto->cProd = $temProduto->id;
            }
                        
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
            
            if($icms00){
                $produto->orig    = $item->imposto->ICMS->ICMS00->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMS00->CST;
                $produto->modBC   = $item->imposto->ICMS->ICMS00->modBC ?? null;
                $produto->vBCICMS = $item->imposto->ICMS->ICMS00->vBC;
                $produto->pICMS   = $item->imposto->ICMS->ICMS00->pICMS;
                $produto->vICMS   = $item->imposto->ICMS->ICMS00->vICMS;
                
                $produto->pFCP    = $item->imposto->ICMS->ICMS00->pFCP ?? null;
                $produto->vFCP    = $item->imposto->ICMS->ICMS00->vFCP ?? null;
            }
            
            if($icms10){
                $produto->orig    = $item->imposto->ICMS->ICMS10->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMS10->CST;
                $produto->modBC   = $item->imposto->ICMS->ICMS00->modBC ?? null;
                $produto->vBCICMS = $item->imposto->ICMS->ICMS10->vBC;
                $produto->pICMS   = $item->imposto->ICMS->ICMS10->pICMS;
                $produto->vICMS   = $item->imposto->ICMS->ICMS10->vICMS;
                
                $produto->vBCFCP  = $item->imposto->ICMS->ICMS10->vBCFCP ?? null;
                $produto->pFCP    = $item->imposto->ICMS->ICMS10->pFCP ?? null;
                $produto->vFCP    = $item->imposto->ICMS->ICMS10->vFCP ?? null;
                $produto->modBCST = $item->imposto->ICMS->ICMS10->modBCST ?? null;
                $produto->pMVAST  = $item->imposto->ICMS->ICMS10->pMVAST ?? null;
                $produto->pRedBCST= $item->imposto->ICMS->ICMS10->pRedBCST ?? null;
                $produto->vBCST   = $item->imposto->ICMS->ICMS10->vBCST ?? null;
                $produto->pICMSST = $item->imposto->ICMS->ICMS10->pICMSST ?? null;
                $produto->vBCFCPST= $item->imposto->ICMS->ICMS10->vBCFCPST ?? null;
                $produto->pFCPST  = $item->imposto->ICMS->ICMS10->pFCPST ?? null;
                $produto->vFCPST  = $item->imposto->ICMS->ICMS10->vFCPST ?? null;
            }
            
            if($icms20){
                $produto->orig    = $item->imposto->ICMS->ICMS20->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMS20->CST;
                $produto->modBC   = $item->imposto->ICMS->ICMS20->modBC ?? null;
                $produto->pRedBC  = $item->imposto->ICMS->ICMS20->pRedBC ?? null;
                $produto->vBCICMS = $item->imposto->ICMS->ICMS20->vBC;
                $produto->pICMS   = $item->imposto->ICMS->ICMS20->pICMS;
                $produto->vICMS   = $item->imposto->ICMS->ICMS20->vICMS;
                
                $produto->vBCFCP  = $item->imposto->ICMS->ICMS20->vBCFCP ?? null;
                $produto->pFCP    = $item->imposto->ICMS->ICMS20->pFCP ?? null;
                $produto->vFCP    = $item->imposto->ICMS->ICMS20->vFCP ?? null;
                
                $produto->vICMSDeson = $item->imposto->ICMS->ICMS20->vICMSDeson ?? null;
                $produto->motDesICMS = $item->imposto->ICMS->ICMS20->motDesICMS ?? null;
            }
            
            if($icms30){
                $produto->orig    = $item->imposto->ICMS->ICMS30->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMS30->CST;
                $produto->modBCST   = $item->imposto->ICMS->ICMS30->modBCST ?? null;
                $produto->pMVAST  = $item->imposto->ICMS->ICMS30->pMVAST ?? null;
                $produto->pRedBCST = $item->imposto->ICMS->ICMS30->pRedBCST;
                $produto->vBCST   = $item->imposto->ICMS->ICMS30->vBCST;
                $produto->pICMSST   = $item->imposto->ICMS->ICMS30->pICMSST;
                $produto->vICMSST  = $item->imposto->ICMS->ICMS30->vICMSST ?? null;
                
                $produto->vBCFCPST    = $item->imposto->ICMS->ICMS30->vBCFCPST ?? null;
                $produto->pFCPST    = $item->imposto->ICMS->ICMS30->pFCPST ?? null;
                $produto->vFCPST    = $item->imposto->ICMS->ICMS30->vFCPST ?? null;
                
                $produto->vICMSDeson = $item->imposto->ICMS->ICMS30->vICMSDeson ?? null;
                $produto->motDesICMS = $item->imposto->ICMS->ICMS30->motDesICMS ?? null;
            }
            
            if($icms40){
                $produto->cstICMS = $item->imposto->ICMS->ICMS40->CST;
                
                $produto->vICMSDeson = $item->imposto->ICMS->ICMS40->vICMSDeson ?? null;
                $produto->motDesICMS = $item->imposto->ICMS->ICMS40->motDesICMS ?? null;
            }
            
            if($icms50){
                $produto->cstICMS = $item->imposto->ICMS->ICMS50->CST;
                
                $produto->vICMSDeson = $item->imposto->ICMS->ICMS50->vICMSDeson ?? null;
                $produto->motDesICMS = $item->imposto->ICMS->ICMS50->motDesICMS ?? null;
            }
            
            if($icms51){
                $produto->orig    = $item->imposto->ICMS->ICMS51->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMS51->CST;
                $produto->modBC   = $item->imposto->ICMS->ICMS51->modBC ?? null;
                $produto->pRedBC   = $item->imposto->ICMS->ICMS51->pRedBC ?? null;
                $produto->vBC   = $item->imposto->ICMS->ICMS51->vBC ?? null;
                $produto->pICMS   = $item->imposto->ICMS->ICMS51->pICMS ?? null;
                $produto->vICMSOp   = $item->imposto->ICMS->ICMS51->vICMSOp ?? null;
                $produto->pDif   = $item->imposto->ICMS->ICMS51->pDif ?? null;
                $produto->vICMSDif   = $item->imposto->ICMS->ICMS51->vICMSDif ?? null;
                $produto->vICMS   = $item->imposto->ICMS->ICMS51->vICMS ?? null;
                
                $produto->vBCFCP   = $item->imposto->ICMS->ICMS51->vBCFCP ?? null;
                $produto->pFCP   = $item->imposto->ICMS->ICMS51->pFCP ?? null;
                $produto->vFCP   = $item->imposto->ICMS->ICMS51->vFCP ?? null;
            }
            
            if($icms60){
                $produto->orig    = $item->imposto->ICMS->ICMS60->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMS60->CST;
                
                $produto->vBCSTRet = $item->imposto->ICMS->ICMS60->vBCSTRet ?? null;
                $produto->pST = $item->imposto->ICMS->ICMS60->pST ?? null;
                $produto->vICMSSubstituto = $item->imposto->ICMS->ICMS60->vICMSSubstituto ?? null;
                $produto->vICMSSTRet = $item->imposto->ICMS->ICMS60->vICMSSTRet ?? null;
                
                $produto->vBCFCPSTRet = $item->imposto->ICMS->ICMS60->vBCFCPSTRet ?? null;
                $produto->pFCPSTRet = $item->imposto->ICMS->ICMS60->pFCPSTRet ?? null;
                $produto->vFCPSTRet = $item->imposto->ICMS->ICMS60->vFCPSTRet ?? null;
                
                $produto->pRedBCEfet = $item->imposto->ICMS->ICMS60->pRedBCEfet ?? null;
                $produto->vBCEfet = $item->imposto->ICMS->ICMS60->vBCEfet ?? null;
                $produto->pICMSEfet = $item->imposto->ICMS->ICMS60->pICMSEfet ?? null;
                $produto->vICMSEfet = $item->imposto->ICMS->ICMS60->vICMSEfet ?? null;
                
            }
            
            if($icms70){
                $produto->orig    = $item->imposto->ICMS->ICMS70->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMS70->CST;
                
                $produto->modBC = $item->imposto->ICMS->ICMS70->modBC ?? null;
                $produto->pRedBC = $item->imposto->ICMS->ICMS70->pRedBC ?? null;
                $produto->vBC = $item->imposto->ICMS->ICMS70->vBC ?? null;
                $produto->pICMS = $item->imposto->ICMS->ICMS70->pICMS ?? null;
                $produto->vICMS = $item->imposto->ICMS->ICMS70->vICMS ?? null;
                
                $produto->vBCFCP = $item->imposto->ICMS->ICMS70->vBCFCP ?? null;
                $produto->pFCP = $item->imposto->ICMS->ICMS70->pFCP ?? null;
                $produto->vFCP = $item->imposto->ICMS->ICMS70->vFCP ?? null;
                $produto->modBCST = $item->imposto->ICMS->ICMS70->modBCST ?? null;
                $produto->pMVAST = $item->imposto->ICMS->ICMS70->pMVAST ?? null;
                $produto->pRedBCST = $item->imposto->ICMS->ICMS70->pRedBCST ?? null;
                $produto->vBCST = $item->imposto->ICMS->ICMS70->vBCST ?? null;
                $produto->pICMSST = $item->imposto->ICMS->ICMS70->pICMSST ?? null;
                $produto->vICMSST = $item->imposto->ICMS->ICMS70->vICMSST ?? null;
                
                $produto->vBCFCPST = $item->imposto->ICMS->ICMS70->vBCFCPST ?? null;
                $produto->pFCPST = $item->imposto->ICMS->ICMS70->pFCPST ?? null;
                $produto->vFCPST = $item->imposto->ICMS->ICMS70->vFCPST ?? null;
                
                $produto->vICMSDeson = $item->imposto->ICMS->ICMS70->vICMSDeson ?? null;
                $produto->motDesICMS = $item->imposto->ICMS->ICMS70->motDesICMS ?? null;
                
            }
            
            if($icms90){
                $produto->orig    = $item->imposto->ICMS->ICMS90->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMS90->CST;
                
                $produto->modBC = $item->imposto->ICMS->ICMS90->modBC ?? null;
                $produto->vBC = $item->imposto->ICMS->ICMS90->vBC ?? null;
                $produto->pRedBC = $item->imposto->ICMS->ICMS90->pRedBC ?? null;
                $produto->pICMS = $item->imposto->ICMS->ICMS90->pICMS ?? null;
                $produto->vICMS = $item->imposto->ICMS->ICMS90->vICMS ?? null;
                
                $produto->modBCST = $item->imposto->ICMS->ICMS90->modBCST ?? null;
                $produto->pMVAST = $item->imposto->ICMS->ICMS90->pMVAST ?? null;
                $produto->pRedBCST = $item->imposto->ICMS->ICMS90->pRedBCST ?? null;
                $produto->vBCST = $item->imposto->ICMS->ICMS90->vBCST ?? null;
                $produto->pICMSST = $item->imposto->ICMS->ICMS90->pICMSST ?? null;
                $produto->vICMSST = $item->imposto->ICMS->ICMS90->vICMSST ?? null;
                
                $produto->vBCFCPST = $item->imposto->ICMS->ICMS90->vBCFCPST ?? null;
                $produto->pFCPST = $item->imposto->ICMS->ICMS90->pFCPST ?? null;
                $produto->vFCPST = $item->imposto->ICMS->ICMS90->vFCPST ?? null;
                
                $produto->vICMSDeson = $item->imposto->ICMS->ICMS90->vICMSDeson ?? null;
                $produto->motDesICMS = $item->imposto->ICMS->ICMS90->motDesICMS ?? null;
                
            }
            if($ICMSST){
                $produto->orig    = $item->imposto->ICMS->ICMSST->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMSST->CST;
                $produto->vBCSTRet   = $item->imposto->ICMS->ICMSST->vBCSTRet ?? null;
                $produto->pST   = $item->imposto->ICMS->ICMSST->pST ?? null;
                $produto->vICMSSubstituto   = $item->imposto->ICMS->ICMSST->vICMSSubstituto ?? null;
                $produto->vICMSSTRet   = $item->imposto->ICMS->ICMSST->vICMSSTRet ?? null;
                
                $produto->vBCFCPSTRet   = $item->imposto->ICMS->ICMSST->vBCFCPSTRet ?? null;
                $produto->pFCPSTRet   = $item->imposto->ICMS->ICMSST->pFCPSTRet ?? null;
                $produto->vFCPSTRet   = $item->imposto->ICMS->ICMSST->vFCPSTRet ?? null;
                $produto->vBCSTDest   = $item->imposto->ICMS->ICMSST->vBCSTDest ?? null;
                $produto->vICMSSTDest   = $item->imposto->ICMS->ICMSST->vICMSSTDest ?? null;
                
                $produto->pRedBCEfet   = $item->imposto->ICMS->ICMSST->pRedBCEfet ?? null;
                $produto->vBCEfet   = $item->imposto->ICMS->ICMSST->vBCEfet ?? null;
                $produto->pICMSEfet   = $item->imposto->ICMS->ICMSST->pICMSEfet ?? null;
                $produto->vICMSEfet   = $item->imposto->ICMS->ICMSST->vICMSEfet ?? null;
                
            }
            
            if($ICMSSN101){
                $produto->orig    = $item->imposto->ICMS->ICMSSN101->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMSSN101->CSOSN;
                $produto->pCredSN = $item->imposto->ICMS->ICMSSN101->pCredSN ?? null;
                $produto->vCredICMSSN = $item->imposto->ICMS->ICMSSN101->vCredICMSSN ?? null;
            }
            
            if($ICMSSN102){
                $produto->orig    = $item->imposto->ICMS->ICMSSN102->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMSSN102->CSOSN;
            }
            
            if($ICMSSN900){
                $produto->orig    = $item->imposto->ICMS->ICMSSN900->orig;
                $produto->cstICMS = $item->imposto->ICMS->ICMSSN900->CSOSN;
                
                $produto->modBC   = $item->imposto->ICMS->ICMSSN900->modBC ?? null;
                $produto->vBCICMS = $item->imposto->ICMS->ICMSSN900->vBC ?? null;
                $produto->pRedBC   = $item->imposto->ICMS->ICMSSN900->pRedBC ?? null;
                $produto->pICMS   = $item->imposto->ICMS->ICMSSN900->pICMS ?? null;
                $produto->vICMS   = $item->imposto->ICMS->ICMSSN900->vICMS ?? null;
                
                $produto->modBCST   = $item->imposto->ICMS->ICMSSN900->modBCST ?? null;
                $produto->pMVAST   = $item->imposto->ICMS->ICMSSN900->pMVAST ?? null;
                $produto->pRedBCST   = $item->imposto->ICMS->ICMSSN900->pRedBCST ?? null;
                $produto->vBCST   = $item->imposto->ICMS->ICMSSN900->vBCST ?? null;
                $produto->pICMSST   = $item->imposto->ICMS->ICMSSN900->pICMSST ?? null;
                $produto->vICMSST   = $item->imposto->ICMS->ICMSSN900->vICMSST ?? null;
                
                $produto->vBCFCPST   = $item->imposto->ICMS->ICMSSN900->vBCFCPST ?? null;
                $produto->pFCPST   = $item->imposto->ICMS->ICMSSN900->pFCPST ?? null;
                $produto->vFCPST   = $item->imposto->ICMS->ICMSSN900->vFCPST ?? null;
                
                $produto->pCredSN   = $item->imposto->ICMS->ICMSSN900->pCredSN ?? null;
                $produto->vCredICMSSN   = $item->imposto->ICMS->ICMSSN900->vCredICMSSN ?? null;
            }
            
            if($IPI){
                $produto->CNPJProd = $item->imposto->IPI->CNPJProd ?? null;
                $produto->cSelo = $item->imposto->IPI->cSelo ?? null;
                $produto->qSelo = $item->imposto->IPI->qSelo ?? null;
                $produto->cEnq = $item->imposto->IPI->cEnq ?? null;
                
                if(isset($item->imposto->IPI->IPITrib)){
                    $produto->cstIPI = $item->imposto->IPI->IPITrib->CST ?? null;
                    $produto->vBCIPI = $item->imposto->IPI->IPITrib->vBC ?? null;
                    $produto->pIPI   = $item->imposto->IPI->IPITrib->pIPI ?? null;
                    $produto->vIPI   = $item->imposto->IPI->IPITrib->vIPI ?? null;
                    
                    $produto->qUnid   = $item->imposto->IPI->IPITrib->qUnid ?? null;
                    $produto->vUnid   = $item->imposto->IPI->IPITrib->vUnid ?? null;
                    $produto->vIPI   = $item->imposto->IPI->IPITrib->vIPI ?? null;
                    $produto->vIPI   = $item->imposto->IPI->IPITrib->vIPI ?? null;
                }
                
                if(isset($item->imposto->IPI->IPINT)){
                    $produto->cstIPI = $item->imposto->IPI->IPINT->CST;
                }
            }
            
            if($PIS){
                if(isset($item->imposto->PIS->PISAliq)){
                    $produto->cstPIS = $item->imposto->PIS->PISAliq->CST ?? null;
                    $produto->vBCPIS = $item->imposto->PIS->PISAliq->vBC ?? null;
                    $produto->pPIS   = $item->imposto->PIS->PISAliq->pPIS ?? null;
                    $produto->vPIS   = $item->imposto->PIS->PISAliq->vPIS ?? null;
                }
                
                if(isset($item->imposto->PIS->PISQtde)){
                    $produto->cstPIS = $item->imposto->PIS->PISQtde->CST ?? null;
                    $produto->qBCProdPis = $item->imposto->PIS->PISQtde->qBCProd ?? null;
                    $produto->vAliqProd_pis   = $item->imposto->PIS->PISQtde->vAliqProd ?? null;
                    $produto->vPIS   = $item->imposto->PIS->PISQtde->vPIS ?? null;
                }
                
                if(isset($item->imposto->PIS->PISNT)){
                    $produto->cstPIS = $item->imposto->PIS->PISNT->CST ?? null;
                }
                
                if(isset($item->imposto->PIS->PISOutr)){
                    $produto->cstPIS    = $item->imposto->PIS->PISOutr->CST ?? null;
                    $produto->vBCPIS    = $item->imposto->PIS->PISOutr->vBC ?? null;
                    $produto->pPIS      = $item->imposto->PIS->PISOutr->pPIS ?? null;
                    $produto->qBCProdPis   = $item->imposto->PIS->PISOutr->qBCProd ?? null;
                    $produto->vAliqProd_pis = $item->imposto->PIS->PISOutr->vAliqProd ?? null;
                    $produto->vPIS      = $item->imposto->PIS->PISOutr->vIPI ?? null;
                }
                
            }
            
            if($PISST){
                $produto->vBCPISST = $item->imposto->PISST->vBC ?? null;
                $produto->pPISST = $item->imposto->PISST->pPIS ?? null;
                $produto->qBCProdPisST = $item->imposto->PISST->qBCProd ?? null;
                $produto->vAliqProd_pisst = $item->imposto->PISST->vAliqProd ?? null;
                $produto->vPISST = $item->imposto->PISST->vPIS ?? null;
            }
            
            if($COFINS){
                if(isset($item->imposto->COFINS->COFINSAliq)){
                    $produto->cstCOFINS = $item->imposto->COFINS->COFINSAliq->CST ?? null;
                    $produto->vBCCOFINS = $item->imposto->COFINS->COFINSAliq->vBC ?? null;
                    $produto->pCOFINS   = $item->imposto->COFINS->COFINSAliq->pCOFINS ?? null;
                    $produto->vCOFINS   = $item->imposto->COFINS->COFINSAliq->vCOFINS ?? null;
                }
                
                if(isset($item->imposto->COFINS->COFINSQtde)){
                    $produto->cstCOFINS = $item->imposto->COFINS->COFINSQtde->CST ?? null;
                    $produto->qBCProdConfis = $item->imposto->COFINS->COFINSQtde->qBCProd ?? null;
                    $produto->vAliqProd_cofins   = $item->imposto->COFINS->COFINSQtde->vAliqProd ?? null;
                    $produto->vCOFINS   = $item->imposto->COFINS->COFINSQtde->vCOFINS ?? null;
                }
                
                if(isset($item->imposto->COFINS->COFINSNT)){
                    $produto->cstCOFINS = $item->imposto->COFINS->COFINSNT->CST ?? null;
                }
                
                if(isset($item->imposto->COFINS->COFINSOutr)){
                    $produto->cstCOFINS    = $item->imposto->COFINS->COFINSOutr->CST ?? null;
                    $produto->vBCCOFINS    = $item->imposto->COFINS->COFINSOutr->vBC ?? null;
                    $produto->pCOFINS      = $item->imposto->COFINS->COFINSOutr->pCOFINS ?? null;
                    $produto->qBCProdConfis       = $item->imposto->COFINS->COFINSOutr->qBCProd ?? null;
                    $produto->vAliqProd_cofins     = $item->imposto->COFINS->COFINSOutr->vAliqProd ?? null;
                    $produto->vCOFINS      = $item->imposto->COFINS->COFINSOutr->vCOFINS ?? null;
                }
                
            }
            
            if($COFINSST){
                $produto->vBCCOFINSST     = $item->imposto->COFINSST->vBC ?? null;
                $produto->pCOFINSST       = $item->imposto->COFINSST->pCOFINS ?? null;
                $produto->qBCProdConfisST = $item->imposto->COFINSST->qBCProd ?? null;
                $produto->vAliqProd_cofinsst = $item->imposto->COFINSST->vAliqProd ?? null;
                $produto->vCOFINSST       = $item->imposto->COFINSST->vCOFINS ?? null;
            }          
          
            NfeItem::Create(objToArray($produto));
            
        }
        
         return $nfe;   
        
    }
    
  
    public static function lerXml($arquivo){
        $xml     = simplexml_load_file($arquivo);
        
        $chaveNfe=  $xml->NFe->infNFe->attributes()->Id;
        $chave   = substr($chaveNfe, 3, 44);
        $tem     = Compra::where('chave', $chave)->first();
        if(!$tem){
            $identificacao      = $xml->NFe->infNFe->ide;
            $fornecedorNfe      = $xml->NFe->infNFe->emit;
            $produtos           = $xml->NFe->infNFe->det ;
            $totais             = $xml->NFe->infNFe->total ;
            $transportadoraNfe  = $xml->NFe->infNFe->transp->transporta;
            $duplicataNfe       = $xml->NFe->infNFe->cobr->dup;
            
            $total              = ($totais->ICMSTot) ?? null;
            
            //Cadastrando o fornecedor
            $dadosEmitente                = new \stdClass();
            $dadosEmitente->cnpj          = ($fornecedorNfe->CNPJ) ? $fornecedorNfe->CNPJ : $fornecedorNfe->CPF;
            $dadosEmitente->razao_social  = $fornecedorNfe->xNome;
            $dadosEmitente->nome_fantasia = $fornecedorNfe->xFant;
            $dadosEmitente->logradouro    = $fornecedorNfe->enderEmit->xLgr;
            $dadosEmitente->numero        = $fornecedorNfe->enderEmit->nro;
            $dadosEmitente->bairro        = $fornecedorNfe->enderEmit->xBairro;
            $dadosEmitente->uf            = $fornecedorNfe->UF;
            $dadosEmitente->complemento   = ($fornecedorNfe->xCpl) ?? null;
            $dadosEmitente->telefone      = ($fornecedorNfe->enderEmit->fone) ?? null;
            $dadosEmitente->cep           = $fornecedorNfe->enderEmit->CEP;
            $dadosEmitente->ibge          = $fornecedorNfe->enderEmit->cMun;
            $dadosEmitente->ie            = ($fornecedorNfe->IE) ?? null;
            $dadosEmitente->cidade        = $fornecedorNfe->enderEmit->xMun;
            
            $fornecedorEncontrado = Fornecedor::where('cnpj',$dadosEmitente->cnpj)->first();
            if(!$fornecedorEncontrado){
                $fornecedor = Fornecedor::Create(objToArray($dadosEmitente));
            }else{
                $fornecedor = $fornecedorEncontrado;
            }
            
            //Tranportadora
            if($transportadoraNfe){
                $transp                = new \stdClass();
                $transp->cnpj          = ($transportadoraNfe->CNPJ) ? $transportadoraNfe->CNPJ : $transportadoraNfe->CPF;
                $transp->razao_social  = $transportadoraNfe->xNome;
                $transp->logradouro    = $transportadoraNfe->xEnder;
                $transp->cidade        = $transportadoraNfe->xMun ;
                $transp->uf            = $transportadoraNfe->UF;
                
                $transportadoraEncontrado = Transportadora::where('cnpj',$transp->cnpj)->first();
                if(!$transportadoraEncontrado){
                    $transportadora = Transportadora::Create(objToArray($transp));
                }else{
                    $transportadora = $transportadoraEncontrado;
                }
            }
            
            //Nfe
            $nf             = null;
            $nfe            = new \stdClass();
            $nfe->status_id = config('constantes.status.Novo');
            $nfe->fornecedor_id= $fornecedor->id;
            $nfe->transportadora_id= ($transportadora->id) ?? null;
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
            $nfe->vProd     = ($total->vProd) ?? null 	;
            $nfe->vFrete    = ($total->vFrete) ?? null 	;
            $nfe->vSeg      = ($total->vSeg) ?? null 	;
            $nfe->vDesc     = ($total->vDesc) ?? null 	;
            $nfe->vNF       = ($total->vNF) ?? null 	;
            $nfe->vOrig     = ($total->vOrig) ?? null 	;
            $nfe->vLiq      = ($total->vLiq) ?? null 	;
            
            $temNfe         = NfeTemp::where("chave", $nfe->chave)->first();
            if(!$temNfe){
                $nf = NfeTemp::Create(objToArray($nfe));
            }
            if($nf){
                //Itens
                foreach($produtos as $item) {
                    $produto            = new \stdClass();
                    $produto->nfe_id    =   $nf->id;
                    $produto->fornecedor_id= $fornecedor->id;
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
                    
                    //verifica se o produto já foi cadastrado
                    $temProduto = Produto::where(["fornecedor_nota_id" =>$fornecedor->id, "referencia" =>$produto->cProd])->first();
                    if($temProduto){
                        $produto->produto_id = $temProduto->id;
                    }
                    
                    NfeItemTemp::Create(objToArray($produto));
                }
                
                //Duplicatas
                if($duplicataNfe){
                    foreach ($duplicataNfe as $dup){
                        $duplicata          = new \stdClass();
                        $duplicata->nfe_id  = $nf->id;
                        $duplicata->nDup    = ($dup->nDup) ?? null;
                        $duplicata->dVenc   = ($dup->dVenc) ?? null;
                        $duplicata->vDup    = ($dup->vDup) ?? null;
                        NfeDuplicataTemp::Create(objToArray($duplicata));
                    }
                }
            }
            
            //Fazendo o upload
            $empresa            = auth()->user()->empresa;
            $nomeImagem         = $chave . ".xml" ;
            $pasta              = "upload/".$empresa->pasta ."/Nfe/Entrada/";
            $upload             = $arquivo->move(public_path($pasta), $nomeImagem);
        }
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
        $novo_nfe->tipo_nfe_id      = $novosDados->tipo_nfe_id;
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
  
        $novo_nfe->save();
        
        //destinatário        
        $destinatario               = $destinatario_original->replicate();
        $destinatario->nfe_id       = $novo_nfe->id;
        $destinatario->save();
        
        //Itens
        foreach($itens_original as $i){
            $novo_item          = $i->replicate();
            $novo_item->nfe_id  = $novo_nfe->id;
            
            $cfop                = $nfe_original->em_UF == $destinatario->dest_UF ? $natureza_operacao->cfop : intval($natureza_operacao->cfop) + 1000;
            $novo_item->CFOP     = $cfop;
            $novo_item->cstIPI   = $natureza_operacao->cstIpi;
            $novo_item->cstPIS   = $natureza_operacao->cstPis;
            $novo_item->cstCOFINS= $natureza_operacao->cstCofins;
            $novo_item->CSOSN    = $natureza_operacao->cstIcms;       
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
        
    }
    

    
    public static function editarNfe($dados){
        $nota               = new \stdClass();
        $nota->status_id    =  $dados->status_id ?? null;
        $nota->natureza_operacao_id=  $dados->natureza_operacao_id ?? null;
        $nota->chave        =  $dados->chave ?? null;
        $nota->recibo       =  $dados->recibo ?? null;
        $nota->protocolo    =  $dados->protocolo ?? null;
        $nota->cUF          =  $dados->cUF ?? null;
        $nota->cNF          =  $dados->cNF ?? null;
        $nota->natOp        =  $dados->natOp ?? null;
        $nota->modelo       =  $dados->modelo ?? null;
        $nota->serie        =  $dados->serie ?? null;
        $nota->nNF          =  $dados->nNF ?? null;
        $nota->cDV          =  $dados->cDV ?? null;
        $nota->sequencia_cce=  $dados->sequencia_cce ?? null;
        $nota->dhEmi        =  $dados->dhEmi ?? null;
        $nota->dhSaiEnt     =  $dados->dhSaiEnt ?? null;
        $nota->tpNF         =  $dados->tpNF ?? null;
        $nota->idDest       =  $dados->idDest ?? null;
        $nota->cMunFG       =  $dados->cMunFG ?? null;
        $nota->tpImp        =  $dados->tpImp ?? null;
        $nota->tpEmis       =  $dados->tpEmis ?? null;
        $nota->tpAmb        =  $dados->tpAmb ?? null;
        $nota->finNFe       =  $dados->tpAmb ?? null;
        $nota->indFinal     =  $dados->indFinal ?? null;
        $nota->indPres      =  $dados->indPres ?? null;
        $nota->indIntermed  =  $dados->indIntermed ?? null;
        $nota->cnpjIntermed =  $dados->cnpjIntermed ?? null;
        $nota->idCadIntTran =  $dados->idCadIntTran ?? null;
        $nota->tipo_nota_referenciada=  $dados->tipo_nota_referenciada ?? null;
        $nota->ref_NFe      =  $dados->ref_NFe ?? null;
        $nota->ref_ano_mes  =  $dados->ref_ano_mes ?? null;
        $nota->ref_num_nf   =  $dados->ref_num_nf ?? null;
        $nota->ref_serie    =  $dados->ref_serie ?? null;
        $nota->procEmi      =  $dados->procEmi ?? null;
        $nota->verProc      =  $dados->verProc ?? null;
        $nota->dhCont       =  $dados->dhCont ?? null;
        $nota->xJust        =  $dados->xJust ?? null;
        $nota->vBC          =  $dados->vBC ?? null;
        $nota->vICMS        =  $dados->vICMS ?? null;
        $nota->vICMSDeson   =  $dados->vICMSDeson ?? null;
        $nota->vFCP         =  $dados->vFCP ?? null;
        $nota->vBCST        =  $dados->vBCST ?? null;
        $nota->vST          =  $dados->vST ?? null;
        $nota->vFCPST       =  $dados->vFCPST ?? null;
        $nota->vFCPSTRet    =  $dados->vFCPSTRet ?? null;
        $nota->vProd        =  $dados->vProd ?? null;
        $nota->vFrete       =  $dados->vFrete ?? null;
        $nota->vSeg         =  $dados->vSeg ?? null;
        $nota->vDesc        =  $dados->vDesc ?? null;
        $nota->vII          =  $dados->vII ?? null;
        $nota->vIPI         =  $dados->vIPI ?? null;
        $nota->vIPIDevol    =  $dados->vIPIDevol ?? null;
        $nota->vPIS         =  $dados->vPIS ?? null;
        $nota->vCOFINS      =  $dados->vCOFINS ?? null;
        $nota->vOutro       =  $dados->vOutro ?? null;
        $nota->vNF          =  $dados->vNF ?? null;
        $nota->vTotTrib     =  $dados->vTotTrib ?? null;
        $nota->vOrig        =  $dados->vOrig ?? null;
        $nota->vLiq         =  $dados->vLiq ?? null;
        $nota->vTroco       =  $dados->vTroco ?? null;
        $nota->nFat         =  $dados->nFat ?? null;
        $nota->em_xNome     =  $dados->em_xNome ?? null;
        $nota->em_xFant     =  $dados->em_xFant ?? null;
        $nota->em_IE        =  $dados->em_IE ?? null;
        $nota->em_IEST      =  $dados->em_IEST ?? null;
        $nota->em_IM        =  $dados->em_IM ?? null;
        $nota->em_CNAE      =  $dados->em_CNAE ?? null;
        $nota->em_CRT       =  $dados->em_CRT ?? null;
        $nota->em_CNPJ      =  $dados->em_CNPJ ?? null;
        $nota->em_CPF       =  $dados->em_CPF ?? null;
        $nota->em_xLgr      =  $dados->em_xLgr ?? null;
        $nota->em_nro       =  $dados->em_nro ?? null;
        $nota->em_xCpl      =  $dados->em_xCpl ?? null;
        $nota->em_xBairro   =  $dados->em_xBairro ?? null;
        $nota->em_cMun      =  $dados->em_cMun ?? null;
        $nota->em_xMun      =  $dados->em_xMun ?? null;
        $nota->em_UF        =  $dados->em_UF ?? null;
        $nota->em_CEP       =  $dados->em_CEP ?? null;
        $nota->em_cPais     =  $dados->em_cPais ?? null;
        $nota->em_xPais     =  $dados->em_xPais ?? null;
        $nota->em_fone      =  $dados->em_fone ?? null;
        $nota->em_EMAIL     =  $dados->em_EMAIL ?? null;
        $nota->em_SUFRAMA   =  $dados->em_SUFRAMA ?? null;
        $nota->modFrete     =  $dados->modFrete ?? null;
        $nota->tPag         =  $dados->tPag ?? null;
        $nota->vPag         =  $dados->vPag ?? null;
        $nota->CNPJ_pag     =  $dados->CNPJ_pag ?? null;
        $nota->tBand        =  $dados->tBand ?? null;
        $nota->cAut         =  $dados->cAut ?? null;
        $nota->tpIntegra    =  $dados->tpIntegra ?? null;
        $nota->indPag       =  $dados->indPag ?? null;
        $nota->infAdFisco   =  $dados->infAdFisco ?? null;
        $nota->infCpl       =  $dados->infCpl ?? null;
        $nota->empresa_id   =  $dados->empresa_id ?? null;
        $nota->resp_CNPJ    =  $dados->resp_CNPJ ?? null;
        $nota->resp_xContato=  $dados->resp_xContato ?? null;
        $nota->resp_email   =  $dados->resp_email ?? null;
        $nota->resp_fone    =  $dados->resp_fone ?? null;
        $nota->resp_CSRT    =  $dados->resp_CSRT ?? null;
        $nota->resp_idCSRT  =  $dados->resp_idCSRT ?? null;
        
        $nfeSalva           = Nfe::where("id", $dados->nfe_id)->update(objToArray($nota));
    }
    
     
    public static function salvarDevolucao($id_nfe){        
        $padrao          = NaturezaOperacao::where("padrao", config("constantes.padrao_natureza.DEVOLUCAO_VENDA"))->first(); 
        $nfe             = Nfe::find($id_nfe);
        $emitente        = Emitente::where("empresa_id", $nfe->empresa_id)->first();
        $nota            = new \stdClass();
        $nota->id        = $nfe->id;
        $nota->nNF       = $emitente->ultimo_numero_nfe + 1;
        $nota->cNF       = rand($nota->nNF,99999999);
        $nota->serie     = $emitente->numero_serie_nfe;
        $nota->cUF       = $nfe->cUF;
        $nota->natOp     = $padrao->descricao;
        $nota->tpNF      = $nfe->tpNF;
        $nota->idDest    = $nfe->idDest;
        $nota->tpImp     = $nfe->tpImp;
        $nota->tpEmis    = $nfe->tpEmis;
        $nota->tpAmb     = $nfe->tpAmb;
        $nota->finNFe    = $nfe->finNFe;
        $nota->indFinal  = $nfe->indFinal;
        $nota->indPres   = $nfe->indPres;
        $nota->procEmi   = $nfe->procEmi;
        $nota->verProc   = $nfe->verProc;
        $nota->modFrete  = $nfe->modFrete;
        
        //Intermediário
        $nota->indIntermed  = $nfe->indIntermed;
        $nota->cnpjIntermed = $nfe->cnpjIntermed;
        $nota->idCadIntTran = $nfe->idCadIntTran;
        
        //Responsável técnico
        $nota->resp_CNPJ    = $nfe->resp_CNPJ; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
        $nota->resp_xContato= $nfe->resp_xContato; //Nome da pessoa a ser contatada
        $nota->resp_email   = $nfe->resp_email; //E-mail da pessoa jurídica a ser contatada
        $nota->resp_fone    = $nfe->resp_fone; //Telefone da pessoa jurídica/física a ser contatada
        $nota->resp_CSRT    = $nfe->resp_CSRT; //Código de Segurança do Responsável Técnico
        $nota->resp_idCSRT  = $nfe->resp_idCSRT; //Identificador do CSRT
        
        $nota->status_id    = config("constantes.status.DIGITACAO");
        //Pagamento    
        $nota->vTroco       = $nfe->vTroco; //incluso no layout 4.00, obrigatório informar para NFCe (65)
        
        //Detalhe do Pagamento
        $nota->tPag     = $nfe->tPag;
        $nota->vPag     = $nfe->vPag; //Obs: deve ser informado o valor pago pelo cliente
        $nota->CNPJ_pag = $nfe->CNPJ_pag;
        $nota->tBand    = $nfe->tBand;
        $nota->cAut     = $nfe->cAut;
        $nota->tpIntegra= $nfe->tpIntegra; //incluso na NT 2015/002
        $nota->indPag   = $nfe->indPag; //0= Pagamento à Vista 1= Pagamento à Prazo
        
        //Emitente
        $nota->em_xNome = $nfe->em_xNome;
        $nota->em_xFant = $nfe->em_xFant;
        $nota->em_IE    = $nfe->em_IE;
        $nota->em_IEST  = $nfe->em_IEST;
        $nota->em_IM    = $nfe->em_IM;
        $nota->em_CNAE  = $nfe->em_CNAE;
        $nota->em_CRT   = $nfe->em_CRT;
        $nota->em_CNPJ  = $nfe->em_CNPJ;
        $nota->em_CPF   = $nfe->em_CPF;
        $nota->em_xLgr  = $nfe->em_xLgr;
        $nota->em_nro   = $nfe->em_nro;
        $nota->em_xCpl  = $nfe->em_xCpl;
        $nota->em_xBairro= $nfe->em_xBairro ;
        $nota->em_cMun  = $nfe->em_cMun;
        $nota->em_xMun  = $nfe->em_xMun;
        $nota->em_UF    = $nfe->em_UF;
        $nota->em_CEP   = $nfe->em_CEP;
        $nota->em_cPais = $nfe->em_cPais;
        $nota->em_xPais = $nfe->em_xPais;
        $nota->em_fone  = $nfe->em_fone;
        
        $nota->vBC       = $nfe->vBC;
        $nota->vICMS     = $nfe->vICMS;
        $nota->vICMSDeson= $nfe->vICMSDeson;
        $nota->vFCP      = $nfe->vFCP; //incluso no layout 4.00
        $nota->vBCST     = $nfe->vBCST;
        $nota->vST       = $nfe->vST;
        $nota->vFCPST    = $nfe->vFCPST; //incluso no layout 4.00
        $nota->vFCPSTRet = $nfe->vFCPSTRet; //incluso no layout 4.00
        $nota->vProd     = $nfe->vProd;
        $nota->vFrete    = $nfe->vFrete;
        $nota->vSeg      = $nfe->vSeg;
        $nota->vDesc     = $nfe->vDesc;
        $nota->vII       = $nfe->vII;
        $nota->vIPI      = $nfe->vIPI;
        $nota->vIPIDevol = $nfe->vIPIDevol; //incluso no layout 4.00
        $nota->vPIS      = $nfe->vPIS;
        $nota->vCOFINS   = $nfe->vCOFINS;
        $nota->vOutro    = $nfe->vOutro;
        $nota->vNF       = $nfe->vNF;
        $nota->vTotTrib  = $nfe->vTotTrib;
        
   
        $nota->nFat    = $nfe->nFat;
        $nota->vOrig   = $nfe->vOrig;
        $nota->vDesc   = $nfe->vDesc;
        $nota->vLiq    = $nfe->vLiq;
        
        $nfeSalva = Nfe::Create(objToArray($nota));
        
        $destinatario                   = new \stdClass();      
        
        $objDest                        = $nfe->destinatario; 
        $destinatario->nfe_id           = $nfeSalva->id;
        $destinatario->dest_xNome       = $objDest->dest_xNome;
        $destinatario->dest_xNome		= $objDest->dest_xNome;
        $destinatario->dest_CPF			= $objDest->dest_CPF;
        $destinatario->dest_idEstrangeiro= $objDest->dest_idEstrangeiro;
        $destinatario->dest_indIEDest	= $objDest->dest_indIEDest;
        $destinatario->dest_IE			= $objDest->dest_IE;
        $destinatario->dest_ISUF		= $objDest->dest_ISUF;
        $destinatario->dest_IM			= $objDest->dest_IM;
        $destinatario->dest_email		= $objDest->dest_email;
        $destinatario->dest_xLgr		= $objDest->dest_xLgr;
        $destinatario->dest_nro			= $objDest->dest_nro;
        $destinatario->dest_xCpl		= $objDest->dest_xCpl;
        $destinatario->dest_xBairro		= $objDest->dest_xBairro;
        $destinatario->dest_cMun		= $objDest->dest_cMun;
        $destinatario->dest_xMun		= $objDest->dest_xMun;
        $destinatario->dest_UF			= $objDest->dest_UF;
        $destinatario->dest_CEP		    = $objDest->dest_CEP;
        $destinatario->dest_cPais		= $objDest->dest_cPais;
        $destinatario->dest_xPais		= $objDest->dest_xPais;
        $destinatario->dest_fone		= $objDest->dest_fone;
        
        NfeDestinatario::Create(objToArray($destinatario));
        
        foreach($nfe->itens as $item){
            $produto              = new \stdClass(); 
            $produto->nfe_id      = $nfeSalva->id;
            $produto->numero_item = $item->numero_item;
            $produto->cProd 	  = $item->cProd;
            $produto->cEAN 	      = $item->cEAN;
            $produto->xProd 	  = $item->xProd;
            $produto->NCM 		  = $item->NCM;
            $produto->cBenef 	  = $item->cBenef;
            $produto->EXTIPI 	  = $item->EXTIPI;
            $cfop                 = $nota->em_UF == $destinatario->dest_UF ? $padrao->cfop : intval($padrao->cfop) + 1000;
            $item->CFOP            = $cfop;
            $produto->uCom 		  = $item->uCom;
            $produto->qCom 		  = $item->qCom;
            $produto->vUnCom 	  = $item->vUnCom;
            $produto->vProd 	  = $item->vProd;
            $produto->cEANTrib 	  = $item->cEANTrib;
            $produto->uTrib 	  = $item->uTrib;
            $produto->qTrib 	  = $item->qTrib;
            $produto->vUnTrib 	  = $item->vUnTrib;
            $produto->vFrete 	  = $item->vFrete;
            $produto->vSeg 		  = $item->vSeg;
            $produto->vDesc 	  = $item->vDesc;
            $produto->vOutro 	  = $item->vOutro;
            $produto->indTot 	  = $item->indTot;
            $produto->xPed 		  = $item->xPed;
            $produto->nItemPed 	  = $item->nItemPed;
            $produto->nFCI 		  = $item->nFCI;            
            
            $produto->item        = $item->numero_item; //item da NFe
            $produto->orig        = $item->orig;
            $produto->CSOSN       = $item->CSOSN;
            $produto->pCredSN     = $item->pCredSN;
            $produto->vCredICMSSN = $item->vCredICMSSN;
            $produto->modBCST     = $item->modBCST;
            $produto->pMVAST      = $item->pMVAST;
            $produto->pRedBCST    = $item->pRedBCST;
            $produto->vBCST       = $item->vBCST;
            $produto->pICMSST     = $item->pICMSST;
            $produto->vICMSST     = $item->vICMSST;
            $produto->vBCFCPST    = $item->vBCFCPST; //incluso no layout 4.00
            $produto->pFCPST      = $item->pFCPST; //incluso no layout 4.00
            $produto->vFCPST      = $item->vFCPST; //incluso no layout 4.00
            $produto->vBCSTRet    = $item->vBCSTRet;
            $produto->pST         = $item->pST;
            $produto->vICMSSTRet  = $item->vICMSSTRet;
            $produto->vBCFCPSTRet = $item->vBCFCPSTRet; //incluso no layout 4.00
            $produto->pFCPSTRet   = $item->pFCPSTRet; //incluso no layout 4.00
            $produto->vFCPSTRet   = $item->vFCPSTRet; //incluso no layout 4.00
            $produto->modBC       = $item->modBC;
            $produto->vBC         = $item->vBCICMS;
            $produto->pRedBC      = $item->pRedBC;
            $produto->pICMS       = $item->pICMS;
            $produto->vICMS       = $item->vICMS;
            $produto->pRedBCEfet  = $item->pRedBCEfet;
            $produto->vBCEfet     = $item->vBCEfet;
            $produto->pICMSEfet   = $item->pICMSEfet;
            $produto->vICMSEfet   = $item->vICMSEfet;
            $produto->vICMSSubstituto = $item->vICMSSubstituto;
            
            $produto->CST           = $item->cstICMS;
            $produto->modBC         = $item->modBC;
            $produto->vBC           = $item->vBCICMS;
            $produto->pICMS         = $item->pICMS;
            $produto->vICMS         = $item->vICMS;
            $produto->pFCP          = $item->pFCP;
            $produto->vFCP          = $item->vFCP;
            $produto->vBCFCP        = $item->vBCFCP;
            $produto->modBCST       = $item->modBCST;
            $produto->pMVAST        = $item->pMVAST;
            $produto->pRedBCST      = $item->pRedBCST;
            $produto->vBCST         = $item->vBCST;
            $produto->pICMSST       = $item->pICMSST;
            $produto->vICMSST       = $item->vICMSST;
            $produto->vBCFCPST      = $item->vBCFCPST;
            $produto->pFCPST        = $item->pFCPST;
            $produto->vFCPST        = $item->vFCPST;
            $produto->vICMSDeson    = $item->vICMSDeson;
            $produto->motDesICMS    = $item->motDesICMS;
            $produto->pRedBC        = $item->pRedBC;
            $produto->vICMSOp       = $item->vICMSOp;
            $produto->pDif          = $item->pDif;
            $produto->vICMSDif      = $item->vICMSDif;
            $produto->vBCSTRet      = $item->vBCSTRet;
            $produto->pST           = $item->pST;
            $produto->vICMSSTRet    = $item->vICMSSTRet;
            $produto->vBCFCPSTRet   = $item->vBCFCPSTRet;
            $produto->pFCPSTRet     = $item->pFCPSTRet;
            $produto->vFCPSTRet     = $item->vFCPSTRet;
            $produto->pRedBCEfet    = $item->pRedBCEfet;
            $produto->vBCEfet       = $item->vBCEfet;
            $produto->pICMSEfet     = $item->pICMSEfet;
            $produto->vICMSEfet     = $item->vICMSEfet;
            $produto->vICMSSubstituto= $item->vICMSSubstituto; //NT 2020.005 v1.20
            $produto->vICMSSTDeson  = $item->vICMSSTDeson; //NT 2020.005 v1.20
            $produto->motDesICMSST  = $item->motDesICMSST; //NT 2020.005 v1.20
            $produto->pFCPDif       = $item->pFCPDif; //NT 2020.005 v1.20
            $produto->vFCPDif       = $item->vFCPDif; //NT 2020.005 v1.20
            $produto->vFCPEfet      = $item->vFCPEfet; //NT 2020.005 v1.20          
            
           
            $produto->clEnq          = $item->clEnq;
            $produto->CNPJProd       = $item->CNPJProd;
            $produto->cSelo          = $item->cSelo;
            $produto->qSelo          = $item->qSelo;
            $produto->cEnq           = $item->cEnq;
            $produto->CST            = $item->cstIPI;
            $produto->vIPI           = $item->vIPI;
            $produto->vBC            = $item->vBCIPI;
            $produto->pIPI           = $item->pIPI;
            $produto->qUnidIPI       = $item->qUnidIPI;
            $produto->vUnidIPI       = $item->vUnidIPI;
            
           
            $produto->CST            = $item->cstPIS;
            $produto->vBC            = $item->vBCPIS;
            $produto->pPIS           = $item->pPIS;
            $produto->vPIS           = $item->vPIS;
            $produto->qBCProd        = $item->qBCProdPis;
            $produto->vAliqProd      = $item->vAliqProd_pis;
            
           
            $produto->cstCOFINS     = $item->cstCOFINS;
            $produto->vBCCOFINS     = $item->vBCCOFINS;
            $produto->pCOFINS       = $item->pCOFINS;
            $produto->vCOFINS       = $item->vCOFINS;
            $produto->qBCProdConfis = $item->qBCProdConfis;
            $produto->vAliqProd_cofins   = $item->vAliqProd_cofins;
            NfeItem::Create(objToArray($produto));
            
    }
           
        
        if($nfe->transporte){
            $transportadora               = new \stdClass();
            $transportadora->nfe_id       = $nfeSalva->id;
            $transportadora->transp_xNome = $nfe->transporte->transp_xNome;
            $transportadora->transp_IE    = $nfe->transporte->transp_IE;
            $transportadora->transp_xEnder= $nfe->transporte->transp_xEnder;
            $transportadora->transp_xMun  = $nfe->transporte->transp_xMun;
            $transportadora->transp_UF    = $nfe->transporte->transp_UF;
            $transportadora->transp_CNPJ  = $nfe->transporte->transp_CNPJ;//só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
            $transportadora->transp_CPF   = $nfe->transporte->transp_CPF;
            NfeTransporte::Create(objToArray($transportadora));
        }
        
        if($nfe->duplicatas){           
            foreach($nfe->duplicatas as $dup){
                $duplicata          = new \stdClass();
                $duplicata->nfe_id  = $nfeSalva->id;
                $duplicata->nDup    = $dup->nDup;
                $duplicata->dVenc   = $dup->dVenc;
                $duplicata->vDup    = $dup->vDup ;
                NfeDuplicata::Create(objToArray($duplicata));
                
            }
        }
        
        
    }
    
    public static function transferir($nfe){
        $nota            = new \stdClass();
        $nota->id        = $nfe->id;
        $nota->cUF       = $nfe->cUF;
        $nota->natOp     = $nfe->natOp;
        $nota->serie     = $nfe->serie;
        $nota->nNF       = $nfe->nNF;
        $nota->tpNF      = $nfe->tpNF;
        $nota->idDest    = $nfe->idDest;
        $nota->tpImp     = $nfe->tpImp;
        $nota->tpEmis    = $nfe->tpEmis;
        $nota->tpAmb     = $nfe->tpAmb;
        $nota->finNFe    = $nfe->finNFe;
        $nota->indFinal  = $nfe->indFinal;
        $nota->indPres   = $nfe->indPres;
        $nota->indIntermed = $nfe->indIntermed;
        $nota->procEmi   = $nfe->procEmi;
        $nota->verProc   = $nfe->verProc;        
        $nota->modFrete  = $nfe->modFrete;        
       
        //Emitente
        $emitente         = new \stdClass();
        $emitente->xNome  = $nfe->em_xNome;
        $emitente->xFant  = $nfe->em_xFant;
        $emitente->IE     = $nfe->em_IE;
        $emitente->IEST   = $nfe->em_IEST;
        $emitente->IM     = $nfe->em_IM;
        $emitente->CNAE   = $nfe->em_CNAE;
        $emitente->CRT    = $nfe->em_CRT;
        $emitente->CNPJ   = $nfe->em_CNPJ; //indicar apenas um CNPJ ou CPF
        $emitente->CPF    = $nfe->em_CPF;
        $emitente->xLgr   = $nfe->em_xLgr;
        $emitente->nro    = $nfe->em_nro;
        $emitente->xCpl   = $nfe->em_xCpl;
        $emitente->xBairro= $nfe->em_xBairro ;
        $emitente->cMun   = $nfe->em_cMun;
        $emitente->xMun   = $nfe->em_xMun;
        $emitente->UF     = $nfe->em_UF;
        $emitente->CEP    = $nfe->em_CEP;
        $emitente->cPais  = $nfe->em_cPais;
        $emitente->xPais  = $nfe->em_xPais;
        $emitente->fone   = $nfe->em_fone;
       
        
        $destinatario     = new \stdClass();
        
        if(count($nfe->destinatario) >0){
            $objDest                    = $nfe->destinatario[0];       
        
            $destinatario->xNome        = $objDest->dest_xNome;
            $destinatario->CNPJ			= $objDest->dest_CNPJ;
            $destinatario->CPF			= $objDest->dest_CPF;
            $destinatario->idEstrangeiro= $objDest->dest_idEstrangeiro;
            $destinatario->indIEDest	= $objDest->dest_indIEDest;
            $destinatario->IE			= $objDest->dest_IE;
            $destinatario->ISUF			= $objDest->dest_ISUF;
            $destinatario->IM			= $objDest->dest_IM;
            $destinatario->email		= $objDest->dest_email;
            $destinatario->xLgr			= $objDest->dest_xLgr;
            $destinatario->nro			= $objDest->dest_nro;
            $destinatario->xCpl			= $objDest->dest_xCpl;
            $destinatario->xBairro		= $objDest->dest_xBairro;
            $destinatario->cMun			= $objDest->dest_cMun;
            $destinatario->xMun			= $objDest->dest_xMun;
            $destinatario->UF			= $objDest->dest_UF;
            $destinatario->CEP			= $objDest->dest_CEP;
            $destinatario->cPais		= $objDest->dest_cPais;
            $destinatario->xPais		= $objDest->dest_xPais;
            $destinatario->fone			= $objDest->dest_fone;
        }
       
        $itens = array();
        if(count($nfe->itens) > 0){
            foreach($nfe->itens as $item){
                $produto            = new \stdClass();
                
                $produto->item 		= $item->numero_item;
                $produto->cProd 	= $item->cProd;
                $produto->cEAN 		= $item->cEAN;
                $produto->xProd 	= $item->xProd;
                $produto->NCM 		= $item->NCM;
                $produto->cBenef 	= $item->cBenef;
                $produto->EXTIPI 	= $item->EXTIPI;
                $produto->CFOP 		= $item->CFOP;
                $produto->uCom 		= $item->uCom;
                $produto->qCom 		= $item->qCom;
                $produto->vUnCom 	= $item->vUnCom;
                $produto->vProd 	= $item->vProd;
                $produto->cEANTrib 	= $item->cEANTrib;
                $produto->uTrib 	= $item->uTrib;
                $produto->qTrib 	= $item->qTrib;
                $produto->vUnTrib 	= $item->vUnTrib;
                $produto->vFrete 	= $item->vFrete;
                $produto->vSeg 		= $item->vSeg;
                $produto->vDesc 	= $item->vDesc;
                $produto->vOutro 	= $item->vOutro;
                $produto->indTot 	= $item->indTot;
                $produto->xPed 		= $item->xPed;
                $produto->nItemPed 	= $item->nItemPed;
                $produto->nFCI 		= $item->nFCI;
                
                $observacao = new \stdClass();
                //$observacao->item =1; //item da NFe
                //$observacao->infAdProd = 'informacao adicional do item';
                
                $imposto = new \stdClass();
                //$imposto->item       = 1; //item da NFe
               // $imposto->vTotTrib   = null;
               
                if($emitente->CRT == 1){
                    $icmssn              = new \stdClass();
                    $icmssn->item        = $item->numero_item; //item da NFe
                    $icmssn->orig        = $item->orig;
                    $icmssn->CSOSN       = $item->CSOSN;
                    $icmssn->pCredSN     = $item->pCredSN;
                    $icmssn->vCredICMSSN = $item->vCredICMSSN;
                    $icmssn->modBCST     = $item->modBCST;
                    $icmssn->pMVAST      = $item->pMVAST;
                    $icmssn->pRedBCST    = $item->pRedBCST;
                    $icmssn->vBCST       = $item->vBCST;
                    $icmssn->pICMSST     = $item->pICMSST;
                    $icmssn->vICMSST     = $item->vICMSST;
                    $icmssn->vBCFCPST    = $item->vBCFCPST; //incluso no layout 4.00
                    $icmssn->pFCPST      = $item->pFCPST; //incluso no layout 4.00
                    $icmssn->vFCPST      = $item->vFCPST; //incluso no layout 4.00
                    $icmssn->vBCSTRet    = $item->vBCSTRet;
                    $icmssn->pST         = $item->pST;
                    $icmssn->vICMSSTRet  = $item->vICMSSTRet;
                    $icmssn->vBCFCPSTRet = $item->vBCFCPSTRet; //incluso no layout 4.00
                    $icmssn->pFCPSTRet   = $item->pFCPSTRet; //incluso no layout 4.00
                    $icmssn->vFCPSTRet   = $item->vFCPSTRet; //incluso no layout 4.00
                    $icmssn->modBC       = $item->modBC;
                    $icmssn->vBC         = $item->vBCICMS;
                    $icmssn->pRedBC      = $item->pRedBC;
                    $icmssn->pICMS       = $item->pICMS;
                    $icmssn->vICMS       = $item->vICMS;
                    $icmssn->pRedBCEfet  = $item->pRedBCEfet;
                    $icmssn->vBCEfet     = $item->vBCEfet;
                    $icmssn->pICMSEfet   = $item->pICMSEfet;
                    $icmssn->vICMSEfet   = $item->vICMSEfet;
                    $icmssn->vICMSSubstituto = $item->vICMSSubstituto;
                }else{
                    $icms                = new \stdClass();
                    $icms->item          = $item->numero_item; //item da NFe
                    $icms->orig          = $item->orig;
                    $icms->CST           = $item->cstICMS;
                    $icms->modBC         = $item->modBC;
                    $icms->vBC           = $item->vBCICMS;
                    $icms->pICMS         = $item->pICMS;
                    $icms->vICMS         = $item->vICMS;
                    $icms->pFCP          = $item->pFCP;
                    $icms->vFCP          = $item->vFCP;
                    $icms->vBCFCP        = $item->vBCFCP;
                    $icms->modBCST       = $item->modBCST;
                    $icms->pMVAST        = $item->pMVAST;
                    $icms->pRedBCST      = $item->pRedBCST;
                    $icms->vBCST         = $item->vBCST;
                    $icms->pICMSST       = $item->pICMSST;
                    $icms->vICMSST       = $item->vICMSST;
                    $icms->vBCFCPST      = $item->vBCFCPST;
                    $icms->pFCPST        = $item->pFCPST;
                    $icms->vFCPST        = $item->vFCPST;
                    $icms->vICMSDeson    = $item->vICMSDeson;
                    $icms->motDesICMS    = $item->motDesICMS;
                    $icms->pRedBC        = $item->pRedBC;
                    $icms->vICMSOp       = $item->vICMSOp;
                    $icms->pDif          = $item->pDif;
                    $icms->vICMSDif      = $item->vICMSDif;
                    $icms->vBCSTRet      = $item->vBCSTRet;
                    $icms->pST           = $item->pST;
                    $icms->vICMSSTRet    = $item->vICMSSTRet;
                    $icms->vBCFCPSTRet   = $item->vBCFCPSTRet;
                    $icms->pFCPSTRet     = $item->pFCPSTRet;
                    $icms->vFCPSTRet     = $item->vFCPSTRet;
                    $icms->pRedBCEfet    = $item->pRedBCEfet;
                    $icms->vBCEfet       = $item->vBCEfet;
                    $icms->pICMSEfet     = $item->pICMSEfet;
                    $icms->vICMSEfet     = $item->vICMSEfet;
                    $icms->vICMSSubstituto= $item->vICMSSubstituto; //NT 2020.005 v1.20
                    $icms->vICMSSTDeson  = $item->vICMSSTDeson; //NT 2020.005 v1.20
                    $icms->motDesICMSST  = $item->motDesICMSST; //NT 2020.005 v1.20
                    $icms->pFCPDif       = $item->pFCPDif; //NT 2020.005 v1.20
                    $icms->vFCPDif       = $item->vFCPDif; //NT 2020.005 v1.20
                    $icms->vFCPEfet      = $item->vFCPEfet; //NT 2020.005 v1.20
                }
                
                $ipi                 = new \stdClass();
                $ipi->item           = $item->numero_item; //item da NFe
                $ipi->clEnq          = $item->clEnq;
                $ipi->CNPJProd       = $item->CNPJProd;
                $ipi->cSelo          = $item->cSelo;
                $ipi->qSelo          = $item->qSelo;
                $ipi->cEnq           = $item->cEnq;
                $ipi->CST            = $item->cstIPI;
                $ipi->vIPI           = $item->vIPI;
                $ipi->vBC            = $item->vBCIPI;
                $ipi->pIPI           = $item->pIPI;
                $ipi->qUnid          = $item->qUnidIPI;
                $ipi->vUnid          = $item->vUnidIPI;
                
                $pis                 = new \stdClass();
                $pis->item           = $item->numero_item; //item da NFe
                $pis->CST            = $item->cstPIS;
                $pis->vBC            = $item->vBCPIS;
                $pis->pPIS           = $item->pPIS;
                $pis->vPIS           = $item->vPIS;
                $pis->qBCProd        = $item->qBCProdPis;
                $pis->vAliqProd      = $item->vAliqProd_pis;
                
                $cofins              = new \stdClass();
                $cofins->item        = $item->numero_item; //item da NFe
                $cofins->CST         = $item->cstCOFINS;
                $cofins->vBC         = $item->vBCCOFINS;
                $cofins->pCOFINS     = $item->pCOFINS;
                $cofins->vCOFINS     = $item->vCOFINS;
                $cofins->qBCProd     = $item->qBCProdConfis;
                $cofins->vAliqProd   = $item->vAliqProd_cofins;  
                
                $itens[] = array(
                    "produto"    => $produto,
                    "observacao" => $observacao,
                    "imposto"    => $imposto,
                    "icms"       => ($icms) ?? null,
                    "icmssn"     => ($icmssn) ?? null,
                    "ipi"        => $ipi,
                    "pis"        => $pis,
                    "cofins"     => $cofins
                );
                
            }
        }
       
       
        $nota->vBC       = $nfe->vBC;
        $nota->vICMS     = $nfe->vICMS;
        $nota->vICMSDeson= $nfe->vICMSDeson;
        $nota->vFCP      = $nfe->vFCP; //incluso no layout 4.00
        $nota->vBCST     = $nfe->vBCST;
        $nota->vST       = $nfe->vST;
        $nota->vFCPST    = $nfe->vFCPST; //incluso no layout 4.00
        $nota->vFCPSTRet = $nfe->vFCPSTRet; //incluso no layout 4.00
        $nota->vProd     = $nfe->vProd;
        $nota->vFrete    = $nfe->vFrete;
        $nota->vSeg      = $nfe->vSeg;
        $nota->vDesc     = $nfe->vDesc;
        $nota->vII       = $nfe->vII;
        $nota->vIPI      = $nfe->vIPI;
        $nota->vIPIDevol = $nfe->vIPIDevol; //incluso no layout 4.00
        $nota->vPIS      = $nfe->vPIS;
        $nota->vCOFINS   = $nfe->vCOFINS;
        $nota->vOutro    = $nfe->vOutro;
        $nota->vNF       = $nfe->vNF;
        $nota->vTotTrib  = $nfe->vTotTrib;
        
        
        if(count($nfe->transporte) > 0){            
            $transportadora        = new \stdClass();
            $transportadora->xNome = $nfe->transporte->xNome;
            $transportadora->IE    = $nfe->transporte->IE;
            $transportadora->xEnder= $nfe->transporte->xEnder;
            $transportadora->xMun  = $nfe->transporte->xMun;
            $transportadora->UF    = $nfe->transporte->UF;
            $transportadora->CNPJ  = $nfe->transporte->CNPJ;//só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
            $transportadora->CPF   = $nfe->transporte->CPF;
        }
        
        $fatura          = new \stdClass();
        $fatura->nFat    = $nfe->nFat;
        $fatura->vOrig   = $nfe->vOrig;
        $fatura->vDesc   = $nfe->vDesc;
        $fatura->vLiq    = $nfe->vLiq;
        
       
        
        if($nfe->duplicatas){
            $duplicatas      = array();
            foreach($nfe->duplicatas as $dup){                        
                $duplicata       = new \stdClass();
                $duplicata->nDup = $dup->nDup;
                $duplicata->dVenc= $dup->dVenc;
                $duplicata->vDup = $dup->vDup ;
                $duplicatas[] = $duplicata;
            }
        }
        
        $pag = new \stdClass();
        $pag->vTroco = null; //incluso no layout 4.00, obrigatório informar para NFCe (65)    
        
        
        $detalhePagamento           = new \stdClass();
        $detalhePagamento->tPag     = $nfe->tPag;
        $detalhePagamento->vPag     = $nfe->vPag; //Obs: deve ser informado o valor pago pelo cliente
        $detalhePagamento->CNPJ     = null;
        $detalhePagamento->tBand    = null;
        $detalhePagamento->cAut     = null;
        $detalhePagamento->tpIntegra= null; //incluso na NT 2015/002
        $detalhePagamento->indPag   = '1'; //0= Pagamento à Vista 1= Pagamento à Prazo
        
        
        $intermediador               = new \stdClass();
       // $intermediador->CNPJ         = '12345678901234';
      //  $intermediador->idCadIntTran = 'Manoel Jailton';
        
        
        $responsavel_tecnico             = new \stdClass();
      /*  $responsavel_tecnico->CNPJ       = '01704817000103'; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
        $responsavel_tecnico->xContato   = 'Fulano de Tal'; //Nome da pessoa a ser contatada
        $responsavel_tecnico->email      = 'fulano@soft.com.br'; //E-mail da pessoa jurídica a ser contatada
        $responsavel_tecnico->fone       = '1155551122'; //Telefone da pessoa jurídica/física a ser contatada
        $responsavel_tecnico->CSRT       = 'G8063VRTNDMO886SFNK5LDUDEI24XJ22YIPO'; //Código de Segurança do Responsável Técnico
        $responsavel_tecnico->idCSRT     = '01'; //Identificador do CSRT
       */ 
        
        
        $dados = array(
            "nota"              => $nota,
            "emitente"          => $emitente,
            "destinatario"      => $destinatario,
            "itens"             => $itens,
            "transportadora"    => ($transportadora) ?? null,
            "fatura"            => ($fatura) ?? null,
            "duplicatas"        => ($duplicatas) ?? null,
            "pag"               => ($pag) ?? null,
            "detalhePagamento"  => ($detalhePagamento) ?? null,
            "intermediador"     => ($intermediador) ?? null,
            "responsavel_tecnico" => ($responsavel_tecnico) ?? null
        );
        $notafiscal = new \stdClass();
        $notafiscal->notafiscal = $dados;
        return $notafiscal;
        
    }
    
    public static function transferirNfce($nfce){
      
        $nota            = new \stdClass();
        $nota->id        = $nfce->id;
        $nota->cUF       = $nfce->cUF;
        $nota->natOp     = $nfce->natOp;
        $nota->serie     = $nfce->serie;
        $nota->nNF       = $nfce->nNF;
        $nota->tpNF      = $nfce->tpNF;
        $nota->idDest    = $nfce->idDest;
        $nota->tpImp     = $nfce->tpImp;
        $nota->tpEmis    = $nfce->tpEmis;
        $nota->tpAmb     = $nfce->tpAmb;
        $nota->finNFe    = $nfce->finNFe;
        $nota->indFinal  = $nfce->indFinal;
        $nota->indPres   = $nfce->indPres;
        $nota->indIntermed = $nfce->indIntermed;
        $nota->procEmi   = $nfce->procEmi;
        $nota->verProc   = $nfce->verProc;
        $nota->modFrete  = $nfce->modFrete;
        
        //Emitente
        $emitente         = new \stdClass();
        $emitente->xNome  = $nfce->em_xNome;
        $emitente->xFant  = $nfce->em_xFant;
        $emitente->IE     = $nfce->em_IE;
        $emitente->IEST   = $nfce->em_IEST;
        $emitente->IM     = $nfce->em_IM;
        $emitente->CNAE   = $nfce->em_CNAE;
        $emitente->CRT    = $nfce->em_CRT;
        $emitente->CNPJ   = $nfce->em_CNPJ; //indicar apenas um CNPJ ou CPF
        $emitente->CPF    = $nfce->em_CPF;
        $emitente->xLgr   = $nfce->em_xLgr;
        $emitente->nro    = $nfce->em_nro;
        $emitente->xCpl   = $nfce->em_xCpl;
        $emitente->xBairro= $nfce->em_xBairro ;
        $emitente->cMun   = $nfce->em_cMun;
        $emitente->xMun   = $nfce->em_xMun;
        $emitente->UF     = $nfce->em_UF;
        $emitente->CEP    = $nfce->em_CEP;
        $emitente->cPais  = $nfce->em_cPais;
        $emitente->xPais  = $nfce->em_xPais;
        $emitente->fone   = $nfce->em_fone;       
        
        
        $destinatario     = new \stdClass();
        if($nfce->cliente_cpf != null){            
            $destinatario->indIEDest    = 9 ;
            $destinatario->CPF          = $nota->cliente_cpf ;
            $destinatario->xNome        = $nota->cliente_nome ;
        }
        
        
        $itens = array();
        if(count($nfce->itens) > 0){
            foreach($nfce->itens as $item){
                $produto            = new \stdClass();
                
                $produto->item 		= $item->numero_item;
                $produto->cProd 	= $item->cProd;
                $produto->cEAN 		= $item->cEAN;
                $produto->xProd 	= $item->xProd;
                $produto->NCM 		= $item->NCM;
                $produto->cBenef 	= $item->cBenef;
                $produto->EXTIPI 	= $item->EXTIPI;
                $produto->CFOP 		= $item->CFOP;
                $produto->uCom 		= $item->uCom;
                $produto->qCom 		= $item->qCom;
                $produto->vUnCom 	= $item->vUnCom;
                $produto->vProd 	= $item->vProd;
                $produto->cEANTrib 	= $item->cEANTrib;
                $produto->uTrib 	= $item->uTrib;
                $produto->qTrib 	= $item->qTrib;
                $produto->vUnTrib 	= $item->vUnTrib;
                $produto->vFrete 	= $item->vFrete;
                $produto->vSeg 		= $item->vSeg;
                $produto->vDesc 	= $item->vDesc;
                $produto->vOutro 	= $item->vOutro;
                $produto->indTot 	= $item->indTot;
                $produto->xPed 		= $item->xPed;
                $produto->nItemPed 	= $item->nItemPed;
                $produto->nFCI 		= $item->nFCI;
                
                $observacao = new \stdClass();
                //$observacao->item =1; //item da NFe
                //$observacao->infAdProd = 'informacao adicional do item';
                
                $imposto = new \stdClass();
                //$imposto->item       = 1; //item da NFe
                // $imposto->vTotTrib   = null;
                
                if($emitente->CRT == 1){
                    $icmssn              = new \stdClass();
                    $icmssn->item        = $item->numero_item; //item da NFe
                    $icmssn->orig        = $item->orig;
                    $icmssn->CSOSN       = $item->CSOSN;
                    $icmssn->pCredSN     = $item->pCredSN;
                    $icmssn->vCredICMSSN = $item->vCredICMSSN;
                    $icmssn->modBCST     = $item->modBCST;
                    $icmssn->pMVAST      = $item->pMVAST;
                    $icmssn->pRedBCST    = $item->pRedBCST;
                    $icmssn->vBCST       = $item->vBCST;
                    $icmssn->pICMSST     = $item->pICMSST;
                    $icmssn->vICMSST     = $item->vICMSST;
                    $icmssn->vBCFCPST    = $item->vBCFCPST; //incluso no layout 4.00
                    $icmssn->pFCPST      = $item->pFCPST; //incluso no layout 4.00
                    $icmssn->vFCPST      = $item->vFCPST; //incluso no layout 4.00
                    $icmssn->vBCSTRet    = $item->vBCSTRet;
                    $icmssn->pST         = $item->pST;
                    $icmssn->vICMSSTRet  = $item->vICMSSTRet;
                    $icmssn->vBCFCPSTRet = $item->vBCFCPSTRet; //incluso no layout 4.00
                    $icmssn->pFCPSTRet   = $item->pFCPSTRet; //incluso no layout 4.00
                    $icmssn->vFCPSTRet   = $item->vFCPSTRet; //incluso no layout 4.00
                    $icmssn->modBC       = $item->modBC;
                    $icmssn->vBC         = $item->vBCICMS;
                    $icmssn->pRedBC      = $item->pRedBC;
                    $icmssn->pICMS       = $item->pICMS;
                    $icmssn->vICMS       = $item->vICMS;
                    $icmssn->pRedBCEfet  = $item->pRedBCEfet;
                    $icmssn->vBCEfet     = $item->vBCEfet;
                    $icmssn->pICMSEfet   = $item->pICMSEfet;
                    $icmssn->vICMSEfet   = $item->vICMSEfet;
                    $icmssn->vICMSSubstituto = $item->vICMSSubstituto;
                }else{
                    $icms                = new \stdClass();
                    $icms->item          = $item->numero_item; //item da NFe
                    $icms->orig          = $item->orig;
                    $icms->CST           = $item->cstICMS;
                    $icms->modBC         = $item->modBC;
                    $icms->vBC           = $item->vBCICMS;
                    $icms->pICMS         = $item->pICMS;
                    $icms->vICMS         = $item->vICMS;
                    $icms->pFCP          = $item->pFCP;
                    $icms->vFCP          = $item->vFCP;
                    $icms->vBCFCP        = $item->vBCFCP;
                    $icms->modBCST       = $item->modBCST;
                    $icms->pMVAST        = $item->pMVAST;
                    $icms->pRedBCST      = $item->pRedBCST;
                    $icms->vBCST         = $item->vBCST;
                    $icms->pICMSST       = $item->pICMSST;
                    $icms->vICMSST       = $item->vICMSST;
                    $icms->vBCFCPST      = $item->vBCFCPST;
                    $icms->pFCPST        = $item->pFCPST;
                    $icms->vFCPST        = $item->vFCPST;
                    $icms->vICMSDeson    = $item->vICMSDeson;
                    $icms->motDesICMS    = $item->motDesICMS;
                    $icms->pRedBC        = $item->pRedBC;
                    $icms->vICMSOp       = $item->vICMSOp;
                    $icms->pDif          = $item->pDif;
                    $icms->vICMSDif      = $item->vICMSDif;
                    $icms->vBCSTRet      = $item->vBCSTRet;
                    $icms->pST           = $item->pST;
                    $icms->vICMSSTRet    = $item->vICMSSTRet;
                    $icms->vBCFCPSTRet   = $item->vBCFCPSTRet;
                    $icms->pFCPSTRet     = $item->pFCPSTRet;
                    $icms->vFCPSTRet     = $item->vFCPSTRet;
                    $icms->pRedBCEfet    = $item->pRedBCEfet;
                    $icms->vBCEfet       = $item->vBCEfet;
                    $icms->pICMSEfet     = $item->pICMSEfet;
                    $icms->vICMSEfet     = $item->vICMSEfet;
                    $icms->vICMSSubstituto= $item->vICMSSubstituto; //NT 2020.005 v1.20
                    $icms->vICMSSTDeson  = $item->vICMSSTDeson; //NT 2020.005 v1.20
                    $icms->motDesICMSST  = $item->motDesICMSST; //NT 2020.005 v1.20
                    $icms->pFCPDif       = $item->pFCPDif; //NT 2020.005 v1.20
                    $icms->vFCPDif       = $item->vFCPDif; //NT 2020.005 v1.20
                    $icms->vFCPEfet      = $item->vFCPEfet; //NT 2020.005 v1.20
                }
                
                $ipi                 = new \stdClass();
                $ipi->item           = $item->numero_item; //item da NFe
                $ipi->clEnq          = $item->clEnq;
                $ipi->CNPJProd       = $item->CNPJProd;
                $ipi->cSelo          = $item->cSelo;
                $ipi->qSelo          = $item->qSelo;
                $ipi->cEnq           = $item->cEnq;
                $ipi->CST            = $item->cstIPI;
                $ipi->vIPI           = $item->vIPI;
                $ipi->vBC            = $item->vBCIPI;
                $ipi->pIPI           = $item->pIPI;
                $ipi->qUnid          = $item->qUnidIPI;
                $ipi->vUnid          = $item->vUnidIPI;
                
                $pis                 = new \stdClass();
                $pis->item           = $item->numero_item; //item da NFe
                $pis->CST            = $item->cstPIS;
                $pis->vBC            = $item->vBCPIS;
                $pis->pPIS           = $item->pPIS;
                $pis->vPIS           = $item->vPIS;
                $pis->qBCProd        = $item->qBCProdPis;
                $pis->vAliqProd      = $item->vAliqProd_pis;
                
                $cofins              = new \stdClass();
                $cofins->item        = $item->numero_item; //item da NFe
                $cofins->CST         = $item->cstCOFINS;
                $cofins->vBC         = $item->vBCCOFINS;
                $cofins->pCOFINS     = $item->pCOFINS;
                $cofins->vCOFINS     = $item->vCOFINS;
                $cofins->qBCProd     = $item->qBCProdConfis;
                $cofins->vAliqProd   = $item->vAliqProd_cofins;
                
                $itens[] = array(
                    "produto"    => $produto,
                    "observacao" => $observacao,
                    "imposto"    => $imposto,
                    "icms"       => ($icms) ?? null,
                    "icmssn"     => ($icmssn) ?? null,
                    "ipi"        => $ipi,
                    "pis"        => $pis,
                    "cofins"     => $cofins
                );
                
            }
        }
        
        
        $nota->vBC       = $nfce->vBC;
        $nota->vICMS     = $nfce->vICMS;
        $nota->vICMSDeson= $nfce->vICMSDeson;
        $nota->vFCP      = $nfce->vFCP; //incluso no layout 4.00
        $nota->vBCST     = $nfce->vBCST;
        $nota->vST       = $nfce->vST;
        $nota->vFCPST    = $nfce->vFCPST; //incluso no layout 4.00
        $nota->vFCPSTRet = $nfce->vFCPSTRet; //incluso no layout 4.00
        $nota->vProd     = $nfce->vProd;
        $nota->vFrete    = $nfce->vFrete;
        $nota->vSeg      = $nfce->vSeg;
        $nota->vDesc     = $nfce->vDesc;
        $nota->vII       = $nfce->vII;
        $nota->vIPI      = $nfce->vIPI;
        $nota->vIPIDevol = $nfce->vIPIDevol; //incluso no layout 4.00
        $nota->vPIS      = $nfce->vPIS;
        $nota->vCOFINS   = $nfce->vCOFINS;
        $nota->vOutro    = $nfce->vOutro;
        $nota->vNF       = $nfce->vNF;
        $nota->vTotTrib  = $nfce->vTotTrib;       
          
        
        $pag = new \stdClass();
        $pag->vTroco = null; //incluso no layout 4.00, obrigatório informar para NFCe (65)
        
        
        $detalhePagamento           = new \stdClass();
        $detalhePagamento->tPag     = $nfce->tPag;
        $detalhePagamento->vPag     = $nfce->vPag; //Obs: deve ser informado o valor pago pelo cliente
        $detalhePagamento->CNPJ     = null;
        $detalhePagamento->tBand    = null;
        $detalhePagamento->cAut     = null;
        $detalhePagamento->tpIntegra= null; //incluso na NT 2015/002
        $detalhePagamento->indPag   = $nfce->indPag; //0= Pagamento à Vista 1= Pagamento à Prazo
        
        
        $intermediador               = new \stdClass();
        // $intermediador->CNPJ         = '12345678901234';
        //  $intermediador->idCadIntTran = 'Manoel Jailton';
        
        
        $responsavel_tecnico             = new \stdClass();
        /*  $responsavel_tecnico->CNPJ    = '01704817000103'; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
         $responsavel_tecnico->xContato   = 'Fulano de Tal'; //Nome da pessoa a ser contatada
         $responsavel_tecnico->email      = 'fulano@soft.com.br'; //E-mail da pessoa jurídica a ser contatada
         $responsavel_tecnico->fone       = '1155551122'; //Telefone da pessoa jurídica/física a ser contatada
         $responsavel_tecnico->CSRT       = 'G8063VRTNDMO886SFNK5LDUDEI24XJ22YIPO'; //Código de Segurança do Responsável Técnico
         $responsavel_tecnico->idCSRT     = '01'; //Identificador do CSRT
         */
        
        $transportadora = new \stdClass();
        $fatura = new \stdClass();
        $duplicatas = new \stdClass();
        
        $dados = array(
            "nota"                  => $nota,
            "emitente"              => $emitente,
            "destinatario"          => $destinatario,
            "itens"                 => $itens,
            "transportadora"        => ($transportadora) ?? null,
            "fatura"                => ($fatura) ?? null,
            "duplicatas"            => ($duplicatas) ?? null,
            "pag"                   => ($pag) ?? null,
            "detalhePagamento"      => ($detalhePagamento) ?? null,
            "intermediador"         => ($intermediador) ?? null,
            "responsavel_tecnico"   => ($responsavel_tecnico) ?? null
        );
        $notafiscal = new \stdClass();
        $notafiscal->notafiscal = $dados;
        return $notafiscal;
        
    }
    
    public static function excluirNfe($id_nfe){
        NfeItem::where("nfe_id", $id_nfe)->delete();
        NfeTransporte::where("nfe_id", $id_nfe)->delete();
        NfeDuplicata::where("nfe_id", $id_nfe)->delete();
        NfeDestinatario::where("nfe_id", $id_nfe)->delete();
        Nfe::where("id", $id_nfe)->delete();
    }
}

