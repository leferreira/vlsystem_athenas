@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
	<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Permissão de menu</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
		</div> 		
	</div>
		<div class="p-4 col-9 m-auto">	               
			<div class="border radius-4">	               
			<div class="rows">	               
				<div class="col-4 pr-0">	               
					<div class="border-right">	               
						<div class="border-bottom mb-0">	               
							<span class="d-block bg-title p-1"><h4 class="text-uppercase text-center h5 mb-0">Menu principal</h4></span>
						</div> 
						<div class="p-1 menuprincipal permitir position-inherit width-100">
							<ul class="menu-ul">
								<li class="ativado"><a href="" title="Configurações"><i class="icon fas fa-cog"></i> Configurações </a></li>								
								<li><a href="" title="Cadastro"><i class="icon fas fa-file"></i> Cadastro </a></li>								
								<li><a href="" title="Compras"><i class="icon fas fa-cart-plus"></i> Compras </a></li>									
								<li><a href="" title="Venda"><i class="icon fas fa-donate"></i> Venda </a></li>
								<li><a href="" title="Ordem de Serviço"><i class="icon fas fa-donate"></i> Ordem de Serviço </a></li>								
								<li><a href="" title="Pedido de Cliente"><i class="icon fas fa-parking"></i> Pedido de Cliente </a></li>
								<li><a href="" title="Loja virtual"><i class="icon fas fa-shopping-basket"></i> Loja Virtual </a></li>
								<li><a href="" title="Estoque"><i class="icon fas fa-cubes"></i> Estoque </a></li>
								<li><a href="" title="NFE"><i class="icon fas fa-copyright"></i> Notas Fiscais </a></li>
								<li><a href="" title="PDV"><i class="icon fas fa-cash-register"></i> PDV </a></li>
								<li><a href="" title="Financeiro/contabil"><i class="icon fas fa-hand-holding-usd"></i> Financeiro </a></li>
								<li><a href="" title="Relatorios"><i class="icon fas fa-hand-holding-usd"></i> Relatórios </a></li>					
													
							</ul>
						</div>
					</div>            
				</div>            
				<div class="col-8 pl-0">	               
					<div class="border-bottom mb-0">	               
						<span class="d-block bg-title p-1"><h4 class="text-uppercase text-center h5 mb-0">Marque as opções desejadas</h4></span>
					</div>
					<div class="p-1">					
					<table cellpadding="0" cellspacing="0" width="100%" class="table border radius-4">
						<thead>
							<tr>
								<th align="center" width="60">Marcar</th>
								<th align="left">Opção</th>
							</tr>
						</thead>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Meu Plano</label></td>
						</tr>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Minha empresa</label></td>
						</tr>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Meu Plano</label></td>
						</tr>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Minha empresa</label></td>
						</tr>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Meu Plano</label></td>
						</tr>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Minha empresa</label></td>
						</tr>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Meu Plano</label></td>
						</tr>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Minha empresa</label></td>
						</tr>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Meu Plano</label></td>
						</tr>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"></div>
							</td>
							<td><label>Minha empresa</label></td>
						</tr>
					</table>
				</div>
				</div>
			</div>
			</div>
        </div>
        </div>
        @endsection