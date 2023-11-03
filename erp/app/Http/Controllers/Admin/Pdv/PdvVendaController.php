<?php

namespace App\Http\Controllers\Admin\Pdv;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\FormaPagto;
use App\Models\PdvCaixaNumero;
use App\Models\PdvVenda;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Models\Tributacao;
use App\Service\ConstanteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\MovimentoService;
use App\Models\Emitente;
use App\Models\NaturezaOperacao;
use App\Models\PdvDuplicata;
use App\Models\PdvItemVenda;
use App\Models\Venda;
use App\Models\PdvCaixa;
use App\Models\Nfce;
use App\Events\NotaFiscalEvent;

class PdvVendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id = null;
        
        $dados["status_financeiro"] = ConstanteService::listaStatusFinanceiro();
        $dados["status"]            = ConstanteService::listaStatusVenda();
        $dados["lista"]             = PdvVenda::filtro($filtro);
        $dados["filtro"]            = $filtro;
        $dados["naturezas"]         = NaturezaOperacao::where("tipo", "S")->get();
        
        return view("Admin.Pdv.Venda.Index", $dados);
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
        $dados["lista"]                 = PdvVenda::filtro($filtro);
        $dados["filtro"]                = $filtro;
        $dados["naturezas"]             = NaturezaOperacao::where("tipo", "S")->get();
        
        return view("Admin.Pdv.Venda.Index", $dados);
    }
    
    public function salvarNfcePorPdvVenda($id_venda, $natureza_id){
        try {
            $nfce       = Nfce::where("pdvvenda_id",$id_venda)->first();
           
            if($nfce){
                return redirect()->back()->with("janela_atencao1","Já existe uma Nota Fiscal vinculada a esta venda, para mais detalhes, entre no menu Nota Fiscal");
            }
            
            $natureza_operacao = NaturezaOperacao::find($natureza_id);
            if(!$natureza_operacao){
                return redirect()->route("admin.naturezaoperacao.index")->with("janela_atencao1","Não existe Natureza de Operação de venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFCE");
            }
            
            $tributacao         = Tributacao::where(["natureza_operacao_id" =>$natureza_operacao->id,"padrao"=>"S"])->first();
            if(!$tributacao){
                return redirect()->back()->with("janela_atencao1","Não existe uma Tributação de venda Padrão cadastrada, cadastre primeiramente pra poder salvar a NFCE");
            }
            
            $emitente = Emitente::where("empresa_id", Auth::user()->empresa_id)->first();
            if(!$emitente->cnpj){
                return redirect()->back()->with('janela_atencao1', "É necessário configurar o Emitente primeiramente.");
            }
            
            if(!$emitente->numero_serie_nfce || !$emitente->ultimo_numero_nfce){
                return redirect()->back()->with('janela_atencao1', "Configure a série e o último Número da NFE.");
            }
            
            $pdvvenda          = PdvVenda::find($id_venda);
            
            if($pdvvenda->status_id == config('constantes.status.DIGITACAO') ){
                return redirect()->back()->with('janela_atencao1', "Não é Possível gerar uma Nota de uma venda com status em Digitação.");
            }
            if(!$nfce){
                inserirNfcePelaPdvVenda($pdvvenda, $natureza_operacao, $tributacao);
                $nota = Nfce::where("pdvvenda_id", $pdvvenda->id)->first();
            }
           
            return redirect()->route("admin.notanfce.edit", $nota->id)->with("msg_sucesso","A Nota Fiscal foi cadatrada com sucesso, altere os dados se achar necessário, salve e em seguida faça a transmissão!");
            
        } catch (\Exception $e) {
            return redirect()->back()->with("msg_erro",$e->getMessage());
        }
        
    }
    public function create()
    {
        //Dados da Venda
        $empresa                    = auth()->user()->empresa;
        $dados["numeros"]           = PdvCaixaNumero::get();
        
        
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["tributacoes"]       = Tributacao::get();
        $dados["parametro"]         = $empresa->parametro;
        
        
        //Dados do Cliente
        $dados["clientes"]          = Cliente::get();
        $dados["parametro"]         = Auth::user()->empresa->parametro;
        $dados["produtos"]          = Produto::get();
        $dados["transportadoras"]   = Transportadora::get();
        
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["pdvVendaJs"]        = true;
        $dados["produtoJs"]         = true;
        
        
        return view("Admin.Pdv.Venda.Create", $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = $request->except(["_token","_method"]);
        Venda::Create($req);
        return redirect()->route('admin.pdvvenda.index')->with('msg_sucesso', "Inserido com sucesso.");
    }
    public function salvar(Request $request){
        $dados                      = $request->venda;
        $venda                      = new \stdClass();
        $venda->usuario_id          = auth()->user()->id ;
        $venda->caixa_id            = $dados["caixa_id"] ;
        $venda->desconto_valor      = $dados["desconto_valor"] != null ? getFloat($dados["desconto_valor"]) : 0;
        $venda->desconto_per        = $dados["desconto_per"] != null ? getFloat($dados["desconto_per"]) : 0;
        $venda->data_venda          = hoje();
        $venda->status_financeiro_id= config("constantes.status.ABERTO");
        $venda->status_id           = config("constantes.status.DIGITACAO");
        $itens                      = (object) $dados["itens"];
        
        $retorno  = new \stdClass();
        
        try {
            $vendaNova = PdvVenda::Create(objToArray($venda));
            if($vendaNova){
                foreach($itens as $i){
                    PdvItemVenda::create([
                        'venda_id'          => $vendaNova->id,
                        'produto_id'        => (int) $i['codigo'],
                        'qtde'              =>  getFloat($i['quantidade']),
                        'valor'             =>  getFloat($i['valor']),
                        'desconto_item'     =>  getFloat($i['desconto_item']),
                        'subtotal'          =>  getFloat($i['valor']) * getFloat($i['quantidade']),
                        'subtotal_liquido'  =>  (getFloat($i['valor']) - getFloat($i['desconto_item']))  * getFloat($i['quantidade']),
                    ]);
                }
                PdvVenda::somarTotal($vendaNova->id);
            }
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Venda Salva com Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/pdvvenda/edit",$vendaNova->id );
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
        $gerar_nota         = $request->gerar_nota ?? null;
        $natureza_operacao_id= $request->natureza_operacao_id ?? null;
        $pdvvenda           = PdvVenda::find($request->venda_id);
        $natureza           = NaturezaOperacao::find($natureza_operacao_id);
        
        $tributacao         = null;
        if($natureza){
            $tributacao         = Tributacao::where(["natureza_operacao_id" =>$natureza->id,"padrao"=>"S"])->first();
        }
        
        $retorno            = new \stdClass();
        $redirect           =  url("admin/pdvvenda");
        
        try {
            
            if($gerar_nota ){
                if(!$tributacao){
                    throw(new \Exception('Não existe nenhuma Tributação para a Geração da Nota Fiscal, por favor cadastre uma Tributação Padrão para a Natureza de Operação selecionada'));
                }
                $emitente = Emitente::where("empresa_id", $pdvvenda->empresa_id)->first();
                if(!$emitente->cnpj){
                    throw(new \Exception('Configure o Emitente para poder gerar a nota'));
                }
                if(!$emitente->numero_serie_nfce){
                    throw(new \Exception('Configure o Número de série para emissão da NFCE (configuração->emitente)'));
                }
                if(!$emitente->ultimo_numero_nfce){
                    throw(new \Exception('Configure a Numeração para emissão da NFCE (configuração->emitente)'));
                }
            }
            
            if($gera_estoque){
                $tipo_movimento = config("constantes.tipo_movimento.SAIDA_VENDA_PRODUTO");
                $descricao      = "Saida Venda - Lançamento Manual: #" . $pdvvenda->id;
                MovimentoService::lancarEstoqueDoPdv($pdvvenda->id, $tipo_movimento, $descricao);
            }
            
            if($gerar_nota){
                /*if($natureza && $tributacao){
                 event(new NotaFiscalEvent($venda, $natureza, $tributacao)) ;
                 $nota               = Nfe::where("venda_id", $venda->id)->first();
                 $redirect           =  url("admin/notafiscal/edit",$nota->id);
                 }*/
            }
            
            $pdvvenda->status_id   = config("constantes.status.CONCRETIZADO");
            $pdvvenda->save();
            
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Venda Salva com Sucesso";
            $retorno->redirect  = $redirect;
            $retorno->erro      = "";
            $retorno->retorno   = $pdvvenda;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Venda";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $venda                      = PdvVenda::find($id);
        $dados["venda"]             = $venda;
        $dados["cliente"]           = $venda->cliente;
        $dados["numeros"]           = PdvCaixaNumero::get();
        $dados["caixas"]            = PdvCaixa::where("caixanumero_id", $venda->caixa->caixanumero_id )->get();
        
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["clientes"]          = Cliente::get();
        $dados["itens"]             = PdvItemVenda::where("venda_id", $id)->get();
        $dados["duplicatas"]        = PdvDuplicata::where("venda_id", $id)->get();
        $dados["naturezas"]         = NaturezaOperacao::where("tipo", "S")->get();
        
        
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["pdvVendaEditJs"]    = true;
        $dados["categoriaJs"]       = true;
        
        return view("Admin.Pdv.Venda.Edit", $dados);
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
        //
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
            $h = Venda::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
