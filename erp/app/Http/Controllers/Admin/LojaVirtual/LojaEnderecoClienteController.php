<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaCliente;
use App\Models\LojaEnderecoCliente;
use Illuminate\Http\Request;

class LojaEnderecoClienteController extends Controller
{
    
    public function index()
    {
        $dados["lista"] = LojaEnderecoCliente::get();
        return view("Admin.Loja.LojaEnderecoCliente.Index", $dados);
    }
    
    public function create()
    {
        $dados["clientes"]     = LojaCliente::get(); 
        return view("Admin.Loja.LojaEnderecoCliente.Create", $dados);
    }
   
    public function store(Request $request){    
        $req = $request->except(["_token","_method"]);
        LojaEnderecoCliente::Create($req);
        return redirect()->route('admin.loja.lojaenderecocliente.index');
    }
    
    public function show($id)
    {
        //
    }
   
    public function edit($id)
    {
        $dados["clientes"]     = LojaCliente::get();        
        $dados["endereco"]     = LojaEnderecoCliente::find($id);
        return view('Admin.Loja.LojaEnderecoCliente.Create', $dados);
    }

    
    public function update(Request $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        LojaEnderecoCliente::where("id", $id)->update($req);
       
        return redirect()->route("admin.loja.lojaenderecocliente.index");
    }

    
    public function destroy($id)
    {
        try{
            $h = LojaEnderecoCliente::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
