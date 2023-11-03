<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\VariacaoGradeRequest;
use App\Models\VariacaoGrade;

class VariacaoGradeController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'variacaograde';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"] = VariacaoGrade::get();
        return view("Admin.Cadastro.VariacaoGrade.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.VariacaoGrade.Create");
    }

    public function salvarJs(VariacaoGradeRequest $request){
        $req = $request->except(["_token","_method"]);
        $retorno = new \stdClass();
        try {
            VariacaoGrade::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->lista     = VariacaoGrade::get();
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return $retorno;
        }
        
    }    
    
    
    public function listarVariacaoGrade(){
        $lista = VariacaoGrade::get();
        echo json_encode($lista);
    }
    
    public function store(VariacaoGradeRequest $request){
        $this->checaPermissao(__FUNCTION__);
        $req = $request->except(["_token","_method"]);
        $req["padrao"] = "N";
        VariacaoGrade::Create($req);
        return redirect()->route('admin.variacaograde.index')->with('msg_sucesso', "Inserido com sucesso.");
    }
   
    
    public function update(VariacaoGradeRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        VariacaoGrade::where("id", $id)->update($req);
        return redirect()->route("admin.variacaograde.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }
    
    public function edit($id){
        $dados["variacaograde"]     = VariacaoGrade::find($id);
        $dados["lista"]    = VariacaoGrade::get();
        return view('Admin.Cadastro.VariacaoGrade.Index', $dados);
    }
   
    

    public function pesquisa(){
        $q          = $_GET["q"];
        $lista      = VariacaoGrade::where("nome","like","%$q%")->get();
        return response()->json($lista);
    }
    
   
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = VariacaoGrade::find($id);
            if($h->padrao=="S"){
                throw new \Exception("Não é possível excluir o Tabela de Preço Padrão");
            }else{
                $h->delete();
            }
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
