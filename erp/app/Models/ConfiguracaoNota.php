<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracaoNota extends Model
{
    protected $fillable = [
        'empresa_id',    'razao_social', 'nome_fantasia', 'cnpj', 'ie', 'logradouro',
        'numero', 'bairro', 'municipio', 'codMun', 'pais', 'codPais',
        'fone', 'cep', 'UF', 'CST_CSOSN_padrao', 'CST_COFINS_padrao', 'CST_PIS_padrao',
        'CST_IPI_padrao', 'frete_padrao', 'tipo_pagamento_padrao', 'nat_op_padrao', 'ambiente',
        'cUF', 'ultimo_numero_nfe', 'ultimo_numero_nfce', 'ultimo_numero_cte', 'ultimo_numero_mdfe',
        'numero_serie_nfe', 'numero_serie_nfce', 'csc', 'csc_id', 'certificado_a3'
    ];
}
