<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assinatura extends Model
{
    use HasFactory;
    public $fillable = ['empresa_id','plano_preco_id','data_inicio_teste', 'data_vencimento_teste', 
        'status_id', 'data_aquisicao','valor_contrato','eh_teste','bloqueado_pelo_gestor','liberado_pelo_gestor',
        'data_vencimento','data_inicial_vencimento','valor_recorrente','dias_bloqueia'
        
    ];    
        
    public function faturas(){
        return $this->hasMany(FinFatura::class, 'assinatura_id', 'id');
    }    
    
    public function planopreco(){
        return $this->belongsTo(PlanoPreco::class,"plano_preco_id");
    } 
}
