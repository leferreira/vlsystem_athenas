<?php

namespace App\Http\Controllers;


use App\Http\Requests\ClienteRequest;
use App\Service\LojaService;
use Illuminate\Http\Request;

class ClienteController extends Controller{ 
    public function index(){
      
        if((session('usuario_loja_logado')->cliente_id ?? null) == null){
            return redirect()->route('login');
        }
        
        $perfil                 = LojaService::perfil() ;
        $dados["carrinho"]      = $perfil->carrinho;
        $dados["configuracao"]  = $perfil->configuracao;
        $dados["itens"]         = $perfil->itens;
        $dados["cliente"]       = $perfil->cliente;
        $dados["pedidos"]       = $perfil->pedidos;
        $dados["enderecos"]     = $perfil->enderecos;
        return view("Cliente.Index", $dados);
    }
    
    public function create(){
        $carrinho                = LojaService::carrinho() ;
        
        $dados["carrinho"]      = $carrinho->carrinho;
        $dados["configuracao"]  = $carrinho->configuracao;
        return view("Cliente.Create", $dados);
    }
    
    public function pedido($id_pedido){
        if((session('usuario_loja_logado')->nome ?? null) == null){
            return redirect()->route('login');
        }
        
        $carrinho              = LojaService::home("pedido",null, null, $id_pedido) ;   
      
        $dados["pedido"]       = $carrinho->carrinho;  
        $dados["itens"]        = $carrinho->itens;
        $dados["configuracao"] = $carrinho->configuracao;
        return view("Cliente.Pedido", $dados);
    }
    
    public function atualizarDadosCliente(Request $request){
        $retorno = null;
        try{
            $cliente             = new \stdClass();
            $cliente->id         = $request->cliente_id;
            $cliente->nome       = $request->nome;
            $cliente->cpf        = tira_mascara($request->cpf);
            $cliente->email      = $request->email;
            $cliente->telefone   = $request->telefone ? tira_mascara($request->telefone) : null;
            if($request->senha){
                $cliente->senha      = $request->senha;
                $cliente->password   = bcrypt($request->senha);
            }
           // $cliente = Cliente::where("id", $cliente->id)->update(objToArray($cliente));
            session()->flash('msg_sucesso', 'Alterado com sucesso');
            
        }catch(\Exception $e){
            session()->flash('msg_erro', 'Erro ao Atualizar Dados: ' . $retorno);
        }
        
        return redirect()->back();
    }
    
    public function salvar(ClienteRequest $request){
        $pedido                 = session('pedido') ?? null;
        $req                    = $request->all();
        try {
            $req["origem"]      = "loja";
            $req["pedido_id"]   = $pedido;
            $req["empresa_uuid"]= getenv("APP_ID_EMPRESA");
            $cliente            = LojaService::novoCliente($req);
            
            //Seta a sessão para o cliente cadastrado
            if($cliente){
                $cli = (object) [
                    'cliente_id'    => $cliente,
                    'nome'          => $request->nome,
                    'email'         => $request->email,
                    'start'         => date('H:i:s')
                ];
                session(['usuario_loja_logado' => $cli]);
            }
            
            if($request->pedido_id){
                return redirect()->route('carrinho.endereco',['tipo_frete'=>'']);
            }else{
                return redirect()->route('home')->with("msg_sucesso","Registro inserido com sucesso");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("msg_erro","erro: " . $e->getMessage());
        }
    }
    
    public function enderecoJs($id){
        $endereco = LojaService::getEnderecoPeloId($id);
        echo json_encode($endereco);
    }
    
    public function salvarEnderecoCliente(Request $request){
        try{
            $endereco               = new \stdClass();
            $endereco->id           = ($request->endereco_id) ?? null;
            $endereco->logradouro   = $request->logradouro;
            $endereco->numero       = $request->numero;
            $endereco->bairro       = $request->bairro;
            $endereco->cep          = $request->cep;
            $endereco->cidade       = $request->cidade;
            $endereco->uf           = $request->uf;
            $endereco->ibge         = $request->ibge;
            $endereco->cliente_id   = $request->cliente_id;
            $endereco->complemento  = $request->complemento ?? '';
            
            LojaService::salvarEnderecoCliente($endereco);            
            session()->flash('msg_sucesso', 'Endereço atualizado!');
            
        }catch(\Exception $e){
            session()->flash('msg_erro', 'Erro ao cadastrar endereço!');
        }
        return redirect()->back();
    }
    
    public function login(){
        $carrinho                = LojaService::carrinho() ;
     
        $dados["carrinho"]      = $carrinho->carrinho;
        $dados["configuracao"]  = $carrinho->configuracao;
        if(($_SESSION['usuario_loja_logado']["nome"] ?? null) == null){
            return view("login", $dados);
        }else{
            $dados["cliente"]   = $carrinho->cliente;
            $dados["pag"]       = "detalhe";
            return view("login", $dados);
        }
        
    }
    
    public function logar(Request $request){
        $req                = $request->all();
        $req["pedido_id"]   = session('pedido') ?? null;
        $req["empresa_uuid"]= getenv("APP_ID_EMPRESA");        
        $cliente            = LojaService::logar($req);        
        if($cliente){
            return redirect()->route('home');
        }else{
            return redirect()->back()->with('msg_erro', 'Email e/ou senha não encontrado!');
        }
    }
    
    public function logoff(){
        session()->forget('usuario_loja_logado');
        return redirect()->route("home")->with('mensagem_sucesso', 'Logoff realizado!!');
    }
      
}
