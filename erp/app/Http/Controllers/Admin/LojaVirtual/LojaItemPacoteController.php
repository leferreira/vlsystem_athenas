<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaCategoriaProduto;
use App\Models\LojaItemPacote;
use App\Models\Produto;
use Illuminate\Http\Request;

class LojaItemPacoteController extends Controller
{
    
    public function index()
    {
        $dados["lista"] = LojaItemPacote::get();
        return view("Admin.Loja.LojaItemPacote.Index", $dados);
    }

    
    public function create()
    {
        $dados["clientes"] = Produto::get();
        $dados["categorias"] = LojaCategoriaProduto::get();
        return view("Admin.Loja.LojaItemPacote.Create", $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){      
        
        $req = $request->except(["_token","_method"]);
        LojaItemPacote::Create($req);
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
        $dados["cliente"]     = LojaItemPacote::find($id);
        $dados["clientes"]    = Produto::get();
        $dados["categorias"]  = LojaCategoriaProduto::get();
        return view('Admin.Loja.LojaItemPacote.Create', $dados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        LojaItemPacote::where("id", $id)->update($req);
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
            $h = LojaItemPacote::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
