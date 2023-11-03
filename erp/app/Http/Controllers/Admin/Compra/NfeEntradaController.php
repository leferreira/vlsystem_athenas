<?php

namespace App\Http\Controllers\Admin\Compra;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\FinContaPagar;
use App\Models\Fornecedor;
use App\Models\ItemCompra;
use App\Models\NfeEntradaDuplicata;
use App\Models\NfeEntradaItem;
use App\Models\NfeEntrada;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Models\Tributacao;
use App\Service\ConstanteService;
use App\Service\ContaPagarSevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\MovimentoService;
use App\Models\ProdutoFornecedor;
use function Termwind\ValueObjects\getFormatString;
use App\Models\Unidade;
use App\Models\DuplicataCompra;
use App\Models\Venda;

class NfeEntradaController extends Controller
{
    
    public function index()
    {       
        $filtro                 = new \stdClass();
        $filtro->data1          = hoje();
        $filtro->data2          = hoje();
        $filtro->status_id      = config("constantes.status.DIGITACAO");
        $filtro->fornecedor_id  = null;
        
        
        $dados["status"]                = ConstanteService::listaStatusNfeEntrada();
        $dados["lista"]                 = NfeEntrada::filtro($filtro);
        $dados["filtro"]                = $filtro;
        
        return view("Admin.Compra.Nfe.Index", $dados);
    }    
    
    public function filtro(){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? hoje();
        $filtro->data2                  = $_GET["data2"] ?? hoje();
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->fornecedor_id          = $_GET["fornecedor_id"] ?? null;
        
        $dados["status"]                = ConstanteService::listaStatusNfeEntrada();
        $dados["lista"]                 = NfeEntrada::filtro($filtro);
        $dados["filtro"]                = $filtro;
        
        return view("Admin.Compra.Nfe.Index", $dados);
    }
    
    public function produtos($id)  {
        $empresa            = auth()->user()->empresa;
        $filtro             = new \stdClass();
        $filtro->tipo       = $_GET["tipo"] ?? "T";
   
        
        if($filtro->tipo   == "T"){
            $lista = NfeEntradaItem::where('nfe_id', $id)->get();
        }
        
        if($filtro->tipo   == "V"){
            $lista = NfeEntradaItem::where('nfe_id', $id)->where("produto_id", "!=", NULL)->get();
        }
        
        if($filtro->tipo   == "N"){
            $lista = NfeEntradaItem::where('nfe_id', $id)->where("produto_id", NULL)->get();
        }
     
        $dados["parametro"]     = $empresa->parametro;
        $dados["filtro"]        = $filtro;        
        $dados["lista"]         = $lista;
        $nota                   = NfeEntrada::find($id);
        $itens                  = $nota->itens;
        $pode_inserir           = NfeEntradaItem::Where("produto_id", "!=", NULL)->where("nfe_id", $id)->get();
        
        $dados["pode_inserir"]  = (count($pode_inserir) == count($itens) ) ? true : false;
        
        $dados["id_nfe"]        = $id;
        $dados["produtos"]      = Produto::get();
        $dados["parametro"]     = auth()->user()->empresa->parametro;
        $dados["categorias"]    = Categoria::get();
        $dados["unidades"]      = Unidade::get();  
        $dados["nfeCompraJs"]   = true;
        $dados["categoriaJs"]   = true;
        return view("Admin.Compra.Nfe.Produtos", $dados);
    }
    
    public function buscar($id)  {
        $item = NfeEntradaItem::find($id);
        return response()->json($item);
    }
    
    public function ver($id){
        $empresa                    = auth()->user()->empresa;
        $nfe                        = NfeEntrada::find($id);  
        
        // i($dados["notafiscal"]);
        $dados["notafiscal"]        = $nfe;
        $dados["emitente"]        = Fornecedor::find($nfe->fornecedor_id);
        
        $dados["transportadoras"]   = Transportadora::get();
        
        $dados["itens"]             = NfeEntradaItem::where("nfe_id", $id)->get();
        $dados["duplicatas"]        = NfeEntradaDuplicata::where("nfe_id",$id)->get();
        
        //Dados da Venda
        $dados["tributacoes"]       = Tributacao::get();
        $dados["parametro"]         = $empresa->parametro;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["cfops"]             = ConstanteService::unidadesMedida();
        $dados["produtoJs"]         = true;
        $dados["transportadoraJs"]  = true;
        
        return view("Admin.Compra.Nfe.NotaEntrada.Index", $dados);
    }
    
    public function lerArquivo(){
        return view("Admin.Compra.Nfe.LerArquivo");
    }
    
    public function importar(Request $request){
        $total = count($request->allFiles()["arquivo"]);
        for($i =0; $i< $total; $i++){
            $xml = $request->allFiles()["arquivo"][$i];           
            $nota = lerXml($xml);      
          
            $tem     = NfeEntrada::where('chave', $nota->identificacao->chave)->first();
            
            if(!$tem){
                $fornecedor = new \stdClass();
                $fornecedor->razao_social      = $nota->emitente->xNome;
                $fornecedor->nome_fantasia     = $nota->emitente->xFant;
                $fornecedor->cnpj              = $nota->emitente->CNPJ;
                $fornecedor->rg_ie             = $nota->emitente->IE;
                $fornecedor->logradouro        = $nota->emitente->xLgr;
                $fornecedor->numero            = $nota->emitente->nro;
                $fornecedor->bairro            = $nota->emitente->xBairro;
                $fornecedor->uf                = $nota->emitente->UF;
                $fornecedor->complemento       = $nota->emitente->xCpl;
                $fornecedor->telefone          = $nota->emitente->fone;
                $fornecedor->email             = $nota->emitente->email;
                $fornecedor->cep               = $nota->emitente->CEP;
                $fornecedor->ibge              = $nota->emitente->cMun;
                $fornecedor->cidade            = $nota->emitente->xMun;
                $fornecedor->tipo_contribuinte = 1;
                
                $forn = Fornecedor::where("cnpj", $nota->emitente->CNPJ)->first();
                if(!$forn){
                    $forn = Fornecedor::Create(objToArray($fornecedor));
                }
                
                $id_transportadora = null;
                if($nota->transportadora->CNPJ){
                    $transp                = new \stdClass();
                    $transp->cnpj          = $nota->transportadora->CNPJ ?? null ;
                    $transp->razao_social  = $nota->transportadora->xNome ?? null;
                    $transp->logradouro    = $nota->transportadora->xEnder ?? null;
                    $transp->cidade        = $nota->transportadora->xMun ?? null;
                    $transp->uf            = $nota->transportadora->UF ?? null;
                    $transportadora = Transportadora::where('cnpj',$transp->cnpj)->first();                
                    if(!$transportadora){
                        $transportadora = Transportadora::Create(objToArray($transp));
                        $id_transportadora = $transportadora->id;
                    }
                }
                
                
                $id                 = salvarNfeEntradaPeloXml($nota, $forn->id, $id_transportadora);
                $empresa            = auth()->user()->empresa;
                $nomeImagem         = $nota->identificacao->chave . ".xml" ;
                $pasta              = "upload/".$empresa->pasta ."/Nfe/Entrada/";
                $upload             = $xml->move(public_path($pasta), $nomeImagem);
            }else{
                return redirect()->back()->with('msg_erro', "Este Arquivo Já foi importado");
            }
            
        }
        return redirect()->route('admin.nfeentrada.index');
    }
    
    
    public function darEntrada(Request $request)  {
        $id                 = $request->id;
       // $gera_estoque       = $request->gerar_estoque ?? null;
      //  $gerar_financeiro   = $request->gerar_financeiro ?? null;
        $retorno            = new \stdClass();
        try {        
            $nota       = NfeEntrada::find($id);        
            $itens      = $nota->itens;
            $duplicatas = $nota->duplicatas; 
            
            $pode_inserir = NfeEntradaItem::Where("produto_id", "!=", NULL)
                                        ->where("nfe_id", $id)->get();         
            
                 
             if(count($pode_inserir) == count($itens) ){
                    //Inserir compra
                    $com                    = new \stdClass();
                    $com->fornecedor_id     = $nota->fornecedor_id;
                    $com->transportadora_id = $nota->transportadora_id;
                    $com->usuario_id        = Auth::user()->id;
                    $com->nf                = $nota->nNF;
                    $com->valor_total       = $nota->vNF;
                    $com->valor_compra      = $nota->vProd;
                    $com->valor_desconto    = $nota->vDesc;
                    $com->valor_frete       = $nota->vFrete;
                    $com->qtde_parcela      = count($nota->duplicatas);
                    $com->primeiro_vencimento =  $nota->duplicatas[0]["dVenc"] ?? hoje();
                    $com->data_compra       = ($nota->dhSaiEnt) ? dataNfe($nota->dhSaiEnt) : hoje();
                    $com->chave             = $nota->chave;
                    $com->status_id         = config("constantes.status.DIGITACAO");
                    $com->numero_emissao    = 0;        
                    $compra                 = Compra::Create(objToArray($com)); 
                    
                    if($compra){
                        ItemCompra::where("compra_id", $compra->id)->delete(); //Excluindo os itens para incluir de novo                    
                        foreach($itens as $i){
                            ItemCompra::create([
                                'compra_id'     => $compra->id,
                                'produto_id'    => $i->produto_id,
                                'quantidade'    => $i->qCom,
                                'unidade'       => $i->unidade,
                                'valor_unitario'=> $i->vUnCom,
                                'subtotal'      => $i->vProd,
                                'desconto_por_unidade'      => 0,
                                'subtotal_liquido' => $i->vProd,
                                'total_desconto_item' => 0,
                                'desconto_por_valor'   => 0,
                                'desconto_percentual'  => 0
                                
                            ]);
                            /*if($gera_estoque){
                                $tipo      = config("constantes.tipo_movimento.ENTRADA_IMPORTACAO_XML");
                                $descricao = "Compra #" . $compra->id;
                                MovimentoService::lancarEstoqueDaCompra($compra->id, $tipo, $descricao);
                            }*/                          
                            
                        }                   
                       
                        if(count($duplicatas) > 0){
                            DuplicataCompra::where("compra_id", $compra->id)->delete(); //Excluindo os itens para incluir de novo
                            foreach($duplicatas as $d){
                                $duplicata = new \stdClass();
                                $duplicata->compra_id  = $compra->id;
                                $duplicata->tPag  = $d->tPag;
                                $duplicata->nDup  = $d->nDup;
                                $duplicata->dVenc = $d->dVenc;
                                $duplicata->vDup  = $d->vDup;
                                $duplicata->obs   = $d->obs;
                                DuplicataCompra::Create(objToArray($duplicata));
                            }
                        }
                        
                    }
                    
                    $nota->status_id    = config("constantes.status.CONCRETIZADO");                   
                    $nota->save();
                      
                    
                    /*NfeEntradaItem::where("nfe_id",$id)->delete();
                    NfeEntradaDuplicata::where("nfe_id",$id)->delete();
                    NfeEntrada::where("id",$id)->delete();*/
                    
                    
                    $retorno->tem_erro  = false;
                    $retorno->titulo    = "Importação realizada  com Sucesso";
                    $retorno->erro      = "";
                    $retorno->redirect  =  url("admin/compra/CompraNfe/".$compra->id);
                    $retorno->retorno   = $compra->id;
                    return response()->json($retorno);                  
                    
                    
             }else{
                 throw new \Exception("Você precisa preencher todos os campos Produto e Unidade de cada Item");
             }   
             
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Importar Xnl";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
          
    }
    
    
    
    public function cadastrarProduto(Request $request){
        $empresa            = auth()->user()->empresa;
        $retorno = new \stdClass();
        try {
            $dados                        = new \stdClass();
            $dados->nfe_item_id           = $request->id;
            $dados->unidade               = $request->unidade;
            $dados->categoria_id          = $request->categoria_id ?? null;
            $dados->subcategoria_id       = $request->subcategoria_id ?? null;
            $dados->subsubcategoria_id    = $request->subsubcategoria_id ?? null;
            $dados->margem_lucro          = $request->margem_lucro ? getFloat($request->margem_lucro) : 0;
            $dados->valor_venda	          = $request->valor_venda ? getFloat($request->valor_venda) : 0;
            
            $dados->estoque_minimo        = $request->estoque_minimo ?? $empresa->parametro->estoque_minimo_padrao;
            $dados->estoque_maximo        = $request->estoque_maximo ?? $empresa->parametro->estoque_maximo_padrao;
            $dados->estoque_inicial       = $request->estoque_inicial ?? 0;
            $dados->sku                   = $request->sku ?? null;
            
            cadastrarProdutoDoXml($dados, "entrada");
           
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function vincularProduto($id_produto, $id_item_nota){
        $retorno = new \stdClass();
        try {
            $produto                = Produto::find($id_produto);
            $nfeItem                = NfeEntradaItem::find($id_item_nota);
            $nfeItem->produto_id    = $produto->id;
            $nfeItem->save();
            
            //verificar se tem algum 
            if($nfeItem->fornecedor_id){
                if($nfeItem->cProd!="" && $nfeItem->cProd!=NULL){
                    $temFornecedor = ProdutoFornecedor::where(["produto_id" => $id_produto, "cProd" => $nfeItem->cProd, "fornecedor_id" =>$nfeItem->fornecedor_id ])->first();
                }
                
                if(!$temFornecedor){
                    if($nfeItem->cEAN != "SEM GTIN" && $nfeItem->cEAN != "" && $nfeItem->cEAN != NULL ){
                        $temFornecedor = ProdutoFornecedor::where(["produto_id" => $id_produto, "codigo_barra" => $nfeItem->cEAN, "fornecedor_id" =>$nfeItem->fornecedor_id ])->first();
                    }
                }
                if(!$temFornecedor){
                    $forn = new \stdClass();
                    $forn->fornecedor_id= $nfeItem->fornecedor_id;
                    $forn->produto_id   = $produto->id;
                    $forn->codigo_barra = $nfeItem->cEAN;
                    $forn->cProd        = $nfeItem->cProd;
                    ProdutoFornecedor::Create(objToArray($forn));                    
                }
            }
           
            
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
            
        }
                
    }
    
    public function atualizarProduto(Request $request){
        $prod            = NfeEntradaItem::find($request->id);
        $prod->produto_id= $request->produto_id;
        $prod->unidade   = $request->unidade;
        $prod->cfop_prod = $request->cfop;
        if($prod->produto_id && $prod->unidade && $prod->cfop_prod){
            $prod->save();
        }
        
        $p = NfeEntradaItem::find($request->id);
        if($p->produto_id)        
            echo json_encode("OK");
        else
            echo json_encode("Nao");
    }
    
    
    private function validaChave($chave){
        $msg = "";
        $chave = substr($chave, 3, 44);        
        $cp         = Compra::where('chave', $chave)->first();        
      //  $manifesto = ManifestaDfe::where('chave', $chave)->first();
        
        if($cp != null) $msg = "XML já importado na compra fiscal";
     //   if($manifesto != null) $msg .= "XML já importado através do manifesto fiscal"; */
        return $msg;
    }
    
    private function verificaAtualizacao($fornecedorEncontrado, $dadosEmitente){
        $dadosAtualizados = [];
        
        $verifica = $this->dadosAtualizados('Razao Social', $fornecedorEncontrado->razao_social, $dadosEmitente['razaoSocial']);
        if($verifica) 
            array_push($dadosAtualizados, $verifica);        
        $verifica = $this->dadosAtualizados('Nome Fantasia', $fornecedorEncontrado->nome_fantasia, $dadosEmitente['nomeFantasia']);
        if($verifica) 
            array_push($dadosAtualizados, $verifica);        
        $verifica = $this->dadosAtualizados('Rua', $fornecedorEncontrado->rua,$dadosEmitente['logradouro']);
        if($verifica) array_push($dadosAtualizados, $verifica);        
            $verifica = $this->dadosAtualizados('Numero', $fornecedorEncontrado->numero,$dadosEmitente['numero']);
        if($verifica) array_push($dadosAtualizados, $verifica);        
            $verifica = $this->dadosAtualizados('Bairro', $fornecedorEncontrado->bairro,$dadosEmitente['bairro']);
        if($verifica) array_push($dadosAtualizados, $verifica);        
            $verifica = $this->dadosAtualizados('IE', $fornecedorEncontrado->ie_rg,$dadosEmitente['ie']);
        if($verifica) array_push($dadosAtualizados, $verifica);
         $this->atualizar($fornecedorEncontrado, $dadosEmitente);
        return $dadosAtualizados;
    }
    
    private function dadosAtualizados($campo, $anterior, $atual){
        if($anterior != $atual){
            return $campo . " atualizado";
        }
        return false;
    }
    
    private function cadastrarFornecedor($fornecedor){        
        $result = Fornecedor::create([
            'empresa_id'        => session('empresa_selecionada_id'),
            'razao_social'      => $fornecedor['razaoSocial'],
            'nome_fantasia'     => $fornecedor['nomeFantasia'],
            'logradouro'        => $fornecedor['logradouro'],
            'numero'            => $fornecedor['numero'],
            'uf'                => $fornecedor['uf'],
            'bairro'            => $fornecedor['bairro'],
            'cep'               => $fornecedor['cep'],
            'cnpj'              => $fornecedor['cnpj'],
            'ie_rg'             => $fornecedor['ie'],
            'celular'           => '*',
            'telefone'          => $fornecedor['fone'],
            'email'             => '*',
            'cidade_id'         => $fornecedor['cidade_id']
        ]);
        return $result->id;
    }
    
    private function atualizar($fornecedor, $dadosEmitente){
        $fornecedor->razao_social   = $dadosEmitente['razaoSocial'];
        $fornecedor->nome_fantasia  = $dadosEmitente['nomeFantasia'];
        $fornecedor->logradouro    = $dadosEmitente['logradouro'];
       // $fornecedor->ie             = $dadosEmitente['ie'];
        $fornecedor->bairro         = $dadosEmitente['bairro'];
        $fornecedor->numero         = $dadosEmitente['numero'];
        $fornecedor->save();
    }
    
    public function excluir($id){
        NfeEntradaItem::where("nfe_id", $id)->delete();
        NfeEntradaDuplicata::where("nfe_id", $id)->delete();
        NfeEntrada::where("id", $id)->delete();
        return redirect()->route("admin.nfeentrada.index");
    }
}
