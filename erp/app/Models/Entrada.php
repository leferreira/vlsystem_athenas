<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class Entrada extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'id',
        'empresa_id',
        'unidade',
        'produto_id',
        'grade_produto_id',
        'qtde_entrada',
        'valor_entrada',
        'subtotal_entrada',
        'eh_grade',
        'data_entrada'];
    
    public function produto(){
        return $this->belongsTo(Produto::class,"produto_id","id");
    }
    
    public function grade(){
        return $this->belongsTo(GradeProduto::class,"grade_produto_id","id");
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class,"empresa_id","id");
    }
    
    public static function total($data){
        return self::where("data_entrada",$data)
        ->sum("subtotal_entrada");
    }
    
    public static function filtro($filtro){
        
        $retorno = Entrada::orderby('entradas.data_entrada',"asc");
        
        if($filtro->produto_id){
            $retorno->where("produto_id", $filtro->produto_id);
        }        
        
        if($filtro->data1){
            if($filtro->data2){
                $retorno->where("data_entrada",">=", $filtro->data1)->where("data_entrada","<=", $filtro->data2);
            }else{
                $retorno->where("data_entrada", $filtro->data1);
            }
        }
        return $retorno;
    }
}
