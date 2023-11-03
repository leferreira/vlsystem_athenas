<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Tenant\Traits\EmpresaTrait;

class FinContaPagar extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        "empresa_id",
        "despesa_id",
        "total_juros",
        "total_multa",
        "total_desconto",
        "total_liquido",
        "total_recebido",
        "total_restante",
        "descricao",
        "fornecedor_id",
        "compra_id",
        "centro_custo_id",
        "num_parcela",
        "ult_parcela",
        "data_emissao",
        "data_vencimento",
        "observacao",
        "valor",
        "status_id",
        "origem",
        "nfe_id"
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class,"empresa_id");
    }
    public function pagamento(){
        return $this->belongsTo(FinPagamento::class, 'pagamento_id');
    }
    
    public function pagamentos(){
        return $this->hasMany(FinPagamento::class, 'conta_pagar_id', 'id');
    }
    
    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class,"fornecedor_id");
    }
    
    public function status(){
        return $this->belongsTo(Status::class,"status_id");
    }
    
    public function compra(){
        return $this->belongsTo(Compra::class,"compra_id");
    }
    
    public function centro_custo(){
        return $this->belongsTo(CentroCusto::class,"centro_custo_id");
    }
    
    public function forma_pagto(){
        return $this->belongsTo(FormaPagto::class,"forma_pagto_id","id");
    }
    
    public static function atualizar($id){
        $conta          = FinContaPagar::find($id);
        //$valor_recebido = FinRecebimento::where("conta_receber_id", $id)->sum("valor_recebido");
        $valor_original = FinPagamento::where("conta_pagar_id", $id)->sum("valor_original");
        $juros          = FinPagamento::where("conta_pagar_id", $id)->sum("juros");
        $multa          = FinPagamento::where("conta_pagar_id", $id)->sum("multa");
        $desconto	    = FinPagamento::where("conta_pagar_id", $id)->sum("desconto");
        
        
        $conta->total_juros     = $juros;
        $conta->total_multa     = $multa;
        $conta->total_desconto  = $desconto;
        $conta->total_recebido  = $valor_original;
        
        $conta->total_liquido   = $valor_original +  $conta->total_juros + $conta->total_multa - $conta->total_desconto;
        $conta->total_restante  = $conta->valor - $valor_original ;
        if($conta->total_restante<=0){
            $conta->status_id    = config("constantes.status.PAGO");
            if($conta->despesa_id){
                FinDespesa::find($conta->despesa_id)->update(["status_financeiro_id" =>config("constantes.status.PAGO"), "status_id" =>config("constantes.status.FINALIZADO")]);
            }
        }
        
        
        $conta->save();
    }
    
    public static function relatorio($filtro){
        
        $lista = array();
        if($filtro->tipo_relatorio=="agrupado_por_vencimento"){
            $datas = listaIntevaloData($filtro->venc01, $filtro->venc02);
            for($i=0; $i<count($datas); $i++){
                $contas = FinContaPagar::where("data_vencimento", $datas[$i])->get();
                if(count($contas) > 0){
                    $retorno = new \stdClass();
                    $retorno->data = $datas[$i];
                    $retorno->lista = $contas;
                    $lista[] = $retorno;
                }
                
            }
        }
        
        if($filtro->tipo_relatorio=="agrupado_por_emissao"){
            $datas = listaIntevaloData($filtro->emissao01, $filtro->emissao02);
            for($i=0; $i<count($datas); $i++){
                $contas = FinContaPagar::where("data_emissao", $datas[$i])->get();
                if(count($contas) > 0){
                    $retorno = new \stdClass();
                    $retorno->data = $datas[$i];
                    $retorno->lista = $contas;
                    $lista[] = $retorno;
                }
                
            }
        }
        
        if($filtro->tipo_relatorio=="agrupado_por_fornecedor"){
                $fornecedor = Fornecedor::select("id", "razao_social")->find($filtro->fornecedor_id);  
               
                $contas = FinContaPagar::where("fornecedor_id", $fornecedor->id)->get();
                if(count($contas) > 0){
                    $retorno = new \stdClass();
                    $retorno->fornecedor = $fornecedor;
                    $retorno->lista = $contas;
                    $lista[] = $retorno;
                }
                
             
        }
        return $lista;
    }
    
    public static function filtro($filtro, $paginas=0){
        $retorno = FinContaPagar::orderBy('fin_conta_pagars.data_vencimento', 'asc');
        if($filtro->conta_id){
            $retorno->where("id", $filtro->conta_id);
        }
        if($filtro->fornecedor_id){
            $retorno->where("fornecedor_id", $filtro->fornecedor_id);
        }
        
        if($filtro->status_id!=null){
            $retorno->whereIn("status_id",$filtro->status_id );
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
                $retorno->where("data_emissao",">=", $filtro->emissao01)->where("data_emissao","<=", $filtro->emissao02);
            }else{
                $retorno->where("data_emissao", $filtro->emissao01);
            }
        }
        
        if($paginas > 0){
            $retorno = $retorno->paginate($paginas);
        }else{
            $retorno = $retorno->get();
        }
        
        return $retorno;
    }
    
    public static function consulta($filtro){
        $retorno = FinContaPagar::orderBy($filtro->ordem, $filtro->tipo_ordem);
        
        if($filtro->emissao01){
            if($filtro->emissao02){
                $retorno->where("data_emissao",">=", $filtro->emissao01)->where("data_emissao","<=", $filtro->emissao02);
            }else{
                $retorno->where("data_emissao", $filtro->emissao01);
            }
        }
        if($filtro->venc01){
            if($filtro->venc02){
                $retorno->where("data_vencimento",">=", $filtro->venc01)->where("data_vencimento","<=", $filtro->venc02);
            }else{
                $retorno->where("data_vencimento", $filtro->venc01);
            }
        }
        
        if($filtro->origem){
            if($filtro->origem=="avulsa"){
                $retorno->where("despesa_id",  Null)->where("fatura_id",  Null)->where("compra_id",  Null);
            }else{
                $retorno->where($filtro->origem, "!=",  Null);
            }
            
        }
        
        if($filtro->descricao){
            $retorno->where("descricao", "like", "%$filtro->descricao%");
        }
        
        if($filtro->fornecedor_id){
            $retorno->where("fornecedor_id", $filtro->fornecedor_id);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
        
        return $retorno->get();
    }
    
    public static function relatorio_antigo($filtro){
        $retorno = FinContaPagar::orderBy('fin_conta_pagars.data_vencimento', 'asc');
        if($filtro->fornecedor_id){
            $retorno->where("fornecedor_id", $filtro->fornecedor_id);
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
                $retorno->where("data_emissao",">=", $filtro->emissao01)->where("data_emissao","<=", $filtro->emissao02);
            }else{
                $retorno->where("data_emissao", $filtro->emissao01);
            }
        }
        
        return $retorno->get();
    }
   
}
