<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\ProdutoRequest;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Fornecedor;
use App\Models\GradeProduto;
use App\Models\Localizacao;
use App\Models\LojaCategoriaProduto;
use App\Models\LojaImagemProduto;
use App\Models\NaturezaOperacao;
use App\Models\NfeEntradaItem;
use App\Models\NfeItem;
use App\Models\Produto;
use App\Models\ProdutoComposicao;
use App\Models\ProdutoFornecedor;
use App\Models\ProdutoSemelhante;
use App\Models\SubCategoria;
use App\Models\TabelaPreco;
use App\Models\TabelaPrecoProduto;
use App\Models\Tributacao;
use App\Models\TributacaoProduto;
use App\Models\Unidade;
use App\Models\User;
use App\Models\VariacaoGrade;
use App\Models\Venda;
use App\Service\ConstanteService;
use App\Service\GradeService;
use App\Service\MovimentoService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Str;

class ProdutoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'produto';
    }
    
    public function index(Request $request)
    {
        $this->checaPermissao(__FUNCTION__);        
        $filtro                     = new \stdClass();
        $filtro->categoria_id       = $request->categoria_id ?? null;
        $filtro->nome               = $request->nome ?? null;
        $filtro->tipo               = config("constantes.tipo_produto.PRODUTO");
        
        $dados["produtos"]          = Produto::filtro($filtro, 20);
        $dados["filtro"]            = $filtro;
        $dados["categorias"]        = Categoria::get();
        return view("Admin.Cadastro.Produto.Index", $dados);
    }
    
    
    public function filtro(Request $request){        
        $filtro                     = new \stdClass();
        $filtro->categoria_id       = $request->categoria_id;
        $filtro->nome               = $request->nome;
        
        $dados["produtos"]          = Produto::filtro($filtro);
        $dados["filtro"]            = $filtro;
        $dados["categorias"]        = Categoria::get();
        return view("Admin.Cadastro.Produto.Index", $dados);
    }
    
    public function create()    {
        $this->checaPermissao(__FUNCTION__);
        $empresa                        = auth()->user()->empresa;
        $dados["categorias"]            = Categoria::orderBy('categoria', 'asc')->get(); 
        $dados["subcategorias"]         = array();
        $dados["subsubcategorias"]      = array();
        $dados["unidades"]              = ConstanteService::unidadesMedida(); 
        $dados["cfops"]                 = ConstanteService::unidadesMedida(); 
        $dados["tributacoes"]           = Tributacao::get();
        $dados["localizacoes"]          = Localizacao::get();
        
        
        $dados["categorias_loja"]       = LojaCategoriaProduto::orderBy('nome', 'asc')->get();
        $dados["parametro"]             = $empresa->parametro;        
        $dados["produtoJs"]             = true;
        $dados["categoriaJs"]           = true;
        return view("Admin.Cadastro.Produto.Create", $dados);
    }
    
    public function novoPeloXml($item_id)    {
        $this->checaPermissao(__FUNCTION__);
        $empresa                        = auth()->user()->empresa;
        
        $produto                        = NfeEntradaItem::find($item_id);        
        $dados["produto"]               = $produto;
        $dados["categorias"]            = Categoria::orderBy('categoria', 'asc')->get();
        $dados["subcategorias"]         = array();
        $dados["subsubcategorias"]      = array();
        $dados["unidades"]              = ConstanteService::unidadesMedida();
        $dados["cfops"]                 = ConstanteService::unidadesMedida();
        $dados["tributacoes"]           = Tributacao::get();
        $dados["localizacoes"]          = Localizacao::get();
        
        
        $dados["categorias_loja"]       = LojaCategoriaProduto::orderBy('nome', 'asc')->get();
        $dados["parametro"]             = $empresa->parametro;
        $dados["produtoJs"]             = true;
        $dados["categoriaJs"]           = true;
        return view("Admin.Cadastro.Produto.Create", $dados);
    }
  
    public function selecionarRelatorioSintetico(){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusVenda();
        $dados["usuarios"]              = User::get();
        $dados["clientes"]              = Cliente::get();
        $dados["lista"]                 = Venda::filtro($filtro);
        $dados["filtro"]                = $filtro;
        
        return view("Admin.Cadastro.Produto.SelecionarRelatorioSintetico", $dados);
    }
    
    public function relatorioSintetico(Request $request){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->usuario_id             = $_GET["usuario_id"] ?? null;
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? null;
        
        $dados["lista"]                 = Produto::relatorio($filtro);
        
        $dados["filtro"]                = $filtro;
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dados["dompdf"]     = $dompdf;
        
        
        return view("Admin.Pdf.Produto.Lista_Produto", $dados);
    }
    
    public function salvarJs(ProdutoRequest $request){
        $this->checaPermissao(__FUNCTION__);
        $retorno = new \stdClass();
        try {                        
            $req                         = $request->except(["_token","_method"]);
            
            $req['gtin']                 = ($req['gtin']) ? $req['gtin'] : "SEM GTIN";
            $req['status_id']	         = config("constantes.status.ATIVO");
            $req['valor_venda']	         = getFloat($req['valor_venda']);
            $req['valor_custo']	         = getFloat($req['valor_custo']);
            $req['ncm']			         = tira_mascara($req['ncm']);
            $req['pRedBC']               = $req['pRedBC'] ? getFloat($req['pRedBC']) : null;
            $req['pRedBCST']             = $req['pRedBCST'] ? getFloat($req['pRedBCST']) : null;            
            $req['pDif']                 = $req['pDif'] ? getFloat($req['pDif']) : null; 
            $req['pMVAST']               = $req['pMVAST'] ? getFloat($req['pMVAST']) : null; 
            $req['pICMS']                = $req['pICMS'] ? getFloat($req['pICMS']) : null; 
            $req['pPIS']                 = $req['pPIS'] ? getFloat($req['pPIS']) : null;
            $req['pCOFINS']              = $req['pCOFINS'] ? getFloat($req['pCOFINS']) : null;
            $req['pIPI']                 = $req['pIPI'] ? getFloat($req['pIPI']) : null;
            
            $req['fragmentacao_qtde']    = $req['fragmentacao_qtde'] ? getFloat($req['fragmentacao_qtde']) : null;
            $req['fragmentacao_unidade'] = $req['fragmentacao_unidade'] ? $req['fragmentacao_unidade'] : null;
            $req['fragmentacao_valor']   = $req['fragmentacao_valor'] ? getFloat($req['fragmentacao_valor']) : null;
            
            $req['estoque_minimo']       = $req['estoque_minimo'] ? getFloat($req['estoque_minimo']) : 0;
            $req['estoque_maximo']       = $req['estoque_maximo'] ? getFloat($req['estoque_maximo']) : 0;
            $req['estoque_inicial']      = $req['estoque_inicial'] ? getFloat($req['estoque_inicial']) : 0;
            
            $req["tipo_produto_id"]      = config("constantes.tipo_produto.PRODUTO");
            
            $produto = Produto::Create(objToArray($req));
            
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = 1;
            $mov->produto_id        = $produto->id;
            $mov->ent_sai           = 'E';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $produto->estoque_inicial;
            $mov->valor_movimento   = $produto->valor_venda;
            $mov->subtotal_movimento= $produto->estoque_inicial * $produto->valor_venda;
            $mov->descricao         = "Entrada de Estoque Inicial";
            MovimentoService::inserir($mov);
           
            
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            return response()->json($retorno);           
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);            
        }
        
    }
    public function store(ProdutoRequest $request){   
        $this->checaPermissao(__FUNCTION__);
        try {
          
        $empresa            = auth()->user()->empresa;        
      
        $req                = $request->except(["_token","_method","file"]);
        $req['estoque_inicial']         = $req['estoque_inicial'] ?? 0;
        $req['estoque_minimo']          = $req['estoque_minimo'] ?? 0;
        $req['estoque_maximo']          = $req['estoque_maximo'] ?? 0;
        $req['valor_venda']	            = $req['valor_venda'] ?? 0;
        $req['valor_custo']	            = $req['valor_custo'] ?? 0;
        $req['margem_lucro']            = $req['margem_lucro'] ?? 0;
        $req['valor_maior']             = $req['valor_maior'] ?? 0;
        $req['valor_venda_atacado']     = $req['valor_venda_atacado'] ?? 0;
        $req['valor_atacado_apartir']   = $req['valor_atacado_apartir'] ?? 0;
        $req['comissao']                = $req['estoque_minimo'] ?? 0;
        
        
        
        $req['gtin']                = ($req['gtin']) ? $req['gtin'] : "SEM GTIN";
        $req['status_id']	        = config("constantes.status.ATIVO");
        $req['valor_venda']	        = $req['valor_venda'] ? getFloat($req['valor_venda']) : 0; 
        $req['valor_custo']	        = $req['valor_custo'] ? getFloat($req['valor_custo']) : 0;
        $req['margem_lucro']        = $req['margem_lucro'] ? getFloat($req['margem_lucro']) : 0;
        $req['valor_maior']         = $req['valor_maior'] ? getFloat($req['valor_maior']) : 0;
        $req['valor_venda_atacado']  = $req['valor_venda_atacado'] ? getFloat($req['valor_venda_atacado']) : 0;
        $req['valor_atacado_apartir']       = $req['valor_atacado_apartir'] ? getFloat($req['valor_atacado_apartir']) : 0;
        $req['comissao']       = $req['estoque_minimo'] ? getFloat($req['comissao']) : 0;
        
        $req['ncm']			= tira_mascara($req['ncm']);
        
        $req['fragmentacao_qtde']    = $req['fragmentacao_qtde'] ? getFloat($req['fragmentacao_qtde']) : null;
        $req['fragmentacao_unidade'] = $req['fragmentacao_unidade'] ? $req['fragmentacao_unidade'] : null;
        $req['fragmentacao_valor']   = $req['fragmentacao_valor'] ? getFloat($req['fragmentacao_valor']) : null;        
   
        $req['estoque_minimo']       = $req['estoque_minimo'] ? getFloat($req['estoque_minimo']) : 0;
        $req['estoque_maximo']       = $req['estoque_maximo'] ? getFloat($req['estoque_maximo']) : 0;
        $req['estoque_inicial']      = $req['estoque_inicial'] ? getFloat($req['estoque_inicial']) : 0;  
        
        
        
        
        $req['pRedBC']               = $req['pRedBC'] ? getFloat($req['pRedBC']) : null;
        $req['pRedBCST']             = $req['pRedBCST'] ? getFloat($req['pRedBCST']) : null;
        $req['pDif']                 = $req['pDif'] ? getFloat($req['pDif']) : null;
        $req['pMVAST']               = $req['pMVAST'] ? getFloat($req['pMVAST']) : null;
        $req['pICMS']                = $req['pICMS'] ? getFloat($req['pICMS']) : null;
        $req['pPIS']                 = $req['pPIS'] ? getFloat($req['pPIS']) : null;
        $req['pCOFINS']              = $req['pCOFINS'] ? getFloat($req['pCOFINS']) : null;
        $req['pIPI']                 = $req['pIPI'] ? getFloat($req['pIPI']) : null;
        
     
      
        $req['largura']			= ($req['largura']) ? getFloat($req['largura']) : 0;
        $req['comprimento']		= ($req['largura']) ? getFloat($req['comprimento']) : 0;
        $req['altura']			= ($req['largura']) ? getFloat($req['altura']) : 0;
        $req['peso_liquido']	= ($req['largura']) ? getFloat($req['peso_liquido']) : 0;
        $req['peso_bruto']	    = ($req['largura']) ? getFloat($req['peso_bruto']) : 0;
        
        if ($request->hasFile('file') && $request->file->isValid()) {            
            $file               = $request->file('file');
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $pasta              = "upload/".$empresa->pasta ."/produtos/";
            //$pasta              = "storage/".$empresa->pasta ."/produtos/";
            $file->move(public_path($pasta), $nomeImagem);
            $req['imagem']       = $pasta . $nomeImagem;            
        }  
        
        $req["tipo_produto_id"]      = config("constantes.tipo_produto.PRODUTO");
        $produto = Produto::Create(objToArray($req));        
   
        if($request->fornecedor_id){
            $item = NfeEntradaItem::find($request->nfe_item_id);
            if($item){
                $forn = new \stdClass();
                $forn->fornecedor_id= $request->fornecedor_id;
                $forn->produto_id   = $produto->id;
                $forn->codigo_barra = $item->cEAN;
                $forn->cProd        = $item->cProd;
                ProdutoFornecedor::Create(objToArray($forn));
                
                //popula o id do produto
                $item->produto_id   = $produto->id;
                $item->save();
            }
             
        }
               
        return redirect()->route('admin.produto.edit', $produto->id)->with('msg_sucesso', "Produto Inserido com sucesso.");
        
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
    }
    
    public function clonarProduto($id_produto){
        $produto                      = Produto::find($id_produto);
        $novo_produto                 = $produto->replicate();
        $novo_produto->usa_grade      = "N";
        $novo_produto->status_id      = config("constantes.status.DIGITACAO");
        $novo_produto->save();       
        
        $mov                    = new \stdClass();
        $mov->tipo_movimento_id = 1;
        $mov->produto_id        = $novo_produto->id;
        $mov->ent_sai           = 'E';
        $mov->data_movimento    = hoje();
        $mov->qtde_movimento    = $novo_produto->estoque_inicial;
        $mov->valor_movimento   = $novo_produto->valor_venda;
        $mov->subtotal_movimento= $novo_produto->estoque_inicial * $novo_produto->valor_venda;
        $mov->descricao         = "Entrada de Estoque Inicial";
        MovimentoService::inserir($mov);
        return redirect()->route('admin.produto.edit', $novo_produto->id)->with('msg_sucesso', "Produto Clonado com sucesso.");
    }
    
    public function detalhe($id){
        $dados["produto"]               = NfeItem::where([ "id"=>$id])->first(); 
        return view('Admin.Cadastro.Produto.Imposto.Detalhe', $dados);
    }
    public function show($id)
    {
        $grade = GradeService::montar($id);
        i($grade);
    }
    
    public function edit($id)
    {
        
        $this->checaPermissao(__FUNCTION__);
        $dados["produto"]               = Produto::where([ "id"=>$id])->first();        
        $dados["categorias"]            = Categoria::get();  
        
        $dados["subcategorias"] = array();
        if($dados["categorias"]){
            $categoria = Categoria::find($dados["produto"]->categoria_id);
            if($categoria){
                $dados["subcategorias"] = $categoria->subcategorias ;
            }
        }
        
        $dados["subsubcategorias"] = array();
        if($dados["subcategorias"]){
            $subcategoria = SubCategoria::find($dados["produto"]->subcategoria_id);             
            if($subcategoria){
                $dados["subsubcategorias"] = $subcategoria->subsubcategorias ;
            }
            
        }
      
        $dados["unidades"]                  = Unidade::get();
        $dados["tributacoes"]               = Tributacao::get();
        $dados["variacoes"]                 = VariacaoGrade::get();
        $dados["grade"]                     = GradeProduto::where("produto_id", $id)->get();
        $dados["fornecedores_produto"]      = ProdutoFornecedor::where("produto_id", $id)->get();
        $dados["fornecedores"]              = Fornecedor::get();        
        $dados["lista_precos"]              = TabelaPrecoProduto::where("produto_id", $id)->get();
        $dados["precos"]                    = TabelaPreco::get();
        $dados["variacao_grade_linha_id"]   = $dados["grade"][0]->variacao_grade_linha_id ?? null;
        $dados["variacao_grade_coluna_id"]  = $dados["grade"][0]->variacao_grade_coluna_id ?? null;
        $dados["imagens"]                   = LojaImagemProduto::where("produto_id", $id)->get();
        $dados["linha"]                     = array();
        $dados["coluna"]                    = array();
        $dados["soma_estoque"]              = GradeProduto::where("produto_id", $id)->sum("estoque");
        $dados["localizacoes"]              = Localizacao::get();
        
        if($dados["produto"]->usa_grade=="S"){
            $grade                        = GradeService::montar($id);
            $dados["linha"]               = $grade->linhas; 
            $dados["coluna"]              = $grade->colunas;
            $dados["variacao_linha"]      = $grade->variacao_linha;
            $dados["variacao_coluna"]     = $grade->variacao_coluna;
            $dados["grade_produto"]       = $grade->grade;
            
           
        }
        
   
    
    
        $dados["tributacao_produto"]    = TributacaoProduto::lista($id);
        $dados["composicao"]            = ProdutoComposicao::where("produto_pai_id", $id)->with("produtoFilho")->get();
        $dados["semelhantes"]           = ProdutoSemelhante::where("produto_principal_id", $id)->with("produtoSemelhante")->get();
        $dados["produtos"]              = Produto::where("tipo_produto_id", config("constantes.tipo_produto.PRODUTO"))->get();
  
        $dados["produtoJs"]             = true;
        $dados["categoriaJs"]           = true;
        return view('Admin.Cadastro.Produto.Edit', $dados);
    }
    
 
    
    public function update(ProdutoRequest $request, $id){    
        $this->checaPermissao(__FUNCTION__);
        $empresa                = auth()->user()->empresa;
        $req                    = $request->except(["_token","_method", "estoque_inicial", "file"]);

        try {        
            
            $req['gtin']                = ($req['gtin']) ? $req['gtin'] : "SEM GTIN";
            $req['valor_venda']	        = getFloat($req['valor_venda']);
            $req['valor_custo']	        = getFloat($req['valor_custo']);
            $req['margem_lucro']        = getFloat($req['margem_lucro']);
            $req['valor_maior']       = $req['valor_maior'] ? getFloat($req['valor_maior']) : 0;
            $req['valor_venda_atacado']       = $req['valor_venda_atacado'] ? getFloat($req['valor_venda_atacado']) : 0;
            $req['valor_atacado_apartir']       = $req['valor_atacado_apartir'] ? getFloat($req['valor_atacado_apartir']) : 0;
            $req['comissao']       = $req['estoque_minimo'] ? getFloat($req['comissao']) : 0;
            
            $req['ncm']			        = tira_mascara($req['ncm']);
            
            $req['fragmentacao_qtde']    = $req['fragmentacao_qtde'] ? getFloat($req['fragmentacao_qtde']) : null;
            $req['fragmentacao_unidade'] = $req['fragmentacao_unidade'] ? $req['fragmentacao_unidade'] : null;
            $req['fragmentacao_valor']   = $req['fragmentacao_valor'] ? getFloat($req['fragmentacao_valor']) : null; 
            $req['pRedBC']               = $req['pRedBC'] ? getFloat($req['pRedBC']) : null;
            $req['pRedBCST']             = $req['pRedBCST'] ? getFloat($req['pRedBCST']) : null;
            $req['pDif']                 = $req['pDif'] ? getFloat($req['pDif']) : null;
            $req['pMVAST']               = $req['pMVAST'] ? getFloat($req['pMVAST']) : null;
            $req['pICMS']                = $req['pICMS'] ? getFloat($req['pICMS']) : null;
            $req['pPIS']                 = $req['pPIS'] ? getFloat($req['pPIS']) : null;
            $req['pCOFINS']              = $req['pCOFINS'] ? getFloat($req['pCOFINS']) : null;
            $req['pIPI']                 = $req['pIPI'] ? getFloat($req['pIPI']) : null;
            
            
            
            $req['estoque_minimo']    = ($req['estoque_minimo']) ? getFloat($req['estoque_minimo']) : 0;
            $req['estoque_maximo']   = ($req['estoque_maximo']) ? getFloat($req['estoque_maximo']) : 0;
            
            $req['largura']			= ($req['largura']) ? getFloat($req['largura']) : 0;
            $req['comprimento']		= ($req['comprimento']) ? getFloat($req['comprimento']) : 0;
            $req['altura']			= ($req['altura']) ? getFloat($req['altura']) : 0;
            $req['peso_liquido']	= ($req['peso_liquido']) ? getFloat($req['peso_liquido']) : 0;
            $req['peso_bruto']		= ($req['peso_bruto']) ? getFloat($req['peso_bruto']) : 0;        
            
            if ($request->hasFile('file') && $request->file->isValid()) {
                
                $file               = $request->file('file');
                $extensao           = $file->getClientOriginalExtension();
                $nomeImagem         = Str::random(25) . ".".$extensao;
                $pasta              = "upload/".$empresa->pasta ."/produtos/";
                $upload             = $file->move(public_path($pasta), $nomeImagem);
                $req['imagem']      = $pasta . $nomeImagem;
            }
            
            Produto::where("id", $id)->update(objToArray($req)); 
            return redirect()->route('admin.produto.index')->with('msg_sucesso', "Produto Inserido com sucesso.");
        
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());            
        }
    }
    
    private function validateLoja(Request $request){      
        $rules =  [
            'nome'          => 'required|min:3|max:100',
            'categoria_id'  => 'required',
            'unidade'       => 'required',
            'valor_venda'   => 'required',
            'valor_custo'   => 'required',
            'ncm'           => 'required|min:10|max:10',
            'controlar_estoque' => 'required',
            'produto_loja'  => 'required',
            'largura'       => 'nullable',
            'altura'        => 'nullable',
            'comprimento'   => 'nullable',
            'peso_liquido'  => 'nullable',
            'peso_bruto'    => 'nullable',
            
            'estoque_inicial' => 'nullable',
            'estoque_maximo' => 'nullable',
            'estoque_minimo' => 'nullable',
            
            'fragmentacao_qtde'     => 'nullable',
            'fragmentacao_unidade'  => 'nullable',
            'fragmentacao_valor'    => 'nullable',
        ];
        if($this->produto_loja=="S"){
            $rules['largura']       = 'required';
            $rules['altura']        = 'required';
            $rules['comprimento']   = 'required';
            $rules['peso_liquido']  = 'required';
            $rules['peso_bruto']    = 'required';
        }
        
        if($this->controlar_estoque=="S"){
            if ($this->method() == 'POST')
                $rules['estoque_inicial']  = 'required';
                $rules['estoque_maximo']   = 'required';
                $rules['estoque_minimo']   = 'required';
        }
        
        if(($this->fragmentacao_qtde) || ($this->fragmentacao_unidade) || ($this->fragmentacao_valor) ){
            $rules['fragmentacao_qtde']     = 'required';
            $rules['fragmentacao_unidade']  = 'required';
            $rules['fragmentacao_valor']    = 'required';
        }   
         
        $this->validate($request, $rules);
    }
    
    private function validateEstoque(Request $request){
        $rules = [
            'estoque_inicial' => 'required',
            'estoque_maximo' => 'required',
            'estoque_minimo' => 'required',
        ];        
        $messages = [
            'estoque_inicial.required' => 'O campo Estoque Inicial é obrigatório.',
            'estoque_maximo.required' => 'O campo Máximo é obrigatório.',
            'estoque_minimo.required' => 'O campo Mínimo é obrigatório.',
        ];
        
        $this->validate($request, $rules, $messages);
    }
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Produto::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Produto excluído com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao excluir [$cod]");
        }
    }
    
    public function salvarProdutoDaNota(Request $request){
        //echo json_encode($request->produto);
        $produto = $request->produto;
       $natureza = NaturezaOperacao::first();
        
        $valorVenda = str_replace(".", "", $produto['valorVenda']);
        $valorVenda = str_replace(",", ".", $valorVenda);
        
        $result = Produto::create([
            'nome'              => $produto['nome'],
            'ncm'               => $produto['ncm'],
            'valor_venda'       => moedaEn($valorVenda),
            'valor_compra'      => moedaEn($produto['valorCompra']),
            'conversao_unitaria'=> (int) $produto['conversao_unitaria'],
            'categoria_id'      => $produto['categoria_id'],
            'tributacao_id'     => $produto['tributacao_id'],
            'unidade_compra'    => $produto['unidadeCompra'],
            'unidade_estoque'   => $produto['unidadeCompra'],
            'unidade_venda'     => $produto['unidadeVenda'],
            'gtin'              => $produto['codBarras'] ?? 'SEM GTIN',
            'cfop_saida'        => $natureza->CFOP_saida_estadual,
            'cfop_pdv'          => $natureza->CFOP_saida_estadual,
            'cfop_compra'       => $produto['cfop'],
            'codigo_anp'        => '',
            'descricao_anp'     => '',
            'cListServ'         => '',
            'imagem'            => '',
            'referencia'        => $produto['referencia']
            
        ]);
        
        echo json_encode($result);
    }
    
    public function pdf(){
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        
        $dados["dompdf"]     = $dompdf;        
        
        $dados["lista"]      = Produto::get();
        return view('Admin.Pdf.Lista_Produto', $dados);      
        
        
    }
    
    public function pesquisa(){
        $q          = $_GET["q"];
        $produtos   = Produto::where("tipo_produto_id", config("constantes.tipo_produto.PRODUTO"))-> where("nome","like","%$q%")->with("estoque")->get();
        
        return response()->json($produtos);
    }
    
    public function buscarServico(){
        $q          = $_GET["q"];
        $produtos   = Produto::where("tipo_produto_id", config("constantes.tipo_produto.SERVICO"))-> where("nome","like","%$q%")->get();
        
        return response()->json($produtos);
    }
    public function pesquisarProdutoPorId($id){
        $retorno = new \stdClass();
        try {
            $produto            = Produto::find($id);
            
            if(!$produto){
                $retorno->tem_erro  = true;
                $retorno->erro      = "Produto não encontrado";
                return response()->json($retorno);
            }else{
                $retorno->tem_erro  = false;
                $retorno->erro      = "";
                $retorno->retorno   = $produto;
                return response()->json($retorno);
            }
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            $retorno->retorno   = "";
            return response()->json($retorno);
        }
        
    }
    
    public function getProduto($id){
        $produto = Produto::where('id', $id)->first();
        $retorno = new \stdClass();
        $retorno->nome          = $produto->nome;
        $retorno->valor_venda   = $produto->valor_venda;
        $retorno->unidade       = $produto->unidade;
        
        if($produto->controlar_estoque=="S")
            $retorno->estoque       = $produto->estoque->quantidade;
        else
            $retorno->estoque       = -1;
        
        echo json_encode($retorno);
    }
}
