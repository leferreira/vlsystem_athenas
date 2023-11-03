<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfeItem extends Model
{
    use HasFactory;
    protected  $fillable= [
        'nfe_id',
        'numero_item',
        'cProd',
        'cEAN',
        'xProd',
        'NCM',
        'cBenef',
        'NVE',
        'EXTIPI',
        'CFOP',
        'uCom',
        'qCom',
        'vUnCom',
        'vProd',
        'cEANTrib',
        'uTrib',
        'qTrib',
        'vUnTrib',
        'vFrete',
        'vSeg',
        'vDesc',
        'vOutro',
        'indTot',
        'xPed',
        'nItemPed',
        'nFCI',
        'cstIPI',
        'clEnq',
        'CNPJProd',
        'cSelo',
        'qSelo',
        'cEnq',
        'vIPI',
        'vBCIPI',
        'pIPI',
        'qUnidIPI',
        'vUnidIPI',
        'tipo_calc_ipi',
        'cstCOFINS',
        'pCOFINS',
        'tipo_calc_cofins',
        'vAliqProd_cofins',
        'vBCCOFINS',
        'vCOFINS',
        'tipo_calc_cofinsst',
        'pCOFINSST',
        'vAliqProd_cofinsst',
        'cstPIS',
        'tipo_calc_pis',
        'vBCPIS',
        'pPIS',
        'vPIS',
        'vAliqProd_pis',
        'tipo_calc_pisst',
        'pPISST',
        'vAliqProd_pisst',
        'orig',
        'cstICMS',
        'modBC',
        'vBCICMS',
        'pICMS',
        'vICMS',
        'pFCP',
        'vFCP',
        'vBCFCP',
        'pMVAST',
        'pRedBCST',
        'vBCST',
        'pICMSST',
        'vICMSST',
        'vBCFCPST',
        'pFCPST',
        'vFCPST',
        'vICMSDeson',
        'motDesICMS',
        'pRedBC',
        'vICMSOp',
        'pDif',
        'vICMSDif',
        'vBCSTRet',
        'pST',
        'vICMSSTRet',
        'vBCFCPSTRet',
        'pFCPSTRet',
        'vFCPSTRet',
        'pRedBCEfet',
        'vBCEfet',
        'pICMSEfet',
        'vICMSEfet',
        'vICMSSubstituto',
        'modBCST',
        'pBCOp',
        'UFST',
        'vBCSTDest',
        'vICMSSTDest',
        'CSOSN',
        'pCredSN',
        'vCredICMSSN',
        'vBCUFDest',
        'vBCFCPUFDest',
        'pFCPUFDest',
        'pICMSUFDest',
        'pICMSInter',
        'pICMSInterPart',
        'vFCPUFDest',
        'vICMSUFDest',
        'vICMSUFRemet',
        'destaca_icms',        
        'estadual','municipal','nacionalfederal','importadosfederal',
    ];
}
