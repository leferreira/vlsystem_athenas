<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class ProdutoRecorrente extends Model
{
    use HasFactory, EmpresaTrait;
    
    protected $fillable =["id",
        "empresa_id",
        "descricao",
        "valor_servico",
        "valor_produto",
        "subtotal_liquido",
        "valor"
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class,"empresa_id","id");
    }
    
    
    public static function somarTotal($id){
        
        
        $total_produto  = ItemProdutoRecorrente::where("produto_id", "!=", Null)->where("produto_recorrente_id", $id)->sum("subtotal");
        $total_servico  = ItemProdutoRecorrente::where("servico_id", "!=", Null)->where("produto_recorrente_id", $id)->sum("subtotal");
        
        $total = $total_produto + $total_servico;
        
        $recorrencia                    = ProdutoRecorrente::find($id);
        $recorrencia->valor_produto     = $total_produto   ;
        $recorrencia->valor_servico     = $total_servico  ;
        $recorrencia->subtotal_liquido  = $total;
        //i($recorrencia);
        $recorrencia->save();
    }
}
