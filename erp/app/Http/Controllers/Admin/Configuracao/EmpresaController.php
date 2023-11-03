<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Service\UtilService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EmpresaRequest;
use Str;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados["empresaJs"] = true;
        $dados["empresa"] = auth()->user()->empresa;
        return view("Admin.Configuracao.Empresa.Create", $dados);
    }
    
    public function create()
    {
        return view("Admin.Empresa.Create");
    }

    public function verLoja(){
        $subdominio = Auth::user()->empresa->subdominio;    
        if($subdominio){ 
            $link = "http://" .$subdominio. ".". getEnv("APP_URL_LOJA")."/home/entrarNaLoja";           
            return redirect( $link);
        }else{
            return redirect()->route("admin.empresa.index")->with("msg_erro", "Configure primeiramente o subdominio para poder acessar a sua loja virtual");
        }
    }

    public function show($id)
    {
        //
    }

    public function buscarCNPJ($cnpj){        
        $empresa = UtilService::buscarCNPJ($cnpj);
        echo json_encode($empresa);
    }
    
    public function edit($id)
    {
        $dados["empresaJs"] = true;
        $dados["empresa"] = Empresa::find($id);
        return view('admin.Empresa.Create', $dados);
    }
    
    public function esconderPendencia(){
        $empresa         = auth()->user()->empresa;
        $empresa->mostrar_pendencia = 'N';
        $empresa->save();
        echo json_encode("OK");
    }
   
    public function update(EmpresaRequest $request, $id){
        $req                    = $request->except(["_token","_method","arquivo", "file","cpf_cnpj"]);       
        try {
            $req["cep"]             = tira_mascara($req["cep"]);
            $req["fone"]            = ($req["fone"]) ? tira_mascara($req["fone"]) : null;
            
            $empresa                = auth()->user()->empresa;
            $file                   = $request->file('file');
            
            if($file){
                $extensao           = $file->getClientOriginalExtension();
                $nomeImagem         = Str::random(25) . ".".$extensao;
                $request->merge([ 'path' => $nomeImagem ]);
                $pasta              = "upload/".$empresa->pasta ."/imagens/";
                $upload             = $file->move(public_path($pasta), $nomeImagem);
                $req["logo"]        = $pasta . $nomeImagem;
            }
            $req["cpf_cnpj"]        = tira_mascara($request->cpf_cnpj);
         
            $empresa= Empresa::where("id", $id)->first();
            if($empresa->cpf_cnpj!=null){
                $req["cpf_cnpj"]        = tira_mascara($request->cpf_cnpj);
            }
 
            $empresa->update($req);
            return redirect()->route("admin.empresa.index")->with("msg_sucesso","Registro alterado com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()->with("msg_erro","Erro: " . $e->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from upload.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $h = Empresa::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
