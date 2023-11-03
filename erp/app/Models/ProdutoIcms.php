<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoIcms extends Model
{
    use HasFactory;
    protected $fillable = [
        'natureza_operacao_id',
        'produto_id',
        'tributacao_id'
    ];
    
    public function produto(){
        return $this->belongsTo(Produto::class,"produto_id");
    } 
}
