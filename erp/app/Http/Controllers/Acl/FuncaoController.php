<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Models\Funcao;
use App\Models\FuncaoPermissao;
use App\Models\Permissao;
use Illuminate\Http\Request;
use App\Http\Requests\FuncaoRequest;
use App\Models\Menu;
use App\Models\FuncaoMenu;
use App\Models\SubMenu;

class FuncaoController extends Controller
{
    use PermissaoTrait;
    protected $funcao, $permissao;
    public function __construct(Funcao $funcao, Permissao $permissao)
    {
        $this->funcao = $funcao;
        $this->permissao = $permissao;
        $this->modelName = 'funcao';
        
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"] = Funcao::all();
        return view("Admin.Funcao.Index", $dados);
    }

    public function salvarJs(FuncaoRequest $request){
        $req = $request->except(["_token","_method"]);
        
        Funcao::Create($req);
        $lista = Funcao::get();
        echo json_encode($lista);
    }
    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Categoria.Create");
    }

    public function vincular(Request $request,$id_funcao){
        if (!$funcao = $this->funcao->find($id_funcao)) {
            return redirect()->back();        }
            
            $dados["filtro"]            = $request->except('_token');
            $dados["funcao"]            = Funcao::find($id_funcao);
            $dados["lista"]             = $funcao->permissoesNaoInseridas($request->filtro);
            
            return view('Admin.Funcao.Vincular', $dados);
    }
    
    public function permissao($id_funcao){
        $dados["funcao"]            = Funcao::find($id_funcao);
        
        $dados["perfis"]            = Funcao::all();
        $dados["permissoes"]        = Permissao::all();
        $dados["funcao_permissoes"] = FuncaoPermissao::where("funcao_id",$id_funcao)->get();
        
        return view('Admin.Funcao.Permissao', $dados);
    }
    
    public function menu($id_funcao, $id_menu=1){
        $dados["funcao"]            = Funcao::find($id_funcao);
        $dados["perfis"]            = Funcao::all();
        $dados["menus"]             = Menu::all();
        $dados["menu"]              = Menu::find($id_menu);
        $dados["submenus"]           = SubMenu::where("menu_id",$id_menu)->get();        
        $dados["funcao_menus"]      = FuncaoMenu::where("funcao_id",$id_funcao)->get();
        
        return view('Admin.Funcao.Menus', $dados);
    }
    
    public function store(FuncaoRequest $request)
    {
        $this->checaPermissao(__FUNCTION__);
        $req = $request->except(["_token","_method"]);
        Funcao::create($req);
        return redirect()->route("admin.funcao.index");
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
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"] = Funcao::all();
        $dados["funcao"] = Funcao::find($id);
        $dados["funcaos"] = Funcao::all();
        return view('Admin.Funcao.Index', $dados);
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
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        Funcao::where("id", $id)->update($req);
        return redirect()->route("admin.funcao.index");
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
            $h = Funcao::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
