<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class FinDespesa extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        "empresa_id",
        "fornecedor_id",
        "tipo_despesa_id",        
        "status_id",
        "status_financeiro_id",
        "classificacao_financeira_id ",
        "valor_despesa",
        "descricao",
        "data_lancamento",
        "data_vencimento",
        "valor_liquido",
        "valor_frete",
        "desconto_valor",
        "desconto_per",
        "valor_desconto"
    ];
    
    
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function tipo(){
        return $this->belongsTo(FinTipoDespesa::class, 'tipo_despesa_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function status_financeiro(){
        return $this->belongsTo(Status::class, 'status_financeiro_id');
    }
    
    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }
    
    public static function filtro($filtro){
        $retorno = FinDespesa::orderBy('fin_despesas.data_vencimento', 'asc');
        if($filtro->fornecedor_id){
            $retorno->where("fornecedor_id", $filtro->fornecedor_id);
        }
        
        if($filtro->tipo_despesa_id){
            $retorno->where("tipo_despesa_id", $filtro->tipo_despesa_id);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
        if($filtro->venc01){
            if($filtro->venc02){
                $retorno->where("data_vencimento",">=", $filtro->venc01)->where("data_vencimento","<=", $filtro->venc02);
            }else{
                $retorno->where("data_vencimento", $filtro->venc01);
            }
        }
        
        if($filtro->emissao01){
            if($filtro->emissao02){
                $retorno->where("data_lancamento",">=", $filtro->emissao01)->where("data_lancamento","<=", $filtro->emissao02);
            }else{
                $retorno->where("data_lancamento", $filtro->emissao01);
            }
        }
        
        return $retorno->get();
    }
}
