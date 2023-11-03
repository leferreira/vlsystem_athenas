<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmitenteRequest;
use App\Models\AutorizadosNfe;
use App\Models\Emitente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContaCorrente;
use App\Models\ClassificacaoFinanceira;

class EmitenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados["emitenteJs"]    = true;
        $dados["emitente"]      = Emitente::where("empresa_id",Auth::user()->empresa_id)->first();    
        $dados["autorizados"]   = AutorizadosNfe::get();
        $dados["contas"]        = ContaCorrente::get();
        $dados["classificacoes"]= ClassificacaoFinanceira::get();
        return view("Admin.Configuracao.Emitente.Create", $dados);
    }

    
    public function create()
    {
        return view("Admin.Emitente.Create");
    }

   

    public function show($id)
    {
        //
    }
    
    public function edit($id){
        $dados["emitente"] = Emitente::find($id);
        return view('admin.Emitente.Create', $dados);
    }

   
    public function update(EmitenteRequest $request, $id){
        $req                    = $request->except(["_token","_method","arquivo"]);
     //   $req["aliquotapis"]     = ($req["aliquotapis"]!=null) ? getFloat($req["aliquotapis"]) : $req["aliquotapis"];
     //   $req["aliqiuotacofins"] = ($req["aliqiuotacofins"]!=null) ? getFloat($req["aliqiuotacofins"]) : $req["aliqiuotacofins"];
        $req["pCredSN"]         = ($req["pCredSN"]!=null) ? getFloat($req["pCredSN"]) : $req["pCredSN"];
        $req["cnpj"]            = tira_mascara($req["cnpj"]);
        $req["cep"]             = tira_mascara($req["cep"]);
        $req["fone"]            = tira_mascara($req["fone"]);
        
    /*    if ($request->hasFile('arquivo') && $request->arquivo->isValid()) {
            $req['certificado_arquivo_binario'] =file_get_contents($_FILES["arquivo"]["tmp_name"]);
        }
     */   
        Emitente::where("id", $id)->update($req);
        return redirect()->route("admin.emitente.index")->with("msg_sucesso","Registro alterado com sucesso");
    }

     public function inserirAutorizado(Request $request){
         $req = $request->except(["_token","_method"]);
         AutorizadosNfe::Create($req);         
         $lista = AutorizadosNfe::get();
         echo json_encode($lista);        
         
     }
     
     public function excluirAutorizado($id){         
         AutorizadosNfe::where("id", $id)->delete();
         $lista = AutorizadosNfe::get();
         echo json_encode($lista);
         
     }
    
    public function destroy($id)
    {
        try{
            $h = Emitente::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
