<?php

namespace App\Http\Controllers;

use App\Http\Requests\GestaoProspectoRequest;
use App\Models\GestaoProspecto;
use App\Models\Plano;


class AssinarController extends Controller
{
    public function index(){ 
        $dados["planos"]       = Plano::all();
        return view("Site.Assinar", $dados);
    }
    
    public function cadastro($plano_preco_id){
        $dados["banner"]            = true;
        $dados["plano_preco_id"]    = $plano_preco_id;
        return view("Site.Cadastro", $dados);
    }
        
    public function cadastrar(GestaoProspectoRequest $request){
        $req = $request->except(["_token","_method"]);
        GestaoProspecto::firstOrCreate($req);
        return redirect()->route('site.sucesso');
    }
    
    
    
    public function sucesso(){
        $dados["banner"]        = true;
        return view("Site.Sucesso", $dados);
    }
}
