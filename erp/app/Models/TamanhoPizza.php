<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TamanhoPizza extends Model
{
    protected $fillable = [
        'nome', 'pedacos', 'maximo_sabores'
    ];
    
    public function produtoPizza(){
        return $this->hasMany(ProdutoPizza::class, 'tamanho_id', 'id');
    }
    
    public function nome(){
        $temp = explode("_", $this->nome);
        if(sizeof($temp) > 1){
            $t = "";
            foreach($temp as $tp){
                $t .= $tp . " ";
            }
            return $t;
        }else{
            return $this->nome;
        }
    }
}
