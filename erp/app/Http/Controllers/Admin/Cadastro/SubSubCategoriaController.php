<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\SubSubCategoriaRequest;
use App\Models\Categoria;
use App\Models\SubCategoria;
use App\Models\SubSubCategoria;

class SubSubCategoriaController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'subsubcategoria';
    }    
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"]         = SubSubCategoria::get();  
        $dados["categorias"]    = Categoria::get();
        $dados["subcategorias"] = array();
        if(count($dados["categorias"])>0){
            $dados["subcategorias"] = $dados["categorias"][0]->subcategorias ;
        }
          
        $dados["categoriaJs"]           = true;
        return view("Admin.Cadastro.SubSubCategoria.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["categoriaJs"]           = true;
        return view("Admin.Cadastro.SubSubCategoria.Create");
    }

    public function salvarJs(SubSubCategoriaRequest $request){
        
        $req = $request->except(["_token","_method"]);
        SubSubCategoria::Create($req);
        $lista = SubSubCategoria::get();
        echo json_encode($lista);
    }
    
    public function store(SubSubCategoriaRequest $request){
        try {
            $this->checaPermissao(__FUNCTION__);
            $req = $request->except(["_token","_method"]);
            $tem = SubSubCategoria::where(["subsubcategoria"=>$request->subsubcategoria, "subcategoria_id"=>$request->subcategoria_id ])->first();            
            if($tem){
                throw(new \Exception(' Já existe um registro com este valor.'));
            }
            SubSubCategoria::Create($req);
            return redirect()->route('admin.subsubcategoria.index')->with('msg_sucesso', "Inserido com sucesso.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro',"erro: " . $e->getMessage());
        }
        
    }

    public function show($id)
    {
        //
    }
   
    public function edit($id){
        $this->checaPermissao(__FUNCTION__);
        $dados["subsubcategoria"]  = SubSubCategoria::find($id);        
        $dados["lista"]         = SubSubCategoria::get();
        $dados["categorias"]    = Categoria::get();
        $dados["subcategorias"] = array();
        if($dados["categorias"]){
            $categoria = Categoria::find($dados["subsubcategoria"]->categoria_id);
            $dados["subcategorias"] = $categoria->subcategorias ;
        }
        
        $dados["categoriaJs"]   = true;
        return view('Admin.Cadastro.SubSubCategoria.Index', $dados);
    }
   
    public function update(SubSubCategoriaRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        SubSubCategoria::where("id", $id)->update($req);
        return redirect()->route("admin.subsubcategoria.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = SubSubCategoria::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
