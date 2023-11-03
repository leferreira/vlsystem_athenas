<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    use HasFactory;
    protected $fillable = [
        'produto_id', 'venda_id', 'unidade', 'quantidade', 'valor','desconto_percentual','total_desconto_item',
        'desconto_por_valor', "subtotal", 'observacao','subtotal_liquido','desconto_por_unidade'
    ];
    
    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    
    public function venda(){
        return $this->belongsTo(Venda::class, 'venda_id');
    }
    
    public function movimetosGrade(){
        return GradeMovimento::where("item_venda_id", $this->id)->get();
    }
}
