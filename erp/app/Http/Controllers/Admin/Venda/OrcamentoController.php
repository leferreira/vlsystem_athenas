<?php

namespace App\Http\Controllers\Admin\Venda;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Emitente;
use App\Models\FinContaPagar;
use App\Models\FinContaReceber;
use App\Models\FormaPagto;
use App\Models\Frete;
use App\Models\ItemCompra;
use App\Models\ItemVenda;
use App\Models\NaturezaOperacao;
use App\Models\Nfe;
use App\Models\PedidoCliente;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Models\Venda;
use App\Service\CompraService;
use App\Service\ConstanteService;
use App\Service\ContaReceberSevice;
use App\Service\EstoqueService;
use App\Service\ItemVendaService;
use App\Service\NotaFiscalService;
use App\Service\UsuarioService;
use App\Service\ValidacaoNfeService;
use App\Service\VendaService;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;
use App\Models\Tributacao;
use App\Events\NotaFiscalEvent;
use App\Models\Orcamento;
use App\Service\ItemOrcamentoService;
use App\Models\Duplicata;
use App\Models\ItemOrcamento;
use App\Models\Vendedor;
use App\Models\GradeMovimentoTemp;
use App\Models\GradeMovimento;

class OrcamentoController extends Controller{    
    
    public function index(){      
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id = null;
        
        $dados["status_financeiro"] = ConstanteService::listaStatusFinanceiro();            
        $dados["status"]            = ConstanteService::listaStatusVenda();            
        $dados["lista"]             = Orcamento::filtro($filtro);
        $dados["filtro"]            = $filtro;
        
        return view("Admin.Venda.Orcamento.Index", $dados);   
        
    }
    
    public function filtro(){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;

        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusVenda();  
        $dados["lista"]                 = Orcamento::filtro($filtro);
        $dados["filtro"]                = $filtro;
            
        return view("Admin.Venda.Orcamento.Index", $dados);
    }
    
    public function create(){
       
        //Dados da Venda
        $empresa                    = auth()->user()->empresa;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["tributacoes"]       = Tributacao::get();
        $dados["parametro"]         = $empresa->parametro;
        
        
        //Dados do Cliente
        $dados["clientes"]          = Cliente::get();
        $dados["parametro"]         = Auth::user()->empresa->parametro;
        $dados["produtos"]          = Produto::get();
        $dados["transportadoras"]   = Transportadora::get();
        //$dados["natureza_operacao"] = NaturezaOperacao::where("padrao", config('constantes.padrao_natureza.VENDA'))->first();      
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["vendedores"]        = Vendedor::all();
        $dados["orcamentoJs"]       = true;    
        $dados["clienteJs"]         = true;
        $dados["vendedorJs"]        = true;
        $dados["categoriaJs"]       = true;
        $dados["produtoJs"]         = true;
       
      
        return view("Admin.Venda.Orcamento.Create", $dados);
    }    
    
    public function finalizarOrcamento(Request $request){
       
        
        $retorno            = new \stdClass();
        $redirect           =  url("admin/orcamento");
        
        try {
            $orcamento          = Orcamento::find($request->id); 
            //verifica a grade
            foreach($orcamento->itens as $item){
                if($item->produto->usa_grade=="S"){
                    if(!validarGradeTemp($item->quantidade,"item_orcamento_id", $item->id)){
                        throw(new \Exception('O item ' . $item->produto->nome . ' usa grade e as quantidades da grade não correspondem com quantidade de Saída, por favor verifique.'));
                    }
                }
            }
            
            
                        
            $orcamento->cliente_id  = $request->cliente_id;
            $orcamento->vendedor_id = $request->vendedor_id;
            $orcamento->save();
            
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Orçamento Salva com Sucesso";
            $retorno->redirect  = $redirect;
            $retorno->erro      = "";
            $retorno->retorno   = $orcamento;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Venda";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function edit($id){
        $orcamento             = Orcamento::find($id);
        
        if($orcamento->status_id == config("constantes.status.CONCRETIZADO")){
            return redirect()->route("admin.venda.detalhe", $id)->with('msg_erro', "Essa venda não pode mais ser alterada.");
        }
        
        
        $dados["orcamento"]         = $orcamento;
        $dados["cliente"]           = $orcamento->cliente;
        $dados["vendedor"]          = $orcamento->vendedor;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["clientes"]          = Cliente::get();
        $dados["itens"]             = ItemOrcamento::where("orcamento_id", $id)->get();
        $dados["duplicatas"]        = Duplicata::where("orcamento_id", $id)->get();
        $dados["vendedores"]        = Vendedor::all();
        
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["orcamentoEditJs"]   = true;
        $dados["gradeTempJs"]       = true;
        $dados["clienteJs"]         = true;
        $dados["vendedorJs"]        = true;
        $dados["categoriaJs"]       = true;
        
        return view("Admin.Venda.Orcamento.Edit", $dados);
    }
    
    public function atualizarDadosPagamentos(Request $request){
        $dados                          = $request->except(["_token","_method"]);
        $orcamento_id                       = $request->orcamento_id;
        $retorno                        = new \stdClass();
        try {
            
            
            $venda                      = Orcamento::find($orcamento_id);
            $venda->valor_frete         = $dados["valor_frete"] != null ? getFloat($dados["valor_frete"]) : 0;
            $venda->total_seguro        = $dados["total_seguro"] != null ? getFloat($dados["total_seguro"]) : 0;
            $venda->despesas_outras     = $dados["despesas_outras"] != null ? getFloat($dados["despesas_outras"]) : 0;
            $venda->desconto_valor      = $dados["desconto_valor"] != null ? getFloat($dados["desconto_valor"]) : 0;
            $venda->desconto_per        = $dados["desconto_per"] != null ? getFloat($dados["desconto_per"]) : 0;
            $venda->save();
            
            Orcamento::somarTotal($orcamento_id);
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function encerrar($id){
        $orcamento = Orcamento::find($id);
        $orcamento->status_id = config('constantes.status.FECHADO');
        $orcamento->save();
        return redirect()->route('admin.orcamento.index');
        
        
        
    }
    
    
    public function transformarEmVenda($id){ 
        
        $orcamento = Orcamento::find($id);      
        
        if($orcamento->venda_id){
            return redirect()->back()->with('msg_erro', "Essa Orçamento já tem uma venda vinculada.");
        }
        
        $venda              = new \stdClass();
        $venda->cliente_id  = $orcamento->cliente_id;
        $venda->usuario_id  = auth()->user()->id;;
        $venda->data_venda  = hoje();
        $venda->status_id   = config('constantes.status.DIGITACAO');
        $venda->status_financeiro_id   = config('constantes.status.ABERTO');
        $venda->valor_total  = $orcamento->valor_total;
        $venda->valor_frete  = $orcamento->valor_frete;
        $venda->total_seguro  = $orcamento->total_seguro;
        $venda->despesas_outras  = $orcamento->despesas_outras;
        $venda->desconto_valor  = $orcamento->desconto_valor;
        $venda->desconto_per  = $orcamento->desconto_per;
        $venda->valor_desconto  = $orcamento->valor_desconto;
        $venda->valor_venda  = $orcamento->valor_orcamento;
        $venda->orcamento_id  = $orcamento->id;
        $venda->vendedor_id  = $orcamento->vendedor_id;
        $novaVenda          = Venda::Create(objToArray($venda));
        $orcamento->venda_id = $novaVenda->id;
        $orcamento->status_id   = config('constantes.status.CONCRETIZADO');
        $orcamento->save();
        
        if($novaVenda){
            $itens = ItemOrcamento::where("orcamento_id", $orcamento->id)->get();
            foreach($itens as $i){
                $item = new ItemVenda();
                $item->venda_id = $novaVenda->id;
                $item->produto_id = $i->produto_id ;
                $item->quantidade = $i->quantidade ;
                $item->valor = $i->valor ;
                $item->subtotal = $i->subtotal ;
                $item->subtotal_liquido = $i->subtotal_liquido ;
                $item->desconto_percentual = $i->desconto_percentual ;
                $item->desconto_por_valor = $i->desconto_por_valor ;
                $item->desconto_por_unidade = $i->desconto_por_unidade ;
                $item->total_desconto_item = $i->total_desconto_item ;
                $item->unidade = $i->unidade ;
                $foi = $item->save();
                //Exportar a grade
                if($foi){
                    if($i->produto->usa_grade=="S"){
                        $movimentos = GradeMovimentoTemp::where("item_orcamento_id", $i->id)->get();
                        foreach($movimentos as $movTemp){
                            //Insere o movimento de grade
                            $mov                    = new \stdClass();
                            $mov->tipo_movimento_id = config("constantes.tipo_movimento.SEM_MOVIMENTO");
                            $mov->produto_id        = $item->produto_id;
                            $mov->grade_id          = $movTemp->grade_id;
                            $mov->estorno           = 'N';
                            $mov->data_movimento    = hoje();
                            $mov->qtde_movimento    = $movTemp->qtde_movimento;                           
                            $mov->item_venda_id     = $item->id;
                            $mov->venda_id          = $item->venda_id;
                            $mov->ent_sai           = 'S';
                            $mov->descricao         = "Saída Por Orçamento - Item: #" . $item->id;                            
                            if($mov->qtde_movimento > 0){
                                GradeMovimento::Create(objToArray($mov));
                            }
                        }
                    }
                }
            }
            
            $duplicatas = Duplicata::where("orcamento_id", $orcamento->id)->get();
            if(count($duplicatas) > 0){
                foreach($duplicatas as $d){
                    $duplicata = new Duplicata();
                    $duplicata->venda_id    = $novaVenda->id;
                    $duplicata->tPag        = $d->tPag ;
                    $duplicata->indPag      = $d->indPag ;
                    $duplicata->nDup        = $d->nDup ;
                    $duplicata->dVenc       = $d->dVenc ;
                    $duplicata->vDup        = $d->vDup ;
                    $duplicata->obs         = $d->obs ;
                    $duplicata->save();
                }
            }
            
        }
     
        return redirect()->route("admin.venda.edit", $novaVenda->id);
     }
    public function show($id){
        $orcamento                  = Orcamento::find($id);  
        
        if(!$orcamento->venda_id){
            return redirect()->route("admin.orcamento.edit", $id);
        }
        
        $dados["orcamento"]         = $orcamento;
        $dados["cliente"]           = $orcamento->cliente;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["clientes"]          = Cliente::get();
        $dados["itens"]             = ItemOrcamento::where("orcamento_id", $id)->get();
        $dados["duplicatas"]        = Duplicata::where("orcamento_id", $id)->get();
        
        
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["orcamentoEditJs"]   = true;
        $dados["clienteJs"]         = true;
        $dados["transportadoraJs"]  = true;
        $dados["categoriaJs"]       = true;
        
        return view("Admin.Venda.Orcamento.Show", $dados);
        
    }
    
    public function salvar(Request $request){          
        $retorno  = new \stdClass();
      
        try {
            $item                           = (object) $request->itens[0];
            
            $orcamento                      = new \stdClass();
            $orcamento->status_id           = config('constantes.status.ABERTO');
            $orcamento->usuario_id          = Auth::user()->id;
            $orcamento->cliente_id          = $request->cliente_id ;
            $orcamento->valor_frete         =  0;
            $orcamento->total_seguro        =  0;
            $orcamento->despesas_outras     =  0;
            $orcamento->desconto_valor      =  0;
            $orcamento->desconto_per        =  0;
            $orcamento->vendedor_id         = $request->vendedor_id ;
            $orcamento->data_orcamento      = hoje();
            $novoOrcamento                  = Orcamento::Create(objToArray($orcamento));           
            
            if($novoOrcamento){
                $item->orcamento_id = $novoOrcamento->id;
                ItemOrcamentoService::inserirItem($item);
            }
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Orçamento Salvo com Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/orcamento/edit",$novoOrcamento->id );
            $retorno->retorno   = $orcamento;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Venda";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
   
    public function pdf($id){
        $orcamento = Orcamento::find($id);
        $p = view('Admin.Venda.Orcamento.Pdf')->with('orcamento', $orcamento);
        
        //return $p;
        $domPdf = new Dompdf(["enable_remote" => true]);
        $domPdf->loadHtml($p);
        
        $pdf = ob_get_clean();
        
        $domPdf->setPaper("A4");
        $domPdf->render();
        $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
        //$domPdf->stream("relatorio de venda $venda->id.pdf");
        
    }
    
}
