<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class LojaCliente extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id', 'nome', 'sobre_nome', 'cpf', 'email', 'telefone','senha','ibge','status_id'
    ];
    
    public function enderecos(){
        return $this->hasMany(LojaEnderecoCliente::class, 'cliente_id', 'id');
    }
    
    public function pedidos(){
        return LojaPedido::where('cliente_id', $this->id)->where('valor_total', '>', 0)->get();
    }   
    
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
