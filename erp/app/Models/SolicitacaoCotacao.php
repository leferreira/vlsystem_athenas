<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacaoCotacao extends Model
{
    use HasFactory;
    protected $fillable = ["solicitacao_id","cotacao_id"];
    
    public function solicitacao(){
        return $this->belongsTo(Solicitacao::class,"solicitacao_id","id");
    }
    
    public function cotacao(){
        return $this->belongsTo(Cotacao::class,"cotacao_id","id");
    }
    
}
