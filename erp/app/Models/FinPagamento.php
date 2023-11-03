<?php

namespace App\Models;

use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinPagamento extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        "empresa_id",
        "usuario_id",
        "descricao_pagamento", 
        "tipo_documento",
        "conta_pagar_id",
        "despesa_id",
        "fatura_id",
        "forma_pagto_id",
        "classificacao_financeira_id",   
        "conta_corrente_id",
        "data_pagamento",
        "numero_documento",
        "observacao",
        "valor_original",
        "valor_pago",
        "juros",
        "desconto",
        "multa",
        "pago"
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class,"empresa_id","id");
    }
    
    public function forma_pagto(){
        return $this->belongsTo(FormaPagto::class,"forma_pagto_id","id");
    }
    
    public function conta_pagar(){
        return $this->belongsTo(FinContaPagar::class, 'conta_pagar_id');
    }
    
    public static function filtroPorMes($mes, $ano){
        $retorno = self::whereYear('data_pagamento', '=', $ano)
        ->whereMonth('data_pagamento', '=', $mes)
        ->get();;
        return $retorno;
    }
    
   
    
    public static function filtro($filtro){
        $retorno = FinPagamento::orderBy('fin_pagamentos.data_pagamento', 'asc');
              
        if($filtro->forma_pagto_id){
            $retorno->where("forma_pagto_id", $filtro->forma_pagto_id);
        }
        
        if($filtro->data01){
            if($filtro->data02){
                $retorno->where("data_pagamento",">=", $filtro->data01)->where("data_pagamento","<=", $filtro->data02);
            }else{
                $retorno->where("data_pagamento", $filtro->data01);
            }
        }        
        
        
        return $retorno->get();
    }
    
    
    public static function relatorio($filtro){
        
        $lista = array();
        if($filtro->tipo_relatorio=="agrupado_por_pagamento"){
            $datas = listaIntevaloData($filtro->pagamento01, $filtro->pagamento02);
            for($i=0; $i<count($datas); $i++){
                $contas = FinPagamento::where("data_pagamento", $datas[$i])->get();
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
                $contas = FinPagamento::where("data_emissao", $datas[$i])->get();
                if(count($contas) > 0){
                    $retorno = new \stdClass();
                    $retorno->data = $datas[$i];
                    $retorno->lista = $contas;
                    $lista[] = $retorno;
                }
                
            }
        }
        
        if($filtro->tipo_relatorio=="agrupado_por_cliente"){
            $clientes = Cliente::select("id", "nome_razao_social")->get();
            foreach ($clientes as $cli){
                $contas = FinPagamento::where("cliente_id", $cli->id)->get();
                if(count($contas) > 0){
                    $retorno = new \stdClass();
                    $retorno->cliente = $cli;
                    $retorno->lista = $contas;
                    $lista[] = $retorno;
                }
                
                
            }
        }
        return $lista;
    }
    
    
    public static function consulta($filtro){
        $retorno = FinPagamento::orderBy($filtro->ordem, $filtro->tipo_ordem);
        
        if($filtro->pagamento01){
            if($filtro->pagamento02){
                $retorno->where("data_pagamento",">=", $filtro->pagamento01)->where("data_pagamento","<=", $filtro->pagamento02);
            }else{
                $retorno->where("data_pagamento", $filtro->pagamento01);
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
}
