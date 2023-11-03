<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class FinContaReceber extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        "empresa_id",
        "usuario_id",
        "descricao",
        "total_juros",
        "total_multa",
        "data_previsao",
        "total_desconto",
        "total_liquido",
        "total_recebido",
        "total_restante",
        "forma_pagto_id",
        "cliente_id",
        "venda_id",
        "pdvduplicata_id",
        "loja_pedido_id",
        "centro_custo_id",
        "forma_pagto_id",
        "num_parcela",
        "ult_parcela",
        "data_emissao",
        "data_vencimento",
        "observacao",
        "valor",
        "status_id",
        "cobranca_id",
        "nfe_id",
        "origem"
    ];
    
 
    
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function recebimentos(){
        return $this->hasMany(FinRecebimento::class, 'conta_receber_id', 'id');
    }   
   
    
    public function forma_pagto(){
        return $this->belongsTo(FormaPagto::class, 'forma_pagto_id');
    }
    
    public function venda(){
        return $this->belongsTo(Venda::class, 'venda_id');
    }
    
    public function centro_custo(){
        return $this->belongsTo(CentroCusto::class, 'centro_custo_id');
    }
    
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function categoria(){
        return $this->belongsTo(CategoriaConta::class, 'categoria_id');
    }
  
    public static function atualizar($id){
        $conta          = FinContaReceber::find($id);
        //$valor_recebido = FinRecebimento::where("conta_receber_id", $id)->sum("valor_recebido");
        $valor_original = FinRecebimento::where("conta_receber_id", $id)->sum("valor_original");
        $juros          = FinRecebimento::where("conta_receber_id", $id)->sum("juros");
        $multa          = FinRecebimento::where("conta_receber_id", $id)->sum("multa");
        $desconto	    = FinRecebimento::where("conta_receber_id", $id)->sum("desconto");
        
        
        $conta->total_juros     = $juros;
        $conta->total_multa     = $multa;
        $conta->total_desconto  = $desconto;
        $conta->total_recebido  = $valor_original;
        
        $conta->total_liquido   = $valor_original +  $conta->total_juros + $conta->total_multa - $conta->total_desconto;
        $conta->total_restante  = $conta->valor - $valor_original ;
        
        if($conta->total_restante>0){
            $conta->status_id    = config("constantes.status.PARCIALMENTE_PAGO");
        }
        
        if($conta->total_restante<=0){
            $conta->status_id    = config("constantes.status.PAGO");
        }
        $conta->save();
    }
    
    public static function relatorio($filtro){ 
       
        $lista = array();
        if($filtro->tipo_relatorio=="agrupado_por_vencimento"){
            $datas = listaIntevaloData($filtro->venc01, $filtro->venc02);
            for($i=0; $i<count($datas); $i++){
                $contas = FinContaReceber::where("data_vencimento", $datas[$i])->get();
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
                $contas = FinContaReceber::where("data_emissao", $datas[$i])->get();
                if(count($contas) > 0){
                    $retorno = new \stdClass();
                    $retorno->data = $datas[$i];
                    $retorno->lista = $contas;
                    $lista[] = $retorno;
                }
                
            }
        } 
        
        if($filtro->tipo_relatorio=="agrupado_por_cliente"){
                $cliente = Cliente::select("id", "nome_razao_social")->find($filtro->cliente_id);
           
                $contas = FinContaReceber::where("cliente_id", $cliente->id)->get();
                if(count($contas) > 0){
                    $retorno = new \stdClass();
                    $retorno->cliente = $cliente;
                    $retorno->lista = $contas;
                    $lista[] = $retorno;
                }
                
             
        }
        return $lista;
    }
    
    
    public static function consulta($filtro){
        $retorno = FinContaReceber::orderBy($filtro->ordem, $filtro->tipo_ordem);
     
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
            $retorno->where($filtro->origem, "!=",  Null);
        }
        
        if($filtro->descricao){
            $retorno->where("descricao", "like", "%$filtro->descricao%");
        }
        
       if($filtro->cliente_id){
            $retorno->where("cliente_id", $filtro->cliente_id);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
       
        return $retorno->get();
    }
    
    public static function filtro($filtro, $paginas=0){
        $retorno = FinContaReceber::orderBy('fin_conta_recebers.data_vencimento', 'asc');
        if($filtro->conta_id){
            $retorno->where("id", $filtro->conta_id);
        }
        
        if($filtro->cliente_id){
            $retorno->where("cliente_id", $filtro->cliente_id);
        }
      
 
        if($filtro->status_id!=null){
            $retorno->whereIn("status_id",$filtro->status_id );
        }
        
        if($filtro->venda_id){
            
            $retorno->where("venda_id", $filtro->venda_id);
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
    
    public static function relatorio_antigo($filtro){
        $retorno = FinContaReceber::orderBy('fin_conta_recebers.data_vencimento', 'asc');
        if($filtro->cliente_id){
            $retorno->where("cliente_id", $filtro->cliente_id);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
        if($filtro->data1){
            if($filtro->data2){
                $retorno->where("data_vencimento",">=", $filtro->data1)->where("data_vencimento","<=", $filtro->data2);
            }else{
                $retorno->where("data_vencimento", $filtro->data1);
            }
        }
        
        /*if($filtro->emissao01){
            if($filtro->emissao02){
                $retorno->where("data_emissao",">=", $filtro->emissao01)->where("data_emissao","<=", $filtro->emissao02);
            }else{
                $retorno->where("data_emissao", $filtro->emissao01);
            }
        }
        */
        return $retorno->get();
    }
 
}
