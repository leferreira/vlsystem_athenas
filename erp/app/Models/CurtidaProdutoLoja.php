<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurtidaProdutoLoja extends Model
{
    protected $fillable = [
        'produto_id', 'cliente_id'
    ];
    
    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
