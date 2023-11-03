<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Http\Requests\NaturezaOperacaoRequest;
use App\Models\Categoria;
use App\Models\Cfop;
use App\Models\CstCofins;
use App\Models\CstIcms;
use App\Models\CstIpi;
use App\Models\CstPis;
use App\Models\Emitente;
use App\Models\NaturezaOperacao;
use App\Models\ProdutoCofins;
use App\Models\ProdutoIcms;
use App\Models\ProdutoIpi;
use App\Models\ProdutoPis;
use Illuminate\Support\Facades\Auth;
use App\Models\Estado;
use App\Models\TipoContribuinte;
use App\Models\IcmsDesoneracao;

class NaturezaOperacaoController extends Controller
{
    
    public function index(){
        
        $dados["lista"] = NaturezaOperacao::get();
        return view("Admin.Configuracao.NaturezaOperacao.Index", $dados);
    }
    
    public function store(NaturezaOperacaoRequest $request){
        try {
            $req = $request->except(["_token","_method"]);
            NaturezaOperacao::Create($req);
            return redirect()->route('admin.naturezaoperacao.index')->with('msg_sucesso', "Inserido com sucesso.");
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
        
    }

    public function tributacao($id_natureza){
        $emitente                   = Emitente::where("empresa_id",Auth::user()->empresa_id)->first();
        $dados["natureza"]          = NaturezaOperacao::find($id_natureza);
       // $tipo = ($emitente->crt==1 || $emitente->crt== null ) ? "S" : "L";
        $dados["lista_cstIcms"]     = CstIcms::get();
        $dados["lista_cst_ipi"]     = CstIpi::get();
        $dados["lista_cfop"]        = Cfop::get();
        $dados["lista_cstPis"]      = CstPis::get();
        $dados["lista_cstCofins"]   = CstCofins::get();
        $dados["estados"]           = Estado::get();    
        $dados["tipos"]             = TipoContribuinte::get();
        $dados["desonaracoes"]      = IcmsDesoneracao::get();
        $dados["emitente"]          = $emitente;
        $dados["tributacaoJs"]      = true;
        
        //$view = ($emitente->crt == 1 || $emitente->crt== null ) ? "TributacaoSimples" : "TributacaoLucro";      
        $view ="TributacaoLucro";
        return view("Admin.Configuracao.NaturezaOperacao." .$view, $dados);
    }
    
    public function create(){            
        $dados["naturezaJs"]            = true;
        return view("Admin.Configuracao.NaturezaOperacao.Create" , $dados);
    }
    
    public function edit($id){
        $dados["natureza"]              = NaturezaOperacao::find($id);      
        return view("Admin.Configuracao.NaturezaOperacao.Create", $dados);
    }
    
    public function buscarCstIpi($tipo){
        $lista = CstIpi::where("tipo", $tipo)->get();
        return response()->json($lista);
    }
    
    public function buscarListaCfop($tipo){
        $lista = Cfop::where("tipo", $tipo)->get();
        return response()->json($lista);
    }
    
    
    
    public function excluirProdutoTributacao($tabela, $id){         
        try {
            if($tabela=="Icms"){
                $produto = ProdutoIcms::find($id);
                $produto->delete();
                $lista = ProdutoIcms::where("tributacao_id", $produto->tributacao_id)->get();
            }
            
            if($tabela=="Ipi"){
                $produto = ProdutoIpi::find($id);
                $produto->delete();
                $lista = ProdutoIpi::where("tributacao_id", $produto->tributacao_id )->get();
            }
            
            if($tabela=="Pis"){
                $produto = ProdutoPis::find($id);
                $produto->delete();
                $lista = ProdutoPis::where("tributacao_id", $produto->tributacao_id )->get();
            }
            
            if($tabela=="Cofins"){
                $produto = ProdutoCofins::find($id);
                $produto->delete();
                $lista = ProdutoCofins::where("tributacao_id", $produto->tributacao_id)->get();
            }            
            $retorno = $this->retornoListaProduto($lista);
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno = new \stdClass();
            $retorno->retorno = array();
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();            
            return response()->json($retorno);
        }
        
    }
    
    public function listaProdutoTributacao($tabela, $tributacao_id){        
        if($tabela=="Icms"){
            $lista = ProdutoIcms::where("tributacao_id", $tributacao_id)->get();
        }
        
        if($tabela=="Ipi"){
            $lista = ProdutoIpi::where("tributacao_id", $tributacao_id )->get();
        }
        
        if($tabela=="Pis"){
            $lista = ProdutoPis::where("tributacao_id", $tributacao_id )->get();
        }
        
        if($tabela=="Cofins"){
            $lista = ProdutoCofins::where("tributacao_id", $tributacao_id)->get();
        }
        
        $retorno = $this->retornoListaProduto($lista);
        return response()->json($retorno);
        
    }
    
    private function retornoListaProduto($lista){
        $retorno = new \stdClass();
        $retorno->retorno = array();
        foreach($lista as $p){
            $resultado                = new \stdClass();
            $resultado->id            = $p->id;
            $resultado->produto_id    = $p->produto->id;
            $resultado->nome          = $p->produto->nome;
            $resultado->tributacao_id = $p->id;
            $retorno->retorno[]       = $resultado;
        }
        
        $retorno->tem_erro  = false;
        $retorno->erro      = "";
        return $retorno;        
    }
    
    

    
    public function show($id)
    {
        //
    }

    
    public function update(NaturezaOperacaoRequest $request, $id){
        try {
            $req = $request->except(["_token","_method"]);
            NaturezaOperacao::where("id", $id)->update($req);
            return redirect()->route('admin.naturezaoperacao.index')->with('msg_sucesso', "Inserido com sucesso.");
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
        
    }

   
    public function destroy($id)
    {
        try{
            $h = Categoria::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
