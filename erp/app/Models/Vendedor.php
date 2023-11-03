<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class Vendedor extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        'empresa_id',
        'uuid',
        'nome',
        'cpf',
        'rg',
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
    
    
    public static function filtro($filtro){
        $retorno = Vendedor::orderBy('vendedors.id', 'asc');
        
        if($filtro->nome){
            $retorno->where("nome", "like", '%'. $filtro->nome .'%');
        }
        
        if($filtro->email){
            $retorno->where("email", "like", '%'. $filtro->email .'%');
        }
        
        if($filtro->cpf){
            $retorno->where("cpf", "like", '%'. $filtro->cpf .'%');
        }
                
        return $retorno->get();
    }
}
