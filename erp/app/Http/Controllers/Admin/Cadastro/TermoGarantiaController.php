<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\TermoGarantiaRequest;
use App\Models\Compra;
use App\Models\TermoGarantia;
use App\Service\UtilService;
use Dompdf\Dompdf;
use Dompdf\Options;

class TermoGarantiaController extends Controller
{    
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'categoria';
    }
    
    public function index(){ 
        
        $dados["lista"] = TermoGarantia::get();
        return view("Admin.Cadastro.TermoGarantia.Index", $dados);
    }    
    
    public function create()
    {
        
        $dados["termogarantiaJs"] = true;
        return view("Admin.Cadastro.TermoGarantia.Create", $dados);
    }    
    
    public function movimento($id){
       
        $dados["termogarantia"]     = TermoGarantia::find($id);
        $dados["lista"]          = Compra::where("termogarantia_id", $id)->get();
        return view("Admin.Cadastro.TermoGarantia.Compras", $dados);
    }
    
    public function find($id){
        $termogarantia = TermoGarantia::where('id', $id)->first();
        echo json_encode($termogarantia);
    }
    
    public function store(TermoGarantiaRequest $request){ 
        
        $req = $request->except(["_token","_method"]);        
       
        TermoGarantia::Create($req);
        return redirect()->route('admin.termogarantia.index')->with('msg_sucesso', "TermoGarantia Inserido com sucesso.");
    }
    
    public function show($id)
    {
        //
    }
    
    
    public function edit($id)
    {
        
        $dados["termogarantia"]     = TermoGarantia::find($id);
        $dados["lista"]          = TermoGarantia::get();
        $dados["termogarantiaJs"] = true;
        return view('Admin.Cadastro.TermoGarantia.Create', $dados);
    }
    
        
    public function update(TermoGarantiaRequest $request, $id)
    {
        
        $req                =   $request->except(["_token","_method"]);
        TermoGarantia::where("id", $id)->update($req);
        return redirect()->route("admin.termogarantia.index")->with('msg_sucesso', "TermoGarantia Alterado com sucesso.");
    }
    
    public function buscarCNPJ($cnpj){        
        $empresa = UtilService::buscarCNPJ($cnpj);               
        echo json_encode($empresa);
    }
    
    public function destroy($id)
    {
        
        try{
            $h = TermoGarantia::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "TermoGarantia Excluído com sucesso.");
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
        
        $dados["lista"]      = TermoGarantia::get();
        return view('Admin.Pdf.Lista_TermoGarantia', $dados);
    }
}
