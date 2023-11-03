<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Cobranca;
use App\Models\Compra;
use App\Models\Empresa;
use App\Models\Entrada;
use App\Models\FinContaPagar;
use App\Models\FinContaReceber;
use App\Models\FinDespesa;
use App\Models\FinPagamento;
use App\Models\FinRecebimento;
use App\Models\GradeMovimento;
use App\Models\GradeProduto;
use App\Models\ItemOrcamento;
use App\Models\ItemVenda;
use App\Models\LojaPedido;
use App\Models\Movimento;
use App\Models\NfceItem;
use App\Models\Nfe;
use App\Models\NfeItem;
use App\Models\Plano;
use App\Models\Produto;
use App\Models\ProdutoOs;
use App\Models\Saida;
use App\Models\ServicoOs;
use App\Models\Venda;
use App\Observers\CategoriaObserver;
use App\Observers\ClienteObserver;
use App\Observers\CobrancaObserver;
use App\Observers\CompraObserver;
use App\Observers\ContaPagarObserver;
use App\Observers\ContaReceberObserver;
use App\Observers\DespesaObserver;
use App\Observers\EmpresaObserver;
use App\Observers\EntradaObserver;
use App\Observers\GradeMovimentoObserver;
use App\Observers\GradeProdutoObserver;
use App\Observers\ItemNfceObserver;
use App\Observers\ItemNotaFiscalObserver;
use App\Observers\ItemOrcamentoObserver;
use App\Observers\ItemVendaObserver;
use App\Observers\LojaPedidoObserver;
use App\Observers\MovimentoObserver;
use App\Observers\NotaFiscalObserver;
use App\Observers\PagamentoObserver;
use App\Observers\PlanoObserver;
use App\Observers\ProdutoObserver;
use App\Observers\ProdutoOsObserver;
use App\Observers\RecebimentoObserver;
use App\Observers\SaidaObserver;
use App\Observers\ServicoOsObserver;
use App\Observers\VendaObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\ItemCompra;
use App\Observers\ItemCompraObserver;
use App\Models\ContaReceberPrevisao;
use App\Observers\PrevisaoPagamentoObserver;
use App\Models\ItemVendaRecorrente;
use App\Observers\ItemVendaRecorrenteObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Empresa::observe(EmpresaObserver::class);
        Categoria::observe(CategoriaObserver::class);
        Plano::observe(PlanoObserver::class);
        Produto::observe(ProdutoObserver::class);
        Cliente::observe(ClienteObserver::class);
        Entrada::observe(EntradaObserver::class);
        Saida::observe(SaidaObserver::class);
        Venda::observe(VendaObserver::class);
        ItemVenda::observe(ItemVendaObserver::class);
        Movimento::observe(MovimentoObserver::class);
        Nfe::observe(NotaFiscalObserver::class);
        NfeItem::observe(ItemNotaFiscalObserver::class);
        NfceItem::observe(ItemNfceObserver::class);
        FinRecebimento::observe(RecebimentoObserver::class);
        FinContaReceber::observe(ContaReceberObserver::class);         
        FinPagamento::observe(PagamentoObserver::class);
        FinContaPagar::observe(ContaPagarObserver::class);
        Cobranca::observe(CobrancaObserver::class);
        Compra::observe(CompraObserver::class);
        ItemVenda::observe(ItemVendaObserver::class);
        ItemCompra::observe(ItemCompraObserver::class);
        ItemOrcamento::observe(ItemOrcamentoObserver::class);
        ProdutoOs::observe(ProdutoOsObserver::class);
        ServicoOs::observe(ServicoOsObserver::class);
        LojaPedido::observe(LojaPedidoObserver::class);
        FinDespesa::observe(DespesaObserver::class);
        GradeProduto::observe(GradeProdutoObserver::class);
        GradeMovimento::observe(GradeMovimentoObserver::class);
        ContaReceberPrevisao::observe(PrevisaoPagamentoObserver::class);
        ItemVendaRecorrente::observe(ItemVendaRecorrenteObserver::class);
    }
}
