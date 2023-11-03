<?php
namespace App\Service;


class VendaService{
    public static function verificarSemTemVendaAberta($caixa_id){
        $url         = getenv("APP_URL_API"). "pdv/verificarVendaAberta/".session("usuario_pdv_logado")->uuid ;
        
        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
    
    public  static function armazenarVenda($dados){
        $dados["empresa_id"]      = session("usuario_pdv_logado")->empresa_id;
        $dados["usuario_uuid"]    = session("usuario_pdv_logado")->uuid;        
        $url        = getenv("APP_URL_API"). "pdv/armazenarVenda";
     /*   echo $url;
        i(json_encode($dados));*/
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        $retorno    = json_decode($resultado);
  
        if(!isset($retorno->data)){
            throw new \Exception("Erro ao buscar no servidor");
        }
        return $retorno->data;
    }
    
    public static function finalizarVenda($venda){
        $url        = getenv("APP_URL_API"). "pdvvenda/finalizarVenda";
        /* echo $url;
         echo json_encode($venda);
         exit;*/
        $resultado  = enviarPostJsonCurl($url,json_encode($venda));
        //   i($resultado);
        return json_decode($resultado);
    }
    
    public static function cancelarVenda($venda){
        $url        = getenv("APP_URL_API"). "pdvvenda/cancelarVenda";
         /*echo $url;
         echo json_encode($venda);
         exit;*/
        $resultado  = enviarPostJsonCurl($url,json_encode($venda));
        return json_decode($resultado);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public static function iniciarPdvVenda($caixa_id){
        $url         = getenv("APP_URL_API"). "pdvvenda/iniciarPdvVenda/".session("usuario_pdv_logado")->uuid ;		

        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
    
    public static function getVendaAbertaPorUsuario($caixa_id){
        $url         = getenv("APP_URL_API"). "pdvvenda/getVendaAbertaPorUsuario/".session("usuario_pdv_logado")->uuid ."/" . $caixa_id;   
       
        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
        
    public static function salvar($venda){
        $url        = getenv("APP_URL_API"). "pdvvenda/salvar";      
        
        $resultado  = enviarPostJsonCurl($url,json_encode($venda));
        return $resultado;
    } 
    
    
    
    
    public static function salvarItens($dados){
        $url        = getenv("APP_URL_API"). "pdvvenda/salvarItens";
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
      
        return $resultado;
    } 
    
    public static function inserirItem($dados){
        $url        = getenv("APP_URL_API"). "pdvvenda/inserirItem"; 
    
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        return json_decode($resultado);
    } 
    
    public static function excluirItem($id, $id_venda){
        $url         = getenv("APP_URL_API"). "pdvvenda/excluirItem/". $id . "/". $id_venda;
        $resultado   = enviarGetCurl($url);
        return $resultado;
    }
    
    public static function salvarPagamento($dados){
        $url        = getenv("APP_URL_API"). "pdvvenda/salvarPagamento";     
       /* echo $url;
        echo json_encode($dados);
        exit;*/
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));  
        
        return json_decode($resultado);
    } 
    
    public static function enviarDescontoAcrescimento($dados){
        $url        = getenv("APP_URL_API"). "pdvvenda/enviarDescontoAcrescimento";
       
        $resultado  = enviarPostJsonCurl($url,json_encode($dados));
        return json_decode($resultado);
    } 
    
    public static function listaPorUsuario($id_usuario){
        $url         = getenv("APP_URL_API"). "pdvvenda/listaPorUsuario/". $id_usuario;
        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
            
    public static function listaPorCaixa($id_caixa){
        $url         = getenv("APP_URL_API"). "pdvvenda/listaPorCaixa/". $id_caixa;    
        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
    
    public static function getVenda($id_venda){
        $url         = getenv("APP_URL_API"). "pdvvenda/getVendaPorId/". $id_venda;
        $resultado   = enviarGetCurl($url);
        return $resultado->data;
    }
    
    public static function excluirDuplicata($id, $id_venda){
        $url         = getenv("APP_URL_API"). "pdvvenda/excluirDuplicata/". $id . "/". $id_venda; 
       
        $resultado   = enviarGetCurl($url);
        return $resultado;
    }
    
     
    
    public static function getDadosParaGerarNfce($venda, $itens){
        $d                  = array("empresa_id"=> getenv("APP_ID_EMPRESA"),"itens"=>$itens );        
        $url                = getenv("APP_URL_API"). "pdv/getDadosParaGerarNfce";
        $dados              = json_decode(enviarPostJsonCurl($url,json_encode($d))); 
        
        $emitente           = $dados->emitente;
        $produtos           = $dados->produtos;
      
        $nota               = new \stdClass();
        $nota->cUF          = ConstanteService::getUf($emitente->uf);
        $nota->natOp        = $emitente->nat_op_padrao_nfce;
        
        $nota->mod          = 65;
        $nota->serie        = $emitente->numero_serie_nfce;
        $nota->tpNF         = 1 ; //0 - Entrada / 1 - Saida
        $nota->idDest       = 1;
        
        $nota->cMunFG       = $emitente->ibge;
        $nota->tpImp        = 4; //formato do danfce
        $nota->tpEmis       = 1; //tipo emissão - 1 - normal
        
        $nota->tpAmb        = $emitente->ambiente_nfce;
        $nota->finNFe       = 1; //Finalidade emissão 1 - Normal
        $nota->indFinal     = 1; // consumidor final
        $nota->indPres      = 1; //presença do comprador
        $nota->procEmi      = '0';
        $nota->verProc      = '3.10.31';
        $nota->dhCont       = null;
        $nota->xJust        = null;
        if($emitente->ambiente_nfce == 2){
            $nota->indIntermed = 0;
        }
        
        $nota->modFrete     = '9';
        $nota->em_xNome        = tiraAcento($emitente->razao_social);
        $nota->em_xFant        = tiraAcento($emitente->nome_fantasia);
        $nota->em_IE           = ($emitente->ie) ? tira_mascara($emitente->ie) : null ;
        $nota->em_IEST         = ($emitente->iest) ? tira_mascara($emitente->iest) : null;
        $nota->em_IM           = $emitente->im;
        $nota->em_CNAE         = $emitente->cnae;
        $nota->em_CRT          = $emitente->crt;
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
        
        //Destinatário
        $nota->cliente_cpf  =  ($venda->cliente_cpf) ? tira_mascara($venda->cliente_cpf) : null;
        $nota->cliente_nome =  ($venda->cliente_nome) ? tiraAcento($venda->cliente_nome) : null;
        $nota->indIEDest    =  ($venda->cliente_cpf) ? 9 : null;
        
        // $total              = 0;
        $totTrib            = 0;
        $somaProdutos       = 0;
        
        $totalItens         = count($itens);
        $somaFrete          = 0;
        $somaIPI            = 0;
        $somaDesconto       = 0;
        $itemCont           = 0;
        
        $nfItens = array();
        foreach($produtos as $i){
           
            $itemCont++;
            $produto        = $i;
            $tributacao     = $i->tributacao;
            $item           = new \stdClass();
            $item->numero_item = $itemCont  ;
            $item->cProd    = $produto->id;
            $item->cEAN     = ($produto->gtin) ? $produto->gtin :"SEM GTIN";
            $item->xProd    = tiraAcento($produto->nome);
            $item->NCM      = $produto->ncm;
            $item->cBenef   = $produto->cbenef; //incluido no layout 4.00
            $item->EXTIPI   = $produto->tipi;
            
            
            
            // $cfop           = intval($produto->cfop) + 1000;
            $item->CFOP     = $produto->cfop;
            
            $item->uCom     = tiraAcento($produto->unidade);
            $item->qCom     = $i->qtde;
            $item->vUnCom   = $i->valor;
            $item->vProd    = $item->qCom * $item->vUnCom;
            
            $item->cEANTrib = ($produto->gtin) ? $produto->gtin :"SEM GTIN";
            
            if($produto->unidade_tributavel == ''){
                $item->uTrib = tiraAcento($produto->unidade);
            }else{
                $item->uTrib = tiraAcento($produto->unidade_tributavel);
            }
            
            if($produto->quantidade_tributavel == 0){
                $item->qTrib = $i->qtde;
            }else{
                $item->qTrib = $produto->quantidade_tributavel * $i->qtde;
            }
            
            $item->vUnTrib  = $i->valor;
            $item->indTot   = 1; //ver depois
            $somaProdutos   += $item->vProd;
            
            $item->vFrete   = null;
            $item->vSeg     = null;
            $item->vDesc    = null;
            $item->vOutro   = null;
            
            $vDesc          = 0;
            if($venda->valor_desconto > 0){
                if($itemCont < sizeof($venda->itens)){
                    $totalVenda = $venda->total_receber;
                    $media = (((($item->vProd - $totalVenda)/$totalVenda))*100);
                    $media = 100 - ($media * -1);
                    
                    $tempDesc = ($venda->valor_desconto * $media)/100;
                    $somaDesconto += $tempDesc;
                    $vDesc     = $item->vDesc = formataNumero($tempDesc);
                }else{
                    $vDesc     = $item->vDesc = formataNumero($venda->valor_desconto - $somaDesconto);
                }
            }
            
            
            $item->infAdProd= ($i->observacao) ?? null;
            $item->nItemPed = $item->numero_item;
            $item->nFCI     = ($i->nfci) ?? null;
            
            // $tributacao     = Tributacao::find($produto->tributacao_id);
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
            if($nota->em_CRT > 1){
                IcmsService::calculoICMS($item, $tributacao);
            }else{
                IcmsService::calculoIcmsSn($item, $tributacao);
            }            
            $nfItens[] = $item;
        }
        
        $nota->vProd      = $somaProdutos;
        $nota->vFrete     = 0.00;
        $nota->vDesc      = ($venda->valor_desconto) ? $venda->valor_desconto : 0.00;
        $nota->vNF        = $venda->total_receber;
        
        //Pagamento
        $nota->tPag       = '1';
        $nota->vPag       = $venda->total_receber;
        $nota->indPag     = '0';
        
        $retorno = (object) array(
            "nfce"=>$nota,
            "itens"=>$nfItens
        );        
        return $retorno;
        
    }
    
    public static function getDadosParaGerarNfcePelaVenda($id_venda){
        $url                = getenv("APP_URL_API"). "pdv/getDadosParaGerarNfcePelaVenda/". $id_venda. "/" .getenv("APP_ID_EMPRESA");
        $dados              = enviarGetCurl($url);
        $emitente           = $dados->emitente;
        $pdvVenda           = $dados->pdvVenda;
        $itens              = $dados->itens;
        $tributacao         = $dados->tributacao;
       
        $nota               = new \stdClass();
        $nota->cUF          = ConstanteService::getUf($emitente->uf);
        $nota->natOp        = $emitente->nat_op_padrao_nfce;        
        
        $nota->empresa_id   = $pdvVenda->empresa_id;
        $nota->venda_id     = $pdvVenda->id;
        $nota->modelo       = 65;
        $nota->serie        = $emitente->numero_serie_nfce;
        $nota->nNF          = $emitente->ultimo_numero_nfce + 1;
        $nota->cNF          = rand($nota->nNF,99999999);
        $nota->dhEmi        = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->dhSaiEnt     = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->tpNF         = 1 ; //0 - Entrada / 1 - Saida
        $nota->idDest       = 1;
        
        $nota->cMunFG       = $emitente->ibge;
        $nota->tpImp        = 4; //formato do danfce
        $nota->tpEmis       = 1; //tipo emissão - 1 - normal
        
        $nota->tpAmb        = $emitente->ambiente_nfce;
        $nota->finNFe       = 1; //Finalidade emissão 1 - Normal
        $nota->indFinal     = 1; // consumidor final
        $nota->indPres      = 1; //presença do comprador
        $nota->procEmi      = '0';
        $nota->verProc      = '3.10.31';
        $nota->dhCont       = null;
        $nota->xJust        = null;
        if($emitente->ambiente_nfce == 2){
            $nota->indIntermed = 0;
        }
        
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
        
        //Destinatário
        $nota->cliente_cpf  =  ($pdvVenda->cliente_cpf) ? tira_mascara($pdvVenda->cliente_cpf) : null;
        $nota->cliente_nome =  ($pdvVenda->cliente_nome) ? tiraAcento($pdvVenda->cliente_nome) : null;
        $nota->indIEDest    =  ($pdvVenda->cliente_cpf) ? 9 : null;
        
        // $total              = 0;
        $totTrib            = 0;
        $somaProdutos       = 0;
        
        $totalItens         = count($itens);
        $somaFrete          = 0;
        $somaIPI            = 0;
        $somaDesconto       = 0;
        $itemCont           = 0;
        
        $nfItens = array();
        foreach($itens as $i){
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
            
            // $cfop           = intval($produto->cfop) + 1000;
            $item->CFOP     = $produto->cfop;
            
            $item->uCom     = tiraAcento($produto->unidade);
            $item->qCom     = $i->qtde;
            $item->vUnCom   = $i->valor;
            $item->vProd    = $item->qCom * $item->vUnCom;
            
            $item->cEANTrib = ($produto->gtin) ? $produto->gtin :"SEM GTIN";
            
            if($produto->unidade_tributavel == ''){
                $item->uTrib = tiraAcento($produto->unidade);
            }else{
                $item->uTrib = tiraAcento($produto->unidade_tributavel);
            }
            
            if($produto->quantidade_tributavel == 0){
                $item->qTrib = $i->qtde;
            }else{
                $item->qTrib = $produto->quantidade_tributavel * $i->qtde;
            }
            
            $item->vUnTrib  = $i->valor;
            $item->indTot   = 1; //ver depois
            $somaProdutos   += $item->vProd;
            
            $item->vFrete   = null;
            $item->vSeg     = null;
            $item->vDesc    = null;
            $item->vOutro   = null;
            
            $vDesc          = 0;
            if($pdvVenda->valor_desconto > 0){
                if($itemCont < sizeof($pdvVenda->itens)){
                    $totalVenda = $pdvVenda->total_receber;
                    $media = (((($item->vProd - $totalVenda)/$totalVenda))*100);
                    $media = 100 - ($media * -1);
                    
                    $tempDesc = ($pdvVenda->valor_desconto * $media)/100;
                    $somaDesconto += $tempDesc;
                    $vDesc     = $item->vDesc = formataNumero($tempDesc);
                }else{
                    $vDesc     = $item->vDesc = formataNumero($pdvVenda->valor_desconto - $somaDesconto);
                }
            }
            
            
            $item->infAdProd= ($i->observacao) ?? null;
            $item->nItemPed = $item->numero_item;
            $item->nFCI     = ($i->nfci) ?? null; 
            
           // $tributacao     = Tributacao::find($produto->tributacao_id);
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
            if($nota->em_CRT > 1){
                IcmsService::calculoICMS($item, $tributacao);
            }else{
                IcmsService::calculoIcmsSn($item, $tributacao);
            }           
            
            $nfItens[] = $item;
        }
        
        $nota->vProd      = $somaProdutos;
        $nota->vFrete     = 0.00;
        $nota->vDesc      = ($pdvVenda->valor_desconto) ? $pdvVenda->valor_desconto : 0.00;
        $nota->vNF        = $pdvVenda->total_receber;
        
        //Pagamento
        $nota->tPag       = '01';
        $nota->vPag       = $pdvVenda->total_receber;
        $nota->indPag     = '0';     
        
        $retorno = (object) array(
            "nfce"=>$nota,
            "itens"=>$nfItens
        );   
   
        return $retorno;
     }   
    
     public static function inserirNfcePelaVenda($nota){
         $url        = getenv("APP_URL_API"). "pdv/salvarNfcePelaVenda";
         $resultado  = enviarPostJsonCurl($url,json_encode($nota));
         return $resultado;
     }
    
}

