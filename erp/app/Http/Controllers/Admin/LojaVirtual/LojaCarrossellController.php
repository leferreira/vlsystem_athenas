<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaCarrossel;
use App\Models\LojaCategoriaProduto;
use App\Models\LojaPacote;
use App\Models\LojaProduto;
use App\Models\Produto;
use Illuminate\Http\Request;

class LojaCarrossellController extends Controller
{
    
    public function index(){
        $dados["lista"] = LojaCarrossel::get();
        return view("Admin.Loja.LojaCarrossel.Index", $dados);
    }

    
    public function create() {
        return view("Admin.Loja.LojaCarrossel.Create", $dados);
    }

    public function store(Request $request){    
        $req = $request->except(["_token","_method"]);        
        LojaCarrossel::Create($req);
        return redirect()->route('admin.loja.lojacarrossel.index');
    }

    public function show($id){
        //
    }    

    public function edit($id){
        $dados["carrossel"]      = LojaCarrossel::where("id", $id)->first();
   
        return view('Admin.Loja.LojaCarrossel.Create', $dados);
    }

    public function update(Request $request, $id){
        $req     =   $request->except(["_token","_method"]);
        LojaCarrossel::where("id", $id)->update($req);
        return redirect()->route("admin.loja.lojacarrossel.index");
    }

    public function destroy($id){
        try{
            $h = LojaCarrossel::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
