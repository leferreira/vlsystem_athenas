<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Models\CertificadoDigital;
use App\Models\Emitente;
use App\Service\NfeService;
use Illuminate\Http\Request;

class CertificadoDigitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $certificado = CertificadoDigital::first();      
        if($certificado){
            $detalhe = NfeService::lerCertificado($certificado); 
        }     
        $dados["detalhe"]       = $detalhe ?? null;
        //i($dados["detalhe"]);
        $dados["certificado"]   = $certificado;
        return view("Admin.Configuracao.CertificadoDigital.Create", $dados);
    }
   
    public function update(Request $request, $id){
        $req            =   $request->except(["_token","_method","arquivo"]);
       
        $certificado = CertificadoDigital::first();        
        
        if ($request->hasFile('arquivo') && $request->arquivo->isValid()) {
            $req['certificado_arquivo_binario'] =file_get_contents($_FILES["arquivo"]["tmp_name"]);
        }        
        
        CertificadoDigital::where("id", $certificado->id)->update($req);
      
        
        return redirect()->route("admin.certificadodigital.index")->with("msg_sucesso","Registro alterado com sucesso");
    }

    public function store(Request $request){
        $req            =   $request->except(["_token","_method","arquivo"]);
        $emitente       = Emitente::first();
        
        $req["emitente_id"] =$emitente->id;
        
        if ($request->hasFile('arquivo') && $request->arquivo->isValid()) {
            $req['certificado_arquivo_binario'] =file_get_contents($_FILES["arquivo"]["tmp_name"]);
        }
        
         CertificadoDigital::Create($req);
       
        
        return redirect()->route("admin.certificadodigital.index")->with("msg_sucesso","Registro alterado com sucesso");
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
