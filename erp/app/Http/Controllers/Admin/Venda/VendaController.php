<?php

namespace App\Http\Controllers\Admin\Venda;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Emitente;
use App\Models\FinContaPagar;
use App\Models\FinContaReceber;
use App\Models\FormaPagto;
use App\Models\ItemCompra;
use App\Models\ItemVenda;
use App\Models\NaturezaOperacao;
use App\Models\Nfe;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Models\Venda;
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
use Dompdf\Options;
use App\Models\User;
use App\Models\Duplicata;
use App\Service\MovimentoService;
use App\Models\Vendedor;
use App\Models\GradeProduto;
use App\Models\GradeMovimento;
use App\Models\TabelaPreco;

class VendaController extends Controller{    
    
    public function index(){      
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id = null;
        
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();            
        $dados["status"]                = ConstanteService::listaStatusVenda();            
        $dados["lista"]                 = Venda::filtro($filtro);
        $dados["filtro"]                = $filtro;
        $dados["naturezas"]             = NaturezaOperacao::where("tipo", "S")->get();
        
        return view("Admin.Venda.Venda.Index", $dados);   
        
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
        $dados["lista"]                 = Venda::filtro($filtro);
        $dados["filtro"]                = $filtro;
        $dados["naturezas"]             = NaturezaOperacao::where("tipo", "S")->get();
            
        return view("Admin.Venda.Venda.Index", $dados);
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
        
        return view("Admin.Venda.Venda.SelecionarRelatorioSintetico", $dados);
    }
    
    public function selecionarRelatorioAnalitico(){
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
        
        return view("Admin.Venda.Venda.SelecionarRelatorioAnalitico", $dados);
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
        
        $dados["lista"]                 = Venda::relatorio($filtro);      
        $dados["filtro"]                = $filtro;
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dados["dompdf"]     = $dompdf;
        
                
        return view("Admin.Pdf.Venda_Sintetica", $dados);
    }
    
    public function relatorioAnalitico(Request $request){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->usuario_id             = $_GET["usuario_id"] ?? null;
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? null;
        
        $dados["lista"]                 = Venda::relatorio($filtro);
        $dados["filtro"]                = $filtro;
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dados["dompdf"]     = $dompdf;
        
        
        return view("Admin.Pdf.Venda_Analitico", $dados);
    }
    
    public function imprimir(Request $request){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? null;        
        
        
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);        
        $dados["dompdf"]     = $dompdf;
        
        $dados["lista"]      = Cliente::get();
        
        $view = '';
        
        if($filtro->tipo_relatorio =="vendaPorMes"){
            $view ="Admin.Pdf.Venda_Mensal";            
        }else if($filtro->tipo_relatorio =="vendaDiaria"){
            $view ="Admin.Pdf.Venda_Diaria";            
        }else if($filtro->tipo_relatorio =="vendaResumo"){
            $view ="Admin.Pdf.Venda_Resumo";            
        }else if($filtro->tipo_relatorio =="vendaPorCliente"){
            $view ="Admin.Pdf.Lista_Cliente";            
        }
        
        return view($view, $dados);
    }
    
    public function create(){
       
        //Dados da Venda
        $empresa                    = auth()->user()->empresa;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["tributacoes"]       = Tributacao::get();
        $dados["precos"]            = TabelaPreco::get();
        $dados["parametro"]         = $empresa->parametro;
        
        
        //Dados do Cliente
        $dados["clientes"]          = Cliente::get();
        $dados["parametro"]         = Auth::user()->empresa->parametro;
        $dados["produtos"]          = Produto::get();
        $dados["transportadoras"]   = Transportadora::get();
        //$dados["natureza_operacao"] = NaturezaOperacao::where("padrao", config('constantes.padrao_natureza.VENDA'))->first();      
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["vendaJs"]           = true;    
        $dados["clienteJs"]         = true;
        $dados["vendedorJs"]        = true;
        $dados["categoriaJs"]       = true;
        $dados["produtoJs"]         = true;
       
      
        return view("Admin.Venda.Venda.Create", $dados);
    }    
    
    public function edit($id){
        $venda             = Venda::find($id);       
        
        if($venda->status_id != config("constantes.status.DIGITACAO")){
            return redirect()->route("admin.venda.detalhe", $id)->with('msg_erro', "Essa venda não pode mais ser alterada.");
        }
        
              
        $dados["venda"]             = $venda;  
        $dados["cliente"]           = $venda->cliente;
        $dados["vendedor"]          = $venda->vendedor;
        $dados["precos"]            = TabelaPreco::get();
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["clientes"]          = Cliente::get();
        $dados["itens"]             = ItemVenda::where("venda_id", $id)->get();
        $dados["duplicatas"]        = Duplicata::where("venda_id", $id)->get();
        $dados["naturezas"]         = NaturezaOperacao::where("tipo", "S")->get();
        $dados["vendedores"]        = Vendedor::all();
        
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["vendaEditJs"]       = true;
        $dados["gradeJs"]           = true;
        $dados["clienteJs"]         = true;
        $dados["vendedorJs"]        = true;
        $dados["categoriaJs"]       = true;
        
        return view("Admin.Venda.Venda.Edit", $dados);
    }
    
    public function salvar(Request $request){
        $retorno  = new \stdClass();  
        
        try {
            $item                       = (object) $request->itens[0];
            
            $venda                      = new \stdClass();
            $venda->usuario_id          = auth()->user()->id;
            $venda->cliente_id          = $request->cliente_id ;
            $venda->vendedor_id         = $request->vendedor_id ;
            $venda->tabela_preco_id     = $request->tabela_preco_id ;
            $venda->valor_frete         = 0;
            $venda->total_seguro        = 0;
            $venda->despesas_outras     = 0;
            $venda->desconto_valor      = 0;
            $venda->desconto_per        = 0;
            $venda->data_venda          = hoje();            
            $vendaNova = Venda::Create(objToArray($venda));  
            if($vendaNova){                 
                $item->venda_id = $vendaNova->id;
                ItemVendaService::inserirItem($item);
            }
           
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Venda Salva com Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/venda/edit",$vendaNova->id ); 
            $retorno->retorno   = $vendaNova->id;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Venda";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function finalizarVenda(Request $request){
        $gera_estoque       = $request->gerar_estoque ?? null;
        $gerar_financeiro   = $request->gerar_financeiro ?? null;
        $gerar_nota         = $request->gerar_nota ?? null;
        $natureza_operacao_id= $request->natureza_operacao_id ?? null;
        $venda              = Venda::find($request->venda_id);
        $natureza           = NaturezaOperacao::find($natureza_operacao_id);
        $soma_duplicata     = Duplicata::where("venda_id", $venda->id)->sum("vDup");
        
       
        
        
        $tributacao         = null;
        if($natureza){
            $tributacao         = Tributacao::where(["natureza_operacao_id" =>$natureza->id,"padrao"=>"S"])->first();
        }
        
        $retorno            = new \stdClass();
        $redirect           =  url("admin/venda");
   
        try {
            
            //verifica a grade
            foreach($venda->itens as $item){
                if($item->produto->usa_grade=="S"){
                    if(!validarGrade($item->quantidade,"item_venda_id", $item->id)){
                        throw(new \Exception('O item ' . $item->produto->nome . ' usa grade e as quantidades da grade não correspondem com quantidade de Saída, clique no link ajustar grade e insira as respectivas quantidade.'));
                    }
                }
            }
            
            //verifica a grade
            foreach($venda->itens as $item){
                if($item->produto->usa_grade=="S"){
                    if(!validarGrade($item->quantidade,"item_venda_id", $item->id)){
                        throw(new \Exception('O item ' . $item->produto->nome . ' usa grade e as quantidades da grade não correspondem com quantidade de entrada, por favor verifique.'));
                    }
                }
            } 
            
            if($gerar_financeiro ){
                if($soma_duplicata <=0){
                    throw(new \Exception('Para gerar financeiro é necessário definir os dados da cobrança'));
                }
                
                if($soma_duplicata != $venda->valor_liquido ){
                    throw(new \Exception('O valor total da venda está diferente do valor total das cobranças'));
                }
            }
            
            if($gerar_nota ){
                if(!$tributacao){
                    throw(new \Exception('Não existe nenhuma Tributação para a Geração da Nota Fiscal, por favor cadastre uma Tributação Padrão para a Natureza de Operação selecionada'));
                }
                $emitente = Emitente::where("empresa_id", $venda->empresa_id)->first();
                if(!$emitente->cnpj){
                    throw(new \Exception('Configure o Emitente para poder gerar a nota'));
                }
                if(!$emitente->numero_serie_nfe){
                    throw(new \Exception('Configure o Número de série para emissão da NFE (configuração->emitente)'));
                }
                if(!$emitente->ultimo_numero_nfe){
                    throw(new \Exception('Configure a Numeração para emissão da NFE (configuração->emitente)'));
                }
            }            
            
            if($gera_estoque){
                ItemVendaService::gerarEstoqueDaVenda($venda);
            }
            
            if($gerar_financeiro){
                ContaReceberSevice::salvarContaReceberPelaVenda($venda);
            }
            
            if($gerar_nota){
                if($natureza && $tributacao){
                    event(new NotaFiscalEvent($venda, $natureza, $tributacao)) ;
                    $nota               = Nfe::where("venda_id", $venda->id)->first();
                    $redirect           =  url("admin/notafiscal/edit",$nota->id);
                }
            }
            
            $venda->status_id   = config("constantes.status.CONCRETIZADO");
            $venda->cliente_id  = $request->cliente_id;
            $venda->vendedor_id = $request->vendedor_id;
            $venda->save();            
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Venda Salva com Sucesso";
            $retorno->redirect  = $redirect;
            $retorno->erro      = "";
            $retorno->retorno   = $venda;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Venda";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function atualizarDadosPagamentos(Request $request){
        $dados                          = $request->except(["_token","_method"]);
        $venda_id                       = $request->venda_id;
        $retorno                        = new \stdClass();
        try {         
            
            
            $venda                      = Venda::find($venda_id);
            $venda->valor_frete         = $dados["valor_frete"] != null ? getFloat($dados["valor_frete"]) : 0;
            $venda->total_seguro        = $dados["total_seguro"] != null ? getFloat($dados["total_seguro"]) : 0;
            $venda->despesas_outras     = $dados["despesas_outras"] != null ? getFloat($dados["despesas_outras"]) : 0;           
            $venda->desconto_valor      = $dados["desconto_valor"] != null ? getFloat($dados["desconto_valor"]) : 0;
            $venda->desconto_per        = $dados["desconto_per"] != null ? getFloat($dados["desconto_per"]) : 0;
            $venda->vendedor_id         = $dados["vendedor_id"] ;
            $venda->save();
            
            Venda::somarTotal($venda_id);
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }

    public function buscar($id){
        $retorno = new \stdClass();
        try {
            $venda            = Venda::find($id);          
            if(!$venda){
                $retorno->tem_erro  = true;
                $retorno->erro      = "Produto não encontrado";
                return response()->json($retorno);
            }else{
                $retorno->tem_erro  = false;
                $retorno->erro      = "";
                $retorno->retorno   = $venda;
                return response()->json($retorno);
            }
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            $retorno->retorno   = "";
            return response()->json($retorno);
        }
        
    }
    
    public function financeiro($id)
    {
        
        $dados["venda"]   = Venda::find($id);
        $dados["lista"]   = FinContaReceber::where("venda_id", $id)->get();
        return view("Admin.Venda.Venda.Financeiro", $dados);
    }
    
    public function detalhe($id){
        $venda                      = Venda::find($id);        
        $dados["venda"]             = $venda;
        $dados["cliente"]           = $venda->cliente;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["clientes"]          = Cliente::get();
        $dados["itens"]             = ItemVenda::where("venda_id", $id)->get();
        $dados["duplicatas"]        = Duplicata::where("venda_id", $id)->get();
        $dados["naturezas"]         = NaturezaOperacao::where("tipo", "S")->get();
        
        return view("Admin.Venda.Venda.Show", $dados);
    }

    
    
    
    public function gerarNfePelaVenda($id){   
        $retorno            = new \stdClass();
        try{
            $venda          = Venda::find($id);  
            $dadosNfe       = VendaService::getDadosParaGerarNfe($venda);           
            $validacaoNfe   = ValidacaoNfeService::dadosNFe($dadosNfe->nfe);
            
            if($validacaoNfe!= ""){
                $retorno->tem_erro  = true;
                $retorno->titulo    = "Erro ao Inserir NFCE";
                $retorno->erro      = $validacaoNfe;
                return response()->json($retorno);
            }       
           
            $validaItensNfe     = ValidacaoNfeService::dadosItemNfe($dadosNfe->itens);
            if($validaItensNfe!= ""){
                $retorno->tem_erro  = true;
                $retorno->titulo    = "Erro ao Inserir Item da NFE";
                $retorno->erro      = $validaItensNfe;
                return response()->json($retorno);
            }
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Inserir NFE";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }       
        
        $nfe  = Nfe::where("venda_id",$id)->first(); 
      
        if(!$nfe){
            $id_nfe =Venda::inserirNfePelaVenda($venda);
        }else{
            if($nfe->status_id != config("constantes.status.AUTORIZADO")){
                NotaFiscalService::excluirNfe($nfe->id);
                $id_nfe = Venda::inserirNfePelaVenda($venda);               
                $nfe    = Nfe::where("id",$id_nfe)->first();
            }            
        }       
    
        $url         = getenv("APP_URL_API"). "nfe/transmitirPelaNfe/".$id_nfe;
        $resultado   = enviarGetCurl($url);
        return response()->json($resultado);
        
    }
    
   
    public function salvar_e_transmitir($id){
        $retorno        = new \stdClass();
        try{
            $venda          = Venda::find($id);
            $dadosNfe       = VendaService::getDadosParaGerarNfe($venda);
            $validacaoNfe   = ValidacaoNfeService::dadosNFe($dadosNfe->nfe);
            
            if($validacaoNfe!= ""){
                $retorno->tem_erro  = true;
                $retorno->titulo    = "Erro ao Inserir NFE";
                $retorno->erro      = $validacaoNfe;
                echo json_encode($retorno);
                exit;
            }
            
            $validaItensNfe     = ValidacaoNfeService::dadosItemNfe($dadosNfe->itens);
            if($validaItensNfe!= ""){
                $retorno->tem_erro  = true;
                $retorno->titulo    = "Erro ao Inserir Item da NFE";
                $retorno->erro      = $validaItensNfe;
                echo json_encode($retorno);
                exit;
            }
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Inserir NFE";
            $retorno->erro      = $e->getMessage();
            echo json_encode($retorno);
        }
        
        $nfe    = Nfe::where("venda_id",$id)->first();
        
        if(!$nfe){
            $id_nfe =Venda::inserirNfePelaVenda($venda);
        }else{
            if($nfe->status_id != config("constantes.status.AUTORIZADO")){
                NotaFiscalService::excluirNfe($nfe->id);
                $id_nfe = Venda::inserirNfePelaVenda($venda);
                $nfe    = Nfe::where("id",$id_nfe)->first();
            }
        }
        
        $url         = getenv("APP_URL_API"). "nfe/transmitirPelaNfe/".$id_nfe;
        $resultado   = enviarGetCurl($url);
        return response()->json($resultado);
               
    }
       
    
    public function pdf($id){ 
        $venda = Venda::find($id);
        
        $p = view('Admin.Venda.Venda.RelatorioVenda')->with('venda', $venda);
        
		//return $p;
        $domPdf = new Dompdf(["enable_remote" => true]);
        $domPdf->loadHtml($p);
        
        $pdf = ob_get_clean();
        
        $domPdf->setPaper("A4");
        $domPdf->render();
        $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
        //$domPdf->stream("relatorio de venda $venda->id.pdf");
        
    }
    
    public function cupom($id){
        $venda = Venda::find($id);
        
        $p = view('Admin.Venda.Venda.Cupom')->with('venda', $venda);
        
		//return $p;
        $domPdf = new Dompdf(["enable_remote" => true]);
        $domPdf->loadHtml($p);
        
        $pdf = ob_get_clean();
        
        $domPdf->setPaper("A4");
        $domPdf->render();
        $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
      //  $domPdf->stream("relatorio de venda $venda->id.pdf");
        
    }
    
    public function buscarNfcePelaVenda($id_venda){
        $nfe         = Nfe::where("venda_id", $id_venda)->where("status_id",config("constantes.status.AUTORIZADO"))->first();
        if($nfe){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
    
    
    
    public function emitirEntrada($id){
        $dados["venda"]             = Compra::find($id); 
        $dados["naturezas"]          = NaturezaOperacao::all();
        $dados["tiposPagamento"]     = Compra::tiposPagamento();
        return view("Admin.Compra.Compra.EmitirEntrada", $dados);
    }
    
    public function clonarVenda($id_venda){
        $venda                      = Venda::find($id_venda);
        $nova_venda                 = $venda->replicate();
        $nova_venda->nfe_id         = null;
        $nova_venda->data_venda     = hoje();
        $nova_venda->status_id      = config("constantes.status.DIGITACAO");
        $nova_venda->xml_path       = null;
        $nova_venda->chave          = null;
        $nova_venda->numero_emissao = null;
        $nova_venda->status_financeiro_id  = config("constantes.status.DIGITACAO");       
        $nova_venda->save();
        
        $v                      = Venda::find($nova_venda->id);
        $v->status_id           = config("constantes.status.DIGITACAO");
        $v->status_financeiro_id  = config("constantes.status.DIGITACAO");
        $v->save();        

        foreach($venda->itens as $i){
            $novo_item              = $i->replicate();
            $novo_item->venda_id    = $nova_venda->id;           
            $novo_item->save();
        }
        
        foreach($venda->duplicatas as $d){
            $novo_item              = $d->replicate();
            $novo_item->venda_id    = $nova_venda->id;
            $novo_item->save();
        }
        
        return redirect()->route("admin.venda.edit", $nova_venda->id)->with('msg_sucesso', "Venda clonada com sucesso, faça as alterações necessárias");
    }
    
    public function excluir($id){        
        try{
            VendaService::cancelarVenda($id);;
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
    

    
    public function lancarEstoque($id_venda){
        $venda          = Venda::find($id_venda);        
        if($venda->status_id != config('constantes.status.CONCRETIZADO') ){
            return redirect()->back()->with('janela_atencao1', "Você só pode Lançar ou Estornar Estoque para vendas com status concretizada.");
        }
        
        $tipo_movimento = config("constantes.tipo_movimento.SAIDA_VENDA_PRODUTO");
        $descricao = "Saida Venda - Lançamento Manual: #" . $id_venda;        
        MovimentoService::lancarEstoqueDaVenda($id_venda, $tipo_movimento, $descricao);
                 
        return redirect()->back()->with('msg_sucesso', "Operação realizada com sucesso.");
    }
    
    public function estornarEstoque($id_venda){ 
        $venda          = Venda::find($id_venda);
        if($venda->status_id != config('constantes.status.CONCRETIZADO') ){
            return redirect()->back()->with('janela_atencao1', "Você só pode Lançar ou Estornar Estoque para vendas com status concretizada.");
        }
        
        $tipo       = config("constantes.tipo_movimento.ENTRADA_ESTORNO_MANUAL");
        $descricao  = "Estorno Manual da Venda: #" . $id_venda; 
        MovimentoService::estornarEstoqueDaVenda($id_venda, $tipo, $descricao);      
        VendaService::retornarEdicao($id_venda);
        return redirect()->back()->with('msg_sucesso', "Operação realizada com sucesso.");
    }
    
    public function estornarContaReceber($id_venda){
        $venda          = Venda::find($id_venda);
        if($venda->status_id != config('constantes.status.CONCRETIZADO') ){
            return redirect()->back()->with('janela_atencao1', "Você só pode Lançar ou Estornar Estoque para vendas com status concretizada.");
        }        
        ContaReceberSevice::estornarContaReceber($id_venda);
        VendaService::retornarEdicao($id_venda);
        return redirect()->back()->with('msg_sucesso', "Operação realizada com sucesso.");
    }
    
    public function salvarNfFiscal(Request $request){
        $nf     = $request->nf;    
        $itens = $request->itens;
        $fatura = $request->fatura;
       
    
        $venda = Compra::create([
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
        if($venda->id){
            foreach($itens as $prod){
                $produto = Produto::where("id", (int) $prod['produto_id'])->first();
                
                ItemCompra::create([
                    'venda_id'     => $venda->id,
                    'produto_id'    => (int) $prod['produto_id'],
                    'quantidade'    =>  str_replace(",", ".", $prod['quantidade']),
                    'valor_unitario'=> str_replace(",", ".", $prod['valor']),
                    'unidade_venda'=> $prod['unidade'],
                    'cfop_entrada'  => $prod['cfop_entrada']
                ]);
                
                $valor = $produto->valor_venda > 0 ? $produto->valor_venda : $prod['valor'];
                EstoqueService::pluStock($produto->id, str_replace(",", ".", $prod['quantidade']) * $produto->conversao_unitaria, str_replace(",", ".", $valor));
            }
        }
        
        if($venda->id){
            foreach($fatura as $parcela){
                $valorParcela = str_replace(".", "", $parcela['valor_parcela']);
                $valorParcela = str_replace(",", ".", $valorParcela);
                $valorParcela = str_replace(" ", "", $valorParcela);                
                FinContaPagar::create([
                    'venda_id'        => $venda->id,
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
