<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LojaItemPacote extends Model
{
    use HasFactory;
    protected $fillable = [
        'loja_produto_id', 'loja_pacote_id', 'quantidade'   ];
    
    public function produto(){
        return $this->belongsTo(LojaProduto::class, 'loja_produto_id');
    }
    
    public function pacote(){
        return $this->belongsTo(LojaPacote::class, 'loja_pacote_id');
    }
}
