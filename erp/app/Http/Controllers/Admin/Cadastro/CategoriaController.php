<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\CategoriaRequest;
use App\Http\Requests\SubCategoriaRequest;
use App\Http\Requests\SubSubCategoriaRequest;
use App\Models\Categoria;
use App\Models\CentroCusto;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\SubCategoria;
use App\Models\SubSubCategoria;
use App\Models\Transportadora;
use Str;

class CategoriaController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'categoria';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["categorias"] = Categoria::get();
        return view("Admin.Cadastro.Categoria.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.Categoria.Create");
    }

    public function salvarJs(CategoriaRequest $request){
        $req = $request->except(["_token","_method"]);
        Categoria::Create($req);
        $lista = Categoria::get();
        echo json_encode($lista);
    }
    
    public function listarCategoria(){
        $lista = Categoria::get();
        echo json_encode($lista);
    }
    
    public function listarSubcategoriaPelaCategoria($categoria_id){
        $lista = SubCategoria::where("categoria_id", $categoria_id)->get();
        echo json_encode($lista);
    }
    
    public function listarSubSubcategoriaPelaSubCategoria($subcategoria_id){
        $lista = SubSubCategoria::where("subcategoria_id", $subcategoria_id)->get();
        echo json_encode($lista);
    }
    
    public function salvarSubCategoriaJs(SubCategoriaRequest $request){
        $req = $request->except(["_token","_method"]);
        SubCategoria::Create($req);
        $lista = SubCategoria::where("categoria_id", $req["categoria_id"])->get();
        echo json_encode($lista);
    }
    
    public function salvarSubSubCategoriaJs(SubSubCategoriaRequest $request){
        $req                    = $request->except(["_token","_method"]);
        $subcategoria           = SubCategoria::find($req["subcategoria_id"]);
        $req["categoria_id"]    = $subcategoria->categoria_id;
        SubSubCategoria::Create($req);
        $lista                  = SubSubCategoria::where("subcategoria_id", $req["subcategoria_id"])->get();
        echo json_encode($lista);
    }
    public function store(CategoriaRequest $request){
        $this->checaPermissao(__FUNCTION__);
        $req = $request->except(["_token","_method","file"]);
        $empresa            = auth()->user()->empresa;
        
        if ($request->hasFile('file') && $request->file->isValid()) {
            $file               = $request->file('file');
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $pasta              = "upload/".$empresa->pasta ."/categorias/";
            //$pasta              = "storage/".$empresa->pasta ."/produtos/";
            $file->move(public_path($pasta), $nomeImagem);
            $req['imagem']       = $pasta . $nomeImagem;
        }
        
        
        Categoria::Create($req);
        return redirect()->route('admin.categoria.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function show($id)
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["fornecedores"]      = Fornecedor::get();
        $dados["transportadoras"]   = Transportadora::get();
        $dados["produtos"]          = Produto::get();
        $dados["centro_custos"]     = CentroCusto::get();
        $dados["excluirJS"]           = true;
        return view("Admin.Excluir.Create", $dados);
    }
   
    public function edit($id){
        $dados["categoria"]     = Categoria::find($id);
        $dados["categorias"]    = Categoria::get();
        return view('Admin.Cadastro.Categoria.Index', $dados);
    }
   
    public function update(CategoriaRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req                    =   $request->except(["_token","_method","file"]);
        $empresa                = auth()->user()->empresa;   
        
        if ($request->hasFile('file') && $request->file->isValid()) {
            $file               = $request->file('file');
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $pasta              = "upload/".$empresa->pasta ."/categorias/";
            //$pasta              = "storage/".$empresa->pasta ."/produtos/";
            $file->move(public_path($pasta), $nomeImagem);
            $req['imagem']       = $pasta . $nomeImagem;
        }
        
        Categoria::where("id", $id)->update($req);
        return redirect()->route("admin.categoria.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    public function pesquisa(){
        $q          = $_GET["q"];
        $lista      = Categoria::where("categoria","like","%$q%")->get();
        return response()->json($lista);
    }
    
    public function selecionarCategoria($id){
        $categoria                  = Categoria::find($id); 
        $categorias                 = Categoria::get();
        $subcategorias              = SubCategoria::where("categoria_id", $id)->get();
        $subsubcategorias           = SubSubCategoria::where("categoria_id", $id)->get();
        
        $retorno                    = new \stdClass();
        $retorno->categoria         = $categoria;
        $retorno->categorias        = $categorias;
        $retorno->subcategorias     = $subcategorias;
        $retorno->subsubcategorias  = $subsubcategorias;
        return response()->json($retorno);
    }
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Categoria::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
