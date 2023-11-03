<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use App\Service\AssinaturaService;

class AssinaturaMiddleware
{
    
    public function handle(Request $request, Closure $next){        
        $usuario = auth()->user(); 
        $retorno = AssinaturaService::verificarAssinatura();
        if($retorno->redireciona==true){
            return redirect()->route($retorno->rota);
        }
      
        if(isset($usuario->empresa)){
            if($usuario->empresa->status_assinatura_id==config('constantes.status.BLOQUEADO')){
                return redirect()->route("meus_planos.vencido");
            }
                        
            if($usuario->empresa->status_assinatura_id==config('constantes.status.DEMO_VENCIDO')){
                return redirect()->route("meus_planos.vencido");
            }
        }        
        return $next($request);
    }
}
