<?php 

use App\Models\Emitente;
use App\Models\Nfe;
use App\Models\NfeAutorizado;
use App\Models\NfeDestinatario;
use App\Models\NfeDuplicata;
use App\Models\NfeItem;
use App\Service\ConstanteService;

function criarTextoRodape($textoBase, $troca)
{
    $procura = ["{CLIENTE_NOME}", "{NUMERO_OS}", "{STATUS_OS}", "{VALOR_OS}", "{DESCRI_PRODUTOS}", "{EMITENTE}", "{TELEFONE_EMITENTE}", "{OBS_OS}", "{DEFEITO_OS}", "{LAUDO_OS}", "{DATA_FINAL}", "{DATA_INICIAL}", "{DATA_GARANTIA}"];
    $textoBase = str_replace($procura, $troca, $textoBase);
    $textoBase = strip_tags($textoBase);
    $textoBase = htmlentities(urlencode($textoBase));
    return $textoBase;
}


function inserirNfePelaVenda($venda, $natureza_operacao, $tributacao){
    $emitente           = Emitente::where("empresa_id", $venda->empresa_id)->first();
    $cliente            = $venda->cliente ;
    $retorno            = new \stdClass();
    try {
        $nota               = new \stdClass();
        $nota->cUF          = ConstanteService::getUf($cliente->uf);
        $nota->natOp        = $natureza_operacao->descricao;
        $nota->natureza_operacao_id = $natureza_operacao->id;
        //$nota->tipo_nfe_id  = config("constantes.tipo_notafiscal.VENDA");
        $nota->venda_id     = $venda->id;
        $nota->modelo       = config("constanteNota.mod.NFE");
        $nota->nNF          = $emitente->ultimo_numero_nfe + 1;
        $nota->serie        = $emitente->numero_serie_nfe;
        $nota->cNF          = rand($nota->nNF,99999999);
        $nota->dhEmi        = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->dhSaiEnt     = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->tpNF         = config("constanteNota.tpNf.SAIDA"); //0 - Entrada / 1 - Saida
        $nota->em_UF       = $emitente->uf;
        //Verifica o destino da operação
        if ($nota->em_UF != "EX"){
            if($nota->em_UF == $cliente->uf ){
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
        $nota->finNFe       = config("constanteNota.finNFe.NORMAL") ; //Finalidade emissão 1 - Normal
        $nota->indFinal     = $cliente->indFinal; // consumidor final
        $nota->indPres      = $natureza_operacao->indPres; //presença do comprador
        $nota->procEmi      = config("constanteNota.procEmi.APLICATIVO_CONTRIBUINTE");
        
        $nota->verProc      = '3.10.31';
        $nota->dhCont       = null;
        $nota->xJust        = null;
        $nota->indIntermed  = $emitente->indIntermed;
        $nota->cnpjIntermed = $emitente->cnpjIntermed ? tira_mascara($emitente->cnpjIntermed) : null ;
        $nota->idCadIntTran = $emitente->idCadIntTran;
        
        $nota->modFrete    = '9';
        $nota->em_xNome    = tiraAcento($emitente->razao_social);
        $nota->em_xFant    = tiraAcento($emitente->nome_fantasia);
        $nota->em_IE       = ($emitente->ie) ? tira_mascara($emitente->ie) : null ;
        $nota->em_IEST     = ($emitente->iest) ? tira_mascara($emitente->iest) : null;
        $nota->em_IM       = $emitente->im;
        $nota->em_CNAE     = ($emitente->cnae) ? tira_mascara($emitente->cnae) : null ;
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
        
        //Salvando a nota
        //Dados gerais
        $nota->nFat         = 1;
        $nota->vFrete       = ($venda->valor_frete) ? $venda->valor_frete : null;
        $nota->vSeg         = ($venda->total_seguro) ? $venda->total_seguro : null;
        $nota->vOutro       = ($venda->despesas_outras) ? $venda->despesas_outras : null;
        $nota->desconto_nota= ($venda->valor_desconto) ? $venda->valor_desconto : null;
        $nota->vDesc        = ($venda->valor_desconto) ? $venda->valor_desconto : null;
        
        $nota->infAdFisco   = $emitente->infAdFisco;
        $nota->infcpl       = $emitente->infcpl;
        
        //Frete
        if($venda->frete != null){
            $nota->modFrete    = $venda->frete->modFrete;
            if($venda->frete->placa != "" && $venda->frete->uf != ""){
                $nota->transp_placa       = strtoupper(tira_mascara($venda->frete->placa));
                $nota->UF_placa    = $venda->frete->uf;
            }
            if($venda->frete->qtdVolumes > 0 && $venda->frete->peso_liquido > 0  && $venda->frete->peso_bruto > 0){
                $nota->qVol    = $venda->frete->qtdVolumes;
                $nota->esp     = $venda->frete->especie != '*' ? $venda->frete->especie : '';
                
                $nota->nVol    = $venda->frete->numeracaoVolumes;
                $nota->pesoL   = $venda->frete->peso_liquido;
                $nota->pesoB   = $venda->frete->peso_bruto;
            }
            
        }
        
        //Tranportadora
        if($venda->transportadora){
            $nota->transp_xNome    = $venda->transportadora->razao_social;
            $nota->transp_xEnder   = $venda->transportadora->logradouro;
            $nota->transp_xMun     = strtoupper(tiraAcento($venda->transportadora->cidade));
            $nota->transp_UF       = $venda->transportadora->uf;
            $cnpj_cpf               = tira_mascara($venda->transportadora->cnpj);
            if(strlen($cnpj_cpf) == 14)
					$nota->transp_CNPJ = $cnpj_cpf;
                else
                    $nota->transp_CPF = $cnpj_cpf;
        }
        
        $nota->status_id    = config("constantes.status.DIGITACAO");
        
        $nfe                = Nfe::Create(objToArray($nota));
        
        $id_nfe             = $nfe->id;
        
        $emitente->ultimo_numero_nfe = $nota->nNF;
        $emitente->save();
        
        
        $dest                   = new \stdClass();
        $dest->nfe_id           = $id_nfe;
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
        
        $destinatario           = NfeDestinatario::where("nfe_id", $nfe->id)->first();
        if(!$destinatario){
            NfeDestinatario::create(objToArray($dest));
        }else{
            $destinatario->update(objToArray($dest));
        }
        
        //Inserindo Itens
        foreach($venda->itens as $i){
            $item                       = new \stdClass();
            $item->nfe_id               = $id_nfe;
            $item->qCom                 = $i->quantidade;
            $item->cProd                = $i->produto_id;
            
            $item->vUnCom               = $i->valor - $i->desconto_por_unidade;
            $item->uCom                 = tiraAcento($i->unidade);
            $item->vProd                = $i->subtotal_liquido ;
            
            $item->preco_original       = $i->valor;
            $item->desconto_por_valor   = $i->desconto_por_valor;
            $item->desconto_percentual  = $i->desconto_percentual;
            $item->desconto_por_unidade = $i->desconto_por_unidade;            
            $item->total_desconto_item  = $i->total_desconto_item;
            $item->subtotal_liquido     = $i->subtotal_liquido ;
            $item->desconto_item        = $i->desconto_por_unidade;            
            
            try {
                NfeItem::Create(objToArray($item));
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            
        }
        
        //Duplicata
        if(count($venda->duplicatas) > 0){
            $contFatura = 1;
            foreach($venda->duplicatas as $ft){
                $dup        = new \stdClass();
                $dup->nfe_id= $id_nfe;
                $dup->nDup  = $ft->nDup;
                $dup->dVenc = $ft->dVenc;
                $dup->vDup  = $ft->vDup;
                $dup->tPag  = $ft->tPag;
                $dup->obs   = $ft->obs;
                NfeDuplicata::Create(objToArray($dup));
                $contFatura++;
            }
        }
        
        if($emitente->autorizados){
            foreach ($emitente->autorizados as $autorizado){
                NfeAutorizado::Create(["nfe_id"=>$nfe->id,"aut_contato"=>$autorizado->aut_contato, "aut_cnpj"=>$autorizado->aut_cnpj]);
            }
        }
        
        $retorno->tem_erro  = false;
        $retorno->erro      = "";
        $retorno->titulo    = "Nota Criada com sucesso!";
        $retorno->retorno   = $id_nfe;
        return $retorno;
    } catch (\Exception $e) {
        $retorno->tem_erro  = true;
        $retorno->erro      = $e->getMessage();
        $retorno->titulo    = "Erro ao criar Nfe";
        $retorno->retorno   = null;
        return $retorno;
    }
    return $retorno;
}

function inserirNfePelaPedidoDaLoja($pedido, $natureza_operacao, $tributacao){
    $emitente               = Emitente::where("empresa_id", $pedido->empresa_id)->first();    
    $cliente                = $pedido->cliente ;

    $retorno                = new \stdClass();
    try {
        $nota               = new \stdClass();
        $nota->cUF          = ConstanteService::getUf($cliente->uf);
        $nota->natOp        = $natureza_operacao->descricao;
        $nota->natureza_operacao_id = $natureza_operacao->id;
        //$nota->tipo_nfe_id  = config("constantes.tipo_notafiscal.VENDA");
        $nota->loja_pedido_id     = $pedido->id;
        $nota->modelo       = config("constanteNota.mod.NFE");
        $nota->nNF          = $emitente->ultimo_numero_nfe + 1;
        $nota->serie        = $emitente->numero_serie_nfe;
        $nota->cNF          = rand($nota->nNF,99999999);
        $nota->dhEmi        = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->dhSaiEnt     = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->tpNF         = config("constanteNota.tpNf.SAIDA"); //0 - Entrada / 1 - Saida
        $nota->em_UF       = $emitente->uf;
        
        //Verifica o destino da operação
        if ($nota->em_UF != "EX"){
            if($nota->em_UF == $cliente->uf ){
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
        $nota->finNFe       = config("constanteNota.finNFe.NORMAL") ; //Finalidade emissão 1 - Normal
        $nota->indFinal     = $cliente->indFinal; // consumidor final
        $nota->indPres      = $natureza_operacao->indPres; //presença do comprador
        $nota->procEmi      = config("constanteNota.procEmi.APLICATIVO_CONTRIBUINTE");
        
        $nota->verProc      = '3.10.31';
        $nota->dhCont       = null;
        $nota->xJust        = null;
        $nota->indIntermed  = $emitente->indIntermed;
        $nota->cnpjIntermed = $emitente->cnpjIntermed ? tira_mascara($emitente->cnpjIntermed) : null ;
        $nota->idCadIntTran = $emitente->idCadIntTran;
        
        $nota->modFrete    = '9';
        $nota->em_xNome    = tiraAcento($emitente->razao_social);
        $nota->em_xFant    = tiraAcento($emitente->nome_fantasia);
        $nota->em_IE       = ($emitente->ie) ? tira_mascara($emitente->ie) : null ;
        $nota->em_IEST     = ($emitente->iest) ? tira_mascara($emitente->iest) : null;
        $nota->em_IM       = $emitente->im;
        $nota->em_CNAE     = ($emitente->cnae) ? tira_mascara($emitente->cnae) : null ;
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
        
        //Dados gerais
        $nota->nFat         = 1;
        $nota->vFrete       = ($pedido->valor_frete) ? $pedido->valor_frete : null;
        $nota->desconto_nota= ($pedido->valor_desconto) ? $pedido->valor_desconto : null;
        
        $nota->infAdFisco   = $emitente->infAdFisco;
        $nota->infcpl       = $emitente->infcpl;
        //Frete
    /*    if($venda->frete != null){
            $nota->modFrete    = $venda->frete->modFrete;
            if($venda->frete->placa != "" && $venda->frete->uf != ""){
                $nota->transp_placa       = strtoupper(tira_mascara($venda->frete->placa));
                $nota->UF_placa    = $venda->frete->uf;
            }
            if($venda->frete->qtdVolumes > 0 && $venda->frete->peso_liquido > 0  && $venda->frete->peso_bruto > 0){
                $nota->qVol    = $venda->frete->qtdVolumes;
                $nota->esp     = $venda->frete->especie != '*' ? $venda->frete->especie : '';
                
                $nota->nVol    = $venda->frete->numeracaoVolumes;
                $nota->pesoL   = $venda->frete->peso_liquido;
                $nota->pesoB   = $venda->frete->peso_bruto;
            }
            
        }
        */
        //Tranportadora
      /*  if($venda->transportadora){
            $nota->transp_xNome    = $venda->transportadora->razao_social;
            $nota->transp_xEnder   = $venda->transportadora->logradouro;
            $nota->transp_xMun     = strtoupper(tiraAcento($venda->transportadora->cidade));
            $nota->transp_UF       = $venda->transportadora->uf;
            $cnpj_cpf               = tira_mascara($venda->transportadora->cnpj);
            if(strlen($cnpj_cpf) == 14)
                $nota->transp_CNPJ = $cnpj_cpf;
                else
                    $nota->transp_CPF = $cnpj_cpf;
        }
        */
        $nota->status_id    = config("constantes.status.DIGITACAO");
        
        $nfe                = Nfe::Create(objToArray($nota));        
        $id_nfe             = $nfe->id;
        
        $emitente->ultimo_numero_nfe = $nota->nNF;
        $emitente->save();        
        
        $dest                   = new \stdClass();
        $dest->nfe_id           = $id_nfe;
        $dest->dest_xNome    	= tiraAcento($cliente->nome_razao_social);
        
        $dest->dest_indIEDest	= $cliente->tipo_contribuinte;
        $dest->dest_ISUF     	= $cliente->suframa ?? null;
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
        $destinatario           = NfeDestinatario::where("nfe_id", $nfe->id)->first();
        if(!$destinatario){
            NfeDestinatario::create(objToArray($dest));
        }else{
            $destinatario->update(objToArray($dest));
        }
        
        //Inserindo Itens
        foreach($pedido->itens as $i){
            $item                  = new \stdClass();
            $item->nfe_id          = $id_nfe;
            $item->qCom            = $i->quantidade;
            $item->cProd           = $i->produto_id;
            $item->vUnCom          = $i->valor;
            $item->vProd           = $i->subtotal ;
            
            $item->desconto_item   = $i->desconto_por_unidade;
            $item->desconto_por_unidade   = $i->desconto_por_unidade;
            $item->total_desconto_item   = $i->total_desconto_item;
            $item->desconto_percentual   = $i->desconto_percentual;
            $item->desconto_por_valor   = $i->desconto_por_valor;
            $item->subtotal_liquido= $i->subtotal_liquido ;
            $item->uCom            = tiraAcento($i->unidade);
            try {
                NfeItem::Create(objToArray($item));
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }            
        }
        
        //Duplicata
        if(count($pedido->duplicatas) > 0){
            $contFatura = 1;
            foreach($pedido->duplicatas as $ft){
                $dup        = new \stdClass();
                $dup->nfe_id= $id_nfe;
                $dup->nDup  = $contFatura;
                $dup->dVenc = $ft->data_vencimento;
                $dup->vDup  = $ft->total_liquido;
                $dup->tPag  = $pedido->forma_pagto_id;
                $dup->obs   = "";
                NfeDuplicata::Create(objToArray($dup));
                $contFatura++;
            }
        }
        
        if($emitente->autorizados){
            foreach ($emitente->autorizados as $autorizado){
                NfeAutorizado::Create(["nfe_id"=>$nfe->id,"aut_contato"=>$autorizado->aut_contato, "aut_cnpj"=>$autorizado->aut_cnpj]);
            }
        }
        
        $retorno->tem_erro  = false;
        $retorno->erro      = "";
        $retorno->titulo    = "Nota Criada com sucesso!";
        $retorno->retorno   = $id_nfe;
        return $retorno;
    } catch (\Exception $e) {
        $retorno->tem_erro  = true;
        $retorno->erro      = $e->getMessage();
        $retorno->titulo    = "Erro ao criar Nfe";
        $retorno->retorno   = null;
        return $retorno;
    }
    return $retorno;
}