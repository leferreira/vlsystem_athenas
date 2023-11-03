<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LojaCurtidaProduto extends Model
{
    use HasFactory;
    protected $fillable = [
        'pedido_id', 'produto_id', 'cliente_id'
    ];
    
    public function pedido(){
        return $this->belongsTo(LojaPedido::class, 'pedido_id');
    }
    
    public function produto(){
        return $this->belongsTo(LojaProduto::class, 'produto_id');
    }
    
    public function cliente(){
        return $this->belongsTo(LojaCliente::class, 'cliente_id');
    }
}
