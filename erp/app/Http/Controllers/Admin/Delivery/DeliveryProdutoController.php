<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\CategoriaAdicional;
use App\Models\CategoriaProdutoDelivery;
use App\Models\ConfigNota;
use App\Models\ImagensProdutoDelivery;
use App\Models\ListaComplementoDelivery;
use App\Models\LojaImagemProduto;
use App\Models\Produto;
use App\Models\ProdutoDelivery;
use App\Models\ProdutoPizza;
use App\Models\TamanhoPizza;
use App\Models\Tributacao;
use Illuminate\Http\Request;
use Str;


class DeliveryProdutoController extends Controller
{
        
    public function index()
    {
        $dados["produtos"]  = Produto::where("produto_delivery", "S")->get();
        $dados["produtoJs"] = true;
        $dados["links"]     = true;        
        return view("Admin.Delivery.Produto.Index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados["produtos"]      = Produto::all();
        $dados["categorias"]    = CategoriaProdutoDelivery::all();
        $dados["tamanhos"]      = TamanhoPizza::all();
        $dados["produtoJs"]     = true;
        return view("Admin.Delivery.Produto.Create", $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        
        $produto    = $request->input('produto');
        $categoria  = CategoriaProdutoDelivery::find($request->categoria_id);
        $tributacao = Tributacao::first();
        
        $this->_validate($request);
        if($request->produto){
            
            //novo produto
            $config     = ConfigNota::first();
            $natureza   = Produto::firstNatureza();
            
            $arr = [
                'nome'          => $produto,
                'categoria_id'  => $categoria->id,
                'cor' => '',
                'valor_venda' => str_replace(",", ".", $request->valor),
                'NCM' => $tributacao->ncm_padrao,
                'CST_CSOSN' => $config->CST_CSOSN_padrao,
                'CST_PIS' => $config->CST_PIS_padrao,
                'CST_COFINS' => $config->CST_COFINS_padrao,
                'CST_IPI' => $config->CST_IPI_padrao,
                'unidade_compra' => 'UN',
                'unidade_venda' => 'UN',
                'composto' => 0,
                'codBarras' => 'SEM GTIN',
                'conversao_unitaria' => 1,
                'valor_livre' => 0,
                'perc_icms' => $tributacao->icms,
                'perc_pis' => $tributacao->pis,
                'perc_cofins' => $tributacao->cofins,
                'perc_ipi' => $tributacao->ipi,
                'CFOP_saida_estadual' => $natureza->CFOP_saida_estadual,
                'CFOP_saida_inter_estadual' => $natureza->CFOP_saida_inter_estadual,
                'codigo_anp' => '',
                'descricao_anp' => '',
                'perc_iss' => 0,
                'cListServ' => '',
                'imagem' => '',
                'alerta_vencimento' => 0,
                'valor_compra' => 0,
                'gerenciar_estoque' => 0,
                'estoque_minimo' => 0,
                'referencia' => '',
                'tela_id' => NULL,
                'largura' => 0,
                'comprimento' => 0,
                'altura' => 0,
                'peso_liquido' => 0,
                'peso_bruto' => 0
            ];
            $produto = Produto::create($arr);
            
        }
        
        $catPizza = false;
        
        
        $request->merge([ 'status' => $request->input('status') ? true : false ]);
        $request->merge([ 'auto_atendimento' => $request->input('auto_atendimento') ? true : false ]);
        $request->merge([ 'destaque' => $request->input('destaque') ? true : false ]);
        $request->merge([ 'ingredientes' => $request->input('ingredientes') ?? '']);
        $request->merge([ 'descricao' => $request->input('descricao') ?? '']);
        $request->merge([ 'produto_id' => $request->produto_id != 'null' ? $request->produto_id : $produto->id]);
        
        
        if(strpos(strtolower($categoria->nome), 'izza') !== false){
            $request->merge([ 'valor' => 0]);
            $request->merge([ 'valor_anterior' => 0]);
            
        }else{
            
            $request->merge([ 'valor' => str_replace(",", ".", $request->valor)]);
            $request->merge([ 'valor_anterior' => str_replace(",", ".", $request->valor_anterior ?? 0)]);
        }
        
        
        $result = ProdutoDelivery::create($request->all());
        
        if(strpos(strtolower($categoria->nome), 'izza') !== false){
            echo 'llll';
            $tamanhosPizza = TamanhoPizza::all();
            
            foreach($tamanhosPizza as $t){
                $res = ProdutoPizza::create([
                    'produto_id' => $result->id,
                    'tamanho_id' => $t->id,
                    'valor' => str_replace(",", ".", $request->input('valor_'.$t->nome))
                ]);
            }
            
        }
        
        if($result){
            
            session()->flash("mensagem_sucesso", "Produto cadastrado com sucesso!");
        }else{
            
            session()->flash('mensagem_erro', 'Erro ao cadastrar produto!');
        }
        
        return redirect()->route('deliveryproduto.index');
    }

    private function _validate(Request $request, $fileExist = true){
        $catPizza = false;
        $categoria = CategoriaProdutoDelivery::
        where('id', $request->categoria_id) ->first();
        
        if($categoria && strpos(strtolower($categoria->nome), 'izza') !== false){
            $catPizza = true;
        }
        
        $rules = [
            'produto_id' => $request->id > 0 ? '' : 'required',
            'ingredientes' => 'max:255',
            'descricao' => 'max:255',
            'valor' => !$catPizza ? 'required' : '',
            'limite_diario' => 'required',
            'categoria_id' => 'required'
        ];
        
        $messages = [
            'produto_id.required' => 'O campo produto é obrigatório.',
            'categoria_id.required' => 'Selecione uma categoria.',
            'produto.min' => 'Selecione um produto.',
            'ingredientes.required' => 'O campo ingredientes é obrigatório.',
            'ingredientes.max' => '255 caracteres maximos permitidos.',
            'descricao.required' => 'O campo descricao é obrigatório.',
            'descricao.max' => '255 caracteres maximos permitidos.',
            'valor.required' => 'O campo valor é obrigatório.',
            'limite_diario.required' => 'O campo limite diário é obrigatório',
        ];
        
        if($catPizza){
            $tamanhosPizza = TamanhoPizza::all();
            
            foreach($tamanhosPizza as $t){
                $rules['valor_'.$t->nome] = 'required';
                $messages['valor_'.$t->nome.'.required'] = 'Campo obrigatório ' . $t->nome;
            }
        }
        
        $this->validate($request, $rules, $messages);
    }
    
    public function alterarDestaque($id){
        $produto    = new ProdutoDelivery(); //Model
        $categorias = CategoriaProdutoDelivery::all();
        $resp       = $produto ->where('id', $id)->first();
        
        $resp->destaque = !$resp->destaque;
        $resp->save();
        
        echo json_encode($resp);
        
    }
    
    public function alterarStatus($id){
        $produto = new ProdutoDelivery(); //Model
        $categorias = CategoriaProdutoDelivery::all();
        $resp = $produto->where('id', $id)->first();
        
        $resp->status = !$resp->status;
        $resp->save();
        echo json_encode($resp);
        
    }
    
    
    public function galeria($id){
        $dados["produto"] = Produto::where('id', $id)->first();
        $dados["imagens"] = LojaImagemProduto::where("produto_id", $id)->get();
        return view("Admin.Delivery.Produto.Galeria", $dados);       
    }
    
    public function salvarImagem (Request $request){
        
        $file = $request->file('file');
        $produtoDeliveryId = $request->id;
        
        $extensao = $file->getClientOriginalExtension();
        // $nomeImagem = md5($file->getClientOriginalName()).".".$extensao;
        $nomeImagem = Str::random(25) . ".".$extensao;
        $request->merge([ 'path' => $nomeImagem ]);
        $request->merge([ 'produto_id' => $produtoDeliveryId ]);
        
        
        $upload = $file->move(public_path('storage/upload/imagens_produtos'), $nomeImagem);
        
        $result = ImagensProdutoDelivery::create($request->all());
        
        $produtoDelivery = ProdutoDelivery::find($produtoDeliveryId);
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
        return redirect()->route('deliveryproduto.galeria',$produtoDeliveryId );
        
        
        // return redirect('/deliveryCategoria');
    }
    
    public function excluirImagem($id){
        $imagem = ImagensProdutoDelivery::where('id', $id) ->first();

        $public = getenv('SERVIDOR_WEB') ? 'public/' : '';
       
        if(file_exists('storage/upload/imagens_produtos/'.$imagem->path))
            unlink('storage/upload/imagens_produtos/'.$imagem->path);

        
        if($imagem->delete()){
            session()->flash('color', 'blue');
            session()->flash('message', 'Imagem removida!');
        }else{
            session()->flash('color', 'red');
            session()->flash('message', 'Erro!');
        }
        
        return redirect()->route('deliveryproduto.galeria',$imagem->produto_id );
    }

    public function adicionais($produtoId){
        $categorias = CategoriaAdicional::all();        
       
        
        $dados["js_delivery"]   = true;
        $dados["produto"]       = Produto::find($produtoId);
        $dados["categorias"]    = $categorias; 
        $dados["adicionados"]   = ListaComplementoDelivery::where("produto_id", $produtoId)->get(); 
        return view("Admin.Delivery.Produto.Adicionais", $dados); 
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
        $dados["categoria"] = CategoriaProdutoDelivery::find($id);
        return view('admin.Delivery.Categoria.Create', $dados);
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
        CategoriaProdutoDelivery::where("id", $id)->update($req);
        return redirect()->route("deliverycategoria.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $h = CategoriaProdutoDelivery::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
