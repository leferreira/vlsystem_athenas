<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class MovimentoConta extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable =[
        'empresa_id',
        'conta_id',
        'sangria_id',
        'suplemento_id',
        'recebimento_id',
        'documento',
        'data_emissao',
        'data_compensacao',
        'tipo_movimento',
        'historico',
        'origem',
        'valor',
        'usuario_id',
        'classificacao_financeira_id',
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function conta(){
        return $this->belongsTo(ContaCorrente::class, 'conta_id');
    }
    
    public function classificacaoFinanceira(){
        return $this->belongsTo(ClassificacaoFinanceira::class, 'classificacao_financeira_id');
    }
    
    
    
    public static function extrato($filtro){
        $soma_entradas      = MovimentoConta::where(["tipo_movimento"=>"C","conta_id" =>$filtro->conta_id])->sum("valor");
        $qtde_entradas      = MovimentoConta::where(["tipo_movimento"=>"C","conta_id" =>$filtro->conta_id])->count("*");
        
        $soma_saidas        = MovimentoConta::where(["tipo_movimento"=>"D","conta_id" =>$filtro->conta_id])->sum("valor"); 
        $qtde_saidas        = MovimentoConta::where(["tipo_movimento"=>"D","conta_id" =>$filtro->conta_id])->count("*");
        
        
        $soma_entrada_filtro  = MovimentoConta::where(["tipo_movimento"=>"C", "conta_id" =>$filtro->conta_id])->where("data_compensacao",">=", $filtro->compensacao01)->where("data_compensacao","<=", $filtro->compensacao02)->sum("valor");
        $qtde_entrada_filtro  = MovimentoConta::where(["tipo_movimento"=>"C", "conta_id" =>$filtro->conta_id])->where("data_compensacao",">=", $filtro->compensacao01)->where("data_compensacao","<=", $filtro->compensacao02)->count("*");
        
        $soma_saida_filtro  = MovimentoConta::where(["tipo_movimento"=>"D", "conta_id" =>$filtro->conta_id])->where("data_compensacao",">=", $filtro->compensacao01)->where("data_compensacao","<=", $filtro->compensacao02)->sum("valor");
        $qtde_saida_filtro  = MovimentoConta::where(["tipo_movimento"=>"D", "conta_id" =>$filtro->conta_id])->where("data_compensacao",">=", $filtro->compensacao01)->where("data_compensacao","<=", $filtro->compensacao02)->count("*");
        
        
        
        $entradas_anterior  = MovimentoConta::where(["tipo_movimento"=>"C", "conta_id" =>$filtro->conta_id])->where("data_compensacao","<", $filtro->compensacao01)->sum("valor");
        $saidas_anterior    = MovimentoConta::where(["tipo_movimento"=>"D", "conta_id" =>$filtro->conta_id])->where("data_compensacao","<", $filtro->compensacao01)->sum("valor");
        $saldo_anterior     = $entradas_anterior - $saidas_anterior;
     
        $lista              = MovimentoConta::where("data_compensacao",">=", $filtro->compensacao01)->where("data_compensacao","<=", $filtro->compensacao02)->where("conta_id", $filtro->conta_id)->get();
        $retorno = new \stdClass();
        $retorno->soma_entradas = $soma_entradas;
        $retorno->qtde_entradas = $qtde_entradas;
        
        $retorno->soma_saidas  = $soma_saidas;
        $retorno->qtde_saidas  = $qtde_saidas;
        
        $retorno->soma_entrada_filtro  = $soma_entrada_filtro;
        $retorno->qtde_entrada_filtro  = $qtde_entrada_filtro;
        
        $retorno->soma_saida_filtro  = $soma_saida_filtro;
        $retorno->qtde_saida_filtro  = $qtde_saida_filtro;
        
        $retorno->saldo_atual  = $retorno->soma_entradas - $retorno->soma_saidas;
        
        $retorno->saldo_anterior = $saldo_anterior;
        $retorno->lista = $lista;
        
        return $retorno;
    }
    public static function filtro($filtro, $paginas=0){
       
        $retorno = MovimentoConta::orderBy('movimento_contas.data_emissao', 'asc');
        
        if($filtro->classificacao_id){
            $retorno->where("classificacao_financeira_id", $filtro->classificacao_id);
        }
        
        if($filtro->tipo){
            $retorno->where("tipo_movimento", $filtro->tipo);
        }
        
        if($filtro->conta_id){
            $retorno->where("conta_id", $filtro->conta_id);
        }
        
        if($filtro->data_emissao01){
            if($filtro->data_emissao02){
                $retorno->where("data_emissao",">=", $filtro->data_emissao01)->where("data_emissao","<=", $filtro->data_emissao02);
            }else{
                $retorno->where("data_emissao", $filtro->data_emissao01);
            }
        }
        
        if($filtro->compensacao01){
            if($filtro->compensacao02){
                $retorno->where("data_compensacao",">=", $filtro->compensacao01)->where("data_compensacao","<=", $filtro->compensacao02);
            }else{
                $retorno->where("data_compensacao", $filtro->compensacao01);
            }
        }
        
        if($paginas > 0){
            $retorno = $retorno->paginate($paginas);
        }else{
            $retorno = $retorno->get();
        }
        
        return $retorno;
    }
    
    public static function relatorio($filtro){
        
        $retorno = new \stdClass();       
        if($filtro->tipo_relatorio=="extrato"){
            $conta              = ContaCorrente::find($filtro->conta_id);
            $entrada_anterior   = MovimentoConta::where("data_emissao", "<", $filtro->emissao01)->where("tipo_movimento", "C")->sum("valor");
            $saida_anterior     = MovimentoConta::where("data_emissao", "<", $filtro->emissao01)->where("tipo_movimento", "D")->sum("valor");
            $saldo              = $entrada_anterior - $saida_anterior;
            
            
            $lista = MovimentoConta::where("data_emissao", ">=", $filtro->emissao01)->where("data_emissao", "<=", $filtro->emissao02)->get();
            if(count($lista) > 0){
                
                $retorno->conta            = $conta;
                $retorno->entrada_anterior = $saida_anterior;
                $retorno->saida_anterior   = $saida_anterior;
                $retorno->saldo_anterior   = $saldo;
                $retorno->lista            = $lista;
            }
           
        }
              
        return $retorno;
    }
    
    public static function consulta($filtro){
        $retorno = MovimentoConta::orderBy($filtro->ordem, $filtro->tipo_ordem);
        
        if($filtro->emissao01){
            if($filtro->emissao02){
                $retorno->where("data_emissao",">=", $filtro->emissao01)->where("data_emissao","<=", $filtro->emissao02);
            }else{
                $retorno->where("data_emissao", $filtro->emissao01);
            }
        }        
        
        
        if($filtro->origem){
            if($filtro->origem=="avulsa"){
                $retorno->where("despesa_id",  Null)->where("fatura_id",  Null)->where("compra_id",  Null);
            }else{
                $retorno->where($filtro->origem, "!=",  Null);
            }
            
        }
        
        if($filtro->historico){
            $retorno->where("historico", "like", "%$filtro->historico%");
        }
        
        if($filtro->tipo_movimento){
            $retorno->where("tipo_movimento", $filtro->tipo_movimento);
        }
        
         
        if($filtro->conta_id){
            $retorno->where("conta_id", $filtro->conta_id);
        }
        
     
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
        
        return $retorno->get();
    }
}
