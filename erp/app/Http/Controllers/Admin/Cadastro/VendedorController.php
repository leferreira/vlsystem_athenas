<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\VendedorRequest;
use App\Models\Cliente;
use App\Models\FinContaReceber;
use App\Models\LojaPedido;
use App\Models\PdvVenda;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\Vendedor;
use App\Service\ConstanteService;
use App\Service\UtilService;
use Dompdf\Dompdf;
use Dompdf\Options;

class VendedorController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'vendedor';
    }
    
    public function index(){ 
        $this->checaPermissao(__FUNCTION__);
        $filtro                 = new \stdClass();
        $filtro->nome           = $_GET["nome"] ?? null;
        $filtro->email          = $_GET["email"] ?? null ;
        $filtro->cpf           = $_GET["cpf"] ?? null;
        
        $dados["lista"]         = Vendedor::filtro($filtro);
        $dados["filtro"]        = $filtro;
        return view("Admin.Cadastro.Vendedor.Index", $dados);
    }    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["vendedorJs"] = true;
        $dados["eh_modal"]  = 1;
        return view("Admin.Cadastro.Vendedor.Create", $dados);
    }    
    
    public function find($id){
        $vendedor = Vendedor::where('id', $id)->first();
        echo json_encode($vendedor);
    }
    
    public function movimento($id){
        $dados["vendedor"]   = Vendedor::find($id);
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusVenda(); 
        $dados["lista"]     = Venda::where("vendedor_id", $id)->get();  
        
        $dados["cliente"]       = Cliente::find($id);
        $dados["qtde_venda_erp"] = Venda::where("cliente_id", $id)->count("id");
        $dados["soma_venda_erp"] = Venda::where("cliente_id", $id)->sum("valor_liquido");
        
        $dados["qtde_venda_loja"] = LojaPedido::where("cliente_id", $id)->count("id");
        $dados["soma_venda_loja"] = LojaPedido::where("cliente_id", $id)->sum("valor_liquido");
        
        $dados["qtde_venda_pdv"] = PdvVenda::where("cliente_id", $id)->count("id");
        $dados["soma_venda_pdv"] = PdvVenda::where("cliente_id", $id)->sum("valor_liquido");
        
        $dados["total_recebimento"] = FinContaReceber::where("cliente_id", $id)->sum("total_recebido");
        $dados["total_a_pagar"]     = FinContaReceber::where("cliente_id", $id)->sum("total_liquido");
        
        $dados["produtos"]          = Produto::get();
        $dados["titulos_atraso"]    = FinContaReceber::get();
        $dados["titulos_aberto"]    = FinContaReceber::get();
        $dados["vendas_aberto"]    = Venda::get();                
        
        return view("Admin.Cadastro.Vendedor.Movimentos", $dados);
        
    }
    
    public function store(VendedorRequest $request){
        $retorno = new \stdClass();
        try {
            $req             = $request->except(["_token","_method","eh_modal"]);       
            $req["eh_modal"] = ($req["eh_modal"]) ?? 0;
            $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
            $req["cpf"]      = $req["cpf"] ? tira_mascara($req["cpf"]) : null;
            $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
            $req["comissao"] = ($req["comissao"]) ? getFloat($req["comissao"]) : 0;
            $req["password"] = md5($req["senha"]);
            $req["status_id"]= config("constantes.status.ATIVO");
         
            Vendedor::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno = Vendedor::get();
            if($request->eh_modal){
                $retorno->retorno  = Vendedor::get();
                return response()->json($retorno);
            }else{
                return redirect()->route('admin.vendedor.index')->with('msg_sucesso', "Vendedor Inserido com sucesso.");
            }
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            if($request->eh_modal){
                return response()->json($retorno);
            }else{
                return redirect()->back()->with('msg_erro', $e->getMessage());
            }
        }
    }
    
    public function show($id)
    {
        //
    }
    
    
    public function edit($id)
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["vendedor"]   = Vendedor::find($id);
        $dados["lista"]     = Vendedor::get();
        $dados["vendedorJs"] = true;
        $dados["eh_modal"]  = 1;
        return view('Admin.Cadastro.Vendedor.Create', $dados);
    }
    
    
    public function update(VendedorRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req             =   $request->except(["_token","_method","eh_modal"]);
        $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
        $req["cpf"]        = ($req["cpf"]) ? tira_mascara($req["cpf"]) : NULL;
        $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
        $req["password"] = md5($req["senha"]);
        $req["comissao"] = ($req["comissao"]) ? getFloat($req["comissao"]) : 0;
        Vendedor::where("id", $id)->update($req);
        return redirect()->route("admin.vendedor.index")->with('msg_sucesso', "Vendedor Alterado com sucesso.");
    }
    
    public function buscarCNPJ($cnpj){
        $empresa = UtilService::buscarCNPJ($cnpj);
        echo json_encode($empresa);
    }
    
    public function pesquisa(){
        $q          = $_GET["q"];
        $vendedors   = Vendedor::where("nome","like","%$q%")->get();
        
        return response()->json($vendedors);
    }
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Vendedor::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Vendedor Excluído com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
    
    public function pdf(){
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        
        $dados["dompdf"]     = $dompdf;
        
        $dados["lista"]      = Vendedor::get();
        return view('Admin.Pdf.Lista_Vendedor', $dados);
    }
}
