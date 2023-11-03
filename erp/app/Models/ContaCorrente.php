<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class ContaCorrente extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = ["id","empresa_id","descricao", "banco_id", "agencia","conta","tipo_conta_corrente_id","pix"];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function tipo(){
        return $this->belongsTo(TipoContaCorrente::class, 'tipo_conta_corrente_id');
    }
    public function banco(){
        return $this->belongsTo(Banco::class, 'banco_id');
    }
    
    public static function saldo(){
        $contas = ContaCorrente::get();
        $lista = array();
        foreach($contas as $conta){
            $retorno = new \stdClass();
            $retorno->conta         = $conta;
            $retorno->todas_entradas= MovimentoConta::where(["tipo_movimento"=>"C","conta_id" =>$conta->id])->sum("valor");
            $retorno->todas_saidas  = MovimentoConta::where(["tipo_movimento"=>"D","conta_id" =>$conta->id])->sum("valor");
            $retorno->saldo_atual   = $retorno->todas_entradas - $retorno->todas_saidas;
            $lista[] = $retorno;
        }
        
        return $lista;
    }
}
