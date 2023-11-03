<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoOs extends Model
{
    use HasFactory;
    protected $fillable = [
        'produto_id', 'os_id', 'unidade', 'quantidade', 'valor','subtotal_liquido', 'observacao',        
        'desconto_percentual', "subtotal", 'desconto_por_valor','desconto_por_unidade', 'total_desconto_item'
    ];
    
    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    
    public function os(){
        return $this->belongsTo(OrdemServico::class, 'os_id');
    }
}
