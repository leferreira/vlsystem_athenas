<div class="col menu-lateral position-relative">

<nav class="menuprincipal" id="principal">				
			<ul class="menu-ul icones">
				<li><a href="{{route('admin.index')}}" title="Página inicial"><i class="fas fa-home"></i> Home</a></li>
				
				<li><a href="#menu_empresa" title="Configurações"><i class="icon fas fa-cog"></i> Configurações <span>+</span></a></li>
			
				<li><a href="#menu_cadastro" title="Cadastro"><i class="icon fas fa-file"></i> Cadastro <span>+</span></a></li>
				@can('modulo_compra')
    				@can('menu_compra')
    					<li><a href="#menu_compras" title="Compras"><i class="icon fas fa-cart-plus"></i> Compras <span>+</span></a></li>	
    				@endcan
    			@endcan
    			
    			@can('modulo_venda')
    				@can('menu_venda')
    					<li><a href="#menu_venda" title="Venda"><i class="icon fas fa-donate"></i> Venda <span>+</span></a></li>
    				@endcan
    			@endcan
    			<li><a href="#menu_venda_recorrente" title="Venda Recorrente"><i class="icon fas fa-donate"></i> Recorrência <span>+</span></a></li>
    			@can('modulo_os')	
    			    @can('menu_os')
    					<!--  <li><a href="#menu_os" title="Ordem de Serviço"><i class="icon fas fa-donate"></i> Ordem de Serviço <span>+</span></a></li>-->
    				@endcan
    			@endcan
    				
    			@can('modulo_pedido_cliente')
    				@can('menu_pedido_cliente')
    					<li><a href="#menu_MDFE"><i class="icon fas fa-parking"></i> Pedido de Cliente <span>+</span></a></li>
    				@endcan
    			@endcan
    			
    			@can('modulo_loja_virtual')
    				@can('menu_loja_virtual')
    					<li><a href="#menu_loja" title="Loja virtual"><i class="icon fas fa-shopping-basket"></i> Loja Virtual <span>+</span></a></li>					
    				@endcan
    			
    			@endcan
    			 <!--  <li><a href="#menu_delivery"><i class="fas fa-shipping-fast"></i> Delivery <span>+</span></a></li>	
    				<li><a href="#menu_cardapio" title="cardapio"><i class="icon fas fa-shopping-basket"></i> Cardápio <span>+</span></a></li>-->
    			@can('modulo_estoque')
    				@can('menu_estoque')
    					<li><a href="#menu_estoque" title="Estoque"><i class="icon fas fa-cubes"></i> Estoque <span>+</span></a></li>
    				@endcan
    			@endcan
    				
    			@can('modulo_nfe')
    				@can('menu_nfe')
    					<li><a href="#menu_CTE" title="NFE"><i class="icon fas fa-copyright"></i> Notas Fiscais <span>+</span></a></li>
    				@endcan
    			@endcan
    				
    			@can('modulo_pdv')
    				@can('menu_pdv')
    					<li><a href="#menu_pedido" title="PDV"><i class="icon fas fa-cash-register"></i> PDV <span>+</span></a></li>	
    				@endcan
    			@endcan
    				
    			@can('modulo_financeiro')
    				@can('menu_financeiro')
    					<li><a href="#menu_financeiro" title="Financeiro/contabil"><i class="icon fas fa-hand-holding-usd"></i> Financeiro <span>+</span></a></li>					
    				@endcan
    			@endcan
    				
    	
				@can('menu_relatorio')
					<li><a href="#menu_relatorio" title="Relatorios"><i class="icon fas fa-hand-holding-usd"></i> Relatórios <span>+</span></a></li>					
				@endcan
    			
					
			</ul>
</nav>

<!-- MENU CADASTRO -->
<nav class="menuprincipal" id="menu_empresa">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-cog ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		
			<h1 class="tt px-2"><b> Minhas Configurações</b></h1>		
		
		@can('submenu_meu_plano')
			<li><a href="{{route('admin.assinatura.index')}}">Minhas Assinaturas</a></li>
		@endcan
		
		@can('submenu_minha_empresa')
			<li><a href="{{route('admin.empresa.index')}}">Minha Empresa</a></li>
		@endcan
		@can('submenu_parametro')
			<li><a href="{{route('admin.parametro.index')}}">Parâmetros do Sistema</a></li>
		@endcan
		
		@can('submenu_emitente')
    		<li><a href="{{route('admin.emitente.index')}}">Emitente NFE</a></li>
    	@endcan
    	
    	@can('submenu_natureza_operacao')
    		<li><a href="{{route('admin.naturezaoperacao.index')}}">Natureza da Operação</a></li>
    	@endcan
    	
    	@can('submenu_certificado_digital')
    		<li><a href="{{route('admin.certificadodigital.index')}}">Certificado Digital</a></li>
    	@endcan
		
				
	</ul>

</nav>

<!-- MENU CADASTRO -->
<nav class="menuprincipal" id="menu_cadastro">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-cart-plus ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Cadastros Gerais</b></h1>
		@can('submenu_categoria')	
			<li><a href="{{route('admin.categoria.index')}}">Categoria</a></li>
		@endcan
		
		@can('submenu_subcategoria')
			<li><a href="{{route('admin.subcategoria.index')}}">SubCategoria</a></li>
		@endcan
		
		@can('submenu_subsubcategoria')
			<li><a href="{{route('admin.subsubcategoria.index')}}">SubSubCategoria</a></li>
		@endcan
		
		@can('submenu_produto')
			<li><a href="{{route('admin.produto.index')}}">Produto</a></li>
		@endcan

		<li><a href="{{route('admin.cupomdesconto.index')}}">Cupom desconto</a></li>
		
		@can('submenu_servico')
			<li><a href="{{route('admin.servico.index')}}">Serviço</a></li>
		@endcan
		@can('submenu_cliente')
			<li><a href="{{route('admin.cliente.index')}}">Cliente</a></li>
		@endcan
		@can('submenu_tabela_preco')
			<li><a href="{{route('admin.tabelapreco.index')}}">Tabela de Preço</a></li>
		@endcan
		@can('submenu_vendedor')
		<li><a href="{{route('admin.vendedor.index')}}">Vendedor</a></li>
		@endcan
		@can('submenu_varicao_grade')
		<li><a href="{{route('admin.variacaograde.index')}}">Variação Grade</a></li>
		@endcan
		@can('submenu_item_variacao')
		<li><a href="{{route('admin.itemvariacaograde.index')}}">Item Variação Grade</a></li>
		@endcan
		@can('submenu_localizacao')
		<!--  <li><a href="{{route('admin.localizacao.index')}}">Localização</a></li> -->
		@endcan
		
		@can('submenu_fornecedor')
			<li><a href="{{route('admin.fornecedor.index')}}">Fornecedor</a></li>	
		@endcan
		@can('submenu_banco')
			<li><a href="{{route('admin.banco.index')}}">Banco</a></li>	
		@endcan
		@can('submenu_conta_corrente')
			<li><a href="{{route('admin.contacorrente.index')}}">Conta Corrente</a></li>	
		@endcan			
		@can('submenu_transportadora')	
			<li><a href="{{route('admin.transportadora.index')}}">Transportadora</a></li>
		@endcan
		
		@can('submenu_admin_cartao')		
			<li><a href="{{route('admin.administradora.index')}}">Administradora de Meios de Pagamento</a></li>
		@endcan
		
		@can('submenu_bandeira')
			<li><a href="{{route('admin.bandeiraadministradora.index')}}">Bandeiras do Cartão</a></li>
		@endcan
					
	</ul>

</nav>

<!-- MENU Loja Virutal -->
<nav class="menuprincipal" id="menu_loja">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-shopping-basket ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Loja Virtual</b></h1>		
		@can('submenu_configuracao_loja')
			<li><a href="{{route('admin.lojaconfiguracao.index')}}">Configuração</a></li>
		@endcan
		@can('submenu_pedidos_loja')
			<li><a href="{{route('admin.lojapedido.index')}}">Pedidos</a></li>		
		@endcan
			
		@can('submenu_banner_loja')
			<li><a href="{{route('admin.lojabanner.index')}}">Banner</a></li>	
		@endcan
		
		
	</ul>
</nav>


<nav class="menuprincipal" id="menu_cardapio">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-shopping-basket ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Loja Virtual</b></h1>		
		@can('submenu_configuracao_loja')
			<li><a href="{{route('admin.lojaconfiguracao.index')}}">Configuração</a></li>
		@endcan
		@can('submenu_pedidos_loja')
			<li><a href="{{route('admin.lojapedido.index')}}">Pedidos</a></li>		
		@endcan
			
		@can('submenu_banner_loja')
			<li><a href="{{route('admin.lojabanner.index')}}">Banner</a></li>	
		@endcan
		
		
	</ul>
</nav>


<!-- MENU Loja Virutal -->
<nav class="menuprincipal" id="menu_os">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-shopping-basket ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Ordem de Serviço</b></h1>
		
		@can('submenu_ordem_servico')	
			<li><a href="{{route('admin.ordemservico.index')}}">Ordem de Serviço</a></li>
		@endcan
		
		@can('submenu_tecnico')
			<li><a href="{{route('admin.tecnico.index')}}">Técnico</a></li>		
		@endcan
		
		@can('submenu_equipamento')
			<li><a href="{{route('admin.equipamento.index')}}">Equipamentos</a></li>	
		@endcan
		
		@can('submenu_termo_garantia')	
			<li><a href="{{route('admin.termogarantia.index')}}">Termo Garantia</a></li>
		@endcan
				
	</ul>
</nav>

<nav class="menuprincipal" id="menu_venda_recorrente">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-shopping-basket ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Vendas Recorrentes</b></h1>
		
		<li><a href="{{route('admin.recorrencia.index')}}">Dashboard</a></li>	
		<li><a href="{{route('admin.produtorecorrente.index')}}">Produto Recorrente</a></li>
		<li><a href="{{route('admin.vendarecorrente.index')}}">Contrato</a></li>
		<li><a href="{{route('admin.clienterecorrente.index')}}">Clientes</a></li>
		<li><a href="{{route('admin.modelocontrato.index')}}">Modelo Contrato</a></li>
				
	</ul>
</nav>
<nav class="menuprincipal" id="menu_venda">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-donate ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Vendas</b></h1>
		
		@can('submenu_lista_venda')
			<li><a href="{{route('admin.venda.index')}}"> Lista de Vendas</a></li>
		@endcan
		
		@can('submenu_nova_venda')
			<li><a href="{{route('admin.venda.create')}}"> Nova Venda</a></li>
		@endcan	
		
		@can('submenu_orcamento')
			<li><a href="{{route('admin.orcamento.index')}}"> Orçamento</a></li>
		@endcan	
		
				
	</ul>
</nav>

<!-- MENU COMPRAS -->
<nav class="menuprincipal" id="menu_compras">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-cart-plus ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Compras</b></h1>
		
		@can('submenu_lista_compra')
		 	<li><a href="{{route('admin.compra.index')}}"> Lista Compras</a></li>
		@endcan 
		
		@can('submenu_compra_manual')
		 <li><a href="{{route('admin.compra.create')}}">Compra Manual</a></li> 
		@endcan 
		@can('submenu_importar_nfe')
			<li><a href="{{route('admin.nfeentrada.index')}}">Importar NFE</a></li>
		@endcan
	</ul>
</nav>

<nav class="menuprincipal" id="menu_estoque">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-cubes ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Estoque</b></h1>
		
		@can('submenu_entrada')
			<li><a href="{{route('admin.entrada.index')}}">Entrada Avulsa</a></li>
		@endcan
		
		@can('submenu_saida')
			<li><a href="{{route('admin.saida.index')}}">Saída Avulsa</a></li>
		@endcan
		
		@can('submenu_estoque_atual')
		<li><a href="{{route('admin.estoque.index')}}">Estoques Atuais </a></li>
		@endcan
		@can('submenu_estoque_minimo')
		<li><a href="{{route('admin.estoque.minimo')}}">Estoque Mínimo</a></li>
		@endcan
		@can('submenu_vencimento')
		<li><a href="{{route('admin.estoque.vencimento')}}">Controle de Vencimento</a></li>
		@endcan
		
		@can('submenu_historico_produto')
			<li><a href="{{route('admin.movimento.selecionarProduto')}}">Histórico de Produto</a></li>
		@endcan	
		
		
		
	</ul>
</nav>


<!-- MENU PEDIDO -->
<nav class="menuprincipal" id="menu_pedido">
	<ul class="menu-lista">

		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-cash-register ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> PDV</b></h1>
		
		@can('submenu_numero_pdv')
			<li><a href="{{route('admin.numerocaixa.index')}}"> Número do PDV</a></li>
		@endcan
		
		@can('submenu_caixa_pdv')
			<li><a href="{{route('admin.caixa.index')}}"> Caixas</a></li>
		@endcan
		
		@can('submenu_sangria')
			<li><a href="{{route('admin.sangria.index')}}"> Sangria</a></li>
		@endcan
		
		@can('submenu_suplemento')
			<li><a href="{{route('admin.suplemento.index')}}"> Suplementos</a></li>
		@endcan
		
		@can('submenu_venda_pdv')
			<li><a href="{{route('admin.pdvvenda.index')}}"> Venda</a></li>
		@endcan
		

	</ul>
</nav>

<!-- MENU FANACEIRO CONTABIL -->
<nav class="menuprincipal" id="menu_financeiro">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-hand-holding-usd ativo"></i><i class="fas fa-arrow-left fa-fw"></i></a></li>
		<h1 class="tt px-2"><b> Financeiro</b></h1>		
		
		@can('submenu_classificacao')
			<li><a href="{{route('admin.classificacaofinanceira.index')}}">Classificação Financeira</a></li>
		@endcan
		@can('submenu_conta_pagar')
			<li><a href="{{ route('admin.contapagar.index') }}" class="nav-link text-light"> Contas a Pagar</a>	</li>
		@endcan
		
		@can('submenu_pagamento')
			<li><a href="{{ route('admin.pagamento.index') }}" class="nav-link text-light"> Pagamento</a></li>
		@endcan
		
		
		@can('submenu_conta_receber')
			<li><a href="{{ route('admin.contareceber.index') }}" class="nav-link text-light"> Contas a Receber</a></li>
		@endcan	
		
		@can('submenu_recebimento')
			<li><a href="{{ route('admin.recebimento.index') }}" class="nav-link text-light"> Recebimentos</a></li>
		@endcan
		
			
	
		
		
		
		@can('submenu_fatura')
			<li><a href="{{ route('admin.fatura.index') }}" class="nav-link text-light"> Faturas</a></li>
		@endcan
		
		@can('submenu_comprovante')
			<li><a href="{{ route('comprovante.index') }}" class="nav-link text-light"> Comprovantes</a></li>
		@endcan
		
		
		
		@can('submenu_movimento_conta')
			<li><a href="{{route('admin.movimentoconta.index')}}">Movimento Conta</a></li>
		@endcan
		
		@can('submenu_extrato')
			<li><a href="{{route('admin.movimentoconta.extrato01')}}">Extrato</a></li>
		@endcan
		
			<li><a href="{{route('admin.movimentoconta.saldo')}}">Saldo das Contas</a></li>
		
	</ul>
</nav>



<!-- MENU COMPRAS -->
<nav class="menuprincipal" id="menu_CTE">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="far fa-far fa-copyright ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Notas Fiscais</b></h1>
		
		@can('submenu_nova_nfe')
			<li><a href="{{route('admin.notafiscal.create')}}"> Nova NFE</a></li>
		@endcan
		
		@can('submenu_lista_nfe')
			<li><a href="{{route('admin.notafiscal.index')}}"> Lista de NFE</a></li>
		@endcan
		
		@can('submenu_importar_nfe')
			<li><a href="{{route('admin.notafiscal.lerArquivo')}}"> Importar NFE</a></li>
		@endcan
		
		@can('submenu_inutilizar_numeracao')
			<li><a href="{{route('admin.notafiscal.inutilizar')}}"> Inutilizar Numeração</a></li>
		@endcan
		
		@can('submenu_lista_nfce')
			<li><a href="{{route('admin.notanfce.index')}}"> Lista de NFCE</a></li>
		@endcan
	</ul>
</nav>

<!-- MENU COMPRAS -->
<nav class="menuprincipal" id="menu_MDFE">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-parking ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b> Pedidos de Cliente</b></h1>
		
		@can('submenu_lista_pedido')
			<li><a href="{{route('admin.pedidocliente.index')}}"> Lista</a></li>
		@endcan	
	</ul>
</nav>

<nav class="menuprincipal" id="menu_relatorio">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="#" title="Recolher menu"><i class="fas fa-parking ativo"></i><i class="fas fa-fw fa-arrow-left"></i></a></li>
		<h1 class="tt px-2"><b>Consultas/ Relatórios</b></h1>		
		@can('submenu_rel_produto')
			<li><a href="{{route('admin.consulta.produto')}}"> Produto</a></li>
		@endcan
			@can('submenu_rel_venda')
			<li><a href="{{route('admin.consulta.venda')}}"> Vendas</a></li>
			@endcan
			@can('submenu_rel_estoque')
			<li><a href="{{route('admin.consulta.estoque')}}">Movimentacao Estoque</a></li>
			@endcan
			@can('submenu_rel_conta_receber')
			<li><a href="{{route('admin.consulta.contareceber')}}"> Conta a Receber</a></li>
			@endcan
			@can('submenu_rel_recebimento')
			<li><a href="{{route('admin.consulta.recebimento')}}"> Recebimentos</a></li>
			@endcan
			@can('submenu_rel_conta_pagar')
			<li><a href="{{route('admin.consulta.contapagar')}}"> Conta a Pagar</a></li>
			@endcan
			@can('submenu_rel_pagamento')
			<li><a href="{{route('admin.consulta.pagamento')}}"> Pagamentos</a></li>
			@endcan
			@can('submenu_rel_movimento_conta')
			<li><a href="{{route('admin.consulta.movimentoconta')}}">Movimento de Conta</a></li>
			@endcan
			@can('submenu_rel_venda_pdv')
			<li><a href="{{route('admin.consulta.pdv')}}">Vendas PDV</a></li>
			@endcan
			@can('submenu_rel_venda_loja_virtual')
			<li><a href="{{route('admin.consulta.lojavirtual')}}">Vendas Loja Virtual</a></li>
			@endcan
	</ul>
</nav>

<nav class="menuprincipal" id="menu_delivery">
	<ul class="menu-lista">
		<li class="icones voltar"><a href="" title="Recolher menu"><i class="fas fa-shipping-fast ativo"></i><i class="fas fa-fw fa-arrow-left "></i></a></li>
		<h1 class="tt px-2"><b> Delivery</b></h1>
		
		<li><a href="{{route('admin.deliveryconfig.index')}}">Configuração</a></li>
		<li><a href="{{route('admin.deliveryproduto.index')}}">Produto</a></li>
		<li><a href="{{route('admin.categoriaadicional.index')}}">Categoria de Adicional</a></li>
		<li><a href="{{route('admin.deliverytamanhopizza.index')}}">Tamanhos de Pizza</a></li>
		<li><a href="{{route('admin.deliverypedido.index')}}">Pedidos de Delivery</a></li>
		<li><a href="{{route('admin.deliverycomplemento.index')}}">Complementos Adicionais</a></li>
		<li><a href="{{route('admin.funcionamentodelivery.index')}}">Funcionamento</a></li>
		<li><a href="{{route('admin.deliverytamanhopizza.index')}}">Tamanhos de Pizza</a></li>
		<li><a href="{{route('admin.deliverymotoboy.index')}}">Motoboys</a></li>
		
	</ul>
</nav>
</div>