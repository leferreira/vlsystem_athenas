<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteLoja extends Model
{
    protected $fillable = [
        'nome', 'sobre_nome', 'cpf', 'email', 'senha', 'status', 'telefone','status'
    ];
    
    public function enderecos(){
        return $this->hasMany(LojaEnderecoCliente::class, 'cliente_id', 'id');
    }
    
    public function pedidos(){
        return LojaPedido::where('cliente_id', $this->id)->where('valor_total', '>', 0)->get();
    }
}
