<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteDelivery extends Model
{
    protected $fillable = [
        'nome', 'sobre_nome', 'celular', 'email', 'token', 'ativo', 'data_token', 'senha',
        'referencia'
    ];
    
    protected $hidden = [
        'senha', 'token',
    ];
    
    public function enderecos(){
        return $this->hasMany(EnderecoDelivery::class, 'cliente_id', 'id');
    }
    
    public function pedidos(){
        return $this->hasMany(PedidoDelivery::class, 'cliente_id', 'id');
    }
    
    public function favoritos(){
        return $this->hasMany(ProdutoFavoritoDelivery::class, 'cliente_id', 'id');
    }
    
    public function tokens(){
        return $this->hasMany(TokenClienteDelivery::class, 'cliente_id', 'id');
    }
    
    public function tokensWeb(){
        return $this->hasMany(TokenWeb::class, 'cliente_id', 'id');
    }
    
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
