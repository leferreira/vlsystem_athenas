<?php
namespace App\Models\Traits;

use App\Models\Assinatura;

trait UserACLTrait
{  
    
    public function modulos(){
        $assinatura = Assinatura::with("planopreco.plano.modulos")->where("status_id", config("constantes.status.ATIVO"))->first();
        $permissoes = [];
        if($assinatura){
            $plano      = $assinatura->planopreco->plano;
            $modulos    = $plano->modulos;
            
            $permissoes = [];
            foreach ($modulos as $modulo){               
                array_push($permissoes, $modulo->menu);
            }
        }         
        return $permissoes;
    }    
    
    public function permissoes(){     
        $funcoes    = $this->funcoes()->with("permissoes")->get(); 
        
        $permissoes = [];
        foreach($funcoes as $funcao){            
            foreach ($funcao->permissoes as $permissao){
                array_push($permissoes, $permissao->permissao);
            }
        }        
      
        return $permissoes;
    }
    public function temAPermissaoModulo(String $nome):bool{
        return in_array($nome, $this->modulos());
    }
    
    public function temPermissaoFuncao(String $nome):bool{
        return in_array($nome, $this->permissoes()) || $this->isAdmin() ;
    }
    public function isAdmin():bool{
        return $this->eh_admin == 'S';
    }
    
    public function isNotAdmin():bool{
        return $this->eh_admin != 'S';
    }
}

