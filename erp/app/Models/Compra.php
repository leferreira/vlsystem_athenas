<?php

namespace App\Models;

use App\Service\ConstanteService;
use App\Service\ItemNotafiscalService;
use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use  EmpresaTrait;
    protected $fillable = [
        'empresa_id', 'fornecedor_id','transportadora_id','centro_custo_id', 'usuario_id', 'status_id',
        'data_compra', 'xml_path', 'chave', 'nf', 'numero_emissao', 'estado',
        'situacao','valor_total', 'valor_frete', 'valor_imposto', 'valor_desconto', 'taxa_desconto', 'valor_compra',
        'qtde_parcela', 'primeiro_vencimento', 'observacao', 'observacao_interna','subtotal_liquido','desconto_por_item',
        'total_desconto_item'
    ];
    
    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function transportadora(){
        return $this->belongsTo(Transportadora::class, 'transportadora_id');
    }
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function itens(){
        return $this->hasMany(ItemCompra::class, 'compra_id', 'id');
    }
    public function faturas(){
        return $this->hasMany(FinContaPagar::class, 'compra_id', 'id');
    }    
    
    public function qtde_paga(){       
        return FinContaPagar::where("pagamento_id",">",0)->where("compra_id", $this->id)->count(); 
    }
    
    public function foiPaga(){
        return ($this->qtde_paga() >= count($this->faturas));
    }
    
    public static function somarTotal($id){
        $compra         = Compra::find($id);
        $valor_total    = ItemCompra::where("compra_id", $id)->sum("subtotal_liquido");
        if($compra){            
            if($compra->chave == null){
                $compra->valor_desconto = 0;
                if($compra->desconto_valor > 0){
                    $compra->valor_desconto = $compra->desconto_valor;
                }
                if($compra->desconto_per > 0){
                    $compra->valor_desconto = $compra->desconto_per * $valor_total * 0.01;
                }
                
                $compra->valor_total = $valor_total;
                $compra->valor_compra = $valor_total +  $compra->valor_frete + $compra->despesas_outras + $compra->total_seguro - $compra->valor_desconto;
                $compra->save();
            }
            
        }
        
    }
    
    
    
    public function somaItems(){
        if(count($this->itens) > 0){
            $total = 0;
            foreach($this->itens as $t){
                $total += $t->quantidade * $t->valor_unitario;
            }
            return $total;
        }else{
            return 0;
        }
    }
    
    public static function filtro($filtro){
        $retorno = Compra::orderBy('compras.data_compra', 'asc');
        
        if($filtro->fornecedor_id){
            $retorno->where("fornecedor_id", $filtro->fornecedor_id);
        }
      
        
        if($filtro->data2){
            if($filtro->data2){
                $retorno->where("data_compra",">=", $filtro->data1)->where("data_compra","<=", $filtro->data1);
            }else{
                $retorno->where("data_compra", $filtro->data1);
            }
        }
        
        
        return $retorno->get();
    }
    
    public static function inserirNfePelaCompra($compra, $natureza_operacao){
        $emitente           = Emitente::where("empresa_id", $compra->empresa_id)->first();
        $destinatario       = $compra->fornecedor ;        
        
        $nota               = new \stdClass();
        $nota->cUF          = ConstanteService::getUf($destinatario->uf);
        $nota->natOp        = $natureza_operacao->descricao;
        $nota->natureza_operacao_id = $natureza_operacao->id;
        $nota->tipo_nfe_id  = config("constantes.tipo_notafiscal.VENDA");
        $nota->compra_id     = $compra->id;
        $nota->modelo       = 55;
        $nota->nNF          = $emitente->ultimo_numero_nfe + 1;
        $nota->serie        = $emitente->numero_serie_nfe;
        $nota->cNF          = rand($nota->nNF,99999999);
        $nota->dhEmi        = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->dhSaiEnt     = hoje(). 'T'.date("H:i:s").'-03:00';
        $nota->tpNF         = ($natureza_operacao->tipo == "S") ? '1' : '0' ; //0 - Entrada / 1 - Saida
        
        //Verifica o destino da operação
        if ($nota->cUF != "EX"){
            if($nota->cUF == $destinatario->uf ){
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
        $nota->indFinal     = $natureza_operacao->indFinal; // consumidor final
        $nota->indPres      = $natureza_operacao->indPres; //presença do comprador
        $nota->procEmi      = '0';
        $nota->verProc      = '3.10.31';
        $nota->dhCont       = null;
        $nota->xJust        = null;
        $nota->indIntermed  = 0;
        
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
        
        $nfe                = Nfe::where("compra_id", $compra->id)->first();
        if(!$nfe){
            $nota->status_id= config("constantes.status.DIGITACAO");
            $nfe            = Nfe::Create(objToArray($nota));
            $id_nfe         = $nfe->id;
            $emitente->ultimo_numero_nfe = $nota->nNF;
            $emitente->save();
        }else{
            //return $nfe->id;
            $id_nfe         = $nfe->id;
        }
        
        $dest = new \stdClass();
        $dest->nfe_id           = $id_nfe;
        $dest->dest_xNome    	= tiraAcento($destinatario->razao_social);
        
        $dest->dest_indIEDest	= $destinatario->tipo_contribuinte;
        $dest->dest_IM       	= $destinatario->im;
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
       
        $temDestinatario           = NfeDestinatario::where("nfe_id", $nfe->id)->first();
        if(!$temDestinatario){
            NfeDestinatario::create(objToArray($dest));
        }else{
            $temDestinatario->update(objToArray($dest));
        }
        
       
        //Inserindo Itens
        $totalItens         = count($compra->itens);
        $itemCont           = 0;
        $somaFrete          = 0;
        $somaIPI            = 0;
        $somaProdutos       = 0;
        
        foreach($compra->itens as $i){
            $i->nfe_id      = $id_nfe;
            $i->cfop        = $emitente->uf == $destinatario->uf ? $natureza_operacao->cfop : intval($natureza_operacao->cfop) + 1000;
            $i->vFrete   = null;
            $i->vSeg     = null;
            $i->vDesc    = null;
            $i->vOutro   = null;
            
            if($compra->valor_desconto > 0){
                if($itemCont < sizeof($compra->itens)){
                    $totalCompra = $compra->valor_compra;
                    $media = (((($i->vProd - $totalCompra)/$totalCompra))*100);
                    $media = 100 - ($media * -1);
                    
                    $tempDesc = ($compra->valor_desconto * $media)/100;
                    $somaDesconto += $tempDesc;
                    $i->vDesc = formataNumero($tempDesc);
                }else{
                    $i->vDesc = formataNumero($compra->valor_desconto - $somaDesconto);
                }
            }
            
            if($compra->frete){
                if($compra->frete->valor > 0){
                    $somaFrete += $vFt = $compra->frete->valor/$totalItens;
                    $i->vFrete = formataNumero($vFt);
                }
            }
            
            $somaProdutos   += $i->vProd;
            ItemNotafiscalService::inserir($i, $natureza_operacao);
        }
        
        $_nfe["vProd"]      = $compra->valor_compra;
        $_nfe["vFrete"]     = ($compra->frete) ? $compra->frete->valor : null;
        $_nfe["vDesc"]      = ($compra->valor_desconto) ? $compra->valor_desconto : null;
        
        if($compra->frete){
            $_nfe["vNF"]    = ($compra->valor_compra + $compra->frete->valor + $somaIPI) - $compra->valor_desconto;
        } else
            $_nfe["vNF"]    = $compra->valor_compra + $somaIPI - $compra->valor_desconto;
            
            
            //Fatura
            $_nfe["nFat"]  = 1;
            $_nfe["vOrig"] = $compra->valor_compra;
            $_nfe["vDesc"] = $compra->valor_desconto;
            $_nfe["vLiq"]  = $compra->valor_total;
            
            //Pagamento
            $_nfe["tPag"]  = $compra->tPag;
            $_nfe["vPag"]  = $compra->tPag != '90' ? $somaProdutos - $compra->valor_desconto : 0.00;
            
            if($compra->tPag == '03' || $compra->tPag == '04'){
                if($compra->cAut_cartao != ""){
                    $_nfe["cAut"] = $compra->cAut_cartao;
                }
                if($compra->cnpj_cartao != ""){
                    $cnpj = tira_mascara($compra->cnpj_cartao);
                    $_nfe["CNPJ_pag"] = $cnpj;
                }
                $_nfe["tBand"] = $compra->bandeira_cartao;
                
                $_nfe["tpIntegra"] = 2;
            }
            $_nfe["indPag"] = $compra->forma_pagamento == 'a_vista' ?  0 : 1;
            
            Nfe::where("id", $id_nfe)->update($_nfe);
            
            //Transporte
            $tansp = new \stdClass();
            $tem_transporte = false;
            if($compra->transportadora){
                $tem_transporte = true;
                $tansp->nfe_id   = $id_nfe  ;
                $tansp->xNome     = $compra->transportadora->razao_social;
                $tansp->xEnder    = $compra->transportadora->logradouro;
                $tansp->xMun      = strtoupper(tiraAcento($compra->transportadora->cidade));
                $tansp->UF        = $compra->transportadora->uf;
                $cnpj_cpf  = tira_mascara($compra->transportadora->cnpj);
                if(strlen($cnpj_cpf) == 14)
                    $tansp->CNPJ = $cnpj_cpf;
                    else
                        $tansp->CPF = $cnpj_cpf;
            }
            
            if($compra->frete != null){
                $tem_transporte = true;
                $tansp->nfe_id   = $id_nfe  ;
                if($compra->frete->placa != "" && $compra->frete->uf != ""){
                    $tansp->placa       = strtoupper(tira_mascara($compra->frete->placa));
                    $tansp->UF_placa    = $compra->frete->uf;
                }
                if($compra->frete->qtdVolumes > 0 && $compra->frete->peso_liquido > 0  && $compra->frete->peso_bruto > 0){
                    $tansp->item = 1;
                    $tansp->modFrete= $compra->frete->modfrete;
                    $tansp->qVol    = $compra->frete->qtdVolumes;
                    $tansp->esp     = $compra->frete->especie != '*' ? $compra->frete->especie : '';
                    
                    $tansp->nVol    = $compra->frete->numeracaoVolumes;
                    $tansp->pesoL   = $compra->frete->peso_liquido;
                    $tansp->pesoB   = $compra->frete->peso_bruto;
                }
                
            }
            
            if($tem_transporte){
                $transporte = NfeTransporte::where("nfe_id", $id_nfe)->first();
                if($transporte){
                    $transporte->update(objToArray($tansp));
                }else{
                    NfeTransporte::Create(objToArray($tansp));
                }
                
            }
            
            //Duplicata
            if(count($compra->faturas) > 0){
                $contFatura = 1;
                foreach($compra->faturas as $ft){
                    $dup        = new \stdClass();
                    $dup->nfe_id= $id_nfe;
                    $dup->nDup  = "00".$contFatura;
                    $dup->dVenc = substr($ft->data_vencimento, 0, 10);
                    $dup->vDup  = $ft->valor;
                    NfeDuplicata::Create(objToArray($dup));
                    $contFatura++;
                }
            }
            
            return $id_nfe;
    }
    
    public static function tiposPagamento(){
        return [
            '01' => 'Dinheiro',
            '02' => 'Cheque',
            '03' => 'Cartão de Crédito',
            '04' => 'Cartão de Débito',
            '05' => 'Crédito Loja',
            '10' => 'Vale Alimentação',
            '11' => 'Vale Refeição',
            '12' => 'Vale Presente',
            '13' => 'Vale Combustível',
            '14' => 'Duplicata Mercantil',
            '15' => 'Boleto Bancário',
            '90' => 'Sem pagamento',
            '99' => 'Outros',
        ];
    }
}
