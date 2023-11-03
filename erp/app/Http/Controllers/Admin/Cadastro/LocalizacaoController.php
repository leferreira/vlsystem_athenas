<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\LocalizacaoRequest;
use App\Models\Localizacao;

class LocalizacaoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'localizacao';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"] = Localizacao::get();
        return view("Admin.Cadastro.Localizacao.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.Localizacao.Create");
    }

    public function salvarJs(LocalizacaoRequest $request){
        $req = $request->except(["_token","_method"]);
        $retorno = new \stdClass();
        try {
            Localizacao::Create($req);
            $retorno->tem_erro = false;
            $retorno->retorno = Localizacao::get();
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function listarLocalizacao(){
        $lista = Localizacao::get();
        echo json_encode($lista);
    }
    
    public function store(LocalizacaoRequest $request){
        $this->checaPermissao(__FUNCTION__);
        $req = $request->except(["_token","_method"]);
        $req["padrao"] = "N";
        Localizacao::Create($req);
        return redirect()->route('admin.localizacao.index')->with('msg_sucesso', "Inserido com sucesso.");
    }
       
    public function update(LocalizacaoRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        Localizacao::where("id", $id)->update($req);
        return redirect()->route("admin.localizacao.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }
    
    public function edit($id){
        $dados["localizacao"]     = Localizacao::find($id);
        $dados["lista"]    = Localizacao::get();
        return view('Admin.Cadastro.Localizacao.Index', $dados);
    }
   
    

    public function pesquisa(){
        $q          = $_GET["q"];
        $lista      = Localizacao::where("nome","like","%$q%")->get();
        return response()->json($lista);
    }
    
   
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Localizacao::find($id);
            $h->delete();
            
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
