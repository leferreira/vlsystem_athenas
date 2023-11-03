<?php

namespace App\Models;

use App\Service\CofinsService;
use App\Service\ConstanteService;
use App\Service\IcmsService;
use App\Service\IpiService;
use App\Service\PisService;
use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PdvVenda extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'id','empresa_id', 'cliente_id', 'caixa_id', 'usuario_id', 'data_venda', 'xml_path',
        'chave','nfce', 'numero_emissao', 'forma_pagamento', 'valor_venda', 'valor_desconto',
        'valor_liquido', 'qtde_parcela','status_id','desconto_per','desconto_valor','estornou_estoque',
        'acrescimo_valor', 'acrescimo_per','valor_acrescimo','cliente_cnpj','cliente_cpf',
        'vendedor_id','venda_balcao_id','venda_loja_id','orcamento_id','venda_id','pedido_cliente_id','titulo',
        'classificacao_financeira_id','valor_liquido', 'uuid','pdvvenda_id','transacao_id','cliente_id','cliente_consumidor_id'
    ];
    
    public function itens(){
        return $this->hasMany(PdvItemVenda::class, 'venda_id', 'id');
    }
    
    public function duplicatas(){
        return $this->hasMany(PdvDuplicata::class, 'venda_id', 'id');
    }
    
    public function pagamentos(){
        return $this->hasMany(PdvPagamento::class, 'venda_id', 'id');
    }    
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    } 
    
    public function caixa(){
        return $this->belongsTo(PdvCaixa::class, 'caixa_id');
    }
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    } 
    
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public static function somarTotal($id){
        $venda          = PdvVenda::find($id);
        $valor_total    = PdvItemVenda::where("venda_id", $id)->sum("subtotal_liquido");
        $venda->valor_desconto = 0;
        if($venda->desconto_valor > 0){
            $venda->valor_desconto = $venda->desconto_valor;
        }
        if($venda->desconto_per > 0){
            $venda->valor_desconto = $venda->desconto_per * $valor_total * 0.01;
        }
        
        ;
        $venda->valor_total   = $valor_total;
        $venda->valor_liquido = $valor_total  - $venda->valor_desconto;
        $venda->save();
    }

    
    public static function filtro($filtro){
        $retorno = PdvVenda::orderBy('pdv_vendas.data_venda', 'asc');
       
        
        if($filtro->data2){
            if($filtro->data2){
                $retorno->where("data_venda",">=", $filtro->data1)->where("data_venda","<=", $filtro->data2);
            }else{
                $retorno->where("data_venda", $filtro->data1);
            }
        }
        
        
        return $retorno->get();
    }
    
    public static function consulta($filtro){
        $retorno = PdvVenda::orderBy($filtro->ordem, $filtro->tipo_ordem);
      
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
        if($filtro->uuid){
            $retorno->where("uuid", "like", "%$filtro->uuid%");
        }
        
        if($filtro->vendedor_id){
            $retorno->where("vendedor_id", $filtro->vendedor_id);
        }
        
        if($filtro->data2){
            if($filtro->data2){
                $retorno->where("data_venda",">=", $filtro->data1)->where("data_venda","<=", $filtro->data2);
            }else{
                $retorno->where("data_venda", $filtro->data1);
            }
        }
        
  
        return $retorno->get();
    }
    
    public static function relatorio($filtro){
        
        $lista = array();
        if($filtro->tipo_relatorio=="resumo_diario"){
            $datas = listaIntevaloData($filtro->data1, $filtro->data2);
            for($i=0; $i<count($datas); $i++){
                $venda      = PdvVenda::where("data_venda", $datas[$i])->sum("valor_venda");
                $desconto   = PdvVenda::where("data_venda", $datas[$i])->sum("valor_desconto");
                $liquido    = PdvVenda::where("data_venda", $datas[$i])->sum("valor_liquido");
                if($venda > 0){
                    $retorno = new \stdClass();
                    $retorno->data      = $datas[$i];
                    $retorno->venda     = $venda;
                    $retorno->desconto  = $desconto;
                    $retorno->liquido   = $liquido;
                    $lista[]            = $retorno;
                }
                
            }
        }
        
       
        return $lista;
    }
    public static function inserirNfcePelaVenda($pdvVenda){        
        $emitente           = Emitente::where("empresa_id", $pdvVenda->empresa_id)->first();
        
        $nota               = new \stdClass();
        $nota->cUF          = ConstanteService::getUf($emitente->uf);
        $nota->natOp        = $emitente->nat_op_padrao_nfce;
        
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
        
        $nfce               = Nfce::where("venda_id", $pdvVenda->id)->first();
        if(!$nfce){
            $nota->status_id= config("constantes.status.DIGITACAO");
            $nfce            = Nfce::Create(objToArray($nota));
            $id_nfce         = $nfce->id;
            $emitente->ultimo_numero_nfce = $nota->nNF;
            $emitente->save();
        }else{
            $id_nfce         = $nfce->id;
        }
                
        // $total              = 0;
        $totTrib            = 0;        
        $somaProdutos       = 0;
        
        $totalItens         = count($pdvVenda->itens);        
        $somaFrete          = 0;
        $somaIPI            = 0;
        $somaDesconto       = 0;
        $itemCont           = 0;
        foreach($pdvVenda->itens as $i){
            $itemCont++;
            $produto        = $i->produto;
            $item           = new \stdClass();
            $item->nfce_id  = $id_nfce  ;
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
                        
            
            $item->infAdProd= $i->observacao;
            $item->xPed     = $id_nfce  ;
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
            
            
            $totTrib        += $item->vUnTrib;
            
            $it = NfceItem::where(["cProd"=> $item->cProd,"nfce_id"=>$id_nfce])->first();
            
            if(!$it){
                $it=  NfceItem::Create(objToArray($item));
            }else{
                $it->update(objToArray($item));
            }
            
        }
        
        $_nfce["vProd"]      = $somaProdutos;
        $_nfce["vFrete"]     = 0.00;
        $_nfce["vDesc"]      = ($pdvVenda->valor_desconto) ? $pdvVenda->valor_desconto : 0.00;
        $_nfce["vNF"]        = $pdvVenda->total_receber;        
            
        //Pagamento
        $_nfce["tPag"]       = '01';
        $_nfce["vPag"]       = $pdvVenda->total_receber;
        $_nfce["indPag"]     = '0';        
        
        Nfce::where("id", $id_nfce)->update($_nfce);
            
        return $id_nfce;
    }
    
}
