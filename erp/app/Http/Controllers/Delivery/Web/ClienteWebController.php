<?php

namespace App\Http\Controllers\Delivery\Web;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\ClienteDelivery;
use App\Rules\CelularDup;
use App\Rules\EmailDup;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use App\Http\Requests\ClienteDeliveryRequest;


class ClienteWebController extends Controller{      
    public function create(){
		
        $clienteLog = session('cliente_delivery_log');
        if(!$clienteLog){
            return view("Delivery.Web.Cliente.Create");
        }else{
            session()->flash("message_sucesso", "Voce já esta logado ".$clienteLog['nome']);
            return redirect()->route('delivery.web.home');
        }
    }
    
    public function salvar(ClienteDeliveryRequest $request){        
        $retorno = new \stdClass();
        try {
            $cod             = rand(100000, 888888);
            $req             = $request->except(["_token","_method"]);
            
           // $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
            $req["cpf_cnpj"] = ($req["cpf_cnpj"]) ? tira_mascara($req["cpf_cnpj"]) : "78589452387";
            $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
            $req["password"] = md5($req["password"]);
            $req["status_id"]= config("constantes.status.ATIVO");
            
            $req["indFinal"]  =  1;
            $req["limite_credito"]  =  0;
            $req["credito_utilizado"]  =  0;
            $req["credito_disponivel"]  =  $req["limite_credito"];
            $req["credito_devolucao"]  =  0;
            $celular = $req["celular"];
            $result = Cliente::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
          
            if($result){
                if(getenv("AUTENTICACAO_SMS") == 1){
                    $this->sendSms($celular, $cod);
                }
                else if(getenv("AUTENTICACAO_EMAIL") == 1) {
                    $this->sendEmailLink($request->email, $cod);
                }else{
                    $cliente = Cliente::find($result->id);
                    $session = [
                        'id' => $cliente->id,
                        'nome' => $cliente->nome,
                    ];
                    $cliente->ativo = 1;
                    $cliente->save();
                    session(['cliente_delivery_log' => $session]);
                    session()->flash("message_sucesso", "Bem vindo ". $cliente->nome);
                    return redirect('delivery.web.home');
                }
                
                return view('Delivery.Web.Cliente.Autenticar')
                ->with('config', $this->config)
                ->with('celular', $celular)
                ->with('cadastro_ative', true)
                ->with('title', 'AUTENTICAR');
                
            }else{
                session()->flash('message_erro', 'Erro ao se registrar!');
                return redirect()->route('delivery.web.cliente.salvar');
            }
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            i($e->getMessage());
            return redirect()->back()->with('msg_erro', $e->getMessage());
           
        }
        
        
       /* $this->_validate($request);
        $cod = rand(100000, 888888);
        $request->merge([ 'senha' => md5($request->senha)]);
        $request->merge([ 'ativo' => false]);
        $request->merge([ 'token' => $cod]);
        
		
        $celular = str_replace("(", "", $request->celular);
        $celular = str_replace(")", "", $celular);
        $celular = str_replace(" ", "", $celular);
        $celular = str_replace("-", "", $celular);
        
        $request->merge([ 'celular' => $celular]);
        
        $result = ClienteDelivery::create($request->all());
        if($result){            
            if(getenv("AUTENTICACAO_SMS") == 1){
                $this->sendSms($celular, $cod);
            }
            else if(getenv("AUTENTICACAO_EMAIL") == 1) {
                $this->sendEmailLink($request->email, $cod);
            }else{
                $cliente = ClienteDelivery::find($result->id);
                $session = [
                    'id' => $cliente->id,
                    'nome' => $cliente->nome,
                ];
                $cliente->ativo = 1;
                $cliente->save();
                session(['cliente_delivery_log' => $session]);
                session()->flash("message_sucesso", "Bem vindo ". $cliente->nome);
                return redirect('delivery.web.home');
            }
            
            return view('Delivery.Web.Cliente.Autenticar')
            ->with('config', $this->config)
            ->with('celular', $celular)
            ->with('cadastro_ative', true)
            ->with('title', 'AUTENTICAR');
            
        }else{
            session()->flash('message_erro', 'Erro ao se registrar!');
            return redirect()->route('delivery.web.cliente.salvar');
        }*/
    }
    
    private function _validate(Request $request){
        $rules = [
            'nome' => 'required|max:30',
            'sobre_nome' => 'required|max:30',
            'senha' => 'required|min:4|max:10',
            'celular' => ['required','min:13', 'max:15', new CelularDup],
            'email' => ['required', 'max:50','email', new EmailDup]
            
        ];
        
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => 'Maximo de 30 caracteres',
            'sobre_nome.required' => 'O campo sobre nome é obrigatório.',
            'sobre_nome.max' => 'Maximo de 30 caracteres',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.max' => 'Maximo de 10 caracteres',
            'senha.min' => 'Maximo de 4 caracteres',
            'celular.required' => 'O campo celular é obrigatório.',
            'celular.min' => 'Minimo de 15 caracteres',
            'celular.max' => 'Maximo de 15 caracteres',
            'email.required' => 'O campo email é obrigatório.',
            'email.max' => 'Maximo de 50 caracteres',
            'email.email' => 'Email inválido'
        ];
        $this->validate($request, $rules, $messages);
    }
    
    public function login(){
        $dados["tokenJs"] = true;
        return view("Delivery.Web.login", $dados);
    }
    
    public function logar(Request $request){
        $email      = $request->email;
        $senha     = md5($request->senha);
     
        $cliente = Cliente::where('password', $senha)->where('email', $email)->first();
    
       
        if($cliente == null){            
            session()->flash('message_erro', 'Credenciais inválidas.');
            return redirect()->route("delivery.web.login");
        }else{
            
            /*if(getenv("AUTENTICACAO_SMS") == 0 && getenv("AUTENTICACAO_EMAIL") == 0){
                $cliente->status_id = 1;
                $cliente->save();
                
                $session = [
                    'id' => $cliente->id,
                    'nome' => $cliente->nome,
                ];
                session(['cliente_delivery_log' => $session]);
                session()->flash("message_sucesso", "Bem vindo ". $cliente->nome);
                return redirect()->route('delivery.web.home');
            }*/
            
            if($cliente->status_id == 0){                
                $celular = $cliente->celular;
                $celular = str_replace("-", "", $celular);
                $celular = str_replace(" ", "", $celular);
                if(getenv("AUTENTICACAO_SMS") == 1) $this->sendSms($celular, $cliente->token);
                
                if(getenv("AUTENTICACAO_EMAIL") == 1) $this->sendEmailLink($cliente->email, $cliente->token);
                return view('delivery/ativar')
                ->with('config', $this->config)
                ->with('cliente', $cliente)
                ->with('login_ative', true)
                ->with('title', 'ATIVAR CADASTRO');
            }else{
                $session = [
                    'id' => $cliente->id,
                    'nome' => $cliente->nome,
                ];
                session(['cliente_delivery_log' => $session]);
                session()->flash("message_sucesso", "Bem vindo ". $cliente->nome);
                return redirect()->route('delivery.web.home');
            }
            
        }
    }
    
    public function logoff(){
        session()->forget('cliente_delivery_log');
        
        session()->flash('message_erro', 'Logoff realizado.');
        return redirect()->route('delivery.home');
    }
}
