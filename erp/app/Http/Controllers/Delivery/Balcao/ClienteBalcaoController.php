<?php

namespace App\Http\Controllers\Delivery\Balcao;

use App\Http\Controllers\Controller;
use App\Models\ClienteDelivery;
use App\Models\PedidoDelivery;
use App\Rules\CelularDup;
use App\Rules\EmailDup;
use Illuminate\Http\Request;


class ClienteBalcaoController extends Controller{      
    public function create(){
        $clienteLog = session('cliente_delivery_log');
        if(!$clienteLog){
            return view("Delivery.Cliente.Create");
        }else{
            session()->flash("message_sucesso", "Voce já esta logado ".$clienteLog['nome']);
            return redirect()->route('delivery.home');
        }
    }
    
    public function inserirClienteNoPedido(Request $request){
        $cli = ClienteDelivery::create(
            [
                'nome'      => $request->nome,
                'sobre_nome'=> $request->sobre_nome,
                'celular'   => $request->celular ?? '',
                'email'     => '',
                'token'     => 0,
                'ativo'     => 1,
                'senha'     => md5($request->senha),
                'referencia'=> $request->referencia ?? ''
            ]
            );        
            return redirect()->route('delivery.balcao.novo');        
    }
    
    
    public function login(){
        $dados["tokenJs"] = true;
        return view("Delivery.login", $dados);
    }
    
    public function logar(Request $request){
        $mailPhone = $request->email_celular;
        $mailPhone = str_replace(" ", "", $mailPhone);
        $senha     = md5($request->senha);
        $cliente   = null;
        
        if(is_numeric($mailPhone)){
            if(strlen($mailPhone) != 11){
                session()->flash('message_erro_telefone', 'Digite o telefone seguindo este padrao de exemplo 43999998888 - 11 Digitos.');
                return redirect()->route("delivery.login");
            }
            $cliente = ClienteDelivery::where('celular', $mailPhone)->where('senha', $senha)->first();
        }else{
            $cliente = ClienteDelivery::where('email', $mailPhone)->where('senha', $senha)->first();
        }
        
        if($cliente == null){
            session()->flash('message_erro', 'Credenciais inválidas.');
            return redirect()->route("delivery.login");
        }else{
            
            if(getenv("AUTENTICACAO_SMS") == 0 && getenv("AUTENTICACAO_EMAIL") == 0){
                $cliente->ativo = 1;
                $cliente->save();
                
                $session = [
                    'id' => $cliente->id,
                    'nome' => $cliente->nome,
                ];
                session(['cliente_delivery_log' => $session]);
                session()->flash("message_sucesso", "Bem vindo ". $cliente->nome);
                return redirect()->route('delivery.home');
            }
            
            if($cliente->ativo == 0){
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
                return redirect()->route('delivery.home');
            }
            
        }
    }
    
    
    public function logoff(){
        session()->forget('cliente_delivery_log');
        
        session()->flash('message_erro', 'Logoff realizado.');
        return redirect()->route('delivery.home');
    }
    
    public function pesquisaPorNome(){
        $q = $_GET["q"];
        $clientes = ClienteDelivery::where("nome","like","%$q%")->get();
        return response()->json($clientes);
    }
    
    public function pesquisaFone(){
        $q = $_GET["q"];
        $clientes = ClienteDelivery::where("celular","like","%$q%")->get();
        return response()->json($clientes);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function salvar(Request $request){
        
        $this->_validate($request);
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
                return redirect('/');
            }
            
            return view('Delivery.Cliente.Autenticar')
            ->with('config', $this->config)
            ->with('celular', $celular)
            ->with('cadastro_ative', true)
            ->with('title', 'AUTENTICAR');
            
        }else{
            session()->flash('message_erro', 'Erro ao se registrar!');
            return redirect()->route('delivery.cliente.salvar');
        }
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
    
    
}
