<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FornecedorCotacao extends Model
{
    use HasFactory;
    protected $fillable = ["id", "fornecedor_id","cotacao_id"];
    
    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class,"fornecedor_id","id");
    }
    
    public function cotacao(){
        return $this->belongsTo(Cotacao::class,"cotacao_id","id");
    }
}
