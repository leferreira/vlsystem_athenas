<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaProdutoDelivery extends Model
{
    protected $fillable = ['nome', 'descricao', 'path' ];
    
    public function produtos(){
        return $this->hasMany(ProdutoDelivery::class, 'categoria_id', 'id');
    }
    
    public function adicionais(){
        return $this->hasMany('App\Models\ListaComplementoDelivery', 'categoria_id', 'id');
    }
}
