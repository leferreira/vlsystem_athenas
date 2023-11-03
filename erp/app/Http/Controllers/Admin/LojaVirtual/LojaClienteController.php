<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaCategoriaProduto;
use App\Models\LojaCliente;
use App\Models\LojaEnderecoCliente;
use Illuminate\Http\Request;

class LojaClienteController extends Controller
{
    
    public function index()
    {
        $dados["lista"] = LojaCliente::get();
        return view("Admin.Loja.LojaCliente.Index", $dados);
    }

    
    public function create()
    {
        return view("Admin.Loja.LojaCliente.Create");
    }

    
    public function store(Request $request){      
        
        $req = $request->except(["_token","_method"]);        
        LojaCliente::Create($req);
        return redirect()->route('admin.loja.lojacliente.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados["cliente"]     = LojaCliente::find($id);
        $dados["categorias"]  = LojaCategoriaProduto::get();
        return view('Admin.Loja.LojaCliente.Create', $dados);
    }

    public function endereco($id)
    {
        $dados["cliente"]       = LojaCliente::find($id);
        $dados["lista"]         = LojaEnderecoCliente::where("cliente_id", $id)-> get();
        return view('Admin.Loja.LojaCliente.Endereco', $dados);
    }
    
    public function update(Request $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        LojaCliente::where("id", $id)->update($req);
        return redirect()->route("admin.loja.lojacliente.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $h = LojaCliente::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
