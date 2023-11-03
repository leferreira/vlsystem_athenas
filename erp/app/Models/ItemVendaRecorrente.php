<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVendaRecorrente extends Model
{
    use HasFactory;
    protected $fillable = [
        'venda_recorrente_id', 'produto_recorrente_id', 'quantidade', 'valor', 'subtotal','subtotal_liquido','desconto_percentual',
        'desconto_por_valor','desconto_por_unidade','total_desconto_item'
    ];
    
    public function produto(){
        return $this->belongsTo(ProdutoRecorrente::class, 'produto_recorrente_id');
    }
    public function venda(){
        return $this->belongsTo(VendaRecorrente::class, 'venda_recorrente_id');
    }
}
