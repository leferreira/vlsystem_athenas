<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class GrupoProduto extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id',
        'nome', 
        'ncm',
        'tipo_produto',
        'origem',
        'nfce',
        'nfce_icms',
        'nfce_fcp',
        'nfce_redicms',
        'nfce_benefiscal',
        'nfce_mot_deson',
        'nfe_st_saida',
        'nfe_st_entrada',
        'nfe_icms',
        'nfe_redicms',
        'nfe_tem_fcp',
        'nfe_fcp',
        'nfe_benefiscal',
        'nfe_mot_deson',
        'mva_modbc_icmsst',
        'mva',
        'mva_reducao',
        'cest',
        'ipi_cst_saida',
        'ipi_mod_calc_saida',
        'ipi_entrada',
        'ipi_cst_entrada',
        'ipi_mod_calc_entrada',
        'ipi_saida',
        'cst_pis_confins_saida',
        'pis_saida',
        'cofins_saida',
        'cst_pis_confins_entrada',
        'pis_entrada',
        'cofins_entrada'
    ];
}
