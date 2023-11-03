<?php

namespace App\Http\Controllers\Admin\Recorrencia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\ModeloContratoRequest;
use App\Models\Cliente;
use App\Models\FinContaReceber;
use App\Models\LojaPedido;
use App\Models\PdvVenda;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\ModeloContrato;
use App\Service\ConstanteService;
use App\Service\UtilService;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\TabelaDicionario;
use App\Models\VendaRecorrente;

class ModeloContratoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'vendedor';
    }
    
    public function index(){ 
        $this->checaPermissao(__FUNCTION__);
        
        $dados["lista"]         = ModeloContrato::get();
        return view("Admin.Recorrencia.ModeloContrato.Index", $dados);
    }    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["vendedorJs"] = true;
        $dados["eh_modal"]  = 1;
        $dados["dicionarios"] = TabelaDicionario::lista();
        return view("Admin.Recorrencia.ModeloContrato.Create", $dados);
    }   
      
    
    public function store(ModeloContratoRequest $request){
        $retorno = new \stdClass();
        try {
            $req             = $request->except(["_token","_method"]); 
            $req["status_id"] = config("constantes.status.ATIVO");
            ModeloContrato::Create($req);
            return redirect()->route('admin.modelocontrato.index')->with('msg_sucesso', "ModeloContrato Inserido com sucesso.");
           
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
           return redirect()->back()->with('msg_erro', $e->getMessage());
            
        }
    }
    
    public function show($id)
    {        
        $dados["tabela_dicionario"]= TabelaDicionario::get();
        $dados["venda"]            = VendaRecorrente::find($id);
        $dados["dicionario"]      = VendaRecorrente::dadosContrato($id);
        
        return view('Admin.Recorrencia.ModeloContrato.show', $dados);
    }
    
    
    public function edit($id)
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["dicionarios"] = TabelaDicionario::lista();
        $dados["modelocontrato"]   = ModeloContrato::find($id);
        return view('Admin.Recorrencia.ModeloContrato.Create', $dados);
    }
    
    
    public function update(ModeloContratoRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req             =   $request->except(["_token","_method","eh_modal"]);
        
        ModeloContrato::where("id", $id)->update($req);
        return redirect()->route("admin.modelocontrato.index")->with('msg_sucesso', "ModeloContrato Alterado com sucesso.");
    }    
   
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = ModeloContrato::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "ModeloContrato Excluído com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
    
    public function pdf($venda_id){
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        
        $dados["dompdf"]     = $dompdf;
        
        $dados["lista"]      = ModeloContrato::get();
        return view('Admin.Pdf.Lista_ModeloContrato', $dados);
    }
}
