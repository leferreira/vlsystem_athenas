<?php

namespace App\Http\Controllers\Admin\OrdemServico;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Emitente;
use App\Models\FinContaPagar;
use App\Models\FinContaReceber;
use App\Models\FormaPagto;
use App\Models\ItemCompra;
use App\Models\ItemOrdemServico;
use App\Models\NaturezaOperacao;
use App\Models\Nfe;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Models\OrdemServico;
use App\Service\ConstanteService;
use App\Service\ContaReceberSevice;
use App\Service\EstoqueService;
use App\Service\ItemOrdemServicoService;
use App\Service\NotaFiscalService;
use App\Service\UsuarioService;
use App\Service\ValidacaoNfeService;
use App\Service\OrdemServicoService;
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
use App\Models\OrdemCompra;
use App\Models\Status;
use App\Models\Tecnico;
use App\Models\TermoGarantia;
use App\Models\ProdutoOs;
use App\Models\ServicoOs;
use App\Models\AnotacaoOs;
use App\Models\Equipamento;

class OrdemServicoController extends Controller{    
    
    public function index(){      
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id = null;
        
        $dados["lista"]                 = OrdemServico::get();
        $dados["status"]                = Status::get();
        $dados["status_financeiro"]     = Status::get();
        ;
        $dados["filtro"]                = $filtro;
        $dados["naturezas"]             = NaturezaOperacao::where("tipo", "S")->get();
        
        return view("Admin.OrdemServico.OrdemServico.Index", $dados);   
        
    }
    
    public function filtro(){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;

        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusOrdemServico();  
        $dados["lista"]                 = OrdemServico::filtro($filtro);
        $dados["filtro"]                = $filtro;
        $dados["naturezas"]             = NaturezaOperacao::where("tipo", "S")->get();
            
        return view("Admin.OrdemServico.OrdemServico.Index", $dados);
    }
 
    
    
    public function create(){
       
        //Dados da OrdemServico
        $empresa                    = auth()->user()->empresa;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["tributacoes"]       = Tributacao::get();
        $dados["parametro"]         = $empresa->parametro;
        
        
        //Dados do Cliente
        $dados["clientes"]          = Cliente::get();
        $dados["produtos"]          = Produto::get();
        $dados["equipamentos"]      = array();
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["vendedores"]        = Vendedor::all();
        
        $dados["tecnicos"]          = Tecnico::get();
        $dados["termos"]            = TermoGarantia::get();
        $dados["vendedores"]        = Vendedor::get();
        $dados["osJs"]              = true;
        $dados["clienteJs"]         = true;
        $dados["tecnicoJs"]         = true;
        $dados["vendedorJs"]        = true;
        $dados["equipamentoJs"]     = true;
      
        return view("Admin.OrdemServico.OrdemServico.Create", $dados);
    }    
    
    public function edit($id){
        $ordemServico             = OrdemServico::find($id);       
        
        if($ordemServico->status_id != config("constantes.status.DIGITACAO")){
            return redirect()->route("admin.venda.detalhe", $id)->with('msg_erro', "Essa venda não pode mais ser alterada.");
        }
        
              
        $dados["ordemservico"]     = $ordemServico;  
        $dados["cliente"]           = $ordemServico->cliente;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["clientes"]          = Cliente::get();
        $dados["produtos"]          = ProdutoOs::where("os_id", $id)->get();
        $dados["servicos"]          = ServicoOs::where("os_id", $id)->get();
        $dados["anotacoes"]         = AnotacaoOs::where("os_id", $id)->get();
        $dados["vendedores"]        = Vendedor::all();       
        
        $dados["equipamentos"]      = Equipamento::where("cliente_id",$ordemServico->cliente->id )->get();
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["vendedores"]        = Vendedor::all();
        
        $dados["tecnicos"]          = Tecnico::get();
        $dados["termos"]            = TermoGarantia::get();
        $dados["vendedores"]        = Vendedor::get();
        $dados["osEditJs"]              = true;
        $dados["clienteJs"]         = true;
        $dados["tecnicoJs"]         = true;
        $dados["vendedorJs"]        = true;
        $dados["equipamentoJs"]     = true;
        $dados["servicoJs"]         = true;
        $dados["produtoJs"]         = true;
        
        return view("Admin.OrdemServico.OrdemServico.Edit", $dados);
    }
    
    public function store(Request $request){
        $req = $request->except(["_token","_method"]);
        
        try {
            $req["usuario_id"]  = auth()->user()->id;
            $req["status_id"]   = config('constantes.status.DIGITACAO');
            $req["status_financeiro_id"]   = config('constantes.status.ABERTO');
            
            $req["valor_total_produto"] = 0;
            $req["valor_total_servico"] = 0;
            $req["valor_desconto"]      = 0;
            $req["valor_liquido"]       = 0;
            $req["desconto_valor"]      = 0;
            $req["desconto_per"]        = 0;
            $req["valor_os"]            = 0;
            $req["taxa_diversa"]        = 0;
            
            $ordem_servico = OrdemServico::Create($req);            
            return redirect()->route('admin.ordemservico.edit', $ordem_servico->id)->with('msg_sucesso', "Inserido com sucesso.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
     }

     public function update(Request $request, $id)
     {
         
         $req     =   $request->except(["_token","_method"]);
         OrdemServico::where("id", $id)->update($req);
         return redirect()->route("admin.ordemservico.edit", $id)->with('msg_sucesso', "item alterado com sucesso.");;
     }
    
   
    
}
