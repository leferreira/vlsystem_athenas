<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\TecnicoRequest;
use App\Models\Tecnico;
use App\Service\UtilService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'tecnico';
    }
    
    public function index(){ 
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"]     = Tecnico::get();
        return view("Admin.Cadastro.Tecnico.Index", $dados);
    }    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["tecnicoJs"] = true;
        $dados["eh_modal"]  = 1;
        return view("Admin.Cadastro.Tecnico.Create", $dados);
    }    
    
    public function find($id){
        $tecnico = Tecnico::where('id', $id)->first();
        echo json_encode($tecnico);
    }
    
    public function movimento($id){
        $dados["lista"]     = Tecnico::get();      
        return view("Admin.Cadastro.Tecnico.Index", $dados);
    }
    
    public function store(Request $request){
        
        $retorno = new \stdClass();
        try {
            $req             = $request->except(["_token","_method","eh_modal"]);      
        
            $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
            $req["cpf"]      = $req["cpf"] ? tira_mascara($req["cpf"]) : null;
            $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
            $req["password"] = md5($req["senha"]);
            $req["status_id"]= config("constantes.status.ATIVO");
         
            Tecnico::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            if($request->eh_modal){
                $retorno->retorno  = Tecnico::get();
                return response()->json($retorno);
            }else{
                return redirect()->route('admin.tecnico.index')->with('msg_sucesso', "Tecnico Inserido com sucesso.");
            }
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            if($request->eh_modal){
                return response()->json($retorno);
            }else{
                return redirect()->back()->with('msg_erro', $e->getMessage());
            }
        }
    }
    
    public function show($id)
    {
        //
    }
    
    
    public function edit($id)
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["tecnico"]   = Tecnico::find($id);
        $dados["lista"]     = Tecnico::get();
        $dados["tecnicoJs"] = true;
        $dados["eh_modal"]  = 1;
        return view('Admin.Cadastro.Tecnico.Create', $dados);
    }
    
    
    public function update(TecnicoRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req             =   $request->except(["_token","_method","eh_modal"]);
        $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
        $req["cnpj"] = tira_mascara($req["cnpj"]);
        $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
        $req["password"] = md5($req["senha"]);
     
        Tecnico::where("id", $id)->update($req);
        return redirect()->route("admin.tecnico.index")->with('msg_sucesso', "Tecnico Alterado com sucesso.");
    }
    
    public function buscarCNPJ($cnpj){
        $empresa = UtilService::buscarCNPJ($cnpj);
        echo json_encode($empresa);
    }
    
    public function pesquisa(){
        $q          = $_GET["q"];
        $tecnicos   = Tecnico::where("nome_razao_social","like","%$q%")->get();
        
        return response()->json($tecnicos);
    }
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Tecnico::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Tecnico Excluído com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
    
    public function pdf(){
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        
        $dados["dompdf"]     = $dompdf;
        
        $dados["lista"]      = Tecnico::get();
        return view('Admin.Pdf.Lista_Tecnico', $dados);
    }
}
