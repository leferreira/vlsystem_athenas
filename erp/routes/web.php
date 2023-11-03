<?php

use App\Http\Controllers\TalrasController;
use App\Http\Controllers\Acl\FuncaoController;
use App\Http\Controllers\Acl\FuncaoPermissaoController;
use App\Http\Controllers\Acl\FuncaoUsuarioController;
use App\Http\Controllers\Acl\PermissaoController;
use App\Http\Controllers\Acl\UsuarioController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChamadoController;
use App\Http\Controllers\Admin\MercadoPagoController;
use App\Http\Controllers\Admin\PedidoClienteController;
use App\Http\Controllers\Admin\UtilController;
use App\Http\Controllers\Admin\Assinatura\AssinaturaController;
use App\Http\Controllers\Admin\Cadastro\AdministradoraController;
use App\Http\Controllers\Admin\Cadastro\BancoController;
use App\Http\Controllers\Admin\Cadastro\BandeiraAdministradoraController;
use App\Http\Controllers\Admin\Cadastro\CategoriaController;
use App\Http\Controllers\Admin\Cadastro\ClassificacaoFinanceiraController;
use App\Http\Controllers\Admin\Cadastro\ClienteController;
use App\Http\Controllers\Admin\Cadastro\ComposicaoProdutoController;
use App\Http\Controllers\Admin\Cadastro\ContaCorrenteController;
use App\Http\Controllers\Admin\Cadastro\CupomDescontoController;
use App\Http\Controllers\Admin\Cadastro\EnderecoClienteController;
use App\Http\Controllers\Admin\Cadastro\EquipamentoController;
use App\Http\Controllers\Admin\Cadastro\FormaParcelamentoController;
use App\Http\Controllers\Admin\Cadastro\FornecedorController;
use App\Http\Controllers\Admin\Cadastro\GradeController;
use App\Http\Controllers\Admin\Cadastro\GrupoProdutoController;
use App\Http\Controllers\Admin\Cadastro\ItemVariacaoGradeController;
use App\Http\Controllers\Admin\Cadastro\LocalizacaoController;
use App\Http\Controllers\Admin\Cadastro\ProdutoController;
use App\Http\Controllers\Admin\Cadastro\ProdutoSemelhanteController;
use App\Http\Controllers\Admin\Cadastro\ServicoController;
use App\Http\Controllers\Admin\Cadastro\SubCategoriaController;
use App\Http\Controllers\Admin\Cadastro\SubSubCategoriaController;
use App\Http\Controllers\Admin\Cadastro\TabelaPrecoController;
use App\Http\Controllers\Admin\Cadastro\TabelaPrecoProdutoController;
use App\Http\Controllers\Admin\Cadastro\TecnicoController;
use App\Http\Controllers\Admin\Cadastro\TermoGarantiaController;
use App\Http\Controllers\Admin\Cadastro\TransportadoraController;
use App\Http\Controllers\Admin\Cadastro\VariacaoGradeController;
use App\Http\Controllers\Admin\Cadastro\VendedorController;
use App\Http\Controllers\Admin\Compra\CompraController;
use App\Http\Controllers\Admin\Compra\DuplicataCompraController;
use App\Http\Controllers\Admin\Compra\ItemCompraController;
use App\Http\Controllers\Admin\Compra\NfeEntradaController;
use App\Http\Controllers\Admin\Configuracao\CertificadoDigitalController;
use App\Http\Controllers\Admin\Configuracao\EmitenteController;
use App\Http\Controllers\Admin\Configuracao\EmpresaController;
use App\Http\Controllers\Admin\Configuracao\MeuPerfilController;
use App\Http\Controllers\Admin\Configuracao\MeuPlanoController;
use App\Http\Controllers\Admin\Configuracao\NaturezaOperacaoController;
use App\Http\Controllers\Admin\Configuracao\ParametroController;
use App\Http\Controllers\Admin\Configuracao\TributacaoController;
use App\Http\Controllers\Admin\Configuracao\TributacaoProdutoController;
use App\Http\Controllers\Admin\Consulta\ConsultaController;
use App\Http\Controllers\Admin\Delivery\CategoriaAdicionalController;
use App\Http\Controllers\Admin\Delivery\DeliveryComplementoController;
use App\Http\Controllers\Admin\Delivery\DeliveryConfigController;
use App\Http\Controllers\Admin\Delivery\DeliveryMotoboyController;
use App\Http\Controllers\Admin\Delivery\DeliveryPedidoController;
use App\Http\Controllers\Admin\Delivery\DeliveryProdutoController;
use App\Http\Controllers\Admin\Delivery\DeliveryTamanhoPizzaController;
use App\Http\Controllers\Admin\Delivery\FuncionamentoDeliveryController;
use App\Http\Controllers\Admin\Delivery\ListaComplementoDeliveryController;
use App\Http\Controllers\Admin\Ead\EadAlunoController;
use App\Http\Controllers\Admin\Ead\EadAulaController;
use App\Http\Controllers\Admin\Ead\EadCursoController;
use App\Http\Controllers\Admin\Ead\EadMatriculaController;
use App\Http\Controllers\Admin\Estoque\EntradaController;
use App\Http\Controllers\Admin\Estoque\EstoqueController;
use App\Http\Controllers\Admin\Estoque\MovimentoController;
use App\Http\Controllers\Admin\Estoque\MovimentoGradeController;
use App\Http\Controllers\Admin\Estoque\MovimentoGradeTempController;
use App\Http\Controllers\Admin\Estoque\SaidaController;
use App\Http\Controllers\Admin\Financeiro\CentroCustoController;
use App\Http\Controllers\Admin\Financeiro\CobrancaController;
use App\Http\Controllers\Admin\Financeiro\ComprovanteController;
use App\Http\Controllers\Admin\Financeiro\ContaPagarController;
use App\Http\Controllers\Admin\Financeiro\ContaReceberController;
use App\Http\Controllers\Admin\Financeiro\ContaReceberPrevisaoController;
use App\Http\Controllers\Admin\Financeiro\DespesaController;
use App\Http\Controllers\Admin\Financeiro\FaturaController;
use App\Http\Controllers\Admin\Financeiro\FinanceiroController;
use App\Http\Controllers\Admin\Financeiro\MovimentoContaController;
use App\Http\Controllers\Admin\Financeiro\PagamentoController;
use App\Http\Controllers\Admin\Financeiro\RecebimentoController;
use App\Http\Controllers\Admin\Financeiro\TipoDespesaController;
use App\Http\Controllers\Admin\LojaVirtual\LojaBannerController;
use App\Http\Controllers\Admin\LojaVirtual\LojaCarrossellController;
use App\Http\Controllers\Admin\LojaVirtual\LojaCategoriaProdutoController;
use App\Http\Controllers\Admin\LojaVirtual\LojaClienteController;
use App\Http\Controllers\Admin\LojaVirtual\LojaConfiguracaoController;
use App\Http\Controllers\Admin\LojaVirtual\LojaCurtidaProdutoController;
use App\Http\Controllers\Admin\LojaVirtual\LojaImagemProdutoController;
use App\Http\Controllers\Admin\LojaVirtual\LojaItemPedidoController;
use App\Http\Controllers\Admin\LojaVirtual\LojaPacoteController;
use App\Http\Controllers\Admin\LojaVirtual\LojaPedidoController;
use App\Http\Controllers\Admin\LojaVirtual\LojaProdutoController;
use App\Http\Controllers\Admin\LojaVirtual\LojaTesteController;
use App\Http\Controllers\Admin\Nfce\NfceController;
use App\Http\Controllers\Admin\Nfce\NotaNfceController;
use App\Http\Controllers\Admin\Nfe\ItemNotaFiscalController;
use App\Http\Controllers\Admin\Nfe\NfeController;
use App\Http\Controllers\Admin\Nfe\NfeDuplicataController;
use App\Http\Controllers\Admin\Nfe\NfePagamentoController;
use App\Http\Controllers\Admin\Nfe\NotaFiscalController;
use App\Http\Controllers\Admin\OrdemServico\AnotacaoOsController;
use App\Http\Controllers\Admin\OrdemServico\OrdemServicoController;
use App\Http\Controllers\Admin\OrdemServico\ProdutoOsController;
use App\Http\Controllers\Admin\OrdemServico\ServicoOsController;
use App\Http\Controllers\Admin\Pdv\PdvCaixaController;
use App\Http\Controllers\Admin\Pdv\PdvDuplicataController;
use App\Http\Controllers\Admin\Pdv\PdvNumeroCaixaController;
use App\Http\Controllers\Admin\Pdv\PdvSangriaController;
use App\Http\Controllers\Admin\Pdv\PdvSuplementoController;
use App\Http\Controllers\Admin\Pdv\PdvVendaController;
use App\Http\Controllers\Admin\Recorrencia\ClienteRecorrenteController;
use App\Http\Controllers\Admin\Recorrencia\ModeloContratoController;
use App\Http\Controllers\Admin\Recorrencia\ProdutoRecorrenteController;
use App\Http\Controllers\Admin\Recorrencia\RecorrenciaController;
use App\Http\Controllers\Admin\Recorrencia\VendaRecorrenteController;
use App\Http\Controllers\Admin\Venda\DuplicataController;
use App\Http\Controllers\Admin\Venda\DuplicataOrcamentoController;
use App\Http\Controllers\Admin\Venda\ItemOrcamentoController;
use App\Http\Controllers\Admin\Venda\ItemVendaController;
use App\Http\Controllers\Admin\Venda\OrcamentoController;
use App\Http\Controllers\Admin\Venda\VendaController;
use App\Http\Controllers\Delivery\EnderecoWebController;
use App\Http\Controllers\Delivery\PedidoWebController;
use App\Http\Controllers\Delivery\Balcao\ClienteBalcaoController;
use App\Http\Controllers\Delivery\Balcao\HomeBalcaoController;
use App\Http\Controllers\Delivery\Balcao\PedidoBalcaoController;
use App\Http\Controllers\Delivery\Balcao\ProdutoBalcaoController;
use App\Http\Controllers\Delivery\Web\CarrinhoWebController;
use App\Http\Controllers\Delivery\Web\ClienteWebController;
use App\Http\Controllers\Delivery\Web\HomeWebController;
use App\Http\Controllers\Delivery\Web\ProdutoWebController;
use App\Http\Middleware\AssinaturaMiddleware;
use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


//rota específica para limpar o cache
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Limpeza total!";
});

    //Rota principal geral


    Route::get('/', function() {
        return redirect()->route('login');
    });;


    Auth::routes(['verify' => true]);


    Route::get('/mensagem-teste', function() {
        //return new MensagemTesteMail();
        Mail::to('laravel@mjailtoncursos.com.br')->send(new MensagemTesteMail());
        return 'E-mail enviado com sucesso!';
    });



    Route::get('/cadastrarPlano/{id}',[AdminController::class,'cadastrarPlano'])->name('cadastrarPlano');

    Route::get('/componente', [TalrasController::class,'componentes'])->name('componente');
    Route::get('/novo', [TalrasController::class,'novo'])->name('novo');

    Route::get("/assinatura/faturas/{id}",[AssinaturaController::class,"faturas"])->name("admin.assinatura.faturas");
    Route::get("/assinatura/comprovante/{id}",[AssinaturaController::class,"comprovante"])->name("admin.assinatura.comprovante");
    Route::get("/assinatura/naoassinante",[AssinaturaController::class,"naoassinante"])->name("admin.assinatura.naoassinante");
    Route::get("/assinatura/nenhumFaturaPaga",[AssinaturaController::class,"nenhumFaturaPaga"])->name("admin.assinatura.nenhumFaturaPaga");
    Route::get("/assinatura/faturaVencida",[AssinaturaController::class,"faturaVencida"])->name("admin.assinatura.faturaVencida");
    Route::get("/assinatura/demovencido",[AssinaturaController::class,"demovencido"])->name("admin.assinatura.demovencido");
    Route::get("/assinatura/bloqueado",[AssinaturaController::class,"bloqueado"])->name("admin.assinatura.bloqueado");
    Route::get('/assinatura/assinar/{id?}',[AssinaturaController::class,'assinar'])->name('admin.assinatura.assinar');
    Route::get('/assinatura/pagamento/{id}',[AssinaturaController::class,'pagamento'])->name('admin.assinatura.pagamento');

    Route::get("/fatura/comprovante/{id}",[FaturaController::class,"comprovante"])->name("admin.fatura.comprovante");
    Route::get("/fatura/confirmarPagamento/{id}",[FaturaController::class,"confirmarPagamento"])->name("admin.fatura.confirmarPagamento");
    Route::get("/fatura/pix/{id}",[FaturaController::class,"pix"])->name("admin.fatura.pix");
    Route::get("/fatura/cartao/{id}",[FaturaController::class,"cartao"])->name("admin.fatura.cartao");
    Route::get("/fatura/boleto/{id}",[FaturaController::class,"boleto"])->name("admin.fatura.boleto");
    Route::get("/fatura/assinar/{tipo}",[FaturaController::class,"assinar"])->name("admin.fatura.assinar");
    Route::post("/fatura/pagar/",[FaturaController::class,"pagar"])->name("fatura.pagar");

    Route::resource("/comprovante",ComprovanteController::class);


    Route::group(['middleware' => 'auth'], function () {
        Route::get('/meus_planos/vencido',[MeuPlanoController::class,'vencido'])->name('meus_planos.vencido');
        //Pagamento
        Route::post('pagamento/cartao', [\App\Http\Controllers\Admin\PagamentoController::class, 'cartao']);
        Route::post('pagamento/pix', [\App\Http\Controllers\Admin\PagamentoController::class, 'pix']);
    });

      Route::group(['middleware' => ['auth', AssinaturaMiddleware::class],'prefix'=>'admin','as'=>'admin.'], function () {
            Route::get('/',[AdminController::class, 'index'])->name('index');
            Route::get('/testeapi',[AdminController::class, 'testeapi'])->name('testeapi');
            //Configuração
            Route::get('/meus_dados/',[MeuPerfilController::class,'index'])->name('meus_dados');
            Route::post('/meus_dados/salvar',[MeuPerfilController::class,'salvar'])->name('meus_dados.salvar');



            Route::get('/meus_planos/obrigado',[MeuPlanoController::class,'obrigado'])->name('meus_planos.obrigado');
            Route::get('/meus_planos/finalizar/{id}',[MeuPlanoController::class,'finalizar'])->name('meus_planos.finalizar');
            Route::get('/meus_planos/pagarComPix/{id}',[MeuPlanoController::class,'pagarComPix'])->name('meus_planos.pagarComPix');
            Route::get('/meus_planos/pagarComCartao/{id}',[MeuPlanoController::class,'pagarComCartao'])->name('meus_planos.pagarComCartao');
            Route::get('/meus_planos/pagarComBoleto/{id}',[MeuPlanoController::class,'pagarComBoleto'])->name('meus_planos.pagarComBoleto');
            Route::get('/meus_planos/pagarPorTransferência/{id}',[MeuPlanoController::class,'pagarPorTransferência'])->name('meus_planos.pagarPorTransferência');

            Route::resource('/meus_planos', MeuPlanoController::class);


            Route::resource('/assinatura', AssinaturaController::class);


            Route::resource('/bandeiraadministradora', BandeiraAdministradoraController::class);
            Route::resource('/tabelapreco', TabelaPrecoController::class);

            Route::resource('/formaparcelamento', FormaParcelamentoController::class);

            Route::post('/localizacao/salvarJs',[LocalizacaoController::class,'salvarJs'])->name('localizacao.salvarJs');
            Route::resource('/localizacao', LocalizacaoController::class);

            Route::post('/variacaograde/salvarJs',[VariacaoGradeController::class,'salvarJs'])->name('variacaograde.salvarJs');
            Route::resource('/variacaograde', VariacaoGradeController::class);

            Route::get('/itemvariacaograde/lista/{linha_id}/{coluna_id}/{produto_id}',[ItemVariacaoGradeController::class,'lista'])->name('itemvariacaograde.lista');
            Route::post('/itemvariacaograde/salvarJs',[ItemVariacaoGradeController::class,'salvarJs'])->name('itemvariacaograde.salvarJs');
            Route::resource('/itemvariacaograde', ItemVariacaoGradeController::class);

            Route::get('/util/buscarCNPJ/{cnpj}',[UtilController::class,'buscarCNPJ'])->name('util.buscarCNPJ');

            Route::get('empresa/verLoja',[EmpresaController::class,'verLoja'])->name('empresa.verLoja');
            Route::get('empresa/esconderPendencia',[EmpresaController::class,'esconderPendencia'])->name('empresa.esconderPendencia');
            Route::resource('/empresa', EmpresaController::class);

            Route::post("/mercadopago/pix",[MercadoPagoController::class,"pix"])->name("mercadopago.pix");
            Route::post("/mercadopago/cartao",[MercadoPagoController::class,"cartao"])->name("mercadopago.cartao");
            Route::post("/mercadopago/boleto",[MercadoPagoController::class,"boleto"])->name("mercadopago.boleto");

            Route::post('/emitente/inserirAutorizado',[EmitenteController::class,'inserirAutorizado'])->name('emitente.inserirAutorizado');
            Route::get('/emitente/excluirAutorizado/{id}',[EmitenteController::class,'excluirAutorizado'])->name('emitente.excluirAutorizado');

            Route::resource('/emitente',EmitenteController::class);
            Route::resource('/parametro',ParametroController::class);

            Route::resource('/tecnico',TecnicoController::class);

            Route::get("/equipamento/pesquisaPorCliente/{id}",[EquipamentoController::class,"pesquisaPorCliente"])->name('equipamento.pesquisaPorCliente');
            Route::resource('/equipamento',EquipamentoController::class);

            Route::resource('/termogarantia',TermoGarantiaController::class);

            Route::get("/administradora/formas/{id}",[AdministradoraController::class,"formas"])->name('administradora.formas');
            Route::resource('/administradora',AdministradoraController::class);

            Route::resource("/composicaoproduto",ComposicaoProdutoController::class);


            Route::resource("/tabelaprecoproduto",TabelaPrecoProdutoController::class);


            Route::resource("/produtosemelhante",ProdutoSemelhanteController::class);

            Route::resource('/banco',BancoController::class);
            Route::resource('/contacorrente',ContaCorrenteController::class);


            Route::get("/contareceberprevisao/lista/{id}",[ContaReceberPrevisaoController::class,"lista"])->name('contareceberprevisao.lista');
            Route::resource('/contareceberprevisao',ContaReceberPrevisaoController::class);

            Route::post("/movimentogradetemp/inserirEntradaSaida",[MovimentoGradeTempController::class,"inserirEntradaSaida"])->name('movimentogradetemp.inserirEntradaSaida');
            Route::post("/movimentogradetemp/salvarJs",[MovimentoGradeTempController::class,"salvarJs"])->name('movimentogradetemp.salvarJs');
            Route::resource('/movimentogradetemp',MovimentoGradeTempController::class);


            Route::post("/movimentograde/inserirAjusteGrade",[MovimentoGradeController::class,"inserirAjusteGrade"])->name('movimentograde.inserirAjusteGrade');
            Route::post("/movimentograde/inserirEntradaSaida",[MovimentoGradeController::class,"inserirEntradaSaida"])->name('movimentograde.inserirEntradaSaida');
            Route::post("/movimentograde/salvarJs",[MovimentoGradeController::class,"salvarJs"])->name('movimentograde.salvarJs');
            Route::resource('/movimentograde',MovimentoGradeController::class);

            Route::get("/movimentoconta/extrato01",[MovimentoContaController::class,"extrato01"])->name('movimentoconta.extrato01');
            Route::get("/movimentoconta/saldo",[MovimentoContaController::class,"saldo"])->name('movimentoconta.saldo');
            Route::get("/movimentoconta/fluxoConta",[MovimentoContaController::class,"fluxoConta"])->name('movimentoconta.fluxoConta');
            Route::get("/movimentoconta/resumoFinanceiro",[MovimentoContaController::class,"resumoFinanceiro"])->name('movimentoconta.resumoFinanceiro');
            Route::get("/movimentoconta/extrato",[MovimentoContaController::class,"extrato"])->name('movimentoconta.extrato');


            Route::get("/movimentoconta/filtro",[MovimentoContaController::class,"filtro"])->name('movimentoconta.filtro');
            Route::resource('/movimentoconta',MovimentoContaController::class);


            Route::get("/consulta/teste/",[ConsultaController::class,"teste"])->name("consulta.teste");

            Route::get("/consulta/produto/",[ConsultaController::class,"produto"])->name("consulta.produto");
            Route::get("/consulta/venda/",[ConsultaController::class,"venda"])->name("consulta.venda");
            Route::get("/consulta/estoque/",[ConsultaController::class,"estoque"])->name("consulta.estoque");
            Route::get("/consulta/contareceber/",[ConsultaController::class,"contareceber"])->name("consulta.contareceber");
            Route::get("/consulta/recebimento/",[ConsultaController::class,"recebimento"])->name("consulta.recebimento");
            Route::get("/consulta/contapagar/",[ConsultaController::class,"contapagar"])->name("consulta.contapagar");
            Route::get("/consulta/pagamento/",[ConsultaController::class,"pagamento"])->name("consulta.pagamento");
            Route::get("/consulta/movimentoconta/",[ConsultaController::class,"movimentoconta"])->name("consulta.movimentoconta");
            Route::get("/consulta/pdv/",[ConsultaController::class,"pdv"])->name("consulta.pdv");
            Route::get("/consulta/lojavirtual/",[ConsultaController::class,"lojavirtual"])->name("consulta.lojavirtual");


            Route::resource('/classificacaofinanceira',ClassificacaoFinanceiraController::class);


            Route::get('/clienterecorrente/cobrancas/{id}',[ClienteRecorrenteController::class,'cobrancas'])->name('clienterecorrente.cobrancas');
            Route::resource('/clienterecorrente',ClienteRecorrenteController::class);

            Route::resource('/recorrencia',RecorrenciaController::class);

            Route::resource('/modelocontrato',ModeloContratoController::class);

            Route::get('/produtorecorrente/buscaPorId',[ProdutoRecorrenteController::class,'buscaPorId'])->name('produtorecorrente.buscaPorId');
            Route::post('/produtorecorrente/inserirServico',[ProdutoRecorrenteController::class,'inserirServico'])->name('produtorecorrente.inserirServico');
            Route::post('/produtorecorrente/inserirProduto',[ProdutoRecorrenteController::class,'inserirProduto'])->name('produtorecorrente.inserirProduto');
            Route::get('/produtorecorrente/excluirItem/{id}',[ProdutoRecorrenteController::class,'excluirItem'])->name('produtorecorrente.excluirItem');
            Route::resource('/produtorecorrente',ProdutoRecorrenteController::class);


            Route::get('/vendarecorrente/pdf/{id}',[VendaRecorrenteController::class,'pdf'])->name('vendarecorrente.pdf');
            Route::get('/vendarecorrente/novaCobranca/{id}',[VendaRecorrenteController::class,'novaCobranca'])->name('vendarecorrente.novaCobranca');
            Route::get('/vendarecorrente/filtro',[VendaRecorrenteController::class,'filtro'])->name('vendarecorrente.filtro');
            Route::post('/vendarecorrente/gerarCobranca',[VendaRecorrenteController::class,'gerarCobranca'])->name('vendarecorrente.gerarCobranca');
            Route::post('/vendarecorrente/salvar',[VendaRecorrenteController::class,'salvar'])->name('vendarecorrente.salvar');
            Route::resource('/vendarecorrente',VendaRecorrenteController::class);

            Route::get("/ordemservico/filtro",[OrdemServicoController::class,"filtro"])->name('ordemservico.filtro');
            Route::resource('/ordemservico',OrdemServicoController::class);

            Route::resource("/produtoos",ProdutoOsController::class);

            Route::resource("/servicoos",ServicoOsController::class);

            Route::resource("/anotacaoos",AnotacaoOsController::class);

            Route::post("/chamado/salvarResposta",[ChamadoController::class,"salvarResposta"])->name("chamado.salvarResposta");
            Route::resource('/chamado',ChamadoController::class);

            Route::resource('/certificadodigital',CertificadoDigitalController::class);

            Route::resource('/cupomdesconto',CupomDescontoController::class);

            Route::get('/estoque/minimo',[EstoqueController::class,'minimo'])->name('estoque.minimo');
            Route::get('/estoque/vencimento',[EstoqueController::class,'vencimento'])->name('estoque.vencimento');
            Route::resource("/estoque",EstoqueController::class);


            Route::post('/itemvenda/ajustarGrade',[ItemVendaController::class,'ajustarGrade'])->name('itemvenda.ajustarGrade');
            Route::resource("/itemvenda",ItemVendaController::class);

            Route::post('/itemcompra/ajustarGrade',[ItemCompraController::class,'ajustarGrade'])->name('itemcompra.ajustarGrade');
            Route::resource("/itemcompra",ItemCompraController::class);


            Route::post('/grade/alterarCodigoBarra',[GradeController::class,'alterarCodigoBarra'])->name('grade.alterarCodigoBarra');
            Route::post('/grade/gradeParaEntradaSaida',[GradeController::class,'gradeParaEntradaSaida'])->name('grade.gradeParaEntradaSaida');
            Route::post('/grade/gradeComMovimento',[GradeController::class,'gradeComMovimento'])->name('grade.gradeComMovimento');
            Route::post('/grade/gradeTempComMovimento',[GradeController::class,'gradeTempComMovimento'])->name('grade.gradeTempComMovimento');
            Route::post('/grade/gerar',[GradeController::class,'gerar'])->name('grade.gerar');
            Route::post('/grade/inserirEstoque',[GradeController::class,'inserirEstoque'])->name('grade.inserirEstoque');
            Route::get('/grade/listaJs/{produto_id}',[GradeController::class,'listaJs'])->name('grade.listaJs');
            Route::resource("/grade",GradeController::class);

            Route::resource("/itemorcamento",ItemOrcamentoController::class);
            //Cadastro
            Route::post('/categoria/salvarJs',[CategoriaController::class,'salvarJs'])->name('categoria.salvarJs');
            Route::post('/categoria/salvarSubCategoriaJs',[CategoriaController::class,'salvarSubCategoriaJs'])->name('categoria.salvarSubCategoriaJs');
            Route::post('/categoria/salvarSubSubCategoriaJs',[CategoriaController::class,'salvarSubSubCategoriaJs'])->name('categoria.salvarSubSubCategoriaJs');

            Route::get('/categoria/listarSubcategoriaPelaCategoria/{id}',[CategoriaController::class,'listarSubcategoriaPelaCategoria'])->name('categoria.listarSubcategoriaPelaCategoria');
            Route::get('/categoria/listarSubSubcategoriaPelaSubCategoria/{id}',[CategoriaController::class,'listarSubSubcategoriaPelaSubCategoria'])->name('categoria.listarSubSubcategoriaPelaSubCategoria');
            Route::get('/categoria/listarCategoria',[CategoriaController::class,'listarCategoria'])->name('categoria.listarCategoria');
            Route::get("/categoria/pesquisa",[CategoriaController::class,"pesquisa"])->name('categoria.pesquisa');
            Route::get('/categoria/selecionarCategoria/{id}',[CategoriaController::class,'selecionarCategoria'])->name('categoria.selecionarCategoria');

            Route::resource('/categoria',CategoriaController::class);

            Route::post('/subcategoria/salvarJs',[SubCategoriaController::class,'salvarJs'])->name('subcategoria.salvarJs');
            Route::resource('/subcategoria',SubCategoriaController::class);
            Route::resource('/subsubcategoria',SubSubCategoriaController::class);

            Route::get('/tributacao/tornarPadrao/{id}',[TributacaoController::class,'tornarPadrao'])->name('tributacao.tornarPadrao');
            Route::post('/tributacao/inserirProduto',[TributacaoController::class,'inserirProduto'])->name('tributacao.inserirProduto');
            Route::get('/tributacao/listaProdutoTributacao/{id}',[TributacaoController::class,'listaProdutoTributacao'])->name('tributacao.listaProdutoTributacao');
            Route::get('/tributacao/excluirProdutoTributacao/{id}',[TributacaoController::class,'excluirProdutoTributacao'])->name('tributacao.excluirProdutoTributacao');
            Route::post('/tributacao/inserirEstado',[TributacaoController::class,'inserirEstado'])->name('tributacao.inserirEstado');
            Route::get('/tributacao/listaTributacaoEstado/{id}',[TributacaoController::class,'listaTributacaoEstado'])->name('tributacao.listaTributacaoEstado');
            Route::get('/tributacao/excluirEstadoTributacao/{id}',[TributacaoController::class,'excluirEstadoTributacao'])->name('tributacao.excluirEstadoTributacao');
            Route::post('/tributacao/inserirIva',[TributacaoController::class,'inserirIva'])->name('tributacao.inserirIva');
            Route::get('/tributacao/listaTributacaoIva/{id}',[TributacaoController::class,'listaTributacaoIva'])->name('tributacao.listaTributacaoIva');
            Route::get('/tributacao/excluirIvaTributacao/{id}',[TributacaoController::class,'excluirIvaTributacao'])->name('tributacao.excluirIvaTributacao');
            Route::resource('/tributacao',TributacaoController::class);

            Route::resource('/tributacaoproduto',TributacaoProdutoController::class);

            Route::get('/naturezaoperacao/listaProdutoTributacao/{tabela}/{id}',[NaturezaOperacaoController::class,'listaProdutoTributacao'])->name('naturezaoperacao.listaProdutoTributacao');
            Route::get('/naturezaoperacao/excluirProdutoTributacao/{tabela}/{id}',[NaturezaOperacaoController::class,'excluirProdutoTributacao'])->name('naturezaoperacao.excluirProdutoTributacao');
            Route::get('/naturezaoperacao/buscarCstIpi/{id}',[NaturezaOperacaoController::class,'buscarCstIpi'])->name('naturezaoperacao.buscarCstIpi');
            Route::get('/naturezaoperacao/buscarListaCfop/{id}',[NaturezaOperacaoController::class,'buscarListaCfop'])->name('naturezaoperacao.buscarListaCfop');
            Route::get('/naturezaoperacao/tributacao/{id}',[NaturezaOperacaoController::class,'tributacao'])->name('naturezaoperacao.tributacao');

            Route::resource('/naturezaoperacao',NaturezaOperacaoController::class);

            Route::get("/fornecedor/pdf",[FornecedorController::class,"pdf"])->name('fornecedor.pdf');
            Route::get('/fornecedor/buscarCNPJ/{cnpj}',[FornecedorController::class,'buscarCNPJ'])->name('fornecedor.buscarCNPJ');
            Route::get('/fornecedor/find/{id}',[FornecedorController::class,'find'])->name('fornecedor.find');
            Route::get("/fornecedor/pesquisa",[FornecedorController::class,"pesquisa"])->name('fornecedor.pesquisa');
            Route::get('/fornecedor/movimento/{id}',[FornecedorController::class,'movimento'])->name('fornecedor.movimento');
            Route::resource('/fornecedor',FornecedorController::class);

            Route::get("/cliente/pdf",[ClienteController::class,"pdf"])->name('cliente.pdf');
            Route::get('/cliente/buscarCNPJ/{cnpj}',[ClienteController::class,'buscarCNPJ'])->name('cliente.buscarCNPJ');
            Route::get("/cliente/pesquisa",[ClienteController::class,"pesquisa"])->name('cliente.pesquisa');
            Route::get('/cliente/find/{id}',[ClienteController::class,'find'])->name('cliente.find');
            Route::get('/cliente/movimento/{id}',[ClienteController::class,'movimento'])->name('cliente.movimento');
            Route::get('/cliente/vendasPaga/{id}',[ClienteController::class,'vendasPaga'])->name('cliente.vendasPaga');
            Route::get('/cliente/vendasAberto/{id}',[ClienteController::class,'vendasAberto'])->name('cliente.vendasAberto');
            Route::get('/cliente/endereco/{id}',[ClienteController::class,'endereco'])->name('cliente.endereco');
            Route::resource('/cliente',ClienteController::class);


            Route::get('/enderecocliente/listaPorCliente/{id}',[EnderecoClienteController::class,'listaPorCliente'])->name('enderecocliente.listaPorCliente');
            Route::get('/enderecocliente/buscar/{id}',[EnderecoClienteController::class,'buscar'])->name('enderecocliente.buscar');
            Route::resource('/enderecocliente', EnderecoClienteController::class);

            Route::get("/vendedor/pdf",[VendedorController::class,"pdf"])->name('vendedor.pdf');
            Route::get("/vendedor/pesquisa",[VendedorController::class,"pesquisa"])->name('vendedor.pesquisa');
            Route::get('/vendedor/find/{id}',[VendedorController::class,'find'])->name('vendedor.find');
            Route::get('/vendedor/movimento/{id}',[VendedorController::class,'movimento'])->name('vendedor.movimento');
            Route::resource('/vendedor',VendedorController::class);

            Route::get("/transportadora/pdf",[TransportadoraController::class,"pdf"])->name('transportadora.pdf');
            Route::get('/transportadora/buscarCNPJ/{cnpj}',[TransportadoraController::class,'buscarCNPJ'])->name('transportadora.buscarCNPJ');
            Route::get('/transportadora/lista',[TransportadoraController::class,'lista'])->name('transportadora.lista');
            Route::get('/transportadora/find/{id}',[TransportadoraController::class,'find'])->name('transportadora.find');
            Route::get('/transportadora/movimento/{id}',[TransportadoraController::class,'movimento'])->name('transportadora.movimento');
            Route::get('/transportadora/selecionarTransportadora/{id}/{id_nfe}',[TransportadoraController::class,'selecionarTransportadora'])->name('transportadora.selecionarTransportadora');
            Route::get("/transportadora/pesquisa",[TransportadoraController::class,"pesquisa"])->name('transportadora.pesquisa');
            Route::resource('/transportadora',TransportadoraController::class);

            Route::resource('/grupoproduto', GrupoProdutoController::class);


            Route::get("/produto/novoPeloXml/{id}",[ProdutoController::class,"novoPeloXml"])->name('produto.novoPeloXml');
            Route::get("/produto/selecionarRelatorioSintetico",[ProdutoController::class,"selecionarRelatorioSintetico"])->name('produto.selecionarRelatorioSintetico');
            Route::get('/produto/relatorioSintetico',[ProdutoController::class,'relatorioSintetico'])->name('produto.relatorioSintetico');
            Route::get("/produto/pdf",[ProdutoController::class,"pdf"])->name('produto.pdf');
            Route::get("/produto/filtro",[ProdutoController::class,"filtro"])->name('produto.filtro');
            Route::get("/produto/pesquisa",[ProdutoController::class,"pesquisa"])->name('produto.pesquisa');
            Route::get("/produto/buscarServico",[ProdutoController::class,"buscarServico"])->name('produto.buscarServico');
            Route::get('/produto/pesquisarProdutoPorId/{id}',[ProdutoController::class,'pesquisarProdutoPorId'])->name('produto.pesquisarProdutoPorId');
            Route::get('/produto/getProduto/{id}',[ProdutoController::class,'getProduto'])->name('produto.getProduto');
            Route::get('/produto/detalhe/{id}',[ProdutoController::class,'detalhe'])->name('produto.detalhe');
            Route::get('/produto/clonarProduto/{id}',[ProdutoController::class,'clonarProduto'])->name('produto.clonarProduto');
            Route::get('/produto/all',[ProdutoController::class,'all'])->name('produto.all');
            Route::post('/produto/salvarProdutoDaNota',[ProdutoController::class,'salvarProdutoDaNota'])->name('produto.salvarProdutoDaNota');
            Route::post('/produto/salvarJs',[ProdutoController::class,'salvarJs'])->name('produto.salvarJs');
            Route::post("/produto/salvarImagemJs",[ProdutoController::class,"salvarImagemJs"])->name('produto.salvarImagemJs');
            Route::resource('/produto', ProdutoController::class);


            Route::post('/servico/salvarJs',[ServicoController::class,'salvarJs'])->name('servico.salvarJs');
            Route::resource('/servico', ServicoController::class);

            Route::get("/notafiscal/filtro",[NotaFiscalController::class,"filtro"])->name('notafiscal.filtro');
            Route::get('/notafiscal/excluir/{id}',[NotaFiscalController::class,'excluir'])->name('notafiscal.excluir');
            Route::get('/notafiscal/edit/{id}',[NotaFiscalController::class,'edit'])->name('notafiscal.edit');
            Route::get('/notafiscal/devolucaoVenda/{id}',[NotaFiscalController::class,'devolucaoVenda'])->name('notafiscal.devolucaoVenda');
            Route::get('/notafiscal/devolucaoCompra/{id}/{natureza_id}',[NotaFiscalController::class,'devolucaoCompra'])->name('notafiscal.devolucaoCompra');
            Route::get('/notafiscal/',[NotaFiscalController::class,'index'])->name('notafiscal.index');
            Route::get('/notafiscal/create',[NotaFiscalController::class,'create'])->name('notafiscal.create');
            Route::get('/notafiscal/notaPorVenda',[NotaFiscalController::class,'notaPorVenda'])->name('notafiscal.notaPorVenda');
            Route::get('/notafiscal/salvarNfePorVenda/{id}/{natureza_id}',[NotaFiscalController::class,'salvarNfePorVenda'])->name('notafiscal.salvarNfePorVenda');
            Route::get('/notafiscal/salvarNfePorPedidoLoja/{id}/{natureza_id}',[NotaFiscalController::class,'salvarNfePorPedidoLoja'])->name('notafiscal.salvarNfePorPedidoLoja');
            Route::get('/notafiscal/salvarNfcePelaVenda/{id}/{natureza_id}',[NotaFiscalController::class,'salvarNfcePelaVenda'])->name('notafiscal.salvarNfcePelaVenda');

            Route::get('/notafiscal/salvarNfePorCompra/{id}',[NotaFiscalController::class,'salvarNfePorCompra'])->name('notafiscal.salvarNfePorCompra');
            Route::post('/notafiscal/salvar',[NotaFiscalController::class,'salvar'])->name('notafiscal.salvar');
            Route::post('/notafiscal/inserirAutorizado',[NotaFiscalController::class,'inserirAutorizado'])->name('notafiscal.inserirAutorizado');
            Route::get('/notafiscal/excluirAutorizado/{id}',[NotaFiscalController::class,'excluirAutorizado'])->name('notafiscal.excluirAutorizado');
            Route::post('/notafiscal/inserirReferenciado',[NotaFiscalController::class,'inserirReferenciado'])->name('notafiscal.inserirReferenciado');
            Route::get('/notafiscal/excluirReferenciado/{id}',[NotaFiscalController::class,'excluirReferenciado'])->name('notafiscal.excluirReferenciado');
            Route::get('/notafiscal/inutilizar',[NotaFiscalController::class,'inutilizar'])->name('notafiscal.inutilizar');
            Route::post('/notafiscal/criarNota',[NotaFiscalController::class,'criarNota'])->name('notafiscal.criarNota');
            Route::post('/notafiscal/atualizarDadosPagamentos',[NotaFiscalController::class,'atualizarDadosPagamentos'])->name('notafiscal.atualizarDadosPagamentos');
            Route::get('/notafiscal/salvarNfePorVendaJs/{id}',[NotaFiscalController::class,'salvarNfePorVendaJs'])->name('notafiscal.salvarNfePorVendaJs');
            Route::get('/notafiscal/calcularImpostos/{id}',[NotaFiscalController::class,'calcularImpostos'])->name('notafiscal.calcularImpostos');
            Route::get('/notafiscal/configurarProdutoNfe/{id}',[NotaFiscalController::class,'configurarProdutoNfe'])->name('notafiscal.configurarProdutoNfe');
            Route::post('/notafiscal/salvarSemCalculo',[NotaFiscalController::class,'salvarSemCalculo'])->name('notafiscal.salvarSemCalculo');
            Route::post('/notafiscal/cadastrarProduto',[NotaFiscalController::class,'cadastrarProduto'])->name('notafiscal.cadastrarProduto');
            Route::get('/notafiscal/edicaoLivre/{id}',[NotaFiscalController::class,'edicaoLivre'])->name('notafiscal.edicaoLivre');
            Route::get('/notafiscal/lerArquivo',[NotaFiscalController::class,'lerArquivo'])->name('notafiscal.lerArquivo');
            Route::get('/notafiscal/vincularProduto/{idproduto}/{idItem}',[NotaFiscalController::class,'vincularProduto'])->name('notafiscal.vincularProduto');
            Route::post('/notafiscal/importarNfe',[NotaFiscalController::class,'importarNfe'])->name('notafiscal.importarNfe');



            Route::post('/itemnotafiscal/inserir',[ItemNotaFiscalController::class,'inserir'])->name('itemnotafiscal.inserir');
            Route::get('/itemnotafiscal/excluir/{id}',[ItemNotaFiscalController::class,'excluir'])->name('itemnotafiscal.excluir');
            Route::get('/itemnotafiscal/detalhe/{id}',[ItemNotaFiscalController::class,'detalhe'])->name('itemnotafiscal.detalhe');
            Route::post('/itemnotafiscal/atualizar',[ItemNotaFiscalController::class,'atualizar'])->name('itemnotafiscal.atualizar');
            Route::post('/itemnotafiscal/recalcular',[ItemNotaFiscalController::class,'recalcular'])->name('itemnotafiscal.recalcular');
            Route::post('/itemnotafiscal/atualizarSemCalculo',[ItemNotaFiscalController::class,'atualizarSemCalculo'])->name('itemnotafiscal.atualizarSemCalculo');
            Route::post('/itemnotafiscal/inserirSemCalculo',[ItemNotaFiscalController::class,'inserirSemCalculo'])->name('itemnotafiscal.inserirSemCalculo');
            Route::get('/itemnotafiscal/excluirSemCalculo/{id}',[ItemNotaFiscalController::class,'excluirSemCalculo'])->name('itemnotafiscal.excluirSemCalculo');

            Route::post('/nfeduplicata/inserir',[NfeDuplicataController::class,'inserir'])->name('nfeduplicata.inserir');
            Route::post('/nfeduplicata/salvarAlteracao',[NfeDuplicataController::class,'salvarAlteracao'])->name('nfeduplicata.salvarAlteracao');
            Route::get('/nfeduplicata/excluir/{id}',[NfeDuplicataController::class,'excluir'])->name('nfeduplicata.excluir');

            Route::resource('/nfepagamento', NfePagamentoController::class);

            Route::get('/notanfce/edit/{id}',[NotaNfceController::class,'edit'])->name('notanfce.edit');
            Route::resource('/notanfce', NotaNfceController::class);

            Route::resource('/permissao', PermissaoController::class);

            Route::post('/funcao/salvarJs',[FuncaoController::class,'salvarJs'])->name('funcao.salvarJs');
            Route::any('funcao/{id}/vincular',[FuncaoController::class,'vincular'])->name('funcao.vincular');
            Route::get('/funcao/permissao/{id}',[FuncaoController::class,'permissao'])->name('funcao.permissao');
            Route::get('/funcao/menu/{id}/{id_menu?}',[FuncaoController::class,'menu'])->name('funcao.menu');
            Route::resource('/funcao', FuncaoController::class);


            Route::post('/funcao/{id}/permissao',[FuncaoPermissaoController::class,'vincularPermissao'])->name('funcao.vincularPermissao');
            Route::post('/funcao/{id}/menu',[FuncaoPermissaoController::class,'vincularMenu'])->name('funcao.vincularMenu');

            Route::post('/funcaopermissao/salvar',[FuncaoPermissaoController::class,'salvar'])->name('funcaopermissao.salvar');
            Route::resource('/funcaopermissao', FuncaoPermissaoController::class);

            Route::resource('/funcaousuario', FuncaoUsuarioController::class);

            Route::get('/usuario/funcoes/{id}', [UsuarioController::class,'funcoes'])->name('usuario.funcoes');

            // Route::get('/usuario', [UsuarioController::class,'perfis'])->name('usuario.perfis');

            Route::resource("/usuario", UsuarioController::class);

            Route::get('/pedidocliente/excluir/{id}', [PedidoClienteController::class,'excluir'])->name('pedidocliente.excluir');
            Route::get('/pedidocliente/filtro', [PedidoClienteController::class,'filtro'])->name('pedidocliente.filtro');
            Route::get('/pedidocliente/verVenda/{id}', [PedidoClienteController::class,'verVenda'])->name('pedidocliente.verVenda');
            Route::get('/pedidocliente/recusar/{id}', [PedidoClienteController::class,'recusar'])->name('pedidocliente.recusar');
            Route::get('/pedidocliente/gerarVendaPeloPedido/{id}', [PedidoClienteController::class,'gerarVendaPeloPedido'])->name('pedidocliente.gerarVendaPeloPedido');
            Route::resource('/pedidocliente', PedidoClienteController::class);


            Route::post('/nfe/email',[NfeController::class,'email'])->name('nfe.email');
            Route::get('/nfe/verXML/{id}',[NfeController::class,'verXML'])->name('nfe.verXML');
            Route::get('/nfe/verXMLNormal/{id}',[NfeController::class,'verXMLNormal'])->name('nfe.verXMLNormal');
            Route::get('/nfe/danfe/{id}',[NfeController::class,'danfe'])->name('nfe.danfe');
            Route::get('/nfe/imprimirDanfePelaChave/{id}',[NfeController::class,'imprimirDanfePelaChave'])->name('nfe.imprimirDanfePelaChave');
            Route::get('/nfe/imprimirDanfePelaNfe/{id}',[NfeController::class,'imprimirDanfePelaNfe'])->name('nfe.imprimirDanfePelaNfe');
            Route::get('/nfe/imprimirDanfePelaVenda/{id}',[NfeController::class,'imprimirDanfePelaVenda'])->name('nfe.imprimirDanfePelaVenda');
            Route::get('/nfe/baixarXML/{id}',[NfeController::class,'baixarXML'])->name('nfe.baixarXML');
            Route::get('/nfe/baixarPdf/{id}',[NfeController::class,'baixarPdf'])->name('nfe.baixarPdf');
            Route::get('/nfe/transmitir/{id}',[NfeController::class,'transmitir'])->name('nfe.transmitir');
            Route::get('/nfe/transmitirJs/{id}',[NfeController::class,'transmitirJs'])->name('nfe.transmitirJs');
            Route::get('/nfe/transmitirNfePelaVendaJs/{id}',[NfeController::class,'transmitirNfePelaVendaJs'])->name('nfe.transmitirNfePelaVendaJs');
            Route::post('/nfe/cartaCorrecao',[NfeController::class,'cartaCorrecao'])->name('nfe.cartaCorrecao');
            Route::post('/nfe/inutilizarNfe',[NfeController::class,'inutilizarNfe'])->name('nfe.inutilizarNfe');
            Route::get('/nfe/imprimirCce/{id}',[NfeController::class,'imprimirCce'])->name('nfe.imprimirCce');
            Route::get('/nfe/consultarNfe/{id}',[NfeController::class,'consultarNfe'])->name('nfe.consultarNfe');
            Route::get('/nfe/simularDanfe/{id}',[NfeController::class,'simularDanfe'])->name('nfe.simularDanfe');
            Route::post('/nfe/cancelarNfe',[NfeController::class,'cancelarNfe'])->name('nfe.cancelarNfe');
            Route::get('/nfe/imprimircancelado/{id}',[NfeController::class,'imprimircancelado'])->name('nfe.imprimircancelado');


            Route::get('/nfeentrada/produtos/{id?}',[NfeEntradaController::class,'produtos'])->name('nfeentrada.produtos');
            Route::get('/nfeentrada/filtro',[NfeEntradaController::class,'filtro'])->name('nfeentrada.filtro');
            Route::get('/nfeentrada/ver/{id}',[NfeEntradaController::class,'ver'])->name('nfeentrada.ver');
            Route::get('/nfeentrada/vincularProduto/{idproduto}/{idItem}',[NfeEntradaController::class,'vincularProduto'])->name('nfeentrada.vincularProduto');
            Route::post('/nfeentrada/darEntrada',[NfeEntradaController::class,'darEntrada'])->name('nfeentrada.darEntrada');
            Route::get('/nfeentrada/excluir/{id}',[NfeEntradaController::class,'excluir'])->name('nfeentrada.excluir');
            Route::get('/nfeentrada/buscar/{id}',[NfeEntradaController::class,'buscar'])->name('nfeentrada.buscar');
            Route::get('/nfeentrada/index',[NfeEntradaController::class,'index'])->name('nfeentrada.index');
            Route::post('/nfeentrada/atualizarProduto',[NfeEntradaController::class,'atualizarProduto'])->name('nfeentrada.atualizarProduto');
            Route::post('/nfeentrada/cadastrarProduto',[NfeEntradaController::class,'cadastrarProduto'])->name('nfeentrada.cadastrarProduto');

            Route::post('/nfe/importar',[NfeEntradaController::class,'importar'])->name('nfe.importar');
            Route::get('/nfe/lerArquivo',[NfeEntradaController::class,'lerArquivo'])->name('nfe.lerArquivo');




            Route::post('/nfce/email',[NfceController::class,'email'])->name('nfce.email');
            Route::get('/nfce/verXML/{id}',[NfceController::class,'verXML'])->name('nfce.verXML');
            Route::get('/nfce/danfce/{id}',[NfceController::class,'danfce'])->name('nfce.danfce');
            Route::get('/nfce/imprimirDanfcePelaVenda/{id}',[NfceController::class,'imprimirDanfcePelaVenda'])->name('nfce.imprimirDanfcePelaVenda');
            Route::get('/nfce/baixarXML/{id}',[NfceController::class,'baixarXML'])->name('nfce.baixarXML');
            Route::get('/nfce/baixarPdf/{id}',[NfceController::class,'baixarPdf'])->name('nfce.baixarPdf');
            Route::get('/nfce/transmitirPelaNfce/{id}',[NfceController::class,'transmitirPelaNfce'])->name('nfce.transmitirPelaNfce');
            Route::get('/nfce/transmitirJs/{id}',[NfceController::class,'transmitirJs'])->name('nfce.transmitirJs');
            Route::get('/nfce/transmitir/{id}',[NfceController::class,'transmitir'])->name('nfce.transmitir');


            Route::post("/entrada/salvarJs",[EntradaController::class,"salvarJs"])->name('entrada.salvarJs');
            Route::get("/entrada/filtro",[EntradaController::class,"filtro"])->name('entrada.filtro');
            Route::resource('/entrada',EntradaController::class);


            Route::post("/saida/salvarJs",[SaidaController::class,"salvarJs"])->name('saida.salvarJs');
            Route::get("/saida/filtro",[SaidaController::class,"filtro"])->name('saida.filtro');
            Route::resource('/saida',SaidaController::class);


            Route::get("/movimento/selecionarRelatorio",[MovimentoController::class,"selecionarRelatorio"])->name('movimento.selecionarRelatorio');
            Route::get('/movimento/imprimir',[MovimentoController::class,'imprimir'])->name('movimento.imprimir');
            Route::get('/movimento/filtro',[MovimentoController::class,'filtro'])->name('movimento.filtro');
            Route::get('/movimento/selecionarProduto',[MovimentoController::class,'selecionarProduto'])->name('movimento.selecionarProduto');
            Route::get('/movimento/verMovimento/{id?}',[MovimentoController::class,'verMovimento'])->name('movimento.verMovimento');
            Route::get('/movimento/historicoProduto',[MovimentoController::class,'historicoProduto'])->name('movimento.historicoProduto');
            Route::get('/movimento/historicoGeral',[MovimentoController::class,'historicoGeral'])->name('movimento.historicoGeral');
            Route::resource('/movimento',MovimentoController::class);


            Route::post('/compra/atualizarDadosPagamentos',[CompraController::class,'atualizarDadosPagamentos'])->name('compra.atualizarDadosPagamentos');
            Route::get('/compra',[CompraController::class,'index'])->name('compra.index');
            Route::get('/compra/create',[CompraController::class,'create'])->name('compra.create');
            Route::post('/compra/salvar',[CompraController::class,'salvar'])->name('compra.salvar');
            Route::post('/compra/salvarNfFiscal',[CompraController::class,'salvarNfFiscal'])->name('compra.salvarNfFiscal');
            Route::get('/compra/detalhe/{id}',[CompraController::class,'detalhe'])->name('compra.detalhe');
            Route::get('/compra/financeiro/{id}',[CompraController::class,'financeiro'])->name('compra.financeiro');
            Route::get('/compra/lancarEstoque/{id}',[CompraController::class,'lancarEstoque'])->name('compra.lancarEstoque');
            Route::get('/compra/estornarEstoque/{id}',[CompraController::class,'estornarEstoque'])->name('compra.estornarEstoque');
            Route::get('/compra/excluir/{id}',[CompraController::class,'excluir'])->name('compra.excluir');
            Route::get('/compra/emitirEntrada/{id}',[CompraController::class,'emitirEntrada'])->name('compra.emitirEntrada');
            Route::get('/compra/edit/{id}',[CompraController::class,'edit'])->name('compra.edit');
            Route::get('/compra/CompraNfe/{id}',[CompraController::class,'CompraNfe'])->name('compra.CompraNfe');
            Route::post('/compra/finalizarCompra',[CompraController::class,'finalizarCompra'])->name('compra.finalizarCompra');
            Route::get("/compra/filtro",[CompraController::class,"filtro"])->name('compra.filtro');


            //Orçamento
            Route::post('/orcamento/finalizarOrcamento',[OrcamentoController::class,'finalizarOrcamento'])->name('orcamento.finalizarOrcamento');
            Route::get('/orcamento/transformarEmVenda/{id}',[OrcamentoController::class,'transformarEmVenda'])->name('orcamento.transformarEmVenda');
            Route::post('/orcamento/atualizarDadosPagamentos',[OrcamentoController::class,'atualizarDadosPagamentos'])->name('orcamento.atualizarDadosPagamentos');
            Route::get('/orcamento/encerrar/{id}',[OrcamentoController::class,'encerrar'])->name('orcamento.encerrar');
            Route::get('/orcamento/pdf/{id}',[OrcamentoController::class,'pdf'])->name('orcamento.pdf');
            Route::post('/orcamento/salvar',[OrcamentoController::class,'salvar'])->name('orcamento.salvar');
            Route::get("/orcamento/filtro",[OrcamentoController::class,"filtro"])->name('orcamento.filtro');
            Route::get('/orcamento/edit/{id}',[OrcamentoController::class,'edit'])->name('orcamento.edit');
            Route::resource("/orcamento",OrcamentoController::class);


            //Venda
            Route::get("/venda/selecionarRelatorioSintetico",[VendaController::class,"selecionarRelatorioSintetico"])->name('venda.selecionarRelatorioSintetico');
            Route::get("/venda/selecionarRelatorioAnalitico",[VendaController::class,"selecionarRelatorioAnalitico"])->name('venda.selecionarRelatorioAnalitico');
            Route::get('/venda/relatorioSintetico',[VendaController::class,'relatorioSintetico'])->name('venda.relatorioSintetico');
            Route::get('/venda/relatorioAnalitico',[VendaController::class,'relatorioAnalitico'])->name('venda.relatorioAnalitico');
            Route::get("/venda/filtro",[VendaController::class,"filtro"])->name('venda.filtro');
            Route::get('/venda/gerarNfePelaVenda/{id}',[VendaController::class,'gerarNfePelaVenda'])->name('venda.gerarNfePelaVenda');
            Route::get('/venda/buscarNfcePelaVenda/{id}',[VendaController::class,'buscarNfcePelaVenda'])->name('venda.buscarNfcePelaVenda');
            Route::get('/venda/salvar_e_transmitir/{id}',[VendaController::class,'salvar_e_transmitir'])->name('venda.salvar_e_transmitir');
            Route::get('/venda/pdf/{id}',[VendaController::class,'pdf'])->name('venda.pdf');
            Route::get('/venda/cupom/{id}',[VendaController::class,'cupom'])->name('venda.cupom');
            Route::get('/venda',[VendaController::class,'index'])->name('venda.index');
            Route::get('/venda/create',[VendaController::class,'create'])->name('venda.create');
            Route::post('/venda/salvar',[VendaController::class,'salvar'])->name('venda.salvar');
            Route::post('/venda/finalizarVenda',[VendaController::class,'finalizarVenda'])->name('venda.finalizarVenda');
            Route::post('/venda/salvarNfFiscal',[VendaController::class,'salvarNfFiscal'])->name('venda.salvarNfFiscal');
            Route::post('/venda/atualizarDadosPagamentos',[VendaController::class,'atualizarDadosPagamentos'])->name('venda.atualizarDadosPagamentos');
            Route::get('/venda/financeiro/{id}',[VendaController::class,'financeiro'])->name('venda.financeiro');
            Route::get('/venda/lancarEstoque/{id}',[VendaController::class,'lancarEstoque'])->name('venda.lancarEstoque');
            Route::get('/venda/estornarEstoque/{id}',[VendaController::class,'estornarEstoque'])->name('venda.estornarEstoque');
            Route::get('/venda/estornarContaReceber/{id}',[VendaController::class,'estornarContaReceber'])->name('venda.estornarContaReceber');
            Route::get('/venda/cancelarVenda/{id}',[VendaController::class,'cancelarVenda'])->name('venda.cancelarVenda');
            Route::get('/venda/detalhe/{id}',[VendaController::class,'detalhe'])->name('venda.detalhe');
            Route::get('/venda/edit/{id}',[VendaController::class,'edit'])->name('venda.edit');
            Route::get('/venda/excluir/{id}',[VendaController::class,'excluir'])->name('venda.excluir');
            Route::get('/venda/emitirSaida/{id}',[VendaController::class,'emitirSaida'])->name('venda.emitirSaida');
            Route::get('/venda/clonarVenda/{id}',[VendaController::class,'clonarVenda'])->name('venda.clonarVenda');
            Route::get('/venda/salvarNfePorVenda/{id}',[VendaController::class,'salvarNfePorVenda'])->name('venda.salvarNfePorVenda');
            Route::get('/venda/buscar/{id}',[VendaController::class,'buscar'])->name('venda.salvarNfePorVenda');



            Route::post('/duplicata/inserir',[DuplicataController::class,'inserir'])->name('duplicata.inserir');
            Route::post('/duplicata/salvarAlteracao',[DuplicataController::class,'salvarAlteracao'])->name('duplicata.salvarAlteracao');
            Route::get('/duplicata/excluir/{id}',[DuplicataController::class,'excluir'])->name('duplicata.excluir');

            Route::post('/duplicatacompra/inserir',[DuplicataCompraController::class,'inserir'])->name('duplicatacompra.inserir');
            Route::post('/duplicatacompra/salvarAlteracao',[DuplicataCompraController::class,'salvarAlteracao'])->name('duplicatacompra.salvarAlteracao');
            Route::get('/duplicatacompra/excluir/{id}',[DuplicataCompraController::class,'excluir'])->name('duplicatacompra.excluir');

            Route::post('/duplicataorcamento/inserir',[DuplicataOrcamentoController::class,'inserir'])->name('duplicataorcamento.inserir');
            Route::post('/duplicataorcamento/salvarAlteracao',[DuplicataOrcamentoController::class,'salvarAlteracao'])->name('duplicataorcamento.salvarAlteracao');
            Route::get('/duplicataorcamento/excluir/{id}',[DuplicataOrcamentoController::class,'excluir'])->name('duplicataorcamento.excluir');

            Route::post('/pdvduplicata/inserir',[PdvDuplicataController::class,'inserir'])->name('pdvduplicata.inserir');
            Route::post('/pdvduplicata/salvarAlteracao',[PdvDuplicataController::class,'salvarAlteracao'])->name('pdvduplicata.salvarAlteracao');
            Route::get('/pdvduplicata/excluir/{id}',[PdvDuplicataController::class,'excluir'])->name('pdvduplicata.excluir');

            //Financeiro
            Route::get("/financeiro/selecionarRelatorio",[FinanceiroController::class,"selecionarRelatorio"])->name('financeiro.selecionarRelatorio');
            Route::get('/financeiro/imprimir',[FinanceiroController::class,'imprimir'])->name('financeiro.imprimir');


            Route::get("/contapagar/selecionarRelatorioSintetico",[ContaPagarController::class,"selecionarRelatorioSintetico"])->name('contapagar.selecionarRelatorioSintetico');
            Route::get("/contapagar/selecionarRelatorioAnalitico",[ContaPagarController::class,"selecionarRelatorioAnalitico"])->name('contapagar.selecionarRelatorioAnalitico');
            Route::get('/contapagar/relatorioSintetico',[ContaPagarController::class,'relatorioSintetico'])->name('contapagar.relatorioSintetico');
            Route::get('/contapagar/relatorioAnalitico',[ContaPagarController::class,'relatorioAnalitico'])->name('contapagar.relatorioAnalitico');
            Route::get("/contapagar/filtro",[ContaPagarController::class,"filtro"])->name("contapagar.filtro");
            Route::get("/contapagar/pormes",[ContaPagarController::class,"pormes"])->name("contapagar.pormes");
            Route::get("/contapagar/confirmarPagamento/{id}",[ContaPagarController::class,"confirmarPagamento"])->name("contapagar.confirmarPagamento");
            Route::get("/contapagar/detalhe/{id}",[ContaPagarController::class,"detalhe"])->name("contapagar.detalhe");
            Route::post("/contapagar/pagar/",[ContaPagarController::class,"pagar"])->name("contapagar.pagar");
            Route::resource("/contapagar",ContaPagarController::class);


            Route::get("/contareceber/tituloReceber",[ContaReceberController::class,"tituloReceber"])->name("contareceber.tituloReceber");
            Route::get("/contareceber/selecionarRelatorioSintetico",[ContaReceberController::class,"selecionarRelatorioSintetico"])->name('contareceber.selecionarRelatorioSintetico');
            Route::get("/contareceber/selecionarRelatorioAnalitico",[ContaReceberController::class,"selecionarRelatorioAnalitico"])->name('contareceber.selecionarRelatorioAnalitico');
            Route::get('/contareceber/relatorioSintetico',[ContaReceberController::class,'relatorioSintetico'])->name('contareceber.relatorioSintetico');
            Route::get('/contareceber/relatorioAnalitico',[ContaReceberController::class,'relatorioAnalitico'])->name('contareceber.relatorioAnalitico');
            Route::get("/contareceber/filtro",[ContaReceberController::class,"filtro"])->name("contareceber.filtro");
            Route::get("/contareceber/pormes",[ContaReceberController::class,"pormes"])->name("contareceber.pormes");
            Route::get("/contareceber/confirmarPagamento/{id}",[ContaReceberController::class,"confirmarPagamento"])->name("contareceber.confirmarPagamento");
            Route::get("/contareceber/detalhe/{id}",[ContaReceberController::class,"detalhe"])->name("contareceber.detalhe");
            Route::post("/contareceber/receber/",[ContaReceberController::class,"receber"])->name("contareceber.receber");
            Route::get("/contareceber/duplicata",[ContaReceberController::class,"duplicata"])->name("contareceber.duplicata");
            Route::resource("/contareceber",ContaReceberController::class);

            Route::resource("/centrocusto",CentroCustoController::class);

            Route::post('/tipodespesa/salvarJs',[TipoDespesaController::class,'salvarJs'])->name('tipodespesa.salvarJs');
            Route::get("/tipodespesa/pesquisa",[TipoDespesaController::class,"pesquisa"])->name('tipodespesa.pesquisa');
            Route::resource("/tipodespesa",TipoDespesaController::class);

            Route::get("/despesa/pesquisa",[DespesaController::class,"pesquisa"])->name('despesa.pesquisa');
            Route::get("/despesa/filtro",[DespesaController::class,"filtro"])->name("despesa.filtro");

            Route::get("/despesa/pormes",[DespesaController::class,"pormes"])->name("despesa.pormes");
            Route::get("/despesa/confirmarPagamento/{id}",[DespesaController::class,"confirmarPagamento"])->name("despesa.confirmarPagamento");
            Route::post("/despesa/pagar/",[DespesaController::class,"pagar"])->name("despesa.pagar");
            Route::resource("/despesa",DespesaController::class);


            Route::get("/fatura/filtro",[FaturaController::class,"filtro"])->name("fatura.filtro");
            Route::get("/fatura/detalhe/{id}",[FaturaController::class,"detalhe"])->name("fatura.detalhe");
            Route::get("/fatura/pormes",[FaturaController::class,"pormes"])->name("fatura.pormes");
            Route::resource("/fatura",FaturaController::class);

            Route::get("/cobranca/confirmarPagamento/{id}",[CobrancaController::class,"confirmarPagamento"])->name("cobranca.confirmarPagamento");
            Route::get("/cobranca/filtro",[CobrancaController::class,"filtro"])->name("cobranca.filtro");
            Route::get("/cobranca/detalhe/{id}",[CobrancaController::class,"detalhe"])->name("cobranca.detalhe");
            Route::get("/cobranca/pormes",[CobrancaController::class,"pormes"])->name("cobranca.pormes");
            Route::resource("/cobranca",CobrancaController::class);

            Route::get("/pagamento/filtro",[PagamentoController::class,"filtro"])->name("pagamento.filtro");
            Route::get("/pagamento/pormes",[PagamentoController::class,"pormes"])->name("pagamento.pormes");
            Route::resource("/pagamento",PagamentoController::class);


            Route::get("/recebimento/selecionarRelatorioSintetico",[RecebimentoController::class,"selecionarRelatorioSintetico"])->name('recebimento.selecionarRelatorioSintetico');
            Route::get('/recebimento/relatorioSintetico',[RecebimentoController::class,'relatorioSintetico'])->name('recebimento.relatorioSintetico');
            Route::get("/recebimento/filtro",[RecebimentoController::class,"filtro"])->name("recebimento.filtro");
            Route::get("/recebimento/pormes",[RecebimentoController::class,"pormes"])->name("recebimento.pormes");
            Route::resource("/recebimento",RecebimentoController::class);


            //Pdv Venda
            Route::post('/pdvvenda/finalizarVenda',[PdvVendaController::class,'finalizarVenda'])->name('pdvvenda.finalizarVenda');
            Route::get('/pdvvenda/salvarNfcePorPdvVenda/{id}/{natureza_id}',[PdvVendaController::class,'salvarNfcePorPdvVenda'])->name('pdvvenda.salvarNfcePorPdvVenda');
            Route::get('/pdvvenda/pdf/{id}',[PdvVendaController::class,'pdf'])->name('pdvvenda.pdf');
            Route::get("/pdvvenda/filtro",[PdvVendaController::class,"filtro"])->name('pdvvenda.filtro');
            Route::post('/pdvvenda/salvar',[PdvVendaController::class, 'salvar'])->name('pdvvenda.salvar');
            Route::get('/pdvvenda/edit/{id}',[PdvVendaController::class,'edit'])->name('pdvvenda.edit');
            Route::resource("/pdvvenda",PdvVendaController::class);



            //PDV
            Route::resource("/numerocaixa",PdvNumeroCaixaController::class);

            Route::get('/caixa/buscarCaixaPorNumero/{id}',[PdvCaixaController::class,'buscarCaixaPorNumero'])->name('caixa.buscarCaixaPorNumero');
            Route::resource("/caixa",PdvCaixaController::class);

            Route::resource("/sangria",PdvSangriaController::class);
            Route::resource("/suplemento",PdvSuplementoController::class);


            //LOJA
            Route::get('/lojateste/gerar',[LojaTesteController::class,'gerar'])->name('lojateste.gerar');
            Route::resource('/lojaconfiguracao',LojaConfiguracaoController::class);


            Route::post('/lojacategoriaproduto/salvarJs',[LojaCategoriaProdutoController::class,'salvarJs'])->name('lojacategoriaproduto.salvarJs');
            Route::resource('/lojacategoriaproduto',LojaCategoriaProdutoController::class);
            Route::resource('/lojacarrossel',LojaCarrossellController::class);
            Route::resource('/lojabanner',LojaBannerController::class);

            Route::get("/lojacliente/filtro",[LojaClienteController::class,"filtro"])->name('lojacliente.filtro');
            Route::get("/lojacliente/endereco/{id}",[LojaClienteController::class,"endereco"])->name('lojacliente.endereco');
            Route::resource('/lojacliente',LojaClienteController::class);


            Route::resource('/lojacurtidaproduto',LojaCurtidaProdutoController::class);

            Route::resource('/lojaimagemproduto',LojaImagemProdutoController::class);



            Route::resource('/lojaitempedido',LojaItemPedidoController::class);
            Route::resource('/lojapacote',LojaPacoteController::class);



            Route::post('/lojapedido/atualizarDados',[LojaPedidoController::class,'atualizarDados'])->name('lojapedido.atualizarDados');
            Route::get('/lojapedido/excluir/{id}',[LojaPedidoController::class,'excluir'])->name('lojapedido.excluir');
            Route::get('/lojapedido/detalhe/{id}',[LojaPedidoController::class,'detalhe'])->name('lojapedido.detalhe');
            Route::get('/lojapedido/nfe/{id}',[LojaPedidoController::class,'nfe'])->name('lojapedido.nfe');
            Route::post('/lojapedido/salvarVenda',[LojaPedidoController::class,'salvarVenda'])->name('lojapedido.salvarVenda');
            Route::resource('/lojapedido',LojaPedidoController::class);

            Route::post("/lojaproduto/salvarImagemJs",[LojaProdutoController::class,"salvarImagemJs"])->name('lojaproduto.salvarImagemJs');
            Route::get("/lojaproduto/filtro",[LojaProdutoController::class,"filtro"])->name('lojaproduto.filtro');
            Route::get("/lojaproduto/pesquisa/{q}",[LojaProdutoController::class,"pesquisa"])->name('lojaproduto.pesquisa');
            Route::resource('/lojaproduto',LojaProdutoController::class);

            Route::resource('/deliverypedido',DeliveryPedidoController::class);

            Route::resource('/funcionamentodelivery',FuncionamentoDeliveryController::class);
            Route::resource('/categoriaadicional',CategoriaAdicionalController::class);
            //Delivery

            Route::get('/deliverycomplemento/listaPorCategoria/{id}',[DeliveryComplementoController::class,'listaPorCategoria'])->name('deliverycomplemento.listaPorCategoria');
            Route::resource('/deliverycomplemento',DeliveryComplementoController::class);
            Route::resource('/listacomplementodelivery',ListaComplementoDeliveryController::class);


            Route::resource('/deliveryconfig',DeliveryConfigController::class);
            Route::resource('/deliverytamanhopizza',DeliveryTamanhoPizzaController::class);
            Route::resource('/deliverymotoboy',DeliveryMotoboyController::class);

            Route::get('/deliveryproduto/push/{id}',[DeliveryProdutoController::class,'push'])->name('deliveryproduto.push');
            Route::get('/deliveryproduto/galeria/{id}',[DeliveryProdutoController::class,'galeria'])->name('deliveryproduto.galeria');
            Route::get('/deliveryproduto/adicionais/{id}',[DeliveryProdutoController::class,'adicionais'])->name('deliveryproduto.adicionais');
            Route::get('/deliveryproduto/alterarDestaque/{id}',[DeliveryProdutoController::class,'alterarDestaque'])->name('deliveryproduto.alterarDestaque');
            Route::get('/deliveryproduto/alterarStatus/{id}',[DeliveryProdutoController::class,'alterarStatus'])->name('deliveryproduto.alterarStatus');
            Route::post('/deliveryproduto/salvarImagem',[DeliveryProdutoController::class,'salvarImagem'])->name('deliveryproduto.salvarImagem');
            Route::get('/deliveryproduto/excluirImagem/{id}',[DeliveryProdutoController::class,'excluirImagem'])->name('deliveryproduto.excluirImagem');
            Route::resource('/deliveryproduto',DeliveryProdutoController::class);

        });


            Route::group(['middleware' => 'auth','prefix'=>'pdv','as'=>'pdv.'], function () {
                Route::get('/', [PdvHomeController::class,'index'])->name('home');

                Route::get('/produtoPorCodigo/{id}',[PdvController::class,'produtoPorCodigo'])->name('produtoPorCodigo');
                Route::get('/pdv/livre',[PdvController::class, 'livre'])->name('livre');
                Route::get('/pdv/create',[PdvController::class, 'create'])->name('create');
                Route::get('/pdv/index',[PdvController::class, 'index'])->name('index');

                Route::post('/caixa/index',[CaixaController::class, 'index'])->name('caixa.index');
                Route::post('/caixa/abrir',[CaixaController::class, 'abrir'])->name('caixa.abrir');
                Route::post('/caixa/fechar',[CaixaController::class, 'fechar'])->name('caixa.fechar');
                Route::get('/caixa/create',[CaixaController::class, 'create'])->name('caixa.create');
                Route::get('/caixa/fechamento',[CaixaController::class, 'fechamento'])->name('caixa.fechamento');

                Route::post('/venda/salvar',[VendaPdvController::class, 'salvar'])->name('venda.salvar');
                Route::get('/venda/salvar_e_transmitir/{id_venda}',[VendaPdvController::class, 'salvar_e_transmitir'])->name('venda.salvar_e_transmitir');
                Route::get('/venda/cupom/{id}',[VendaPdvController::class, 'cupom'])->name('venda.cupom');
                Route::get('/venda/imprimirNfcePelaVenda/{id}',[VendaPdvController::class, 'imprimirNfcePelaVenda'])->name('venda.imprimirNfcePelaVenda');

                Route::post('/sangria/salvarJs',[SangriaController::class, 'salvarJs'])->name('sangria.salvarJs');
                Route::resource('/sangria',SangriaController::class);

                Route::post('/suplemento/salvarJs',[SuplementoController::class, 'salvarJs'])->name('suplemento.salvarJs');
                Route::resource('/suplemento',SuplementoController::class);

            });

                //Ead
                Route::group(['prefix'=>'ead','as'=>'ead.'], function () {
                    Route::resource('/aluno',EadAlunoController::class);
                    Route::get('/aluno/matricula/{id}',[EadAlunoController::class,'matricular'])->name('aluno.matricular');

                    Route::get('/curso/aulas/{id}',[EadCursoController::class,'aulas'])->name('curso.aulas');
                    Route::resource('/curso',EadCursoController::class);

                    Route::resource('/aula',EadAulaController::class);
                    Route::resource('/matricula',EadMatriculaController::class);


                });


                    //Site
                    Route::group(['prefix'=>'site','as'=>'site.'], function () {
                        Route::get('/',[SiteController::class, 'index'])->name('home');
                        Route::get('/cadastro',[SiteController::class, 'cadastro'])->name('cadastro');
                        Route::post('/cadastrar',[SiteController::class, 'cadastrar'])->name('cadastrar');
                        Route::get('/sucesso',[SiteController::class, 'sucesso'])->name('sucesso');
                        Route::get('/testar/{}',[SiteController::class, 'sucesso'])->name('sucesso');
                        Route::get('/planos',[SiteController::class, 'planos'])->name('planos');
                        Route::get('/recorrencia/{id}',[SiteController::class, 'recorrencia'])->name('recorrencia');
                        Route::get('/assinar',[AssinarController::class, 'index'])->name('assinar');
                        Route::get('/finalizar/{id}',[AssinarController::class, 'finalizar'])->name('finalizar');

                    });

        //Deliverey WEB
        Route::group(['prefix'=>'web','as'=>'delivery.web.'], function () {
            Route::get('/',[HomeWebController::class, 'index'])->name('home');
            Route::get('/novo',[PedidoWebController::class, 'index'])->name('novo');
            Route::get('/finalizar',[PedidoWebController::class, 'finalizar'])->name('finalizar');
            Route::get('/produto/detalhe/{id}',[ProdutoWebController::class, 'detalhe'])->name('produto.detalhe');

            Route::post('/carrinho/add',[CarrinhoWebController::class,'add'])->name('carrinho.add');
            Route::post('/carrinho/finalizarPedido',[CarrinhoWebController::class,'finalizarPedido'])->name('carrinho.finalizarPedido');
            Route::get('/checkout',[CarrinhoController::class,'checkout'])->name('carrinho.checkout');
            Route::get('/carrinho/finalizado/{id}',[CarrinhoWebController::class,'finalizado'])->name('carrinho.finalizado');
            Route::get('/carrinho/forma_pagamento',[CarrinhoWebController::class,'forma_pagamento'])->name('carrinho.forma_pagamento');
            Route::get('/carrinho/excluir/{id}',[CarrinhoWebController::class,'excluir'])->name('carrinho.excluir');
            Route::get('/carrinho/atualizar/{id}/{qtde}',[CarrinhoWebController::class,'atualizar'])->name('carrinho.atualizar');
            Route::get('/carrinho',[CarrinhoWebController::class,'index'])->name('carrinho.index');


            Route::get('/login',[ClienteWebController::class, 'login'])->name('login');
            Route::post('/logar',[ClienteWebController::class, 'logar'])->name('logar');
            Route::get('/logoff',[ClienteWebController::class, 'logoff'])->name('logoff');
            Route::get('/cadastro',[ClienteWebController::class, 'create'])->name('cadastro');
            Route::post('/cliente/salvar',[ClienteWebController::class, 'salvar'])->name('cliente.salvar');
            Route::resource("/enderecodelivery",EnderecoWebController::class);
        });
    //Deliver Balcão
    Route::group(['prefix'=>'balcao','as'=>'delivery.balcao.'], function () {
        Route::get('/',[HomeBalcaoController::class, 'index'])->name('home');
        Route::get('/novo',[PedidoBalcaoController::class, 'index'])->name('novo');
        Route::get('/edit/{id}',[PedidoBalcaoController::class, 'edit'])->name('edit');
        Route::get('/buscarProdutoParaPedido/{id}',[ProdutoBalcaoController::class, 'buscarProdutoParaPedido'])->name('buscarProdutoParaPedido');
        Route::get('/abrirPedido/{id}',[PedidoBalcaoController::class, 'abrirPedido'])->name('abrirPedido');
        Route::post('/inserirItem',[PedidoBalcaoController::class, 'inserirItem'])->name('inserirItem');
        Route::post('/finalizar',[PedidoBalcaoController::class, 'finalizar'])->name('finalizar');
        Route::post('/cliente/inserirClienteNoPedido',[ClienteBalcaoController::class, 'inserirClienteNoPedido'])->name('inserirClienteNoPedido');
        Route::get('/cliente/pesquisaPorNome',[ClienteBalcaoController::class, 'pesquisaPorNome'])->name('cliente.pesquisaPorNome');
        Route::post('/inserirEnderecoCliente',[PedidoBalcaoController::class, 'inserirEnderecoCliente'])->name('inserirEnderecoCliente');
        Route::post('/marcarEnderecoCliente',[PedidoBalcaoController::class, 'marcarEnderecoCliente'])->name('marcarEnderecoCliente');
        Route::get('/verPedido/{id}',[PedidoBalcaoController::class, 'verPedido'])->name('verPedido');
        Route::get('/imprimirPedido/{id}',[PedidoBalcaoController::class, 'imprimirPedido'])->name('imprimirPedido');
    });

    //Fronte do atendimento
    Route::group(['prefix'=>'comanda','as'=>'comanda.'], function () {
        Route::get('/',[HomeComandaController::class, 'index'])->name('home');
        Route::get('/novo/{id}', [ComandaController::class,'novo'])->name('novo');
        Route::resource("/camanda",ComandaController::class);
    });

    //Deliverty



