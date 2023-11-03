<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class Nfce extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        'empresa_id',
        'venda_id',
        'natureza_operacao_id',
        'pdvvenda_id',
        'status_id',
        'chave',
        'recibo',
        'protocolo',
        'cUF',
        'cNF',
        'natOp',
        'indPag',
        'modelo',
        'serie',
        'nNF',
        'dhEmi',
        'dhSaiEnt',
        'tpNF',
        'idDest',
        'cMunFG',
        'tpImp',
        'tpEmis',
        'cDV',
        'tpAmb',
        'finNFe',
        'indFinal',
        'indPres',
        'indIntermed',
        'procEmi',
        'verProc',
        'dhCont',
        'xJust',
        'vBC',
        'vICMS',
        'vICMSDeson',
        'vFCP',
        'vBCST',
        'vST',
        'vFCPST',
        'vFCPSTRet',
        'vProd_liquido',
        'vProd',
        'vFrete',
        'modFrete',
        'vSeg',
        'vDesc',
        'vII',
        'vIPI',
        'vIPIDevol',
        'vPIS',
        'vCOFINS',
        'vOutro',
        'vNF',
        'vTotTrib',
        'vOrig',
        'vLiq',
        'em_xNome',
        'em_xFant',
        'em_IE',
        'em_IEST',
        'em_IM',
        'em_CNAE',
        'em_CRT',
        'em_CNPJ',
        'em_CPF',
        'em_xLgr',
        'em_nro',
        'em_xCpl',
        'em_xBairro',
        'em_cMun',
        'em_xMun',
        'em_UF',
        'em_CEP',
        'em_cPais',
        'em_xPais',
        'em_fone',
        'em_EMAIL',
        'em_SUFRAMA',
        'atualizacao',
        'cliente_cpf',
        'cliente_nome',
        'indIEDest',
        'estadual','municipal','nacionalfederal','importadosfederal',
        
    ];
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function itens(){
        return $this->hasMany(NfceItem::class, 'nfce_id');
    }
    
    public function duplicatas(){
        return $this->hasMany(NfceDuplicata::class, 'nfce_id');
    }
  
    
    public static function filtro($filtro){
        $retorno = Nfce::orderBy('nfces.created_at', 'asc');
        if($filtro->venda_id){
            $retorno->where("venda_id", $filtro->venda_id);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
        if($filtro->data2){
            if($filtro->data2){
                $retorno->whereDate("created_at",">=", $filtro->data1)->whereDate("created_at","<=", $filtro->data2);
            }else{
                $retorno->whereDate("created_at", $filtro->data1);
            }
        }
        
        
        return $retorno->get();
    }
    
    
}
