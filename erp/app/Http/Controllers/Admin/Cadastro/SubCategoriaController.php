<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\SubCategoriaRequest;
use App\Models\Categoria;
use App\Models\SubCategoria;

class SubCategoriaController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'subcategoria';
    }
    
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"] = SubCategoria::get();
        $dados["categorias"] = Categoria::get();
        return view("Admin.Cadastro.SubCategoria.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.SubCategoria.Create");
    }

    public function salvarJs(SubCategoriaRequest $request){
        
        $req = $request->except(["_token","_method"]);
        SubCategoria::Create($req);
        $lista = SubCategoria::get();
        echo json_encode($lista);
    }
    
    public function store(SubCategoriaRequest $request){  
        
        try {
            $this->checaPermissao(__FUNCTION__);
            $req = $request->except(["_token","_method"]);     
            $tem = SubCategoria::where(["subcategoria"=>$request->subcategoria, "categoria_id"=>$request->categoria_id])->first();
         
            if($tem){
                throw(new \Exception(' Já existe um registro com este valor.'));                
            }
            SubCategoria::Create($req);
            return redirect()->route('admin.subcategoria.index')->with('msg_sucesso', "Inserido com sucesso.");
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
        $dados["subcategoria"]     = SubCategoria::find($id);
        $dados["lista"] = SubCategoria::get();
        $dados["categorias"]    = Categoria::get();
        return view('Admin.Cadastro.SubCategoria.Index', $dados);
    }
   
    public function update(SubCategoriaRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        SubCategoria::where("id", $id)->update($req);
        return redirect()->route("admin.subcategoria.index")->with('msg_sucesso', "item alterado com sucesso.");;
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
            $h = SubCategoria::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
