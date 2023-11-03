<?php

namespace App\Http\Controllers\Admin\Compra;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\DuplicataCompra;
use App\Models\FinContaPagar;
use App\Models\FormaPagto;
use App\Models\Fornecedor;
use App\Models\ItemCompra;
use App\Models\NaturezaOperacao;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Service\CompraService;
use App\Service\ConstanteService;
use App\Service\ContaPagarSevice;
use App\Service\EstoqueService;
use App\Service\ItemCompraService;
use App\Service\MovimentoService;
use App\Service\UsuarioService;
use Illuminate\Http\Request;

class CompraController extends Controller
{    
    
    public function index(){
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->fornecedor_id = null;
        
        $dados["lista"]     = Compra::filtro($filtro);
        $dados["filtro"]    = $filtro;
        
        $dados["naturezas"]         = NaturezaOperacao::where("tipo", "S")->get();
        $dados["lista"]             = Compra::get();
        $dados["fornecedores"]      = Fornecedor::get();
        $dados["somaCompraMensal"]  = CompraService::somaCompraMensal();        
        return view("Admin.Compra.Compra.Index", $dados);        
    }
    
    
    public function filtro(){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->fornecedor_id          = $_GET["fornecedor_id"] ?? null;
        
        $dados["naturezas"]         = NaturezaOperacao::where("tipo", "S")->get();
        $dados["lista"]                 = Compra::filtro($filtro);
        $dados["filtro"]                = $filtro;
        $dados["fornecedores"]          = Fornecedor::get();
        
        return view("Admin.Compra.Compra.Index", $dados);
    }
    
    public function create(){   
        $dados["fornecedores"]      = Fornecedor::get();
        $dados["transportadoras"]   = Transportadora::get();
        $dados["produtos"]          = Produto::get();
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["compraJs"]          = true;
        $dados["clienteJs"]         = true;
        $dados["fornecedorJs"]      = true;
        $dados["categoriaJs"]       = true;
        $dados["produtoJs"]         = true;
        
        return view("Admin.Compra.Compra.Create", $dados);
    }    
    
    public function edit($id){
        $compra             = Compra::find($id);
        if($compra->status_id!= config("constantes.status.DIGITACAO")){
            return redirect()->route("admin.compra.detalhe", $id)->with('msg_erro', "Essa compra não pode mais ser alterada.");
        }
        
        $dados["compra"]            = $compra;
        $dados["fornecedor"]        = $compra->fornecedor;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["fornecedores"]      = Fornecedor::get();
        $dados["itens"]             = ItemCompra::where("compra_id", $id)->get();
        $dados["duplicatas"]        = DuplicataCompra::where("compra_id", $id)->get();
        
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["compraEditJs"]      = true;
        $dados["gradeJs"]           = true;
        $dados["clienteJs"]         = true;
        $dados["fornecedorJs"]      = true;
        $dados["categoriaJs"]       = true;
        $dados["produtoJs"]         = true;        
        
        return view("Admin.Compra.Compra.Edit", $dados);
    } 
    
    public function compraNfe($id){
        $compra             = Compra::find($id);
        if($compra->status_id!= config("constantes.status.DIGITACAO")){
            return redirect()->route("admin.compra.detalhe", $id)->with('msg_erro', "Essa compra não pode mais ser alterada.");
        }
        
        $dados["compra"]            = $compra;
        $dados["fornecedor"]        = $compra->fornecedor;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["fornecedores"]      = Fornecedor::get();
        $dados["itens"]             = ItemCompra::where("compra_id", $id)->get();
        $dados["duplicatas"]        = DuplicataCompra::where("compra_id", $id)->get();
        
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["compraJs"]      = true;
        $dados["gradeJs"]      = true;
        $dados["compraEditJs"]         = true;
        $dados["fornecedorJs"]      = true;
        $dados["categoriaJs"]       = true;
        $dados["produtoJs"]         = true;
        $dados["pode_finalizar"]    = true;
        
        return view("Admin.Compra.Compra.CompraNfe", $dados);
    }
    
    public function financeiro($id)
    {
        $dados["compra"]   = Compra::find($id);
        $dados["lista"]    = FinContaPagar::where("compra_id", $id)->get();
        return view("Admin.Compra.Compra.Financeiro", $dados);
    }
    
    public function detalhe($id){
        $dados["compra"]             = Compra::find($id);
        return view("Admin.Compra.Compra.Detalhe", $dados);
    }
    
    public function excluir($id){
        $dados["lista"]             = Compra::all();
        $dados["somaCompraMensal"]  = CompraService::somaCompraMensal();
        return view("Admin.Compra.Compra.Index", $dados);
    }
    
    public function emitirEntrada($id){
        $dados["compra"]             = Compra::find($id); 
        $dados["naturezas"]          = NaturezaOperacao::all();
        $dados["tiposPagamento"]     = Compra::tiposPagamento();
        return view("Admin.Compra.Compra.EmitirEntrada", $dados);
    }
    
    public function lancarEstoque($id_compra){
        
        $tipo_movimento = config("constantes.tipo_movimento.ENTRADA_COMPRA_MANUAL");
        $descricao = "Entrada Compra - Lançamento Manual: #" . $id_compra;
        MovimentoService::lancarEstoqueDaCompra($id_compra, $tipo_movimento, $descricao);
       
        return redirect()->back()->with('msg_sucesso', "Operação realizada com sucesso.");
    }
    
    public function estornarEstoque($id_compra){
        
        $tipo_movimento = config("constantes.tipo_movimento.SAIDA_ESTORNO_MANUAL");
        $descricao = "Estorno Manual da Compra: #" . $id_compra;
        MovimentoService::estornarEstoqueDaCompra($id_compra, $tipo_movimento, $descricao);
        
        return redirect()->back()->with('msg_sucesso', "Operação realizada com sucesso.");
    }
    public function lancarFinanceiro($id_compra){
        /*$compra = Compra::find($id_compra);
        FinContaPagar::where("compra_id", $compra->id)->delete(); //Excluindo os itens para incluir de novo
        ContaPagarSevice::salvarContaPagar($compraCadastrada, $compra['fatura'] );
        Compra::where("id", $compraCadastrada->id)-> update(["enviou_financeiro"=>"S"]);*/
    }
    
    
    public function salvar(Request $request){         
        $retorno  = new \stdClass();
        
        try {
            $compra                 = new \stdClass();
            $compra->fornecedor_id  = $request->fornecedor_id ;
            $compra->data_compra    = $request->data_compra ;
            $compraNova             = Compra::Create(objToArray($compra));           
            $item                   = (object) $request->itens[0];
                       
            if($compraNova){
                $item->compra_id = $compraNova->id;
                ItemCompraService::inserirItem($item);
            }                
         
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Compra Salva com Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/compra/edit",$compraNova->id );
            $retorno->retorno   = $compraNova->id;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Compra";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
    }
    
    public function finalizarCompra(Request $request){
        $gera_estoque       = $request->gerar_estoque ?? null;
        $gerar_financeiro   = $request->gerar_financeiro ?? null;
        $compra             = Compra::find($request->compra_id);
        $soma_duplicata     = DuplicataCompra::where("compra_id", $compra->id)->sum("vDup");
        
        $retorno            = new \stdClass();
        $redirect           =  url("admin/compra");        
        try {
            
            //verifica a grade           
            foreach($compra->itens as $item){
                if($item->produto->usa_grade=="S"){
                    if(!validarGrade($item->quantidade,"item_compra_id", $item->id)){
                        throw(new \Exception('O item ' . $item->produto->nome . ' usa grade e as quantidades da grade não correspondem com quantidade de entrada, por favor verifique.'));
                    }
                }
            }                       
            
            if($gerar_financeiro ){
                if($soma_duplicata <=0){
                    throw(new \Exception('Para gerar financeiro é necessário definir os dados da cobrança'));
                }
                
               /* if($soma_duplicata != $compra->valor_compra){
                    throw(new \Exception('O valor total da compra está diferente do valor total das cobranças'));
                }*/
            }                     
            
            if($gera_estoque){                
                ItemCompraService::gerarEstoqueDaCompra($compra);
            }
            
            if($gerar_financeiro){
                ContaPagarSevice::salvarContaPagarPelaCompraManual($compra);
            }            
                       
            $compra->status_id   = config("constantes.status.CONCRETIZADO");
            $compra->save();
            
           
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Compra Salva com Sucesso";
            $retorno->redirect  = $redirect;
            $retorno->erro      = "";
            $retorno->retorno   = $compra;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Compra";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function atualizarDadosPagamentos(Request $request){
        $dados                          = $request->except(["_token","_method"]);
        $compra_id                       = $request->compra_id;
        $retorno                        = new \stdClass();
        try {
            
            
            $compra                      = Compra::find($compra_id);
            $compra->valor_frete         = $dados["valor_frete"] != null ? getFloat($dados["valor_frete"]) : 0;
            $compra->total_seguro        = $dados["total_seguro"] != null ? getFloat($dados["total_seguro"]) : 0;
            $compra->despesas_outras     = $dados["despesas_outras"] != null ? getFloat($dados["despesas_outras"]) : 0;
            $compra->desconto_valor      = $dados["desconto_valor"] != null ? getFloat($dados["desconto_valor"]) : 0;
            $compra->desconto_per        = $dados["desconto_per"] != null ? getFloat($dados["desconto_per"]) : 0;
            $compra->fornecedor_id       = $dados["fornecedor_id"] ;
            $compra->save();
            
            Compra::somarTotal($compra_id);
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    
    public function salvarNfFiscal(Request $request){
        $nf     = $request->nf;    
        $itens = $request->itens;
        $fatura = $request->fatura;
       
    
        $compra = Compra::create([
            'fornecedor_id'     => $nf['fornecedor_id'],
            'usuario_id'        => UsuarioService::get_id_user(),
            'nf'                => $nf['nNf'],
            'observacao'        => $nf['observacao'],
            'valor'             => str_replace(",", ".", $nf['valor_nf']),
            'desconto'          => str_replace(",", ".", $nf['desconto']),
            'xml_path'          => $nf['xml_path'],
            'estado'            => 'NOVO',
            'numero_emissao'    => 0,
            //'categoria_id' => 1,
            'chave' => $nf['chave']
        ]);
        
        //Salvar o item
        if($compra->id){
            foreach($itens as $prod){
                $produto = Produto::where("id", (int) $prod['produto_id'])->first();
                
                ItemCompra::create([
                    'compra_id'     => $compra->id,
                    'produto_id'    => (int) $prod['produto_id'],
                    'quantidade'    =>  str_replace(",", ".", $prod['quantidade']),
                    'valor_unitario'=> str_replace(",", ".", $prod['valor']),
                    'unidade_compra'=> $prod['unidade'],
                    'cfop_entrada'  => $prod['cfop_entrada']
                ]);
                
                $valor = $produto->valor_venda > 0 ? $produto->valor_venda : $prod['valor'];
                EstoqueService::pluStock($produto->id, str_replace(",", ".", $prod['quantidade']) * $produto->conversao_unitaria, str_replace(",", ".", $valor));
            }
        }
        
        if($compra->id){
            foreach($fatura as $parcela){
                $valorParcela = str_replace(".", "", $parcela['valor_parcela']);
                $valorParcela = str_replace(",", ".", $valorParcela);
                $valorParcela = str_replace(" ", "", $valorParcela);                
                FinContaPagar::create([
                    'compra_id'        => $compra->id,
                    'data_vencimento' => dataen($parcela['vencimento']),
                    'data_pagamento' => dataen($parcela['vencimento']),
                    'valor_integral' => $valorParcela,
                    'valor_pago' => 0,
                    'status' => false,
                    'referencia' => $parcela['referencia'],
                    'categoria_id' => 1,
                ]);
            }
            
        }
       
   }
    
   
    
}
