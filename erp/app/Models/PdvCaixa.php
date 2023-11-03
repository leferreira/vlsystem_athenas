<?php

namespace App\Models;

use App\Tenant\Traits\EmpresaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PdvCaixa extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id', 'caixanumero_id', 'data_abertura', 'hora_abertura', 'valor_abertura', 'gerente_abriu_id', 
        'gerente_fechou_id','data_fechamento', 'hora_fechamento', 'valor_fechamento', 'valor_vendido', 'valor_quebra',
        'valor_sangria', 'valor_suplemento',  'total_em_caixa', 'usuario_abriu_id',
        'usuario_fechou_id', 'status_id'  ,'dinheiro_gaveta'      
    ];
    
    public function empresa(){
        return $this->belongsTo(Empresa::class,"empresa_id","id");
    }
    
    public function caixaNumero(){
        return $this->belongsTo(PdvCaixaNumero::class,"caixanumero_id","id");
    }
    
    public function usuario(){
        return $this->belongsTo(User::class,"usuario_abriu_id","id");
    }
    public static function caixaNumeroNaoInseridas(){
        $numeros = PdvCaixaNumero::whereNotIn('id', function($query) {
            $query->select('pdv_caixas.caixanumero_id');
            $query->from('pdv_caixas');
            $query->whereRaw("pdv_caixas .status_id={config('constantes.status.ABERTO')}");
        })
        ->get();
        return $numeros;
    }
}
