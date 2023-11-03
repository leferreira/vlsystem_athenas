<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class Cliente extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        'empresa_id',
        'eh_consumidor',
        'credito_liberado',
        'limite_credito',
        'credito_utilizado',
        'credito_disponivel',
        'credito_devolucao',
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
    
    public function enderecos(){
        return $this->hasMany(EnderecoCliente::class, 'cliente_id', 'id');
    }
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public static function filtro($filtro, $paginas=0){
        $retorno = Cliente::orderBy('clientes.id', 'asc');
        
        if($filtro->nome){
            $retorno->where("nome_razao_social", "like", '%'. $filtro->nome .'%');
        }
        
        if($filtro->email){
            $retorno->where("email", "like", '%'. $filtro->email .'%');
        }
       
        if($filtro->cpf){
            $retorno->where("cpf", "like", '%'. $filtro->cpf .'%');
        }
        
        if($filtro->tipo_cliente){
            $retorno->where("tipo_cliente", $filtro->tipo_cliente);
        }
              
        if($paginas > 0){
            $retorno = $retorno->paginate($paginas);
        }else{
            $retorno = $retorno->get();
        }
        
        return $retorno;
    }
}
