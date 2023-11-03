<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\EquipamentoRequest;
use App\Models\Compra;
use App\Models\Equipamento;
use App\Service\UtilService;
use Dompdf\Dompdf;
use Dompdf\Options;

class EquipamentoController extends Controller
{    
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'equipamento';
    }
    
    public function index(){ 
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"] = Equipamento::get();
        return view("Admin.Cadastro.Equipamento.Index", $dados);
    }    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["equipamentoJs"] = true;
        return view("Admin.Cadastro.Equipamento.Create", $dados);
    }    
    
    public function movimento($id){
       
        $dados["equipamento"]     = Equipamento::find($id);
        $dados["lista"]          = Compra::where("equipamento_id", $id)->get();
        return view("Admin.Cadastro.Equipamento.Compras", $dados);
    }
    
    public function find($id){
        $equipamento = Equipamento::where('id', $id)->first();
        echo json_encode($equipamento);
    }
    
    public function store(EquipamentoRequest $request){ 
        $retorno = new \stdClass();
        try {
            $req         = $request->except(["_token","_method","eh_modal"]);
            $equipamento = Equipamento::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";            
            if($request->eh_modal){
                $retorno->retorno = Equipamento::where("cliente_id", $equipamento->cliente_id)->get();
                return response()->json($retorno);
            }else{
                return redirect()->route('admin.equipamento.index')->with('msg_sucesso', "Vendedor Inserido com sucesso.");
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
        $dados["equipamento"]     = Equipamento::find($id);
        $dados["lista"]          = Equipamento::get();
        $dados["equipamentoJs"] = true;
        return view('Admin.Cadastro.Equipamento.Create', $dados);
    }
    
    public function pesquisaPorCliente($cliente_id){
        $lista = Equipamento::where("cliente_id",$cliente_id)->get();
        echo json_encode($lista);
    }
    
    public function update(EquipamentoRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req                =   $request->except(["_token","_method"]);
        Equipamento::where("id", $id)->update($req);
        return redirect()->route("admin.equipamento.index")->with('msg_sucesso', "Equipamento Alterado com sucesso.");
    }
    
    public function buscarCNPJ($cnpj){        
        $empresa = UtilService::buscarCNPJ($cnpj);               
        echo json_encode($empresa);
    }
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Equipamento::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Equipamento Excluído com sucesso.");
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
        
        $dados["lista"]      = Equipamento::get();
        return view('Admin.Pdf.Lista_Equipamento', $dados);
    }
}
