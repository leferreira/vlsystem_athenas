<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MeuPerfilController extends Controller
{
    
    public function index()
    {
        $dados["usuario"] = Auth::user();
        $dados["uploadJs"]  = true;
        return view("Admin.Configuracao.MeusDados", $dados);
    }
    
    public function salvar(Request $request)
    {        
        $req             = $request->except(["_token","_method","senha","file"]);
        $req["password"] = ($req["password"]!="") ? bcrypt($req["password"]) : $request->senha;
        $empresa = auth()->user()->empresa;
        
        if ($request->hasFile('file') && $request->file->isValid()) { 
            $file               = $request->file('file'); 
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;          
            $pasta              = "upload/".$empresa->pasta ."/imagens/";
            $upload             = $file->move(public_path($pasta), $nomeImagem);
            $req["foto"] = $pasta . $nomeImagem;
            
        }    
     
        User::where("id", $req["id"])->update($req);
        return redirect()->route("admin.meus_dados")->with("msg_sucesso","Registro alterado com sucesso");
    }

}
