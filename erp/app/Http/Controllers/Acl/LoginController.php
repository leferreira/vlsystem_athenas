<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use App\Models\Log; //adicionar recurso de log de sistema no futuro


class LoginController extends Controller{
    public function index(){
        return view('Login');
    }   
    
    public function esqueci(){
        return view('Esqueci');
    }
  
    public function logar(Request $req ){  
        $this->validate($req, ['email'=>'required', 'password'=>'required']);        
        $data = $req->all();
    
        if ( Auth::attempt( [ 'email' => $data['email'] , 'password' => $data['password' ]] ) ) {
            $usuario_logado = Auth::user();                  
            
            if ( $usuario_logado->isAtivo() ) {                
                return redirect()->route('admin.index');
            } else {
                Auth::logout();              
                return redirect('acl.login')->with('msg_erro', 'Usuário inativo.');
            }
        }

         return redirect()->back()->with('msg_erro', 'Usuário ou senha inválidos.');
        //return redirect()->route('home');
    }
    public function logoff () {
        Auth::logout();
        return redirect()->route('acl.login');
    }
    
    

}
