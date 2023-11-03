<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListaPreco extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome', 'percentual_alteracao'
    ];
    
    
    public function itens(){
        return $this->hasMany(ProdutoListaPreco::class,'lista_id', 'id');
    }
}
