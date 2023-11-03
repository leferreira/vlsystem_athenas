<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Models\EnderecoCliente;
use App\Service\UtilService;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Venda;
use App\Models\LojaPedido;
use App\Models\PdvVenda;
use App\Models\FinContaReceber;
use App\Models\Produto;

class ClienteController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'cliente';
    }
    
    public function index(){ 
        $this->checaPermissao(__FUNCTION__);
        $filtro                 = new \stdClass();
        $filtro->nome           = $_GET["nome"] ?? null;
        $filtro->email          = $_GET["email"] ?? null ;
        $filtro->cpf            = $_GET["cpf"] ?? null;
        $filtro->tipo_cliente   = $_GET["tipo_cliente"] ?? null;
       
        $dados["lista"]                 = Cliente::filtro($filtro,30);
        $dados["filtro"]                = $filtro;   
        return view("Admin.Cadastro.Cliente.Index", $dados);
    }    
    
    public function create()
    {
        
        $this->checaPermissao(__FUNCTION__);
        $dados["clienteJs"] = true;
        $dados["eh_modal"]  = 1;
        return view("Admin.Cadastro.Cliente.Create", $dados);
    }    
    
    public function find($id){
        $cliente = Cliente::where('id', $id)->first();
        echo json_encode($cliente);
    }
    
    public function movimento($id){        
        $dados["cliente"]               = Cliente::find($id);   
        $dados["qtde_venda_erp"]        = Venda::where(["cliente_id" => $id,"status_id"=>config("constantes.status.CONCRETIZADO")])->count("id");
        $dados["soma_venda_erp_pago"]   = Venda::where(["cliente_id" =>$id,"status_financeiro_id"=>config("constantes.status.PAGO")])->sum("valor_liquido");
        $dados["soma_venda_erp_aberto"] = Venda::where(["cliente_id" =>$id,"status_financeiro_id"=>config("constantes.status.ABERTO")])->sum("valor_liquido");
        
        $dados["qtde_venda_loja"] = LojaPedido::where("cliente_id", $id)->count("id");
        $dados["soma_venda_loja"] = LojaPedido::where("cliente_id", $id)->sum("valor_liquido");
        
        $dados["qtde_venda_pdv"] = PdvVenda::where("cliente_id", $id)->count("id");
        $dados["soma_venda_pdv"] = PdvVenda::where("cliente_id", $id)->sum("valor_liquido");
        
        $dados["total_geral"]       = FinContaReceber::where("cliente_id", $id)->sum("total_liquido");
        $dados["total_pago"]        = FinContaReceber::where("cliente_id", $id)->sum("total_recebido");
        $dados["total_aberto"]      = FinContaReceber::where(["cliente_id" =>$id, "status_id"=>config("constantes.status.ABERTO")])->sum("total_liquido");
        $dados["total_atrasado"]    = FinContaReceber::where(["cliente_id" =>$id, "status_id"=>config("constantes.status.ABERTO")])->where("data_vencimento","<", hoje() )->sum("total_liquido");
        
        
        
        
        $dados["total_a_pagar"]     = FinContaReceber::where("cliente_id", $id)->sum("total_liquido");  
        $dados["total_recebimento"] = FinContaReceber::where("cliente_id", $id)->sum("total_recebido");
        
        $dados["produtos"]          = Produto::get();
        $dados["titulos_atraso"]    = FinContaReceber::where(["cliente_id" =>$id, "status_id"=>config("constantes.status.ABERTO")])->where("data_vencimento","<", hoje() )->get();
        
        $dados["titulos_aberto"]    = FinContaReceber::where(["cliente_id" =>$id, "status_id"=>config("constantes.status.ABERTO")])->get();
        $dados["vendas_aberto"]     = Venda::where(["cliente_id" =>$id,"status_financeiro_id"=>config("constantes.status.ABERTO")])->get();
        
        return view("Admin.Cadastro.Cliente.Movimentos", $dados);
    }
    
    public function vendasPaga($id){
        $dados["lista"]     = Venda::where(["cliente_id" =>$id,"status_financeiro_id"=>config("constantes.status.PAGO")])->get();
        $dados["cliente"]   = Cliente::find($id);
        return view("Admin.Cadastro.Cliente.Vendas", $dados);
    }
    
    public function vendasAberto($id){
        $dados["lista"]     = Venda::where(["cliente_id" =>$id,"status_financeiro_id"=>config("constantes.status.ABERTO")])->get();
        $dados["cliente"]   = Cliente::find($id);
        return view("Admin.Cadastro.Cliente.Vendas", $dados);
    }
    public function endereco($id){
        $dados["lista"]     = EnderecoCliente::where("cliente_id", $id)->get();
        $dados["cliente"]  = Cliente::find($id);
        return view("Admin.Cadastro.Cliente.Endereco", $dados);
    }
    public function store(ClienteRequest $request){
        $this->checaPermissao(__FUNCTION__);
        $retorno = new \stdClass();
        try {
            $req             = $request->except(["_token","_method","eh_modal"]);       
            $req["eh_modal"] = ($req["eh_modal"]) ?? 0;
            $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
            $req["cpf_cnpj"] = tira_mascara($req["cpf_cnpj"]);
            $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
            $req["password"] = md5($req["senha"]);
            $req["status_id"]= config("constantes.status.ATIVO");
            
            $req["limite_credito"]  = ($req["limite_credito"]) ? getFloat($req["limite_credito"]) : 0;
            $req["credito_utilizado"]  =  0;
            $req["credito_disponivel"]  =  $req["limite_credito"];
            $req["credito_devolucao"]  =  0;
         
            Cliente::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            if($req["eh_modal"]){
                return response()->json($retorno);
            }else{
                return redirect()->route('admin.cliente.index')->with('msg_sucesso', "Cliente Inserido com sucesso.");
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
        $dados["cliente"]   = Cliente::find($id);
        $dados["lista"]     = Cliente::get();
        $dados["clienteJs"] = true;
        $dados["eh_modal"]  = 1;
        return view('Admin.Cadastro.Cliente.Edit', $dados);
    }
    
    
    public function update(ClienteRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req             =   $request->except(["_token","_method","eh_modal"]);
        $req["telefone"] = ($req["telefone"]) ? tira_mascara($req["telefone"]) : NULL;
        $req["cpf_cnpj"] = tira_mascara($req["cpf_cnpj"]);
        $req["celular"]  = ($req["celular"]) ? tira_mascara($req["celular"]) : NULL;
        $req["password"] = md5($req["senha"]);
        
        $req["limite_credito"]      = ($req["limite_credito"]) ? getFloat($req["limite_credito"]) : 0;
     
        Cliente::where("id", $id)->update($req);
        return redirect()->route("admin.cliente.index")->with('msg_sucesso', "Cliente Alterado com sucesso.");
    }
    
    public function buscarCNPJ($cnpj){
        $empresa = UtilService::buscarCNPJ($cnpj);
        echo json_encode($empresa);
    }
    
    public function pesquisa(){
        $q          = $_GET["q"];
        $clientes   = Cliente::where("eh_consumidor",null)->where("nome_razao_social","like","%$q%")->get();        
        return response()->json($clientes);
    }
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Cliente::find($id);
            if($h->eh_consumidor=="S"){
                throw new \Exception("Não é possível excluir o cliente Consumidor");
            }else{
                $h->delete();
            }
            
            return redirect()->back()->with('msg_sucesso', "Cliente Excluído com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            $msg = $e->getMessage();
            if($cod =="23000"){
                $msg = "Não é possível excluir este item para garantir a integridade dos dados";
            }
            return redirect()->back()->with('msg_erro', "erro: " . $msg );
        }
    }
    
    public function pdf(){
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        
        $dados["dompdf"]     = $dompdf;
        
        $dados["lista"]      = Cliente::get();
        return view('Admin.Pdf.Lista_Cliente', $dados);
    }
}
