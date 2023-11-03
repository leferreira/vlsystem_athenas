<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemProdutoRecorrente extends Model
{
    use HasFactory;
    protected $fillable = [
        'produto_recorrente_id', 'produto_id', 'servico_id', 'quantidade', 'valor','subtotal'
    ];
    
    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    
    public function servico(){
        return $this->belongsTo(Produto::class, 'servico_id');
    }
    
    public function recorrencia(){
        return $this->belongsTo(ProdutoRecorrente::class, 'produto_recorrente_id');
    }
}
