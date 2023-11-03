<?php

namespace App\Models;

use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PdvCaixaNumero extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [ "empresa_id", "num_caixa","descricao","padrao_busca",'gerar_nfce', 
                            'transmitir_nfce', 'imprimir_direto_na_impressora','mostrar_pdf', 'apos_a_venda',
                            'gerar_financeiro','gerar_estoque','pergunta_antes_de_finalizar_venda'];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
