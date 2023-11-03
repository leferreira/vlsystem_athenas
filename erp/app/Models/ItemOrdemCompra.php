<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOrdemCompra extends Model
{
    use HasFactory;
    protected $fillable =["id","ordem_compra_id","status_id","produto_id", "qtde","valor","subtotal"];
    
    public function ordemCompra(){
        return $this->belongsTo(OrdemCompra::class,"ordem_compra_id","id");
    }
    
    public function produto(){
        return $this->belongsTo(Produto::class,"produto_id","id");
    }
    
}
