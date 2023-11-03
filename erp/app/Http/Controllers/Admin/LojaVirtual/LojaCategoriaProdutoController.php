<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaCategoriaProduto;
use Illuminate\Http\Request;

class LojaCategoriaProdutoController extends Controller
{
    
    public function index()
    {        
        $dados["lista"] = LojaCategoriaProduto::get();
        return view("Admin.Loja.Categoria.Index", $dados);
    }

    
    public function create()
    {
        return view("Admin.Loja.Categoria.Create");
    }

    public function salvarJs(Request $request){
        
        $req = $request->except(["_token","_method"]);
        
        $req["empresa_id"] = session('empresa_selecionada_id');
        LojaCategoriaProduto::firstOrCreate($req);
        $lista = LojaCategoriaProduto::get();
        echo json_encode($lista);
    }
    
    public function store(Request $request){    
        
        $req = $request->except(["_token","_method"]);
        $req["empresa_id"] = session('empresa_selecionada_id');
        LojaCategoriaProduto::firstOrCreate($req);
        return redirect()->route('admin.loja.lojacategoriaproduto.index')->with('msg_sucesso', "Categoria Inserida com sucesso.");
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
        $dados["categoria"]     = LojaCategoriaProduto::find($id);
        $dados["lista"]    = LojaCategoriaProduto::get();
        return view('Admin.Loja.Categoria.Index', $dados);
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
        LojaCategoriaProduto::where("id", $id)->update($req);
        return redirect()->route("admin.loja.lojacategoriaproduto.index")->with('msg_sucesso', "Categoria alterada com sucesso.");
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
            $h = LojaCategoriaProduto::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
