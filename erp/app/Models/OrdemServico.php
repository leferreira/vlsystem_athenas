<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class OrdemServico extends Model
{
    use HasFactory,EmpresaTrait;
    
    protected $fillable =[
        'empresa_id',
        'cliente_id',
        'vendedor_id',
        'tecnico_id',
        'usuario_id',
        'status_id',
        'status_financeiro_id',
        'garantia_id',
        'data_abertura',
        'previsao_entrega',
        'data_final',
        'garantia',
        'descricao_produto',
        'defeito',
        'laudo_tecnico',
        'observacoes',
        'valor_total_produto',
        'valor_total_servico',
        'valor_desconto',
        'valor_liquido',
        'desconto_valor',
        'desconto_per',
        'taxa_diversa',
        
    ];
    
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function status_financeiro(){
        return $this->belongsTo(Status::class, 'status_financeiro_id');
    }
    
    public static function somarTotal($id){      
        $os                         = OrdemServico::find($id);
        $total_produto              = ProdutoOs::where("os_id", $id)->sum("subtotal_liquido");
        $total_servico              = ServicoOs::where("os_id", $id)->sum("subtotal_liquido"); 
        $valor_os                    = $total_produto + $total_servico;        
        $os->valor_desconto      = 0;
        if($os->desconto_valor > 0){
            $os->valor_desconto = $os->desconto_valor;
        }
        if($os->desconto_per > 0){
            $os->valor_desconto = $os->desconto_per * $valor_os * 0.01;
        }
        
        $os->valor_total_produto     = $total_produto   ;
        $os->valor_total_servico     = $total_servico  ;     
        $os->valor_os                = $valor_os;
        $os->valor_liquido           = $os->valor_os - $os->valor_desconto + $os->taxa_diversa;
        $os->save();
    }
}

