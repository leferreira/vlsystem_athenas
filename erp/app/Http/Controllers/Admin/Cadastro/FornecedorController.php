<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\FornecedorRequest;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\FinContaReceber;
use App\Models\Fornecedor;
use App\Models\LojaPedido;
use App\Models\PdvVenda;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\Vendedor;
use App\Service\ConstanteService;
use App\Service\UtilService;
use Dompdf\Dompdf;
use Dompdf\Options;

class FornecedorController extends Controller
{    
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'fornecedor';
    }
    
    public function index(){ 
        $this->checaPermissao(__FUNCTION__);
        $filtro                 = new \stdClass();
        $filtro->nome           = $_GET["nome"] ?? null;
        $filtro->email          = $_GET["email"] ?? null ;
        $filtro->cnpj           = $_GET["cnpj"] ?? null;
        
        $dados["lista"]                 = Fornecedor::filtro($filtro);
        $dados["filtro"]                = $filtro;  
        return view("Admin.Cadastro.Fornecedor.Index", $dados);
    }    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["fornecedorJs"] = true;
        return view("Admin.Cadastro.Fornecedor.Create", $dados);
    }    
    
    public function movimento($id){       
        $dados["fornecedor"]     = Fornecedor::find($id);
        $dados["lista"]          = Compra::where("fornecedor_id", $id)->get();
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
        
        return view("Admin.Cadastro.Fornecedor.Movimentos", $dados);
    }
    
    public function find($id){
        $fornecedor = Fornecedor::where('id', $id)->first();
        echo json_encode($fornecedor);
    }
    
    public function store(FornecedorRequest $request){
        $this->checaPermissao(__FUNCTION__);
        $retorno = new \stdClass();
        try {
            $req             = $request->except(["_token","_method","eh_modal","tipo_cliente"]);         
            $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
            $req["cnpj"]     = tira_mascara($req["cnpj"]);
            $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
            
            Fornecedor::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            if(isset($request->eh_modal)){
                return response()->json($retorno);
            }else{
                return redirect()->route('admin.fornecedor.index')->with('msg_sucesso', "Cliente Inserido com sucesso.");
            }
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            if($req["eh_modal"]){
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
        $dados["fornecedor"]     = Fornecedor::find($id);
        $dados["lista"]          = Fornecedor::get();
        $dados["fornecedorJs"] = true;
        return view('Admin.Cadastro.Fornecedor.Create', $dados);
    }
    
    
    public function update(FornecedorRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req                =   $request->except(["_token","_method","tipo_cliente"]);
        $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
        $req["cnpj"]     = tira_mascara($req["cnpj"]);
        $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
        Fornecedor::where("id", $id)->update($req);
        return redirect()->route("admin.fornecedor.index")->with('msg_sucesso', "Fornecedor Alterado com sucesso.");
    }
    
    public function buscarCNPJ($cnpj){        
        $empresa = UtilService::buscarCNPJ($cnpj);               
        echo json_encode($empresa);
    }
    
    public function pesquisa(){
        $q          = $_GET["q"];
        $lista   = Fornecedor::where("razao_social","like","%$q%")->get();
        
        return response()->json($lista);
    }
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Fornecedor::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Fornecedor Excluído com sucesso.");
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
        
        $dados["lista"]      = Fornecedor::get();
        return view('Admin.Pdf.Lista_Fornecedor', $dados);
    }
}
