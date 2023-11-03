<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaCategoriaProduto;
use App\Models\LojaImagemProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Str;

class LojaImagemProdutoController extends Controller
{
    
    public function index()
    {
        $dados["lista"] = LojaImagemProduto::get();
        return view("Admin.Loja.LojaImagemProduto.Index", $dados);
    }

    
    public function create()
    {
        $dados["clientes"] = Produto::get();
        $dados["categorias"] = LojaCategoriaProduto::get();
        return view("Admin.Loja.LojaImagemProduto.Create", $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){     
        $empresa            = auth()->user()->empresa;
        $file               = $request->file('file');
        $img                = new \stdClass();
        $img->produto_id    = $request->produto_id;
       
        if ($request->hasFile('file') && $request->file->isValid()) {
            
            $file               = $request->file('file');
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $pasta              = "upload/".$empresa->pasta ."/produtos/";
            $upload             = $file->move(public_path($pasta), $nomeImagem);
            $img->img           = $pasta . $nomeImagem;
        }      
        
        $result  = LojaImagemProduto::create(objToArray($img));        
        
        $lista  = LojaImagemProduto::where("produto_id", $img->produto_id)->get();
        echo json_encode($lista);
    }

   
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
        $dados["cliente"]     = LojaImagemProduto::find($id);
        $dados["clientes"]    = Produto::get();
        $dados["categorias"]  = LojaCategoriaProduto::get();
        return view('Admin.Loja.LojaImagemProduto.Create', $dados);
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
        LojaImagemProduto::where("id", $id)->update($req);
        return redirect()->route("admin.loja.lojacliente.index");
    }

    public function destroy( $id){
        try {
            $composicao = LojaImagemProduto::find($id);
            $composicao->delete();
            $retorno = new \stdClass();
            $retorno->tem_erro  = false;
            $retorno->retorno   = LojaImagemProduto::where("produto_id", $composicao->produto_id)->get();
            
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno = new \stdClass();
            $retorno->retorno = array();
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    
}
