<?php

namespace App\Models;

use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinRecebimento extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        'id',
        "empresa_id",
        "usuario_id",
        "descricao_recebimento",
        "tipo_documento",
        "documento_id",
        'conta_receber_id',
        'conta_corrente_id',
        'classificacao_financeira_id',
        "forma_pagto_id",
        "data_recebimento",
        "numero_documento",
        "valor_original",
        "valor_a_receber",
        "valor_recebido",
        "juros",
        "desconto",
        "multa",
        "status_id",
        "desconto",
    ];
    
    
    
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function venda(){
        return $this->belongsTo(Venda::class, 'venda_id');
    }
    
    public function forma_pagamento(){
        return $this->belongsTo(FormaPagto::class, 'forma_pagto_id');
    }
    
    public function conta_receber(){
        return $this->belongsTo(FinContaReceber::class, 'conta_receber_id');
    }
    
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function categoria(){
        return $this->belongsTo(CategoriaConta::class, 'categoria_id');
    }
    
    public static function filtroPorMes($mes, $ano){
        $retorno = self::whereYear('data_recebimento', '=', $ano)
        ->whereMonth('data_recebimento', '=', $mes)
        ->get();;
        return $retorno;
    }
    
    public static function filtro($filtro){
        $retorno = FinRecebimento::orderBy('fin_recebimentos.data_recebimento', 'asc');
        
        if($filtro->forma_pagto_id){
            $retorno->where("forma_pagto_id", $filtro->forma_pagto_id);
        }
        
        if($filtro->data01){
            if($filtro->data02){
                $retorno->where("data_recebimento",">=", $filtro->data01)->where("data_recebimento","<=", $filtro->data02);
            }else{
                $retorno->where("data_recebimento", $filtro->data01);
            }
        }
        
        
        return $retorno->get();
    }
    
    public static function relatorio($filtro){        
        $lista = array();
        if($filtro->tipo_relatorio=="agrupado_por_recebimento"){
            $datas = listaIntevaloData($filtro->recebimento01, $filtro->recebimento02);
            for($i=0; $i<count($datas); $i++){
                $contas = FinRecebimento::where("data_recebimento", $datas[$i])->get();
                if(count($contas) > 0){
                    $retorno = new \stdClass();
                    $retorno->data = $datas[$i];
                    $retorno->lista = $contas;
                    $lista[] = $retorno;
                }
                
            }
        }
        
        if($filtro->tipo_relatorio=="resumo_por_forma_pagamento"){
            $formas = FormaPagto::get();
            foreach($formas as $f){
                $venda      = FinRecebimento::where("data_recebimento", ">=", $filtro->recebimento01)->where("data_recebimento", "<=", $filtro->recebimento02)->where("forma_pagto_id", $f->id)->sum("valor_original");
                $desconto   = FinRecebimento::where("data_recebimento", ">=", $filtro->recebimento01)->where("data_recebimento", "<=", $filtro->recebimento02)->where("forma_pagto_id", $f->id)->sum("desconto");
                $liquido    = FinRecebimento::where("data_recebimento", ">=", $filtro->recebimento01)->where("data_recebimento", "<=", $filtro->recebimento02)->where("forma_pagto_id", $f->id)->sum("valor_recebido");
                $juros      = FinRecebimento::where("data_recebimento", ">=", $filtro->recebimento01)->where("data_recebimento", "<=", $filtro->recebimento02)->where("forma_pagto_id", $f->id)->sum("juros");
               
                if($venda > 0){
                    $retorno = new \stdClass();
                    $retorno->forma     = $f;
                    $retorno->venda     = $venda;
                    $retorno->juros     = $juros;
                    $retorno->desconto  = $desconto;
                    $retorno->liquido   = $liquido;
                    $lista[]            = $retorno;
                }
                
            }
        }
        
      
        return $lista;
    }
    
    
    public static function consulta($filtro){
        $retorno = FinRecebimento::orderBy($filtro->ordem, $filtro->tipo_ordem);
        
        if($filtro->recebimento01){
            if($filtro->recebimento02){
                $retorno->where("data_recebimento",">=", $filtro->recebimento01)->where("data_recebimento","<=", $filtro->recebimento02);
            }else{
                $retorno->where("data_recebimento", $filtro->recebimento01);
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
