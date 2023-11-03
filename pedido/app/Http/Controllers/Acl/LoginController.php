<?php

namespace App\Http\Controllers\Acl;

use App\Service\LoginService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;



class LoginController extends Controller{
    public function index(){
        return view('Login');
    }    
    
    public function login(Request $req ){
        try {
            $cliente = LoginService::logar($req->all());
            if($cliente){
                session(['usuario_logado' => $cliente]);
                return redirect()->route('home');
            }
            
            session()->forget('usuario_logado');
            return redirect()->route('login')->with("Email/Senha não localizados");
        } catch (\Exception $e) {
            session()->forget('usuario_logado');
            return redirect()->route('login')->with("Email/Senha não localizados");
        }
      
        
      }

    public function logout () {
        //logger
        session()->forget('usuario_logado');      
        return redirect()->route('login');

    }

}
