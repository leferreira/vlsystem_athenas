<?php

namespace App\Http\Controllers\Admin\Ead;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\Cliente;
use App\Models\EadAluno;
use App\Models\Status;
use App\Service\UtilService;
use Illuminate\Http\Request;
use App\Models\EadMatricula;

class EadMatriculaController extends Controller
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
    
           
    
    public function store(Request $request){
        $this->checaPermissao(__FUNCTION__);
        $retorno = new \stdClass();
        try {
            $req             = $request->except(["_token","_method"]);    
            $req["hora_matricula"] = agora();
            EadMatricula::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            return redirect()->route('ead.aluno.matricular', $request->curso_id)->with('msg_sucesso', "Aluno Inserido com sucesso.");
           
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
        $dados["cliente"]   = Cliente::find($id);
        $dados["lista"]     = Cliente::get();
        $dados["clienteJs"] = true;
        $dados["eh_modal"]  = 1;
        return view('Admin.Cadastro.Cliente.Create', $dados);
    }
    
    
    public function update(Request $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req             =   $request->except(["_token","_method","eh_modal"]);
        $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
        $req["cpf_cnpj"] = tira_mascara($req["cpf_cnpj"]);
        $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
        $req["password"] = md5($req["senha"]);
     
        Cliente::where("id", $id)->update($req);
        return redirect()->route("admin.cliente.index")->with('msg_sucesso', "Cliente Alterado com sucesso.");
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
