<?php

namespace App\Http\Controllers\Admin\Nfe;

use App\Events\NotaFiscalEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\NfeRequest;
use App\Http\Requests\NovaNfeRequest;
use App\Models\Categoria;
use App\Models\Cfop;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\CstCofins;
use App\Models\CstIcms;
use App\Models\CstIpi;
use App\Models\CstPis;
use App\Models\Emitente;
use App\Models\Fornecedor;
use App\Models\NaturezaOperacao;
use App\Models\Nfe;
use App\Models\NfeAutorizado;
use App\Models\NfeDestinatario;
use App\Models\NfeDuplicata;
use App\Models\NfeItem;
use App\Models\NfePagamento;
use App\Models\NfeReferenciado;
use App\Models\NfeTransporte;
use App\Models\NfeXml;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Models\Tributacao;
use App\Models\Venda;
use App\Service\ConstanteService;
use App\Service\ItemNotafiscalService;
use App\Service\NfeDestinatarioService;
use App\Service\NotaFiscalOperacaoService;
use App\Service\NotaFiscalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Nfce;
use App\Models\LojaPedido;
use App\Service\LojaPedidoService;

class NotaFiscalController extends Controller
{    
    
    public function index(){ 
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->venda_id   = null;
     
        $dados["lista"]     = Nfe::filtro($filtro); 
        $dados["status"]    = ConstanteService::listaStatusNfe();
        $dados["filtro"]    = $filtro;
        $dados["opcoesNfeJs"]       = true;
        return view("Admin.Nfe.Index", $dados);        
    }
    
    public function filtro(){
        $filtro             = new \stdClass();
        $filtro->data1      = $_GET["data1"] ?? null;
        $filtro->data2      = $_GET["data2"] ?? null;
        $filtro->status_id  = $_GET["status_id"] ?? null;
        $filtro->venda_id   = $_GET["venda_id"] ?? null;
        
        $dados["lista"]     = Nfe::filtro($filtro);
        $dados["status"]    = ConstanteService::listaStatusNfe();
        $dados["filtro"]    = $filtro;
        $dados["opcoesNfeJs"]       = true;
        return view("Admin.Nfe.Index", $dados);
    }
    
    public function create(){
        $natureza_operacao = NaturezaOperacao::first();        
        if(!$natureza_operacao){
            return redirect()->route("admin.naturezaoperacao.index")->with("janela_atencao1","Não existe Nenhuma Natureza de Operação cadastrada, cadastre primeiramente pra poder salvar a NFE");
        }
        
        $emitente = Emitente::where("empresa_id", auth()->user()->empresa->id)->first();
        if(!$emitente->cnpj){
            return redirect()->back()->with('janela_atencao1', "É necessário configurar o Emitente primeiramente.");
        }
        
        if(!$emitente->numero_serie_nfe || !$emitente->ultimo_numero_nfe){
            return redirect()->back()->with('janela_atencao1', "Configure a série e o último Número da NFE.");
        }
        
        $dados["opcoesNfeJs"]   = true;
        $dados["clienteJs"]     = true;
        $dados["naturezas"]     = NaturezaOperacao::all();
        $dados["clientes"]      = Cliente::all();
        return view("Admin.Nfe.Novo", $dados);
    }
    
    //Cria uma nova Nota
    public function criarNota(NovaNfeRequest $request){
        $retorno = new \stdClass();
        $req                    = $request->except(["_token","_method"]);
        try {          
            $nota                           = (object) $req ;           
            $nota->empresa_id               = auth()->user()->empresa->id;          
            $nota->modFrete                 = "9";            
            $nfe                            = NotaFiscalOperacaoService::criarNotaNova($nota);          
            if($nfe){
                $cliente = Cliente::find($req["cliente_id"]);
                NfeDestinatarioService::criar($nfe->id, $cliente);
            }            
            return redirect()->route("admin.notafiscal.edit", $nfe->id)->with("msg_sucesso","A Nota Fiscal foi cadatrada com sucesso, altere os dados se achar necessário, salve e em seguida faça a transmissão!");
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return redirect()->back()->with("msg_erro",$retorno->erro);
        }
        
    }
    
    public function cadastrarProduto(Request $request){        
        $retorno = new \stdClass();
        try {
            $dados                        = new \stdClass();
            $dados->nfe_item_id           = $request->id;
            $dados->unidade               = $request->unidade;
            $dados->categoria_id          = $request->categoria_id;
            $dados->subcategoria_id       = $request->subcategoria_id;
            $dados->subsubcategoria_id    = $request->subsubcategoria_id;
            $dados->valor_venda	          = $request->valor_venda ? $request->valor_venda : null;
            
            $dados->fragmentacao_qtde    = $request->fragmentacao_qtde ? getFloat($request->fragmentacao_qtde) : null;
            $dados->fragmentacao_unidade = $request->fragmentacao_unidade ? $request->fragmentacao_unidade : null;
            $dados->fragmentacao_valor   = $request->fragmentacao_valor ? getFloat($request->fragmentacao_valor) : null;
            $dados->estoque_minimo       = $request->estoque_minimo ?? 5;
            $dados->estoque_maximo       = $request->estoque_maximo ?? 100;
            $dados->estoque_inicial      = $request->estoque_inicial ?? 0;                   
            
            cadastrarProdutoDoXml($dados, "nfe");
                
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
                
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    //NFCE
    public function salvarNfcePelaVenda($id_venda, $natureza_id){
        try {
            $nfce       = Nfce::where("venda_id",$id_venda)->first();
            
            if($nfce){
                return redirect()->back()->with("janela_atencao1","Já existe uma Nota Fiscal vinculada a esta venda, para mais detalhes, entre no menu Nota Fiscal");
            }
            
            $natureza_operacao = NaturezaOperacao::find($natureza_id);
            if(!$natureza_operacao){
                return redirect()->route("admin.naturezaoperacao.index")->with("janela_atencao1","Não existe Natureza de Operação de venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
            }
            
            $tributacao         = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
            if(!$tributacao){
                return redirect()->back()->with("janela_atencao1","Não existe uma Tributação de venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
            }
            
            $emitente = Emitente::where("empresa_id", Auth::user()->empresa_id)->first();
            if(!$emitente->cnpj){
                return redirect()->back()->with('janela_atencao1', "É necessário configurar o Emitente primeiramente.");
            }
            
            if(!$emitente->numero_serie_nfe || !$emitente->ultimo_numero_nfe){
                return redirect()->back()->with('janela_atencao1', "Configure a série e o último Número da NFE.");
            }
            
            $venda          = Venda::find($id_venda);
            
            if($venda->status_id == config('constantes.status.DIGITACAO') ){
                return redirect()->back()->with('janela_atencao1', "Não é Possível gerar uma Nota de uma venda com status em Digitação.");
            }
            
            if(!$nfce){
                inserirNfcePelaVenda($venda, $natureza_operacao, $tributacao);
                $nota = Nfce::where("venda_id", $venda->id)->first();
            }
            
            return redirect()->route("admin.notanfce.edit", $nota->id)->with("msg_sucesso","A Nota Fiscal foi cadatrada com sucesso, altere os dados se achar necessário, salve e em seguida faça a transmissão!");
            
        } catch (\Exception $e) {
            return redirect()->back()->with("msg_erro",$e->getMessage());
        }
        
    }
    
    
    public function salvarNfePorVenda($id_venda, $natureza_id){
        try {
            $nfe       = Nfe::where("venda_id",$id_venda)->first();
            
            if($nfe){
                return redirect()->back()->with("janela_atencao1","Já existe uma Nota Fiscal vinculada a esta venda, para mais detalhes, entre no menu Nota Fiscal");
            }
            
            $natureza_operacao = NaturezaOperacao::find($natureza_id);
            if(!$natureza_operacao){
                return redirect()->route("admin.naturezaoperacao.index")->with("janela_atencao1","Não existe Natureza de Operação de venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
            }
            
            $tributacao         = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
            if(!$tributacao){
                return redirect()->back()->with("janela_atencao1","Não existe uma Tributação de venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
            }
            
            $emitente = Emitente::where("empresa_id", Auth::user()->empresa_id)->first();
            if(!$emitente->cnpj){
                return redirect()->back()->with('janela_atencao1', "É necessário configurar o Emitente primeiramente.");
            }
            
            if(!$emitente->numero_serie_nfe || !$emitente->ultimo_numero_nfe){
                return redirect()->back()->with('janela_atencao1', "Configure a série e o último Número da NFE.");
            }
            
            $venda          = Venda::find($id_venda);
            
            if($venda->status_id == config('constantes.status.DIGITACAO') ){
                return redirect()->back()->with('janela_atencao1', "Não é Possível gerar uma Nota de uma venda com status em Digitação.");
            }
            
            if(!$nfe){              
                event(new NotaFiscalEvent($venda, $natureza_operacao, $tributacao)) ;
                $nota = Nfe::where("venda_id", $venda->id)->first();
            }
            
            return redirect()->route("admin.notafiscal.edit", $nota->id)->with("msg_sucesso","A Nota Fiscal foi cadatrada com sucesso, altere os dados se achar necessário, salve e em seguida faça a transmissão!");
            
        } catch (\Exception $e) {
            return redirect()->back()->with("msg_erro",$e->getMessage());
        }
        
    }
    
    
    public function salvarNfePorPedidoLoja($id_pedido, $natureza_id){
        try {
            $nfe       = Nfe::where("loja_pedido_id",$id_pedido)->first();
            
            if($nfe){
                return redirect()->back()->with("janela_atencao1","Já existe uma Nota Fiscal vinculada a este pedido, para mais detalhes, entre no menu Nota Fiscal");
            }
            
            $natureza_operacao = NaturezaOperacao::find($natureza_id);
            if(!$natureza_operacao){
                return redirect()->route("admin.naturezaoperacao.index")->with("janela_atencao1","Não existe Natureza de Operação de venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
            }
            
            $tributacao         = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
            if(!$tributacao){
                return redirect()->back()->with("janela_atencao1","Não existe uma Tributação de venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
            }
            
            $emitente = Emitente::where("empresa_id", Auth::user()->empresa_id)->first();
            if(!$emitente->cnpj){
                return redirect()->back()->with('janela_atencao1', "É necessário configurar o Emitente primeiramente.");
            }
            
            if(!$emitente->numero_serie_nfe || !$emitente->ultimo_numero_nfe){
                return redirect()->back()->with('janela_atencao1', "Configure a série e o último Número da NFE.");
            }
            
            $pedido          = LojaPedido::find($id_pedido);
            
            if($pedido->status_id == config('constantes.status.DIGITACAO') ){
                return redirect()->back()->with('janela_atencao1', "Não é Possível gerar uma Nota de uma venda com status em Digitação.");
            }
            if(!$nfe){
                LojaPedidoService::gerarNfe($pedido, $natureza_operacao, $tributacao);
                $nota = Nfe::where("loja_pedido_id", $pedido->id)->first();
            }
            
            return redirect()->route("admin.notafiscal.edit", $nota->id)->with("msg_sucesso","A Nota Fiscal foi cadatrada com sucesso, altere os dados se achar necessário, salve e em seguida faça a transmissão!");
            
        } catch (\Exception $e) {
            i($e->getMessage());
            return redirect()->back()->with("msg_erro",$e->getMessage());
        }
        
    }
    
    
    public function configurarProdutoNfe($id)  {
        $dados["pode_editar"]   = NfeItem::where("produto_id", Null)->where("importado","S")->first();
      
        $dados["nota"]          = Nfe::find($id);
        $dados["lista"]         = NfeItem::where(['nfe_id' => $id])->get();   
        $dados["produtos"]      = Produto::get();
        $dados["categorias"]    = Categoria::get();
        $dados["unidades"]      = ConstanteService::unidadesMedida();
               
        
        $dados["importarXmlJs"] = true;
        $dados["categoriaJs"]   = true;
        return view("Admin.Nfe.ConfigProduto", $dados);
    }
    
    public function vincularProduto($id_produto, $id_item_nota){
        $retorno = new \stdClass();
        try {
             
            $produto               = Produto::find($id_produto);
            $nfeItem                = NfeItem::find($id_item_nota);
            $nfeItem->produto_id    = $produto->id;
            $nfeItem->save();
            
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
            
        }
        
    }
    public function inserirAutorizado(Request $request){
        $req = $request->except(["_token","_method"]);
        NfeAutorizado::Create($req);
        $lista = NfeAutorizado::where("nfe_id", $req["nfe_id"])->get();
        echo json_encode($lista);
        
    }
    
    public function excluirAutorizado($id){
        $autorizado = NfeAutorizado::where("id", $id)->first();
        $autorizado->delete();
        $lista = NfeAutorizado::where("nfe_id", $autorizado->nfe_id)->get();
        echo json_encode($lista);
        
    }
    
    public function inserirReferenciado(Request $request){
        $req = $request->except(["_token","_method"]);
        NfeReferenciado::Create($req);
        $lista = NfeReferenciado::where("nfe_id", $req["nfe_id"])->get();
        echo json_encode($lista);
        
    }
    
    public function excluirReferenciado($id){
        $referenciado = NfeReferenciado::where("id", $id)->first();
        $referenciado->delete();
        $lista = NfeReferenciado::where("nfe_id", $referenciado->nfe_id)->get();
        echo json_encode($lista);
        
    }
    public function edit($id){         
        $empresa                    = auth()->user()->empresa;
        $nfe                        = Nfe::find($id);       

        //verifica se é importada e se todos os itens estão vinculados
        if($nfe->importado =="S"){
            $tem = NfeItem::where("produto_id", Null)->where("importado","S")->first();
            if($tem){
                return redirect()->route("admin.notafiscal.configurarProdutoNfe", $id)->with("msg_erro","Cadastre ou Vincule os produtos Importados do XML para a tabela de  produtos Cadastrados!");
                
            }
        }
        
        
       // i($dados["notafiscal"]);
        $dados["notafiscal"]        = $nfe;
        $dados["transportadoras"]   = Transportadora::get();
        $dados["destinatario"]      = NfeDestinatario::where("nfe_id", $id)->first();
        $dados["itens"]             = NfeItem::where("nfe_id", $id)->get();
        $dados["duplicatas"]        = NfeDuplicata::where("nfe_id",$id)->get();
        $dados["autorizados"]       = NfeAutorizado::where("nfe_id", $id)->get();
        $dados["referenciados"]     = NfeReferenciado::where("nfe_id", $id)->get();
        $dados["pagamentos"]        = NfePagamento::lista($id);
        //$dados["nfetransporte"]     = NfeTransporte::where("nfe_id", $id)->first();
        
        //Dados da Venda
        $dados["tributacoes"]       = Tributacao::get();
        $dados["parametro"]         = $empresa->parametro;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["cfops"]             = ConstanteService::unidadesMedida();
        $dados["produtoJs"]         = true;
        $dados["transportadoraJs"]  = true;
        
        //Tributacao
        $dados["lista_cstIcms"]     = CstIcms::get();
        $dados["lista_cst_ipi"]     = CstIpi::get();
        $dados["lista_cfop"]        = Cfop::get();
        $dados["lista_cstPis"]      = CstPis::get();
        $dados["lista_cstCofins"]   = CstCofins::get();
        $dados["lista_modalidade"]  = ConstanteService::listaModalidade();
        $dados["lista_modalidade_st"]  = ConstanteService::listaModalidadeSt();
        $dados["lista_motivo"]      = ConstanteService::motivoDesoneracao();
        
        $dados["xml"]               = NfeXml::where("nfe_id", $id)->first();
      
        return view("Admin.Nfe.Edit", $dados);
    }
    
    public function edicaoLivre($id){
        
        $empresa                    = auth()->user()->empresa;
        $dados["notafiscal"]        = Nfe::find($id);
        $dados["transportadoras"]   = Transportadora::get();
        $dados["destinatario"]      = NfeDestinatario::where("nfe_id", $id)->first();
        $dados["itens"]             = NfeItem::where("nfe_id", $id)->get();
        $dados["duplicatas"]        = NfeDuplicata::listaPorNfe($id);
        $dados["autorizados"]       = NfeAutorizado::where("nfe_id", $id)->get();
        $dados["referenciados"]     = NfeReferenciado::where("nfe_id", $id)->get();
        $dados["pagamentos"]        = NfePagamento::lista($id);
        //$dados["nfetransporte"]     = NfeTransporte::where("nfe_id", $id)->first();
        
        //Dados da Venda
        $dados["tributacoes"]       = Tributacao::get();
        $dados["parametro"]         = $empresa->parametro;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["cfops"]             = ConstanteService::unidadesMedida();
        $dados["produtoJs"]         = true;
        $dados["transportadoraJs"]  = true;
        
        //Tributacao
        $dados["lista_cstIcms"]     = CstIcms::get();
        $dados["lista_cst_ipi"]     = CstIpi::get();
        $dados["lista_cfop"]        = Cfop::get();
        $dados["lista_cstPis"]      = CstPis::get();
        $dados["lista_cstCofins"]   = CstCofins::get();
        $dados["lista_modalidade"]  = ConstanteService::listaModalidade();
        $dados["lista_modalidade_st"]  = ConstanteService::listaModalidadeSt();
        $dados["lista_motivo"]      = ConstanteService::motivoDesoneracao();
        
        return view("Admin.Nfe.Livre.Edit", $dados);
    }
    
    public function atualizarDadosPagamentos(Request $request){
        $nfe_id             = $request->nfe_id;
        $retorno            = new \stdClass();
        try {
            $req                = $request->except(["_token","_method"]);
            $nota               = Nfe::find($nfe_id);
            $nota->vFrete		= $req["vFreteTot"] ? getFloat($req["vFreteTot"]) : null;
            $nota->vSeg		    = $req["vSegTot"] ? getFloat($req["vSegTot"]) : null;
            $nota->vOutro		= $req["vOutroTot"] ? getFloat($req["vOutroTot"]) : null;
            $nota->desconto_nota= $req["desconto_nota"] ? getFloat($req["desconto_nota"]) : null;
            $nota->vDesc        = $req["desconto_nota"] ? getFloat($req["desconto_nota"]) : null;  
            $nota->livre        = null;
            //Se livre igual a S significa que não é pra fazer cálculo e só salvar
            if($request->livre == "S"){
                $nota->livre =  rand(1,99999999);                
            }
            $nota->save();
       
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
               
    }
    
   
    public function lerArquivo(){
        $naturezas = NaturezaOperacao::all();
        if(count($naturezas) <=0){
            return redirect()->route("admin.naturezaoperacao.index")->with("janela_atencao1","É obrigatório ter pelo menos uma Natureza de Operação cadastrada para executar esta operação");
        }        
        
       
        $dados["naturezas"]     = $naturezas;
        $dados["clientes"]      = Cliente::all();
        return view("Admin.Nfe.LerArquivo",$dados);
    }
    
    public function importarNfe(Request $request){
        try {
            $natureza_operacao_id = $request->natureza_operacao_id;     
            
            $natureza_operacao = NaturezaOperacao::find($natureza_operacao_id);
            if(!$natureza_operacao){
                return redirect()->route("admin.naturezaoperacao.index")->with("janela_atencao1","Não existe Natureza de Operação de venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
            }
            
            $tributacao         = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
            if(!$tributacao){
                return redirect()->back()->with("janela_atencao1","Não existe uma Tributação vinculada à Natureza de Operação Selecionada, por favor cadastre a Tributação");
            }
            
            $emitente = Emitente::where("empresa_id", Auth::user()->empresa_id)->first();
            if(!$emitente->cnpj){
                return redirect()->back()->with('janela_atencao1', "É necessário configurar o Emitente primeiramente.");
            }
            
            if(!$emitente->numero_serie_nfe || !$emitente->ultimo_numero_nfe){
                return redirect()->back()->with('janela_atencao1', "Configure a série e o último Número da NFE.");
            }
            
            if (!$request->hasFile('arquivo')){
                return redirect()->back()->with('janela_atencao1', "Não foi Possível abrir o arquivo selecionado");
                
            }
                
                $nota                     = lerXml($request->arquivo); 
                //Se a nota não é nossa, Então o emitente será nosso cliente
                if($nota->emitente->CNPJ != $emitente->cnpj){
                    $cliente                  = new \stdClass();
                    $cliente->cpf_cnpj        = ($nota->emitente->CNPJ) ? $nota->emitente->CNPJ : $nota->emitente->CPF;
                    $cliente->nome_razao_social = $nota->emitente->xNome;
                    $cliente->nome_fantasia   = $nota->emitente->xFant;
                    $cliente->logradouro      = $nota->emitente->xLgr;
                    $cliente->numero          = $nota->emitente->nro;
                    $cliente->bairro          = $nota->emitente->xBairro;
                    $cliente->uf              = $nota->emitente->UF;
                    $cliente->complemento     = ($nota->emitente->xCpl) ?? null;
                    $cliente->telefone        = ($nota->emitente->fone) ?? null;
                    $cliente->cep             = $nota->emitente->CEP;
                    $cliente->ibge            = $nota->emitente->cMun;
                    $cliente->rg_ie           = ($nota->emitente->IE) ?? null;
                    $cliente->cidade          = $nota->emitente->xMun;
                    $cliente->indFinal        = 1;
                    $cliente->tipo_contribuinte= "1";
                    $cliente->tipo_cliente    = "J";
                    $cliente->senha           = "123456";
                    $cliente->password        = bcrypt($cliente->senha);
                    $cliente->status_id       = config('constantes.status.ATIVO');
                    $cli = Cliente::where("cpf_cnpj", $cliente->cpf_cnpj)->first();
                    
                    if(!$cli){
                        $cli = Cliente::Create(objToArray($cliente));
                    }
                }                                   
              
                
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
                    }
                }       
         
                $id = salvarNfePeloXml($nota, $natureza_operacao, $cli->id, "C" );
                return redirect()->route("admin.notafiscal.edit", $id);
                
        } catch (\Exception $e){
            return redirect()->back()->with('janela_atencao1', "Erro: " . $e->getMessage());
        }
            
            
           
    }
    
    public function salvar(NfeRequest $request){
        $retorno = new \stdClass();
        $id_nfe = $request->id_nfe;
        $req    = $request->except(["_token","_method","id_nfe","vProd"]);      
        try {            
            $nota   = (object) $req ; 
            
           /* $nota->transp_xNome		    = $req["transp_xNome"] ?? null;
            $nota->transp_CNPJ	        = $req["transp_CNPJ"] ?? null;
            $nota->transp_IE		    = $req["transp_IE"] ?? null;
            $nota->transp_xEnder	    = $req["transp_xEnder"] ?? null;
            $nota->transp_xMun	        = $req["transp_xMun"] ?? null;
            $nota->transp_UF	        = $req["transp_UF"] ?? null;
            
            
            $nota->transp_placa	        = $req["transp_placa"] ?? null;
            $nota->transp_ufveic		= $req["transp_ufveic"] ?? null;
            $nota->transp_rntc	        = $req["transp_rntc"] ?? null;
            $nota->transp_vagao	        = $req["transp_vagao"] ?? null;
            $nota->transp_balsa	        = $req["transp_balsa"] ?? null;
            $nota->nLacre		        = $req["vol_lacre"] ?? null;
            
            
            $nota->ret_tran_vserv	    = $req["transp_placa"] ?? null;
            $nota->ret_tran_vbc		    = $req["transp_ufveic"] ?? null;
            $nota->ret_tran_pcims	    = $req["transp_rntc"] ?? null;
            $nota->ret_tran_vicms	    = $req["transp_vagao"] ?? null;
            $nota->ret_tran_cfop	    = $req["transp_balsa"] ?? null;
            $nota->ret_tran_cmunfg		= $req["vol_lacre"] ?? null;      */     
            
            
            $nota->qVol		            = ($req["vol_qtde"]) ? $req["vol_qtde"] : null ;
            $nota->esp	                = $req["vol_especie"] ?? null;
            $nota->marca		        = $req["vol_marca"] ?? null;
            $nota->nVol	                = $req["vol_numeraco"] ?? null;
            $nota->pesoL	            = $req["vol_peso_liq"] ?? null;
            $nota->pesoB	            = $req["vol_peso_bruto"] ?? null;
            $nota->nLacre		        = $req["vol_lacre"] ?? null; 
            
          
            
            //Dados da Nota
            NotaFiscalOperacaoService::salvarDadosNota($nota, $id_nfe);      
     
            //Destinatário
            $destinatario                = new \stdClass();
            $destinatario->dest_xNome    = $req["xNomeDestinatario"] ?? null;
            $destinatario->dest_indIEDest= $req["indIEDest"] ?? null;
            $destinatario->dest_IE       = $req["IEDestinatario"] ?? null;
            $destinatario->dest_ISUF     = $req["ISUFDestinatario"] ?? null;
            $destinatario->dest_IM       = $req["IMDestinatario"] ?? null;
            $destinatario->dest_email    = $req["emailDestinatario"] ?? null;
            $destinatario->dest_CNPJ     = $req["CNPJDestinatario"] ?? null;
            $destinatario->dest_CPF      = $req["CPFDestinatario"] ?? null;
            
            //Endereço Destinatário
            $destinatario->dest_idEstrangeiro= $req["idEstrangeiro"] ?? null;
            $destinatario->dest_xLgr     	= $req["xLgrDestinatario"] ?? null;
            $destinatario->dest_nro      	= $req["nroDestinatario"] ?? null;
            $destinatario->dest_xCpl     	= $req["xCplDestinatario"] ?? null;
            $destinatario->dest_xBairro  	= $req["xBairroDestinatario"] ?? null;
            $destinatario->dest_cMun     	= $req["cMunDestinatario"] ?? null;
            $destinatario->dest_xMun     	= $req["xMunDestinatario"] ?? null;
            $destinatario->dest_UF       	= $req["UFDestinatario"] ?? null;
            $destinatario->dest_CEP      	= $req["CEPDestinatario"] ?? null;
            $destinatario->dest_fone     	= $req["CEPDestinatario"] ?? null;
            
            NfeDestinatario::where("nfe_id", $id_nfe)->update(objToArray($destinatario));
            
        /*    //Atualizar transporte
            $transporte                     = new \stdClass();
            $transporte->nfe_id	            = $id_nfe;
            $transporte->modFrete	        = $req["modFrete"] ?? null;
            $transporte->transp_xNome	    = $req["transp_xNome"] ?? null;
            $transporte->transp_CNPJ	    = $req["transp_CNPJ"] ?? null;
            $transporte->transp_IE	        = $req["transp_IE"] ?? null;
            $transporte->transp_xEnder	    = $req["transp_xEnder"] ?? null;
            $transporte->transp_xMun	    = $req["transp_xMun"] ?? null;
            $transporte->transp_UF	        = $req["transp_UF"] ?? null;
            
            $transporte->transp_placa	    = $req["transp_placa"] ?? null;
            $transporte->UF_placa	        = $req["UF_placa"] ?? null;
            $transporte->RNTC	            = $req["RNTC"] ?? null;
            $transporte->transp_vagao       = $req["transp_vagao"] ?? null;
            $transporte->transp_balsa       = $req["transp_balsa"] ?? null;
            
            $transporte->qVol		        = ($req["vol_qtde"]) ? $req["vol_qtde"] : null ;
            $transporte->esp	            = $req["vol_especie"] ?? null;
            $transporte->marca		        = $req["vol_marca"] ?? null;
            $transporte->nVol	            = $req["vol_numeraco"] ?? null;
            $transporte->pesoL	            = $req["vol_peso_liq"] ?? null;
            $transporte->pesoB	            = $req["vol_peso_bruto"] ?? null;
            $transporte->nLacre		        = $req["vol_lacre"] ?? null;      
            $nfeTransp = NfeTransporte::where("nfe_id", $id_nfe)->first();
            if($nfeTransp){
                NfeTransporte::where("nfe_id", $id_nfe)->update(objToArray($transporte));
             }else{
                NfeTransporte::Create(objToArray($transporte));
            }
            */
            return redirect()->route("admin.notafiscal.edit", $id_nfe)->with("msg_sucesso", "Salvo com sucesso");
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return redirect()->back()->with("msg_erro",$retorno->erro);
        }
    }
    
   
    public function salvarSemCalculo(NfeRequest $request){
        $retorno = new \stdClass();
        $id_nfe = $request->id_nfe;
        $req    = $request->except(["_token","_method","id_nfe","vProd"]);
        try {
            $nota                       = (object) $req ;            
            $nota->qVol		            = ($req["vol_qtde"]) ? $req["vol_qtde"] : null ;
            $nota->esp	                = $req["vol_especie"] ?? null;
            $nota->marca		        = $req["vol_marca"] ?? null;
            $nota->nVol	                = $req["vol_numeraco"] ?? null;
            $nota->pesoL	            = $req["vol_peso_liq"] ?? null;
            $nota->pesoB	            = $req["vol_peso_bruto"] ?? null;
            $nota->nLacre		        = $req["vol_lacre"] ?? null;
            
            //Dados da Nota
            NotaFiscalOperacaoService::salvarDadosNota($nota, false, $id_nfe);
            
            //Destinatário
            $destinatario                = new \stdClass();
            $destinatario->dest_xNome    = $req["xNomeDestinatario"] ?? null;
            $destinatario->dest_indIEDest= $req["indIEDest"] ?? null;
            $destinatario->dest_IE       = $req["IEDestinatario"] ?? null;
            $destinatario->dest_ISUF     = $req["ISUFDestinatario"] ?? null;
            $destinatario->dest_IM       = $req["IMDestinatario"] ?? null;
            $destinatario->dest_email    = $req["emailDestinatario"] ?? null;
            $destinatario->dest_CNPJ     = $req["CNPJDestinatario"] ?? null;
            $destinatario->dest_CPF      = $req["CPFDestinatario"] ?? null;
            
            //Endereço Destinatário
            $destinatario->dest_idEstrangeiro= $req["idEstrangeiro"] ?? null;
            $destinatario->dest_xLgr     	= $req["xLgrDestinatario"] ?? null;
            $destinatario->dest_nro      	= $req["nroDestinatario"] ?? null;
            $destinatario->dest_xCpl     	= $req["xCplDestinatario"] ?? null;
            $destinatario->dest_xBairro  	= $req["xBairroDestinatario"] ?? null;
            $destinatario->dest_cMun     	= $req["cMunDestinatario"] ?? null;
            $destinatario->dest_xMun     	= $req["xMunDestinatario"] ?? null;
            $destinatario->dest_UF       	= $req["UFDestinatario"] ?? null;
            $destinatario->dest_CEP      	= $req["CEPDestinatario"] ?? null;
            $destinatario->dest_fone     	= $req["CEPDestinatario"] ?? null;
            
            NfeDestinatario::where("nfe_id", $id_nfe)->update(objToArray($destinatario));
            
            /*    //Atualizar transporte
             $transporte                     = new \stdClass();
             $transporte->nfe_id	            = $id_nfe;
             $transporte->modFrete	        = $req["modFrete"] ?? null;
             $transporte->transp_xNome	    = $req["transp_xNome"] ?? null;
             $transporte->transp_CNPJ	    = $req["transp_CNPJ"] ?? null;
             $transporte->transp_IE	        = $req["transp_IE"] ?? null;
             $transporte->transp_xEnder	    = $req["transp_xEnder"] ?? null;
             $transporte->transp_xMun	    = $req["transp_xMun"] ?? null;
             $transporte->transp_UF	        = $req["transp_UF"] ?? null;
             
             $transporte->transp_placa	    = $req["transp_placa"] ?? null;
             $transporte->UF_placa	        = $req["UF_placa"] ?? null;
             $transporte->RNTC	            = $req["RNTC"] ?? null;
             $transporte->transp_vagao       = $req["transp_vagao"] ?? null;
             $transporte->transp_balsa       = $req["transp_balsa"] ?? null;
             
             $transporte->qVol		        = ($req["vol_qtde"]) ? $req["vol_qtde"] : null ;
             $transporte->esp	            = $req["vol_especie"] ?? null;
             $transporte->marca		        = $req["vol_marca"] ?? null;
             $transporte->nVol	            = $req["vol_numeraco"] ?? null;
             $transporte->pesoL	            = $req["vol_peso_liq"] ?? null;
             $transporte->pesoB	            = $req["vol_peso_bruto"] ?? null;
             $transporte->nLacre		        = $req["vol_lacre"] ?? null;
             $nfeTransp = NfeTransporte::where("nfe_id", $id_nfe)->first();
             if($nfeTransp){
             NfeTransporte::where("nfe_id", $id_nfe)->update(objToArray($transporte));
             }else{
             NfeTransporte::Create(objToArray($transporte));
             }
             */
            return redirect()->route("admin.notafiscal.edicaoLivre", $id_nfe)->with("msg_sucesso", "Salvo com sucesso");
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return redirect()->back()->with("msg_erro",$retorno->erro);
        }
    }
    
    
    public function devolucaoVenda($id){ 
        $natureza_operacao = NaturezaOperacao::where("padrao", config('constantes.padrao_natureza.DEVOLUCAO_VENDA'))->first();        
        
        if(!$natureza_operacao){
            return redirect()->back()->with("msg_erro","Não existe Natureza de Operação de Devoluçao de Venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
        }
        
        $dados                       = new \stdClass();
        $dados->nfe_id               = $id;
        $dados->natureza_operacao_id = $natureza_operacao->id;
        $dados->finNFe               = config("constanteNota.finNFe.DEVOLUCAO");        
        $novoNfeId = NotaFiscalService::clonarNfe($dados);
        return redirect()->route("admin.notafiscal.edit", $novoNfeId)->with("msg_sucesso","A Nota Fiscal de Devolução de Venda foi gerada com sucesso, altere os dados se achar necessário, salve e em seguida faça a transmissão!");
        
    }
    
    public function devolucaoCompra($id, $natureza_id){              
        try {
            $natureza_operacao = NaturezaOperacao::find($natureza_id);
            if(!$natureza_operacao){
                return redirect()->route("admin.naturezaoperacao.index")->with("janela_atencao1","Não existe Natureza de Operação de Devolução de Compra Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
            }
            
            $tributacao         = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
            if(!$tributacao){
                return redirect()->back()->with("janela_atencao1","Não existe nenhuma tributação cadastrada para a Natureza de Operação Selecionada, cadastre primeiramente pra poder Emitir a NFE");
            }
            
            $emitente = Emitente::where("empresa_id", Auth::user()->empresa_id)->first();
            if(!$emitente->cnpj){
                return redirect()->back()->with('janela_atencao1', "É necessário configurar o Emitente primeiramente.");
            }
            
            if(!$emitente->numero_serie_nfe || !$emitente->ultimo_numero_nfe){
                return redirect()->back()->with('janela_atencao1', "Configure a série e o último Número da NFE.");
            }
            
            $compra         = Compra::find($id);
            $empresa        = auth()->user()->empresa;
            $path           = "upload/". $empresa->pasta."/Nfe/Entrada/". $compra->chave .".xml"; 
            
            if (!file_exists($path)){
                return redirect()->back()->with('janela_atencao1', "Nenhum Arquivo XML vinculado a esta compra. Você pode emitir a devolução dos produtos manualmente no menu Nota Fiscal");
            }
     
            $nota = lerXml($path);
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
          
            $forn = Fornecedor::where("cnpj", $nota->emitente->CNPJ)->first();           
            if(!$forn){
                $forn = Fornecedor::Create(objToArray($fornecedor));             
            } 
          
            $id = salvarNfePeloXml($nota, $natureza_operacao, $forn->id,"F");
           
            return redirect()->route("admin.notafiscal.edit", $id)->with("msg_sucesso","A Nota Fiscal foi cadatrada com sucesso, altere os dados se achar necessário, salve e em seguida faça a transmissão!");
            
        } catch (\Exception $e){
            return redirect()->back()->with('janela_atencao1', "Erro: " . $e->getMessage());
        }      
    }
    
 
    
    public function excluir($id)
    {
        try{
            $nfe = Nfe::find($id);
            if($nfe->status_id == (config("constantes.status.AUTORIZADO"))){
                return redirect()->back()->with('msg_erro', "Não é possível excluir Nota Autorizada.");
            }
            
            if($nfe->status_id == (config("constantes.status.CANCELADO"))){
                return redirect()->back()->with('msg_erro', "Não é possível excluir Nota Cancelada.");
            }
            
            NfeDestinatario::where("nfe_id", $id)->delete();
            NfeAutorizado::where("nfe_id", $id)->delete();
            NfeDuplicata::where("nfe_id", $id)->delete();
            NfeDestinatario::where("nfe_id", $id)->delete();
            NfeItem::where("nfe_id", $id)->delete();
            NfePagamento::where("nfe_id", $id)->delete();
            NfeReferenciado::where("nfe_id", $id)->delete();
            NfeDestinatario::where("nfe_id", $id)->delete();
            NfeTransporte::where("nfe_id", $id)->delete();
            NfeXml::where("nfe_id", $id)->delete();
            $nfe->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            return redirect()->back()->with('msg_erro', "Erro: " . $e->getMessage());
        }
    }
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function inutilizar(){
        return view("Admin.Nfe.Inutilizar");
    }
    
   
     
    public function notaPorVenda(){
        $dados["vendas"]    = Venda::where("chave","=","")->orWhereNull("chave")->get();        
        return view("Admin.Nfe.Novo.NotaPorVenda", $dados);
    }
      
    
    
    
    
    public function salvarNfePorCompra($id_compra){
        $nfe       = Nfe::where("compra_id",$id_compra)->first();
        if($nfe){
            return redirect()->back()->with("janela_atencao1","Já existe uma Nota Fiscal vinculada a esta compra, para mais detalhes, entre no menu Nota Fiscal");
        }
        
        $natureza_operacao = NaturezaOperacao::where("padrao", config('constantes.padrao_natureza.COMPRA'))->first();
        if(!$natureza_operacao){
            return redirect()->route("admin.naturezaoperacao.index")->with("janela_atencao1","Não existe Natureza de Operação de Compra Padrão cadastrada, cadastre primeiramente pra poder salvar a NFE");
        }
        
        $emitente = Emitente::where("empresa_id", Auth::user()->empresa_id)->first();
        if(!$emitente->cnpj){
            return redirect()->back()->with('janela_atencao1', "É necessário configurar o Emitente primeiramente.");
        }
        
        if(!$emitente->numero_serie_nfe || !$emitente->ultimo_numero_nfe){
            return redirect()->back()->with('janela_atencao1', "Configure a série e o último Número da NFE.");
        }
        
        $compra          = Compra::find($id_compra);
        if(!$nfe){
            $id_nfe = Compra::inserirNfePelaCompra($compra, $natureza_operacao);
        }        
        return redirect()->route("admin.notafiscal.edit", $id_nfe)->with("msg_sucesso","A Nota Fiscal foi cadatrada com sucesso, altere os dados se achar necessário, salve e em seguida faça a transmissão!");
        
    }
    
    
    
    
    
    
    
  
    
    
    
    public function salvarDevolucao(Request $request){
        $id_nfe = $request->id_nfe;
        $req    = $request->except(["_token","_method","id_nfe"]);
    }
    
    
     
     public function calcularImpostos($id_venda){
         $venda              = Venda::find($id_venda);
         $natureza_operacao  = NaturezaOperacao::where("padrao", config('constantes.padrao_natureza.VENDA'))->first();
         $emitente           = Emitente::where("empresa_id", $venda->empresa_id)->first();
         
         $qtd                = 1;
         foreach($venda->itens as $i){
             $i->numero_item = $qtd++;
             $i->vFrete   = null;
             $i->vSeg     = null;
             $i->vDesc    = null;
             $i->vOutro   = null;
             
            
             ItemNotafiscalService::inserir($i, $natureza_operacao, $emitente );
         }
         
         exit();
         
     }
    
    
 }
