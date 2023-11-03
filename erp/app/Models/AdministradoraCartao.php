<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class AdministradoraCartao extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id', "descricao","operadora_cartao_id", "conta_corrente_id", 'classificacao_financeira_id', 'plano_conta_taxa_id','dias_para_recebimento','parcela_recebe_diferenca'
    ];
    
    public function operadora(){
        return $this->belongsTo(OperadoraCartao::class, 'operadora_cartao_id');
    }
    
    public function contaCorrente(){
        return $this->belongsTo(ContaCorrente::class, 'conta_corrente_id');
    }
    
    public function classificacaoTaxa(){
        return $this->belongsTo(ClassificacaoFinanceira::class, 'classificacao_financeira_id');
    }
}

