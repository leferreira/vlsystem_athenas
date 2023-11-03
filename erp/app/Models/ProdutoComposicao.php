<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoComposicao extends Model
{
    use HasFactory;
    protected $fillable = [
        'produto_pai_id',
        'produto_filho_id',
        'qtde'
    ];
    
    public function produtoPai(){
        return $this->belongsTo(Produto::class,"produto_pai_id");
    } 
    
    public function produtoFilho(){
        return $this->belongsTo(Produto::class,"produto_filho_id");
    } 
}
