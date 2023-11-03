<?php

namespace App\Http\Controllers\Admin\Ead;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\Categoria;
use App\Models\EadAulas;
use App\Models\EadCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EadAulaController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'aula';
    }
    
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"]     = EadAulas::get();
        return view("Admin.Ead.Aula.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["cursos"]     = EadCurso::get();
        return view("Admin.Ead.Aula.Create", $dados);
    }

    public function salvarJs(Request $request){
        
        $req = $request->except(["_token","_method"]);
        EadAulas::Create($req);
        $lista = EadAulas::get();
        echo json_encode($lista);
    }
    
    public function store(Request $request){    
        $this->checaPermissao(__FUNCTION__);
        $req                    = $request->except(["_token","_method", "pagina"]);
        $req["data_cadastro"]   = $req["data_cadastro"] ?? hoje() ;
        $req["slug"]            = Str::kebab($request->titulo);
        $retorno                = new \stdClass();
        try {
            EadAulas::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            if(isset($request->pagina)){
                return redirect()->route('ead.curso.aulas', $request->curso_id);
            }            
            return redirect()->route('ead.aula.index')->with('msg_sucesso', "Curso Inserido com sucesso.");
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
        
    }

    public function show($id)
    {
        //
    }
   
    public function edit($id){
        $this->checaPermissao(__FUNCTION__);
        $dados["subcategoria"]     = EadAulas::find($id);
        $dados["lista"] = EadAulas::get();
        $dados["categorias"]    = Categoria::get();
        return view('Admin.Cadastro.EadAulas.Index', $dados);
    }
   
    public function update(Request $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        EadAulas::where("id", $id)->update($req);
        return redirect()->route("ead.aula.index")->with('msg_sucesso', "item alterado com sucesso.");;
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
            $h = EadAulas::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
