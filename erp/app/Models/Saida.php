<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class Saida extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'id',
        'empresa_id',
        'produto_id',
        'grade_produto_id',
        'unidade',
        'qtde_saida',
        'valor_saida',
        'subtotal_saida',
        'data_saida',
        'eh_grade'
    ];
    
    public function grade(){
        return $this->belongsTo(GradeProduto::class,"grade_produto_id","id");
    }
    
    public function produto(){
        return $this->belongsTo(Produto::class,"produto_id","id");
    }
    
    public function empresa(){
        return $this->belongsTo(Empresa::class,"empresa_id","id");
    }
    
    public static function filtro($filtro){
        
        $retorno = Saida::orderby('saidas.data_saida',"asc");
        
        if($filtro->produto_id){
            $retorno->where("produto_id", $filtro->produto_id);
        }
        
        if($filtro->data1){
            if($filtro->data2){
                $retorno->where("data_saida",">=", $filtro->data1)->where("data_saida","<=", $filtro->data2);
            }else{
                $retorno->where("data_saida", $filtro->data1);
            }
        }
        return $retorno;
    }
   
    
    public static function total($data){
        return self::where("data_saida",$data)
        ->sum("subtotal_saida");
    }
}
