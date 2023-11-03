<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOrcamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'produto_id', 'orcamento_id', 'unidade', 'quantidade', 'valor','total_desconto_item',
        'desconto_por_item', "subtotal", 'observacao','subtotal_liquido','desconto_por_valor','desconto_por_unidade'
    ];
    
    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    
    public function orcamento(){
        return $this->belongsTo(Orcamento::class, 'orcamento_id');
    }
}
