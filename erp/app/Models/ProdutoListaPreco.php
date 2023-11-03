<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoListaPreco extends Model
{
    use HasFactory;
    protected $fillable = [
        'lista_id', 'produto_id', 'percentual_lucro', 'valor'
    ];
    
    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    
    public function lista(){
        return $this->belongsTo(ListaPreco::class, 'lista_id');
    }
}
