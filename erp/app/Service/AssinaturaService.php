<?php
namespace App\Service;

use App\Models\Assinatura;
use App\Models\FinFatura;

class AssinaturaService
{
    public static function verificarAssinatura(){
        $assinatura     = Assinatura::orderBy("id", "desc")->first(); 
      
        session()->forget('dias_restante');
        $retorno        = new \stdClass();      
        $retorno->redireciona = false;
        $retorno->rota  = "";
        //Não tem uma assinatura, fazer alguma coisa
        if($assinatura->status_id != config("constantes.status.ATIVO")){
            $retorno->redireciona = true;
            $retorno->rota = 'admin.assinatura.naoassinante';
            return $retorno;
        }        
        
        if($assinatura->bloqueado_pelo_gestor=="S"){
            $retorno->redireciona = true;
            $retorno->rota = 'admin.assinatura.bloqueado';
            return $retorno;
        }
        
        if($assinatura->liberado_pelo_gestor=="S"){
            $retorno->redireciona = false;
            $retorno->liberado = true;
            return $retorno;
        }      
     
        //Verificar o plano demo
        if($assinatura->eh_teste=="S"){
            $vencimento         =  somarData($assinatura->data_aquisicao, 15);
            $dias_restante      =  diferencaDataEmDias($vencimento, hoje()) ;
                        
            if($dias_restante <= 0){
                
                $retorno->redireciona = true;
                $retorno->rota = 'admin.assinatura.demovencido';
            }else{
                session(['dias_restante' => $dias_restante]);
            }
        }else{
            //ultima paga
            $ultima_paga   = FinFatura::where(["assinatura_id" => $assinatura->id, "status_id" => config("constantes.status.PAGO")])
                    ->orderBy("id","desc")->first(); 
            if($ultima_paga){
                $fatura_atual   = FinFatura::where("id",">",$ultima_paga->id)->first();
                
                $vencimento     = somarData($fatura_atual->data_vencimento, $assinatura->dias_bloqueia);
                
                if($vencimento < hoje()){
                    $retorno->redireciona = true;
                    $retorno->rota = 'admin.assinatura.faturaVencida';
                }
            }else{
                    $retorno->redireciona = true;
                    $retorno->rota = 'admin.assinatura.nenhumFaturaPaga';               
            }
            
        }
        
        return $retorno;
    }
    
   
    public static function data_vencimento(){
        $assinatura      = Assinatura::orderBy("id", "desc")->first();        
        if($assinatura->eh_teste=="S"){
            return   somarData($assinatura->data_aquisicao, 15);            
        }else{
            if($assinatura->ultima_fatura_paga){
                $fatura         = FinFatura::where(["assinatura_id" => $assinatura->id])->where("id",">",$assinatura->ultima_fatura_paga)->first();
            }else{
                $fatura         = FinFatura::where(["assinatura_id" => $assinatura->id])->first();
            }
            $vencimento     = somarData($fatura->data_vencimento, $assinatura->dias_bloqueia);
            return $vencimento;
        }
        
    }
    
    public static function diaParaVencimento(){
        $assinatura      = Assinatura::where("status_id", config("constantes.status.ATIVO"))->first();
        $retorno = true;
        if(!$assinatura){
            $retorno = false;
        }
        
        //Verificar o plano demo
        if($assinatura->eh_teste=="S"){
            $vencimento         =  somarData($assinatura->data_aquisicao, 15);
            $dias_restante      =  diferencaDataEmDias($vencimento, hoje()) ;
            if($dias_restante <= 0){
                $retorno = false;
            }
        }else{
            $fatura         = FinFatura::where("assinatura_id", $assinatura->id)->first();
            $vencimento     = somarData($fatura->data_vencimento, $assinatura->dias_bloqueia);
            if($vencimento < hoje()){
                $retorno    = false;
            }
        }
        
        return $retorno;
    }
}

