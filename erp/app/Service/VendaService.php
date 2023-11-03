<?php
namespace App\Service;

use App\Models\Emitente;
use App\Models\FinContaReceber;
use App\Models\NaturezaOperacao;
use App\Models\Tributacao;
use App\Models\Venda;

class VendaService{
    
    public static function depois_da_venda($id_venda, $opcao){
        if($opcao == 2){
            $nfe = self::salvarNfePorVenda($id_venda);
            return $nfe;
        }else if($opcao >=3 ){
            $nfe = self::salvarNfePorVenda($id_venda);           
            if($nfe->tem_erro == false){
                $transmissao = self::transmitirNfe($nfe->retorno);                
                return $transmissao;
            }else{
                return $nfe;
            }
            return $nfe;
        }
    }
    
    public static function salvarNfePorVenda($id_venda){        
        $natureza_operacao  = NaturezaOperacao::where("padrao", config('constantes.padrao_natureza.VENDA'))->first();
        $tributacao         = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();       
        $venda              = Venda::find($id_venda);
        $retorno            = NotaFiscalOperacaoService::inserirNfePelaVenda($venda, $natureza_operacao, $tributacao);
        NotaFiscalOperacaoService::atualizarTotaisDaNota($retorno->retorno);
        ItemNotafiscalService::refazTodosCalculos($retorno->retorno);
        return $retorno; 
    }
    
    public static function retornarEdicao($venda_id){
        $contas     = FinContaReceber::where("venda_id", $venda_id)->first();
        $venda   = Venda::find($venda_id); 
        if(!$contas && $venda->estornou_estoque=="S"){
            $venda->status_id               = config('constantes.status.DIGITACAO');
            $venda->status_financeiro_id    = config('constantes.status.DIGITACAO');
            $venda->estornou_estoque        = "N";
            $venda->save();
        }
    }
    
    public static function transmitirNfe($id_nfe){        
        $url         = getenv("APP_URL_API"). "nfe/transmitirPelaNfe/".$id_nfe;
        $resultado   = enviarGetCurl($url);
        return $resultado;        
    }
    
    public static function cancelarVenda($id_venda){
        $tipo       = config("constantes.tipo_movimento.ENTRADA_CANCELAMENTO_VENDA");
        $descricao  = "Cancelamento da Venda: #" . $id_venda;
        MovimentoService::estornarEstoqueDaVenda($id_venda, $tipo, $descricao);
        ContaReceberSevice::cancelarContaReceber($id_venda);
        Venda::where("id", $id_venda)->update(["status_id"=>config("constantes.status.DELETADO"), "status_financeiro_id"=>config("constantes.status.DELETADO")]);
                
    }
    
    public static function cancelarNotaFiscal($nfe, $justificativa){                
        if($nfe){
            if($nfe->status_id == config("constantes.status.AUTORIZADO") ){
                $retorno =  NfeService::cancelarNfe($nfe,$justificativa);   
                return json_decode($retorno);
            }elseif($nfe->status_id == config("constantes.status.CANCELADO") ){                
                $retorno = new \stdClass();
                $retorno->tem_erro = false;
                return $retorno;
            }elseif($nfe->status_id == config("constantes.status.DELETADO") ){           
                $retorno = new \stdClass();
                $retorno->tem_erro = false;
                return $retorno;
            }elseif($nfe->status_id == config("constantes.status.INUTILIZADO") ){
                $retorno = new \stdClass();
                $retorno->tem_erro = false;
                return $retorno;
            }else{
                $retorno = NfeService::inutilizar($nfe);
                return json_decode($retorno);
            }           
           
        }
    }
       
    
    public static function getDadosParaGerarNfe($venda){
        $emitente           = Emitente::where("empresa_id", $venda->empresa_id)->first();
        $cliente            = $venda->cliente ;    
        $nota               = new \stdClass();
        $nota->cUF          = ConstanteService::getUf($cliente->uf);
        $nota->natOp        = $emitente->nat_op_padrao_nfe;        
        $nota->venda_id     = $venda->id;
        $nota->modelo       = 55;
        $nota->serie        = $emitente->numero_serie_nfe;
        $nota->nNF          = $emitente->ultimo_numero_nfe + 1;
        $nota->cNF          = rand($nota->nNF,99999999);
        $nota->dhEmi        = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->dhSaiEnt     = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->tpNF         = 1 ; //0 - Entrada / 1 - Saida        
        //Verifica o destino da operação
        if ($nota->cUF != "EX"){
            if($nota->cUF == $cliente->uf ){
                $nota->idDest = 1;
            }else{
                $nota->idDest = 2;
            }
        }else{
            $nota->idDest       = 3;
        }
        
        $nota->cMunFG       = $emitente->ibge;
        $nota->tpImp        = 1; //formato do danfe
        $nota->tpEmis       = 1; //tipo emissão - 1 - normal
        
        $nota->tpAmb        = $emitente->ambiente_nfe;
        $nota->finNFe       = 1; //Finalidade emissão 1 - Normal
        $nota->indFinal     = 1; // consumidor final
        $nota->indPres      = 2; //presença do comprador
        $nota->procEmi      = '0';
        $nota->verProc      = '3.10.31';
        $nota->dhCont       = null;
        $nota->xJust        = null;        
        $nota->indIntermed  = 0;
        /*if($venda->pedido_loja_id > 0){
            $nota->indIntermed = 1;
        }else{
            $nota->indIntermed = 0;
        }*/
       
        
        $nota->modFrete    = '9';
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
        
       
        
        $dest                   = new \stdClass();
        $dest->dest_xNome    	= tiraAcento($cliente->nome_razao_social);
        
        $dest->dest_indIEDest	= $cliente->tipo_contribuinte;
        $dest->dest_ISUF     	= $cliente->suframa;
        $dest->dest_IM       	= $cliente->im;
        $dest->dest_email    	= $cliente->email;
        $cnpj_cpf               = tira_mascara($cliente->cpf_cnpj);
        
        if(strlen($cnpj_cpf) == 14){
            $dest->dest_CNPJ = $cnpj_cpf;
            $dest->dest_IE   = tira_mascara($cliente->rg_ie);
        }
        else{
            $dest->dest_CPF  = $cnpj_cpf;
        }
        
        $dest->dest_idEstrangeiro=null;
        $dest->dest_xLgr     	= tiraAcento($cliente->logradouro);
        $dest->dest_nro      	= $cliente->numero;
        $dest->dest_xCpl     	= tiraAcento($cliente->complemento);
        $dest->dest_xBairro  	= tiraAcento($cliente->bairro);
        $dest->dest_cMun     	= $cliente->ibge;
        $dest->dest_xMun     	= strtoupper(tiraAcento($cliente->cidade));
        $dest->dest_UF       	= $cliente->uf;
        $dest->dest_CEP      	= tira_mascara($cliente->cep);
        $dest->dest_cPais       = "1058";
        $dest->dest_xPais       = "Brasil";
        $dest->dest_fone     	= ($cliente->telefone) ? tira_mascara($cliente->telefone) : null ;
        
        $nota->destinatario     = $dest;
        
        // $total              = 0;
        $totTrib            = 0;
        
        $somaProdutos       = 0;
        
        $totalItens         = count($venda->itens);
        
        $somaFrete          = 0;
        $somaIPI            = 0;
        $somaDesconto       = 0;
        $itemCont           = 0;
        $nfItens            = array();
        foreach($venda->itens as $i){
            $itemCont++;
            $produto        = $i->produto;
            $item           = new \stdClass();
            $item->numero_item = $itemCont  ;
            $item->cProd    = $produto->id;
            $item->cEAN     = ($produto->gtin) ? $produto->gtin :"SEM GTIN";
            $item->xProd    = tiraAcento($produto->nome);
            $item->NCM      = $produto->ncm;
            $item->cBenef   = $produto->cbenef; //incluido no layout 4.00
            $item->EXTIPI   = $produto->tipi;
            
            $cfop           = $emitente->uf == $cliente->uf ? $produto->cfop : intval($produto->cfop) + 1000;
            $item->CFOP     = $cfop;
            
            $item->uCom     = tiraAcento($produto->unidade);
            $item->qCom     = $i->quantidade;
            $item->vUnCom   = $i->valor;
            $item->vProd    = $item->qCom * $item->vUnCom;
            
            $item->cEANTrib = ($produto->gtin) ? $produto->gtin :"SEM GTIN";
            
            if($produto->unidade_tributavel == ''){
                $item->uTrib = tiraAcento($produto->unidade);
            }else{
                $item->uTrib = tiraAcento($produto->unidade_tributavel);
            }
            
            if($produto->quantidade_tributavel == 0){
                $item->qTrib = $i->quantidade;
            }else{
                $item->qTrib = $produto->quantidade_tributavel * $i->quantidade;
            }
            
            $item->vUnTrib  = $i->valor;
            $item->indTot   = 1; //ver depois
            $somaProdutos   += $item->vProd;
            
            $item->vFrete   = null;
            $item->vSeg     = null;
            $item->vDesc    = null;
            $item->vOutro   = null;
            
            $vDesc = 0;
            if($venda->valor_desconto > 0){
                if($itemCont < sizeof($venda->itens)){
                    $totalVenda = $venda->valor_venda;
                    $media = (((($item->vProd - $totalVenda)/$totalVenda))*100);
                    $media = 100 - ($media * -1);
                    
                    $tempDesc = ($venda->valor_desconto * $media)/100;
                    $somaDesconto += $tempDesc;
                    $vDesc     = $item->vDesc = formataNumero($tempDesc);
                }else{
                    $vDesc     = $item->vDesc = formataNumero($venda->valor_desconto - $somaDesconto);
                }
            }
            
            if($venda->frete){
                if($venda->frete->valor > 0){
                    $somaFrete += $vFt = $venda->frete->valor/$totalItens;
                    $item->vFrete = formataNumero($vFt);
                }
            }            
            
            $item->infAdProd= $i->observacao;
            $item->nItemPed = $item->numero_item;
            $item->nFCI     = $i->nfci;
            
            $tributacao     = Tributacao::find($produto->tributacao_id);
         
            //IPI
            IpiService::calculo($item, $tributacao)  ;
            if($item->vIPI){
                $somaIPI += $item->vIPI;
            }
            
            //PIS
            PisService::calculo($item, $tributacao);
            //Confins
            CofinsService::calculo($item, $tributacao);
            //ICMS
            if($nota->em_CRT >1){
                IcmsService::calculoICMS($item, $tributacao);
            }else{
                IcmsService::calculoIcmsSn($item, $tributacao);
            }            
            $nfItens[] = $item;
            
        }
        
        $nota->vProd      = $somaProdutos;
        
        $nota->vFrete     = ($venda->frete) ??  0.00;
        $nota->vDesc     = ($venda->valor_desconto) ?? 0.00;
        
        if($venda->frete){
            $nota->vNF    = ($somaProdutos + $venda->frete->valor + $somaIPI) - $venda->valor_desconto;
        } else
            $nota->vNF    = $somaProdutos + $somaIPI - $venda->valor_desconto;            
            
            //Fatura
            $nota->nFat  = 1;
            $nota->vOrig = $somaProdutos;
            $nota->vDesc = $venda->valor_desconto;
            $nota->vLiq  = $somaProdutos-$venda->valor_desconto;
            
            //Pagamento
            $nota->tPag  = $venda->tPag;
            $nota->vPag  = $venda->tPag != '90' ? $somaProdutos - $venda->valor_desconto : 0.00;
            
            if($venda->tPag == '03' || $venda->tPag == '04'){
                if($venda->cAut_cartao != ""){
                    $nota->cAut = $venda->cAut_cartao;
                }
                if($venda->cnpj_cartao != ""){
                    $cnpj = tira_mascara($venda->cnpj_cartao);
                    $nota->CNPJ_pag = $cnpj;
                }
                $nota->tBand = $venda->bandeira_cartao;
                
                $nota->tpIntegra = 2;
            }
            $nota->indPag = $venda->forma_pagamento == 'a_vista' ?  0 : 1;            
           
            
            //Transporte
            $tansp = new \stdClass();
            $tem_transporte = false;
            if($venda->transportadora){
                $tem_transporte = true;
                $tansp->xNome     = $venda->transportadora->razao_social;
                $tansp->xEnder    = $venda->transportadora->logradouro;
                $tansp->xMun      = strtoupper(tiraAcento($venda->transportadora->cidade));
                $tansp->UF        = $venda->transportadora->uf;
                $cnpj_cpf  = tira_mascara($venda->transportadora->cnpj);
                if(strlen($cnpj_cpf) == 14)
                    $tansp->CNPJ = $cnpj_cpf;
                    else
                        $tansp->CPF = $cnpj_cpf;
            }
            
            if($venda->frete != null){
                $tem_transporte = true;
                if($venda->frete->placa != "" && $venda->frete->uf != ""){
                    $tansp->placa       = strtoupper(tira_mascara($venda->frete->placa));
                    $tansp->UF_placa    = $venda->frete->uf;
                }
                if($venda->frete->qtdVolumes > 0 && $venda->frete->peso_liquido > 0  && $venda->frete->peso_bruto > 0){
                    $tansp->item = 1;
                    $tansp->modFrete= $venda->frete->modfrete;
                    $tansp->qVol    = $venda->frete->qtdVolumes;
                    $tansp->esp     = $venda->frete->especie != '*' ? $venda->frete->especie : '';
                    
                    $tansp->nVol    = $venda->frete->numeracaoVolumes;
                    $tansp->pesoL   = $venda->frete->peso_liquido;
                    $tansp->pesoB   = $venda->frete->peso_bruto;
                }
                
                $nota->transporte = $tansp;                
            }
            
                        
            //Duplicata
            $nota->duplicatas[] = array();
            if(count($venda->duplicatas) > 0){
                $contFatura = 1;
                foreach($venda->duplicatas as $ft){
                    $dup        = new \stdClass();
                    $dup->nDup  = "00".$contFatura;
                    $dup->dVenc = substr($ft->data_vencimento, 0, 10);
                    $dup->vDup  = $ft->valor;
                    $contFatura++;
                    $nota->duplicatas[] = $dup;
                }
            }
            
            $retorno = (object) array(
                "nfe"   =>$nota,
                "itens" =>$nfItens
            );
            
            return $retorno;
            
    }
}

