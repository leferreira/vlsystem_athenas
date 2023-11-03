<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class NaturezaOperacao extends Model
{
    use HasFactory;
    use EmpresaTrait;
    protected $fillable = [
        "descricao",
        "tipo",
        "indPres",
        'finNFe',
        "devolucao",
        "padrao",
        "cstIcms",
        "cfop",
        "modBC",
        "pICMS",
        "pRedBC",
        "modBCST",
        "vBCST",
        "pICMSST",
        "pMVAST",
        "pRedBCST",
        "vICMSSubstituto",
        "pFCP",
        "pFCPST",
        "pFCPSTRet",
        "pDif",
        "cstIpi",
        "pIPI",
        "vBCIPI",
        "tipo_calc_ipi",
        "CNPJProd",
        "cSelo",
        "qSelo",
        "qUnidIPI",
        "vUnidIPI",
        "cEnq",
        "cstPis",
        "tipo_calc_pis",
        "pPIS1",
        "vAliqProd_pis",
        "pPISST",
        "vAliqProd_pisst",
        "cstCofins",
        "tipo_calc_cofins",
        "pCofins",
        "vAliqProd_cofins",
        "tipo_calc_cofinsst",
        "vAliqProd_cofinsst",
        "obs",
        "infAdFisco",
    ];
    
    public function tributacoes(){
        return $this->hasMany(Tributacao::class, 'natureza_operacao_id', 'id');
    }
    
    public function tributacaoIcms(){
        return $this->hasMany(TributacaoIcms::class, 'natureza_operacao_id', 'id');
    }
    public function tributacaoPis(){
        return $this->hasMany(TributacaoPis::class, 'natureza_operacao_id', 'id');
    }
    public function tributacaoCofins(){
        return $this->hasMany(TributacaoCofins::class, 'natureza_operacao_id', 'id');
    }
    public function tributacaoIpi(){
        return $this->hasMany(TributacaoIpi::class, 'natureza_operacao_id', 'id');
    }
    
}
