<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCompra extends Model
{
    protected $fillable = [
        'produto_id', "subtotal", 'compra_id', 'quantidade', 'valor_unitario', 'unidade', 'desconto_por_unidade',
        'validade', 'cfop_entrada', 'total_desconto_item','subtotal_liquido','desconto_por_item',
       
    ];
    
    public function produto(){
        return $this->belongsTo(Produto::class);
    }
    
    public function compra(){
        return $this->belongsTo(Compra::class);
    }
    
    public function movimetosGrade(){
       return GradeMovimento::where("item_compra_id", $this->id)->get();
    }
    
}
