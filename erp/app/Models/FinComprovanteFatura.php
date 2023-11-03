<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class FinComprovanteFatura extends Model
{
    use HasFactory;
    use EmpresaTrait;
    protected $fillable =[
        "empresa_id",
        "fatura_id",
        "data_emissao",
        "data_pagamento",
        "nome_arquivo",
        "confirmado",
        "valor_pago",
        "planopreco_id",
        "descricao",
        "forma_pagto_id",
        "classificacao_id",
        "conta_corrente_id",
        "obs"
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function fatura(){
        return $this->belongsTo(FinFatura::class, 'fatura_id');
    }
}
