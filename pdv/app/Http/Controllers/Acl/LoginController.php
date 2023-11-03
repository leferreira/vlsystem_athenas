<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Service\LoginService;
use App\Service\NotaFiscalService;
//use App\Models\Log; //adicionar recurso de log de sistema no futuro


class LoginController extends Controller{
    public function index(){
        //$retorno = NotaFiscalService::verificarRequisito();        
        return view('Login');                
    }   
    
    public function erros(){
        $pendencias = session("usuario_pdv_logado")->pendencias;       
        $dados["requisitos"] = $pendencias->erro;
        $dados["caminho"] = $pendencias->caminho;
        return view('Requisitos', $dados);        
    }      
   
    public function login(LoginRequest $request ){  
        $req = $request->all();            
       // $req["token"] = getenv("APP_ID_EMPRESA");
        $retorno = LoginService::logar($req);   
     
        if($retorno){
            /*$erros = NotaFiscalService::verificarRequisito($retorno->empresa_uuid);        
            if($erros->tem_erro){
                return redirect()->route('erros',$retorno->empresa_uuid );
            }*/
            session(['usuario_pdv_logado' => $retorno]);
            return redirect()->route('home');
        }        
        session()->forget('usuario_pdv_logado');
        return redirect()->route('login');            
   }
   
    public function logout () {
        session()->forget('usuario_pdv_logado');
        return redirect()->route('login');
    }

}
