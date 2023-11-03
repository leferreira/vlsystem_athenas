<?php
namespace App\Service;

use App\Models\FuncaoPermissao;
use App\Models\Permissao;

class PermissaoService
{
   
    public static function tem_permissao($funcao_id, $descricao){
        $permissao = Permissao::where("permissao", $descricao)->first();
        $tem = false;
        if($permissao){
            $tem      = FuncaoPermissao::where(["permissao_id"=>$permissao->id ,"funcao_id" =>$funcao_id])->first();  
        }
             
        return $tem ? true : false;
        
    }
    
   
}

