<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\TransportadoraRequest;
use App\Models\Fornecedor;
use App\Models\NfeTransporte;
use App\Models\Transportadora;
use App\Models\Venda;
use App\Service\UtilService;
use Dompdf\Dompdf;
use Dompdf\Options;

class TransportadoraController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'transportadora';
    }
    
    public function index(){ 
        $this->checaPermissao(__FUNCTION__);
        $filtro                 = new \stdClass();
        $filtro->nome           = $_GET["nome"] ?? null;
        $filtro->email          = $_GET["email"] ?? null ;
        $filtro->cnpj           = $_GET["cnpj"] ?? null;
        
        $dados["lista"]         = Transportadora::filtro($filtro);
        $dados["filtro"]        = $filtro;  
        
        return view("Admin.Cadastro.Transportadora.Index", $dados);
    }    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["transportadoraJs"] = true;
        return view("Admin.Cadastro.Transportadora.Create", $dados);
    }    
    
    public function movimento($id){
        $dados["transportadora"]     = Transportadora::find($id);
        $dados["lista"]          = Venda::where("transportadora_id", $id)->get();
        
        return view("Admin.Cadastro.Transportadora.Vendas", $dados);
    }
    
    public function find($id){
        $transportadora = Transportadora::where('id', $id)->first();
        echo json_encode($transportadora);
    }
    
    public function lista(){
        $transportadora = Transportadora::get();
        echo json_encode($transportadora);
    }
    
    public function store(TransportadoraRequest $request){  
        $this->checaPermissao(__FUNCTION__);
        $retorno = new \stdClass();
        $req = $request->except(["_token","_method"]);  
        try {
            $req["eh_modal"] = ($req["eh_modal"]) ?? 0;
            $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
            $req["cnpj"]     = tira_mascara($req["cnpj"]);
            $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
            
            Transportadora::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            if($req["eh_modal"]){
                return response()->json($retorno);
            }else{
                return redirect()->route('admin.transportadora.index')->with('msg_sucesso', "Cliente Inserido com sucesso.");
            }
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            if($req["eh_modal"]){
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
        $dados["transportadora"]    = Transportadora::find($id);
        $dados["lista"]             = Transportadora::get();
        $dados["transportadoraJs"]  = true;
        return view('Admin.Cadastro.Transportadora.Create', $dados);
    }
    
    
    public function update(TransportadoraRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req             =   $request->except(["_token","_method"]);
        $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
        $req["cnpj"]     = tira_mascara($req["cnpj"]);
        $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
        Transportadora::where("id", $id)->update($req);
        return redirect()->route("admin.transportadora.index")->with('msg_sucesso', "Transportadora Alterado com sucesso.");
    }
    
    public function buscarCNPJ($cnpj){
        $empresa = UtilService::buscarCNPJ($cnpj);
        echo json_encode($empresa);
    }
    
    public function selecionarTransportadora($id_transportadora, $id_nfe){
        $tem = NfeTransporte::where("nfe_id", $id_nfe)->first();
        if($tem){
            $tem->delete();
        }
        
        $transportadora             = Transportadora::find($id_transportadora);
    ;
        $transporte                 = new \stdClass();
        $transporte->nfe_id      	= $id_nfe;
        $transporte->transp_xNome	= $transportadora->razao_social;
        $transporte->transp_xEnder	= $transportadora->logradouro;
        $transporte->transp_xMun	= $transportadora->cidade;
        $transporte->transp_UF	    = $transportadora->uf;
        $transporte->transp_CNPJ	= $transportadora->cnpj;
        
        $retorno = NfeTransporte::Create(objToArray($transporte));     
        echo json_encode($retorno);
    }
    
    
    public function getTransportadoraJson($id){
        $transportadora = Transportadora::find($id);
        echo json_encode($transportadora);
    }
    
    public function pesquisa(){
        $q          = $_GET["q"];
        $lista      = Transportadora::where("razao_social","like","%$q%")->get();
        
        return response()->json($lista);
    }
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Transportadora::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Transportadora Excluído com sucesso.");
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
        
        $dados["lista"]      = Transportadora::get();
        return view('Admin.Pdf.Lista_Transportadora', $dados);
    }
}
