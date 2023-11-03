<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Models\Funcao;
use App\Models\FuncaoPermissao;
use App\Models\Permissao;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FuncaoUser;
use App\Http\Requests\UsuarioRequest;
use Str;
use App\Models\Assinatura;
use App\Http\Requests\UsuarioUpdateRequest;

class UsuarioController extends Controller
{
    use PermissaoTrait;
    public function __construct(Funcao $funcao, Permissao $permissao)
    {
        $this->funcao = $funcao;
        $this->permissao = $permissao;
        $this->modelName = 'funcao';
        
    }
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["usuarios"] = User::where('empresa_id', Auth::user()->empresa_id)->get();
        return view("Admin.Usuario.Index", $dados);
    }
    
    public function create()
    {        
        $this->checaPermissao(__FUNCTION__);
        $dados["status"]  = Status::all();
        $dados["funcoes"] = Funcao::get();
        $dados["tipo"]      = 'insercao';
        return view("Admin.Usuario.Create", $dados);
    }

    public function funcoes( $id){
        $dados["usuarioLogado"] = auth()->user();
        $dados["funcoesusuario"] = FuncaoUser::where("user_id", $id)->get();
        $dados["usuario"]        = User::find($id);
        $dados["funcoes"]        = Funcao::get();
        
        return view("Admin.Usuario.Funcoes", $dados);
    }
    
    public function permissao($id_funcao){
        $dados["perfis"]            = Funcao::all();
        $dados["permissoes"]        = Permissao::all();
        $dados["funcao_permissoes"] = FuncaoPermissao::where("funcao_id",$id_funcao)->get();
        
        return view('admin.Funcao.Permissao', $dados);
    }
    
    public function store(UsuarioRequest $request){
        $this->checaPermissao(__FUNCTION__);        
        
        try{
            $usuarios = User::where("empresa_id", Auth::user()->empresa_id)->get();
            $assinatura = Assinatura::where("empresa_id", Auth::user()->empresa_id)->where("status_id", config("constantes.status.ATIVO"))->first();
            if( count($usuarios)  >= $assinatura->planopreco->plano->limite_usuario){
                return redirect()->route("admin.usuario.index")->with('msg_erro', "Você alcançou o limite de usuários contratado no seu plano.");
            }
                        
            $req              = $request->except(["_token","_method","funcoes"]);            
            $req['password']  = bcrypt($req['password']);
            $req['status_id'] = Config('constantes.status.ATIVO');
            $req['empresa_id']= Auth::user()->empresa_id;
            $req['uuid']      = Str::uuid();
            User::Create($req);          
            
            return redirect()->route("admin.usuario.index")->with('msg_sucesso', "Cadastro realizado com sucesso.");
        }catch (\Exception $e){
            return redirect()->back()->with('msg_erro', "Houve um problema na tentativa de cadastro [{$e->getMessage()}]");
        }
        
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
    public function edit($id){
        $this->checaPermissao(__FUNCTION__);
        $dados["status"]    = Status::all();
        $dados["usuario"]   = User::find($id);
        $dados["perfis"]    = Funcao::where('empresa_id', Auth::user()->empresa_id)->get();
        $dados["funcoes"]   = array();
        $dados["tipo"]      = 'edicao';
        return view("Admin.Usuario.Edit", $dados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioUpdateRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        try {
            $req             = $request->except(["_token","_method","senha","file"]);
            $empresa = auth()->user()->empresa;
            if ($request->hasFile('file') && $request->file->isValid()) {
                $file               = $request->file('file');
                $extensao           = $file->getClientOriginalExtension();
                $nomeImagem         = Str::random(25) . ".".$extensao;
                $pasta              = "upload/".$empresa->pasta ."/imagens/";
                $upload             = $file->move(public_path($pasta), $nomeImagem);
                $req["foto"]        = $pasta . $nomeImagem;
            }
            
            User::where("id", $id)->update($req);
            return redirect()->route("admin.usuario.index");
        } catch (\Exception $e){
            return redirect()->back()->with('msg_erro', "erro: [{$e->getMessage()}]");
        }
        
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
            $h = User::find($id);
            $h->status_id = config("constantes.status.DELETADO");
            $h->save();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
