<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\ImagensProdutoDelivery;
use App\Models\LojaBanner;
use App\Models\LojaPacote;
use App\Models\Produto;
use App\Models\ProdutoDelivery;
use Illuminate\Http\Request;
use Str;

class LojaBannerController extends Controller
{
    
    public function index(){
        $dados["produtos"]  = Produto::get();
        $dados["lista"]     = LojaBanner::get();
        return view("Admin.Loja.LojaBanner.Index", $dados);
    }

    
    public function create() {
        $dados["uploadJs"]  = true;
        $dados["produtos"]  = Produto::get();
        $dados["pacotes"]   = LojaPacote::get();
        return view("Admin.Loja.LojaBanner.Create", $dados);
    }

    public function store(BannerRequest $request){
        $empresa = auth()->user()->empresa;
      
        $file               = $request->file('file');  
        $request["status_id"] = config("constantes.status.ATIVO");
        
        if ($request->hasFile('file') && $request->file->isValid()) {
            $file               = $request->file('file');
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $pasta              = "storage/".$empresa->pasta ."/imagens/";
            $upload             = $file->move(public_path($pasta), $nomeImagem);
            $request["path"]    = $pasta . $nomeImagem;
            
        } 
        
        
        
        if($request->path){
            $result = LojaBanner::create($request->all()); 
        }else{
            return back()->with('msg_erro', "Escolha uma imagem para inserir");
            exit;
        }
        
        if($result){
            session()->flash("msg_sucesso", "Imagem cadastrada com sucesso!");
        }else{            
            session()->flash('msg_erro', 'Erro ao cadastrar produto!');
        }
        
        return redirect()->route('admin.lojabanner.index');
        
        
    }
    
    public function salvarImagem (Request $request){
        
        $file               = $request->file('file');
        $produto_id         = $request->id;
       
        $extensao = $file->getClientOriginalExtension();
        $nomeImagem = Str::random(25) . ".".$extensao;
        $request->merge([ 'path' => $nomeImagem ]);
        $request->merge([ 'produto_id' => $produto_id ]);        
        
        $upload = $file->move(public_path('storage/upload/imagens_produtos'), $nomeImagem);
        
        $result = ImagensProdutoDelivery::create($request->all());
        
        $produtoDelivery = ProdutoDelivery::find($produto_id);
        $produto = $produtoDelivery->produto;
        
        if($produto->imagem == ""){
            copy(public_path('storage/upload/imagens_produtos/').$nomeImagem, public_path('storage/upload/imgs_produtos/').$nomeImagem);
            $produto->imagem = $nomeImagem;
            $produto->save();
        }
        
        if($result){
            session()->flash("mensagem_sucesso", "Imagem cadastrada com sucesso!");
        }else{
            
            session()->flash('mensagem_erro', 'Erro ao cadastrar produto!');
        }
        return redirect()->route('deliveryproduto.galeria',$produto_id );
        
        
    }
    

    public function show($id){
        //
    }

    public function edit($id){
        $dados["banner"]    = LojaBanner::where("id", $id)->first();
        $dados["uploadJs"]  = true;
        $dados["produtos"]  = Produto::get();
        $dados["pacotes"]   = LojaPacote::get();
        return view('Admin.Loja.LojaBanner.Create', $dados);
    }

    public function update(Request $request, $id){      
        $req                    = $request->except(["_token","_method","file"]);
        $file                   = $request->file('file');
        $empresa                = auth()->user()->empresa;
        if ($request->hasFile('file') && $request->file->isValid()) {
            $file               = $request->file('file');
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $pasta              = "storage/".$empresa->pasta ."/imagens/";
            $upload             = $file->move(public_path($pasta), $nomeImagem);
            $req["path"]        = $pasta . $nomeImagem;
            
        }       
        
        
        if($req["path"]){
            $result = LojaBanner::where("id", $id)->update($req);
        }else{
            return back()->with('msg_erro', "Escolha uma imagem para inserir");
            exit;
        }
        
        
        return redirect()->route("admin.lojabanner.index");
    }

    public function destroy($id){
        try{
            $h = LojaBanner::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Banner excluído com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
