<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected  $fillable =[
        "id",
        "pedido_id",
        "produto_id",
        "qtde_reserva"] ;
    
    public function lancamento(){
        return $this->belongsTo(Pedido::class,"pedido_id","id");
    }  
  
    
    public function produto(){
        return $this->belongsTo(Produto::class,"produto_id","id");
    }
    
}
