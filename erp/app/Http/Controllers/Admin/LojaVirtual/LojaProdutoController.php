<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Http\Requests\LojaProdutoRequest;
use App\Models\LojaCategoriaProduto;
use App\Models\LojaImagemProduto;
use App\Models\LojaProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LojaProdutoController extends Controller
{
    
    public function index()
    {
        $dados["lista"]     = LojaProduto::get();
        $dados["categorias"]= LojaCategoriaProduto::get();       
        return view("Admin.Loja.LojaProduto.Index", $dados);
    }

    public function filtro(Request $request){
        $filtro                     = new \stdClass();
        $filtro->categoria_id       = $request->categoria_id;
        $filtro->nome               = $request->nome;
        
        $dados["lista"]             = LojaProduto::filtro($filtro);
        $dados["filtro"]            = $filtro;
        $dados["categorias"]        = LojaCategoriaProduto::get();
        return view("Admin.Loja.LojaProduto.Index", $dados);
    }
    
    
    public function create()
    {
        $dados["produtos"]    = LojaProduto::listaSomenteTabelaProduto();      
        $dados["categorias"]  = LojaCategoriaProduto::get();
        return view("Admin.Loja.LojaProduto.Create", $dados);
    }

   
    public function salvarImagemJs (Request $request){ 
        $file               = $request->file('file');
        $produtoId          = $request->produto_id;
        
        $extensao           = $file->getClientOriginalExtension();
        $nomeImagem         = Str::random(25) . ".".$extensao;
        $request->merge([ 'img' => $nomeImagem ]);
        $request->merge([ 'produto_id' => $produtoId ]);
        $request->merge([ 'empresa_id' => $empresa->id ]);
        $pasta = "storage/upload/".$empresa->cpf_cnpj."/imagens_produtos";
        $upload = $file->move(public_path($pasta), $nomeImagem);
        
        
        $result  = LojaImagemProduto::create($request->all());
        
        //
        $id = $result->produto->produto_id;
        
        $produto = Produto::find($id);     
        if($produto->imagem == ""){
            $produto->imagem = $nomeImagem;
            $produto->save();
        }
        
        $lista  = LojaImagemProduto::where("produto_id", $produtoId)->get();
        echo json_encode($lista);
        
    }
    
    public function store(LojaProdutoRequest $request){    
        $req = $request->except(["_token","_method"]);
        $produto = LojaProduto::Create($req);
        return redirect("/lojaadmin/lojaproduto/$produto->id/edit#tab-2")->with('msg_sucesso', "Produto Inserido com sucesso,agora insira as imagens do produto.");
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $dados["produto"]     = LojaProduto::find($id);  
        $dados["uploadJs"]    = true;
        $dados["imagens"]     = LojaImagemProduto::where("produto_id", $id)->get();
        $dados["produtos"]    = LojaProduto::listaSomenteTabelaProduto($id);
    
        $dados["categorias"]  = LojaCategoriaProduto::get();
        return view('Admin.Loja.LojaProduto.Create', $dados);
    }

    
    public function update(Request $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        LojaProduto::where("id", $id)->update($req);
        return redirect()->route("admin.loja.lojaproduto.index");
    }

    public function pesquisa($q){
        $empresa_id     = session('empresa_selecionada_id');
        
        $retorno =  LojaProduto::where('loja_produtos.empresa_id', $empresa_id)
        ->where('nome', 'like', '%'.$q.'%')
        ->join('produtos', 'loja_produtos.produto_id', '=', 'produtos.id')
        ->select("loja_produtos.*", "produtos.nome", "produtos.valor_venda")
        ->get();
        echo json_encode($retorno);        
    }
    
    public function destroy($id)
    {
        try{
            $h = LojaProduto::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
