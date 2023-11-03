<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoFornecedor extends Model
{
    use HasFactory;
    protected $fillable = [
        'produto_id', 'fornecedor_id', 'codigo_produto', 'codigo_barra','cProd'
    ];
    
    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }  
    
    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }
}
