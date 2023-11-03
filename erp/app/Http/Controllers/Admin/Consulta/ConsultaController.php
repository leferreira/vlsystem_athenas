<?php

namespace App\Http\Controllers\Admin\Consulta;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\Categoria;
use App\Models\ClassificacaoFinanceira;
use App\Models\Cliente;
use App\Models\ContaCorrente;
use App\Models\FinContaPagar;
use App\Models\FinContaReceber;
use App\Models\Fornecedor;
use App\Models\LojaPedido;
use App\Models\MovimentoConta;
use App\Models\PdvVenda;
use App\Models\Produto;
use App\Models\Status;
use App\Models\User;
use App\Models\Venda;
use App\Models\Vendedor;
use App\Service\ConstanteService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use App\Models\FinRecebimento;
use App\Models\FinPagamento;
use App\Models\Movimento;

class ConsultaController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'produto';
    }
    
   
    public function produto(Request $request){
        $dados["usuario"]   = auth()->user();  
        $filtro = new \stdClass();
        $filtro->campo                  = $_GET["campo"] ?? null;
        $filtro->valor                  = $_GET["valor"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->operador               = $_GET["operador"] ?? null;
        $filtro->produto_loja           = $_GET["produto_loja"] ?? null;
        $filtro->fornecedor_nota_id     = $_GET["fornecedor_nota_id"] ?? null;
        $filtro->categoria_id           = $_GET["categoria_id"] ?? null;
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->tipo_saida             = $_GET["tipo_saida"] ?? 'tela';
        
        
        
        $dados["categorias"]            = Categoria::get();
        $dados["status"]                = ConstanteService::listaStatusVenda();
        $dados["usuarios"]              = User::get();
        $dados["fornecedores"]          = Fornecedor::get();
        $dados["lista"]                 = Produto::consulta($filtro);
        $dados["filtro"]                = $filtro;
        
        if($filtro->tipo_saida=="pdf"){
            $p = view('Admin.Relatorios.Produto.ListaProduto', $dados);
            $domPdf = new Dompdf(["enable_remote" => true]);
            $domPdf->loadHtml($p);
            $pdf = ob_get_clean();
            $domPdf->setPaper("A4");
            $domPdf->render();
            $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
        }else{
            return view("Admin.Consulta.SelecionarProduto", $dados);
        }
      }
    
    public function venda(Request $request){
        $dados["usuario"]   = auth()->user();
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? hoje();
        $filtro->data2                  = $_GET["data2"] ?? hoje();
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->vendedor_id            = $_GET["vendedor_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->tipo_saida             = $_GET["tipo_saida"] ?? 'tela';
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? 'listagem';
        
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusVenda();
        $dados["usuarios"]              = User::get();
        $dados["clientes"]              = Cliente::get();
        $dados["vendedores"]            = Vendedor::get();
        $dados["lista"]                 = Venda::consulta($filtro);
        $dados["filtro"]                = $filtro;
        $paisagem                       = false;
        if($filtro->tipo_saida=="pdf"){
            if($filtro->tipo_relatorio=="listagem"){
                $view = 'Admin.Relatorios.Venda.ListaVenda';
            }
            if($filtro->tipo_relatorio=="resumo_diario"){
                $dados["lista"] =  Venda::relatorio($filtro);
               
                $view       = 'Admin.Relatorios.Venda.ResumoDiario';
            }
            
            //Imprimir o relatório
            $p = view($view, $dados);
            $domPdf = new Dompdf(["enable_remote" => true]);
            $domPdf->loadHtml($p);
            ob_get_clean();
            $domPdf->setPaper("a4");
            if($paisagem){
                $domPdf->setPaper("a4","landscape");
            }
            $domPdf->render();
            $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
        }else{
            return view("Admin.Consulta.SelecionarVenda", $dados);
        }        
        
    }
    
      
    public function estoque(Request $request){
        $dados["usuario"]   = auth()->user();
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? hoje();
        $filtro->data2                  = $_GET["data2"] ?? hoje();
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->produto_id             = $_GET["produto_id"] ?? null;        
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->tipo_saida             = $_GET["tipo_saida"] ?? 'tela';
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? 'listagem';
        
        $dados["produtos"]              = Produto::get();
        $dados["lista"]                 = Movimento::consulta($filtro);
        $dados["filtro"]                = $filtro;
        $paisagem = false;
        if($filtro->tipo_saida=="pdf"){
            if($filtro->tipo_relatorio=="listagem"){
                $view = 'Admin.Relatorios.MovimentoEstoque.Listagem';
            }
            
            if($filtro->tipo_relatorio=="historico"){
                $dados["retorno"] =  Movimento::relatorio($filtro);
                $view = 'Admin.Relatorios.MovimentoEstoque.Historico';
                $paisagem = true;
            }
            
            
            
            //Imprimir o relatório
            $p = view($view, $dados);
            $domPdf = new Dompdf(["enable_remote" => true]);
            $domPdf->loadHtml($p);
            ob_get_clean();
            $domPdf->setPaper("a4");
            if($paisagem){
                $domPdf->setPaper("a4","landscape");
            }
            $domPdf->render();
            $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
            
        }else{
            return view("Admin.Consulta.SelecionarEstoque", $dados);
        }
        
    }
    
    public function contareceber(Request $request){
        $dados["usuario"]   = auth()->user();
        $filtro = new \stdClass();
        $filtro->emissao01              = $_GET["emissao01"] ?? hoje();
        $filtro->emissao02              = $_GET["emissao02"] ?? hoje();
        $filtro->venc01                 = $_GET["venc01"] ?? null;
        $filtro->venc02                 = $_GET["venc02"] ?? null;
        $filtro->descricao              = $_GET["descricao"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->origem                 = $_GET["origem"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->tipo_saida             = $_GET["tipo_saida"] ?? 'tela';
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? 'listagem';
 
        $dados["status"]                = Status::get();
        $dados["usuarios"]              = User::get();
        $dados["clientes"]              = Cliente::get();
        $dados["filtro"]                = $filtro;
        $dados["lista"]                 = FinContaReceber::consulta($filtro);
        $paisagem = false;
        if($filtro->tipo_saida=="pdf"){
            if($filtro->tipo_relatorio=="listagem"){
                $view = 'Admin.Relatorios.ContaReceber.ListaContaReceber';
            }
            
            if($filtro->tipo_relatorio=="agrupado_por_vencimento"){
                $dados["lista"] =  FinContaReceber::relatorio($filtro);  
                $view = 'Admin.Relatorios.ContaReceber.AgrupadoPorVencimento';
                $paisagem = true;
            } 
            
            if($filtro->tipo_relatorio=="agrupado_por_emissao"){
                $dados["lista"] =  FinContaReceber::relatorio($filtro);
                $view = 'Admin.Relatorios.ContaReceber.AgrupadoPorEmissao';
                $paisagem = true;
            }
            
            if($filtro->tipo_relatorio=="agrupado_por_cliente"){
                $dados["lista"] =  FinContaReceber::relatorio($filtro);
                $view = 'Admin.Relatorios.ContaReceber.AgrupadoPorCliente';
                $paisagem = true;
            }
            
            //Imprimir o relatório
            $p = view($view, $dados);
            $domPdf = new Dompdf(["enable_remote" => true]);
            $domPdf->loadHtml($p);
            ob_get_clean();
            $domPdf->setPaper("a4");
            if($paisagem){
                $domPdf->setPaper("a4","landscape");
            }            
            $domPdf->render();
            $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
            
        }else{
            return view("Admin.Consulta.SelecionarContaReceber", $dados);
        }
        
    }
    
    public function recebimento(Request $request){
        $dados["usuario"]               = auth()->user();
        $filtro                         = new \stdClass();
        $filtro->recebimento01     = $_GET["recebimento01"] ?? hoje();
        $filtro->recebimento02     = $_GET["recebimento02"] ?? hoje();
        $filtro->venc01                 = $_GET["venc01"] ?? null;
        $filtro->venc02                 = $_GET["venc02"] ?? null;
        $filtro->descricao              = $_GET["descricao"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->origem                 = $_GET["origem"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->tipo_saida             = $_GET["tipo_saida"] ?? 'tela';
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? 'listagem';
        
        $dados["status"]                = Status::get();
        $dados["usuarios"]              = User::get();
        $dados["clientes"]              = Cliente::get();
        $dados["filtro"]                = $filtro;
        $dados["lista"]                 = FinRecebimento::consulta($filtro);
        $paisagem = false;
        if($filtro->tipo_saida=="pdf"){
            if($filtro->tipo_relatorio=="listagem"){
                $view = 'Admin.Relatorios.Recebimento.ListaRecebimento';
            }
            
            if($filtro->tipo_relatorio=="agrupado_por_recebimento"){
                $dados["lista"] =  FinRecebimento::relatorio($filtro);
                $view = 'Admin.Relatorios.Recebimento.AgrupadoPorVencimento';
                $paisagem = false;
            }
            
            if($filtro->tipo_relatorio=="resumo_por_forma_pagamento"){
                $dados["lista"] =  FinRecebimento::relatorio($filtro);
                $view = 'Admin.Relatorios.Recebimento.ResumoPorTipoPagto';
                $paisagem = false;
            }
            
         
            
            //Imprimir o relatório
            $p = view($view, $dados);
            $domPdf = new Dompdf(["enable_remote" => true]);
            $domPdf->loadHtml($p);
            ob_get_clean();
            $domPdf->setPaper("a4");
            if($paisagem){
                $domPdf->setPaper("a4","landscape");
            }
            $domPdf->render();
            $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
            
        }else{
            return view("Admin.Consulta.SelecionarRecebimento", $dados);
        }
        
    }
    
    public function contapagar(Request $request){
        $dados["usuario"]   = auth()->user();
        $filtro = new \stdClass();
        $filtro->emissao01              = $_GET["emissao01"] ?? hoje();
        $filtro->emissao02              = $_GET["emissao02"] ?? hoje();
        $filtro->venc01                 = $_GET["venc01"] ?? null;
        $filtro->venc02                 = $_GET["venc02"] ?? null;
        $filtro->descricao              = $_GET["descricao"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->origem                 = $_GET["origem"] ?? null;
        $filtro->fornecedor_id          = $_GET["fornecedor_id"] ?? null;
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->tipo_saida             = $_GET["tipo_saida"] ?? 'tela';
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? 'listagem';
        
        $dados["status"]                = Status::get();
        $dados["usuarios"]              = User::get();
        $dados["fornecedores"]          = Fornecedor::get();
        $dados["filtro"]                = $filtro;
        $dados["lista"]                 = FinContaPagar::consulta($filtro);
        $paisagem = false;
        if($filtro->tipo_saida=="pdf"){
            if($filtro->tipo_relatorio=="listagem"){
                $view = 'Admin.Relatorios.ContaPagar.Listagem';
            }
            
            if($filtro->tipo_relatorio=="agrupado_por_vencimento"){
                $dados["lista"] =  FinContaPagar::relatorio($filtro);
                $view = 'Admin.Relatorios.ContaPagar.AgrupadoPorVencimento';
                $paisagem = true;
            }
            
            if($filtro->tipo_relatorio=="agrupado_por_emissao"){
                $dados["lista"] =  FinContaPagar::relatorio($filtro);
                $view = 'Admin.Relatorios.ContaPagar.AgrupadoPorEmissao';
                $paisagem = true;
            }
            
            if($filtro->tipo_relatorio=="agrupado_por_fornecedor"){
                $dados["lista"] =  FinContaPagar::relatorio($filtro);
                $view = 'Admin.Relatorios.ContaPagar.AgrupadoPorCliente';
                $paisagem = true;
            }
            
            //Imprimir o relatório
            $p = view($view, $dados);
            $domPdf = new Dompdf(["enable_remote" => true]);
            $domPdf->loadHtml($p);
            ob_get_clean();
            $domPdf->setPaper("a4");
            if($paisagem){
                $domPdf->setPaper("a4","landscape");
            }
            $domPdf->render();
            $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
            
        }else{
            return view("Admin.Consulta.SelecionarContaPagar", $dados);
        }
        
    }
    
    public function pagamento(Request $request){
        $dados["usuario"]   = auth()->user();
        $filtro = new \stdClass();
        $filtro->pagamento01            = $_GET["pagamento01"] ?? hoje();
        $filtro->pagamento02            = $_GET["pagamento02"] ?? hoje();
        $filtro->venc01                 = $_GET["venc01"] ?? null;
        $filtro->venc02                 = $_GET["venc02"] ?? null;
        $filtro->descricao              = $_GET["descricao"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->origem                 = $_GET["origem"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->tipo_saida             = $_GET["tipo_saida"] ?? 'tela';
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? 'listagem';
        
        $dados["status"]                = Status::get();
        $dados["usuarios"]              = User::get();
        $dados["clientes"]              = Cliente::get();
        $dados["filtro"]                = $filtro;
        $dados["lista"]                 = FinPagamento::consulta($filtro);
        $paisagem = false;
        if($filtro->tipo_saida=="pdf"){
            if($filtro->tipo_relatorio=="listagem"){
                $view = 'Admin.Relatorios.Pagamento.ListaPagamento';
            }
            
            if($filtro->tipo_relatorio=="agrupado_por_pagamento"){
                $dados["lista"] =  FinPagamento::relatorio($filtro);
                $view = 'Admin.Relatorios.Pagamento.AgrupadoPorPagamento';
                $paisagem = false;
            }
            
            if($filtro->tipo_relatorio=="agrupado_por_emissao"){
                $dados["lista"] =  FinPagamento::relatorio($filtro);
                $view = 'Admin.Relatorios.Pagamento.AgrupadoPorEmissao';
                $paisagem = true;
            }
            
            
            
            //Imprimir o relatório
            $p = view($view, $dados);
            $domPdf = new Dompdf(["enable_remote" => true]);
            $domPdf->loadHtml($p);
            ob_get_clean();
            $domPdf->setPaper("a4");
            if($paisagem){
                $domPdf->setPaper("a4","landscape");
            }
            $domPdf->render();
            $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
            
        }else{
            return view("Admin.Consulta.SelecionarPagamento", $dados);
        }
        
    }
    
    public function movimentoconta(Request $request){
        $dados["usuario"]   = auth()->user();
        $filtro = new \stdClass();
        $filtro->emissao01              = $_GET["emissao01"] ?? hoje();
        $filtro->emissao02              = $_GET["emissao02"] ?? hoje();
        $filtro->historico              = $_GET["historico"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->conta_id               = $_GET["conta_id"] ?? null;
        $filtro->origem                 = $_GET["origem"] ?? null;
        $filtro->tipo_movimento             = $_GET["tipo_movimento"] ?? null;
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->tipo_saida             = $_GET["tipo_saida"] ?? 'tela';
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? 'listagem';
        
        $dados["status"]                = Status::get();
        $dados["usuarios"]              = User::get();
        $dados["contas"]              = ContaCorrente::get();
        $dados["filtro"]                = $filtro;
        $dados["lista"]                 = MovimentoConta::consulta($filtro);
        $paisagem = false;
        if($filtro->tipo_saida=="pdf"){
            if($filtro->tipo_relatorio=="listagem"){
                $view = 'Admin.Relatorios.MovimentoConta.Listagem';
            }
            
            if($filtro->tipo_relatorio=="extrato"){
                $dados["conta"] =  MovimentoConta::relatorio($filtro);               
                $view = 'Admin.Relatorios.MovimentoConta.Extrato';
                $paisagem = true;
            }
                       
            
            
            //Imprimir o relatório
            $p = view($view, $dados);
            $domPdf = new Dompdf(["enable_remote" => true]);
            $domPdf->loadHtml($p);
            ob_get_clean();
            $domPdf->setPaper("a4");
            if($paisagem){
                $domPdf->setPaper("a4","landscape");
            }
            $domPdf->render();
            $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
            
        }else{
            return view("Admin.Consulta.SelecionarMovimentoConta", $dados);
        }        
        
    }
    
    public function pdv(Request $request){
        $dados["usuario"]   = auth()->user();
        $filtro = new \stdClass();
        $filtro->data1              = $_GET["data1"] ?? hoje();
        $filtro->data2              = $_GET["data2"] ?? hoje();
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->vendedor_id            = $_GET["vendedor_id"] ?? null;
        $filtro->conta_id               = $_GET["conta_id"] ?? null;
        $filtro->origem                 = $_GET["origem"] ?? null;
        $filtro->uuid                 = $_GET["uuid"] ?? null;
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->tipo_saida             = $_GET["tipo_saida"] ?? 'tela';
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? 'listagem';
        
        $dados["status"]                = Status::get();
        $dados["usuarios"]              = User::get();
        $dados["contas"]              = ContaCorrente::get();
        $dados["filtro"]                = $filtro;
        $dados["vendedores"]            = Vendedor::get();
        $dados["lista"]                 = PdvVenda::consulta($filtro);
        $paisagem = false;
        if($filtro->tipo_saida=="pdf"){
            if($filtro->tipo_relatorio=="listagem"){
                $view = 'Admin.Relatorios.Pdv.Listagem';
            }            
            if($filtro->tipo_relatorio=="resumo_diario"){
                $dados["lista"] =  PdvVenda::relatorio($filtro);
                $view = 'Admin.Relatorios.Pdv.ResumoDiario';
                $paisagem = false;
            }            
            
            //Imprimir o relatório
            $p = view($view, $dados);
            $domPdf = new Dompdf(["enable_remote" => true]);
            $domPdf->loadHtml($p);
            ob_get_clean();
            $domPdf->setPaper("a4");
            if($paisagem){
                $domPdf->setPaper("a4","landscape");
            }
            $domPdf->render();
            $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
            
        }else{
            return view("Admin.Consulta.SelecionarPdv", $dados);
        }
       
    }
    
    public function lojavirtual(Request $request){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->ordem                  = $_GET["ordem"] ?? "id";
        $filtro->tipo_ordem             = $_GET["tipo_ordem"] ?? 'asc';
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->uuid                   = $_GET["uuid"] ?? null;
        
        $dados["status"]                = Status::get();
        $dados["usuarios"]              = User::get();
        $dados["clientes"]              = Cliente::get();
        $dados["vendedores"]            = Vendedor::get();
        $dados["lista"]                 = LojaPedido::consulta($filtro);
        $dados["filtro"]                = $filtro;
        
        return view("Admin.Consulta.SelecionarLojaVirtual", $dados);
    }
  
}
