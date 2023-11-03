<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Models\Funcao;
use App\Models\FuncaoPermissao;
use App\Models\Menu;
use App\Models\Permissao;
use Illuminate\Http\Request;

class FuncaoPermissaoController extends Controller
{
    protected $funcao, $permissao;
    
    public function __construct(Funcao $funcao, Permissao $permission)
    {
        $this->funcao       = $funcao;
        $this->permissao    = $permission;
        
        //$this->middleware(['can:profiles']);
    }
    public function index()
    {
        $dados["funcaos"] = Funcao::all();
        return view("Admin.Permissao.Index", $dados);
    }

    
    public function create()
    {
        return view("Admin.Categoria.Create");
    }

    public function salvar(Request $request)
    {
        
        try {
            $permissao = Permissao::where("permissao", $request->descricao)->first();            
            $p                  = new \stdClass();
            $p->permissao_id    = $permissao->id;
            $p->funcao_id       = $request->funcao_id;
            $p->menu_id         = $request->menu_id;
            $p->submenu_id      = $request->submenu_id;
            
            $menu               = Menu::find($p->menu_id);
            $permissao_menu     = Permissao::where("permissao",$menu->cod)->first();
            
            if($request->opcao=="true"){
                $funcaopermissao = FuncaoPermissao::Create(objToArray($p));
                if($funcaopermissao){                    
                    $tem            = FuncaoPermissao::where(["permissao_id" => $permissao_menu->id, "funcao_id"=>$p->funcao_id])->first();
                    if(!$tem){
                        $p2                  = new \stdClass();
                        $p2->permissao_id    = $permissao_menu->id;
                        $p2->funcao_id       = $request->funcao_id;
                        $p2->menu_id         = $request->menu_id;
                        FuncaoPermissao::Create(objToArray($p2));
                    }
                }                
                
            }else{
                FuncaoPermissao::where(["permissao_id"=>$permissao->id ,"funcao_id" =>$request->funcao_id])->delete();
                $tem            = FuncaoPermissao::where("submenu_id","!=", null)->where(["menu_id" => $p->menu_id, "funcao_id"=>$p->funcao_id])->first();
                if(!$tem){
                    FuncaoPermissao::where(["menu_id" => $p->menu_id, "funcao_id"=>$p->funcao_id])->delete();
                }
            }
            echo json_encode("ok");
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
            
        }
    }
    
    public function store(Request $request)
    {
        $req                = $request->except(["_token","_method"]);
        FuncaoPermissao::firstOrCreate($req);
        return redirect()->route('funcao.permissao',$req["funcao_id"]);
    }

    public function vincularPermissao(Request $request, $idFuncao){
        if (!$funcao = $this->funcao->find($idFuncao)) {
            return redirect()->back();
        }
        
        if (!$request->permissoes || count($request->permissoes) == 0) {
            return redirect()
            ->back()
            ->with('msg_erro', 'Precisa escolher pelo menos uma permissão');
        }
        
        $funcao->permissoes()->attach($request->permissoes);
        
        return redirect()->route('admin.funcao.permissao', $funcao->id);
    }
    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $dados["funcao"] = Funcao::find($id);
        $dados["funcaos"] = Funcao::all();
        return view('Funcao.Create', $dados);
    }
    
    public function update(Request $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        Permissao::where("id", $id)->update($req);
        return redirect()->route("permissao.index");
    }

    public function destroy($id)
    {
        try{
            $h = FuncaoPermissao::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
