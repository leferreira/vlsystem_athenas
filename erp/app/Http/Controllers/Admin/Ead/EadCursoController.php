<?php

namespace App\Http\Controllers\Admin\Ead;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\Cliente;
use App\Models\EadAulas;
use App\Models\EadCurso;
use App\Models\Status;
use App\Service\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EadCursoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'curso';
    }
    
    public function index(){ 
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"]     = EadCurso::get();
        return view("Admin.Ead.Curso.Index", $dados);
    }    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["status"]     = Status::get();
        return view("Admin.Ead.Curso.Create", $dados);
    }    
    
           
    
    public function store(Request $request){
        $this->checaPermissao(__FUNCTION__);
        $empresa            = auth()->user()->empresa;  
        $retorno = new \stdClass();
        try {
            $req                    = $request->except(["_token","_method", "file"]);     
            $req["valor"]           = isset($req["valor"]) ? getFloat($req["valor"]) : null;
            $req["data_cadastro"]   = $req["data_cadastro"] ?? hoje() ;
            $req["status_id"]       = config("constantes.status.ATIVO");
            $req["slug"]            = Str::kebab($request->curso);
            
            if ($request->hasFile('file') && $request->file->isValid()) {
                $file               = $request->file('file');
                $extensao           = $file->getClientOriginalExtension();
                $nomeImagem         = Str::random(25) . ".".$extensao;
                $pasta              = "upload/".$empresa->pasta ."/cursos/";
                //$pasta              = "storage/".$empresa->pasta ."/produtos/";
                $file->move(public_path($pasta), $nomeImagem);
                $req['imagem']       = $pasta . $nomeImagem;
            } 
                     
            EadCurso::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            return redirect()->route('ead.curso.index')->with('msg_sucesso', "Curso Inserido com sucesso.");
           
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return redirect()->back()->with('msg_erro', $e->getMessage());
            
        }
    }
    
    public function aulas($id)
    {
        $dados["curso"]     = EadCurso::find($id);
        $dados["lista"]     = EadAulas::where("curso_id", $id)->get();
        return view("Admin.Ead.Curso.Aulas", $dados);
    }
    
    
    public function edit($id)
    {
       // $this->checaPermissao(__FUNCTION__);
        $dados["curso"]     = EadCurso::find($id);
        return view("Admin.Ead.Curso.Create", $dados);
    }
    
    
    public function update(Request $request, $id)
    {
       // $this->checaPermissao(__FUNCTION__);
        $empresa            = auth()->user()->empresa;
        $retorno = new \stdClass();
        try {
            $req                    = $request->except(["_token","_method", "file"]);
            $req["valor"]           = isset($req["valor"]) ? getFloat($req["valor"]) : null;
            $req["data_cadastro"]   = $req["data_cadastro"] ?? hoje() ;
            
            if ($request->hasFile('file') && $request->file->isValid()) {
                $file               = $request->file('file');
                $extensao           = $file->getClientOriginalExtension();
                $nomeImagem         = Str::random(25) . ".".$extensao;
                $pasta              = "upload/".$empresa->pasta ."/cursos/";
                //$pasta              = "storage/".$empresa->pasta ."/produtos/";
                $file->move(public_path($pasta), $nomeImagem);
                $req['imagem']       = $pasta . $nomeImagem;
            }
            
            EadCurso::where("id", $id)->update($req);            
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            return redirect()->route('ead.curso.index')->with('msg_sucesso', "Curso Alterado com sucesso.");
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return redirect()->back()->with('msg_erro', $e->getMessage());
            
        }
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
