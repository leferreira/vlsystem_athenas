<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable =[
        'empresa_id',
        'eh_consumidor',
        'uuid',
        'tipo_cliente',
        'nome_razao_social',
        'nome_fantasia',
        'cpf_cnpj',
        'rg_ie',
        'im',
        'suframa',
        'responsavel',
        'isento_ie_estadual',
        'tipo_contribuinte',
        'indFinal',
        'nascimento',
        'logradouro',
        'complemento',
        'numero',
        'bairro',
        'telefone',
        'celular',
        'email',
        'uf',
        'cep',
        'ibge',
        'cidade',
        'senha',
        'nascimento',
        'status_id',
        "password"
    ];
    
  
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
