<?php

namespace App\Http\Controllers\Admin\Ead;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\Cliente;
use App\Models\EadAluno;
use App\Models\Status;
use App\Service\UtilService;
use Illuminate\Http\Request;
use App\Models\EadCurso;
use App\Models\EadMatricula;

class EadAlunoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'aluno';
    }
    
    public function index(){ 
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"]     = EadAluno::get();
        return view("Admin.Ead.Aluno.Index", $dados);
    }    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["status"]     = Status::get();
        return view("Admin.Ead.Aluno.Create", $dados);
    }    
    
    public function matricular($id)
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["aluno"]     = EadAluno::find($id);
        $dados["cursos"]    = EadCurso::get();
        $dados["lista"]     = EadMatricula::where("aluno_id", $id)->get();
 
        return view("Admin.Ead.Aluno.Matricula", $dados);
    }
    
    public function store(Request $request){
        $this->checaPermissao(__FUNCTION__);
        $retorno = new \stdClass();
        try {
            $req             = $request->except(["_token","_method"]);     
            $req["password"] = md5($req["senha"]);
            $req["status_id"]= config("constantes.status.ATIVO");
         
            EadAluno::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            return redirect()->route('ead.aluno.index')->with('msg_sucesso', "Aluno Inserido com sucesso.");
           
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return redirect()->back()->with('msg_erro', $e->getMessage());
            
        }
    }
    
    public function show($id)
    {
        //
    }
    
    
    public function edit($id)
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["aluno"]     = EadAluno::find($id);
        return view("Admin.Ead.Aluno.Create", $dados);
    }
    
    
    public function update(Request $request, $id){
        $this->checaPermissao(__FUNCTION__);
        $req                =   $request->except(["_token","_method","eh_modal"]);
        $req["cpf"]         = tira_mascara($req["cpf"]);
        $req["celular"]     = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
        $req["password"]    = md5($req["senha"]);
     
        EadAluno::where("id", $id)->update($req);
        return redirect()->route('ead.aluno.index')->with('msg_sucesso', "Cliente Alterado com sucesso.");
    }
    
    public function buscarCNPJ($cnpj){
        $empresa = UtilService::buscarCNPJ($cnpj);
        echo json_encode($empresa);
    }
    
    public function pesquisa(){
        $q          = $_GET["q"];
        $clientes   = Cliente::where("nome_razao_social","like","%$q%")->get();
        
        return response()->json($clientes);
    }
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Cliente::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Cliente Excluído com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
