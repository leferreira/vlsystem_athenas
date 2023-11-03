<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class Transportadora extends Model
{
    use EmpresaTrait;
    protected $fillable = [
        'empresa_id',
        'razao_social',
        'nome_fantasia',
        'cnpj',
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
        'cidade'
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public static function filtro($filtro){
        $retorno = Transportadora::orderBy('transportadoras.id', 'asc');
        
        if($filtro->nome){
            $retorno->where("razao_social", "like", '%'. $filtro->nome .'%');
        }
        
        if($filtro->email){
            $retorno->where("email", "like", '%'. $filtro->email .'%');
        }
        
        if($filtro->cnpj){
            $retorno->where("cnpj", "like", '%'. $filtro->cnpj .'%');
        }
        
        return $retorno->get();
    }
}
