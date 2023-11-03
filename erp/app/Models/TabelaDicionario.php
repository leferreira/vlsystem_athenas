<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaDicionario extends Model
{
    use HasFactory;
    protected $fillable = [
        'chave',
        'campo',
        'tabela',        
    ];
    
    public static function lista(){
        $tabelas=["empresa", "cliente", "contrato" ];
        $lista = array();
        foreach($tabelas as $tab){
            $retorno = new \stdClass();
            $retorno->tabela = $tab;
            $retorno->itens = TabelaDicionario::where("tabela", $tab)->get();
            $lista[] = $retorno;
        }
        
        return $lista;
    }
    
    
    
}
