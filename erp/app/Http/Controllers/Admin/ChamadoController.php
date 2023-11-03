<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
use App\Models\Chamado;
use App\Models\ChamadoReposta;

class ChamadoController extends Controller
{  
   
    
    public function index()
    {
        $dados["lista"] = Chamado::get();
        return view("Admin.Chamado.Index", $dados);
    }
    
    public function show($id)
    {
        $dados["chamado"]   = Chamado::find($id);
        $dados["respostas"] = ChamadoReposta::where("chamado_id", $id)->get(); 
        return view("Admin.Chamado.Edit", $dados);
    }
    
    public function create()
    {       
        return view("Admin.Chamado.Create");
    }
    
    public function store(Request $request){
        $req                    = $request->except(["_token","_method","file"]);
        $empresa                = auth()->user()->empresa;
        $req["status_id"]       = config('constantes.status.ABERTO');
        $req["usuario_id"]      = auth()->user()->id;
        
        if ($request->hasFile('file') && $request->file->isValid()) {
            $file               = $request->file('file');
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $pasta              = "storage/".$empresa->pasta ."/anexos/";
            $upload             = $file->move(public_path($pasta), $nomeImagem);
            $req["anexo"] = $pasta . $nomeImagem;            
        }        
        Chamado::Create($req);
        return redirect()->route("admin.chamado.index")->with("msg_sucesso","Registro alterado com sucesso");
    }
    
  
    public function salvarResposta(Request $request){
        $req                    = $request->except(["_token","_method"]);
        $req["usuario_id"]      = auth()->user()->id;
        
        ChamadoReposta::Create($req);
        $chamado = Chamado::find($req["chamado_id"]);
        $chamado->status_id = config("constantes.status.PENDENTE");
        $chamado->save();
        
        
        return redirect()->route("admin.chamado.index")->with("msg_sucesso","Registro alterado com sucesso");
    }
    
    
}
