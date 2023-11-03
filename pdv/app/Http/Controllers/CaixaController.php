<?php

namespace App\Http\Controllers;
use App\Http\Requests\PdvCaixaRequest;
use App\Service\CaixaService;
use App\Service\SangriaService;
use App\Service\SuplementoService;
use App\Service\VendaService;
use App\Service\PdvService;

class CaixaController extends Controller{
    
    public function create(){       
        $caixa_id = session("usuario_pdv_logado")->caixa_id;
       
        if($caixa_id){
            return redirect()->back()->with("msg_erro", "Já existe um caixa Aberto, Feche-o primeiramente para abrir um novo!");
        }
        $dados["numeros"] = CaixaService::listaNumeroCaixa()->data;
        return view('Caixa.Create', $dados);
    }
    
    
    public function abrir(PdvCaixaRequest $request){
        $req = $request->all();        
        $req["usuario_abriu_uuid"] = session("usuario_pdv_logado")->uuid;
        $req["valor_abertura"] = $req["valor_abertura"] ? getFloat($req["valor_abertura"]) : 0;
        PdvService::abrirCaixa($req);     
        $caixa_id        = session("usuario_pdv_logado")->caixa_id;      
        if($caixa_id){
            return redirect()->route("home");
        }else{
            return redirect()->route('caixa.create')->with("msg_erro", "Erro ao inserir o Caixa");
        }
    }
    
    public function fechar($id){
        PdvService::fecharCaixa();        
        return redirect()->route("home");        
    }
    
    public function fechamento($id_caixa){
        try {
            $dados["detalhe"]     = CaixaService::detalhamento($id_caixa);
            if($dados["detalhe"]->pode_fechar =="N"){
                throw(new \Exception('Existe alguma venda deste caixa que não foi finalizada, para fechar o caixa não pode haver nenhuma venda pendente.'));
            }
            return view("Caixa.Fechamento", $dados);
        } catch (\Exception $e) {
            return redirect()->back()->with("msg_erro", "Erro: " . $e->getMessage());
        }
        
    }
    
    public function contagem($id_caixa){
        
        return view("Caixa.Contagem");
    }
    
    public function caixasAberto(){
        $caixa_id = session("usuario_pdv_logado")->caixa_id;
        
        if(!$caixa_id){
            return redirect()->back()->with("msg_erro", "Não existe nenhum caixa aberto, abra-o primeiramente!");
        }
        $dados["caixa"]     = PdvService::home("ver_caixa")->caixa;  

        
        return view('Caixa.CaixasAbertos', $dados);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function index(){
        $dados["lista"] = CaixaService::listaCaixa();      
        return view('Caixa.Index', $dados);
    }
    
    
    
    public function detalhes($id_caixa){
        $dados["detalhe"]       = CaixaService::detalhamento($id_caixa);   
        return view('Caixa.Detalhe', $dados);
    }
    
    public function ver(){
        $caixas = CaixaService::listaCaixaAbertoPorUsuario(session("usuario_pdv_logado")->uuid);
        if($caixas){
            if(count($caixas) ==1){
                return redirect()->route('caixa.fechamento', $caixas[0]->id);
            }else{
                return redirect()->route('caixa.caixasAberto');
            }
        }else{
            return redirect()->back()->with("msg_erro", "Para esta funcionalidade é necessário que tenha pelo menos um caixa aberto");
        }
    }
    
      
            
    public function venda($id_caixa){
        $dados["lista"]       = VendaService::listaPorCaixa($id_caixa);
        return view('Caixa.Vendas', $dados);
    }
    
    public function sangria($id_caixa){
        $dados["lista"]       = SangriaService::listaPorCaixa($id_caixa);
        $dados["caixa_id"]    = $id_caixa;
        return view('Sangria.Index', $dados);
    }
    
    public function suplemento($id_caixa){
        $dados["lista"]       = SuplementoService::listaPorCaixa($id_caixa);     
        $dados["caixa_id"]    = $id_caixa;
        return view('Suplemento.Index', $dados);
    }
    
    
    
    
    
    
}
