<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaParcelamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'administradora_cartao_id', "tipo_parcelamento_id","parcela_de", "parcela_ate", 'taxa', 'acrescimo','desconto','valor_minimo'
    ];
    
    public function tipo(){
        return $this->belongsTo(TipoParcelamento::class, 'tipo_parcelamento_id');
    }
}
