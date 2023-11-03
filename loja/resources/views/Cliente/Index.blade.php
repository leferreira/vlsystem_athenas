@extends("template_loja")
@section("conteudo")


<div class="carrinho col-12 produtos alt">
	<div class="card">
		<div class="titulo border-top-0 border-0 mb-0 d-flex">
			<span class="text-capitalize"><i class="fas fa-user" style="position:initial"></i> Olá, {{$cliente->nome_razao_social}}</span>			
		</div>
	</div>
	<div id="tabs" class="px-0">
		<ul class="tab">
			<li><a href="#aba-01">Dados pessoais</a></li>
			<li><a href="#aba-02">Meus pedidos</a></li>
			<li><a href="#aba-03">Meus endereços</a></li>
		</ul>
		<div id="aba-01">
			<div class="card px-2 mt-3 pb-4">
				<form action="{{route('cliente.atualizarDadosCliente')}}" method="post">
			@csrf
				<div class="rows">		
					<div class="col-12 mb-3 thead between">
						<div>
							<h3><i class="fas fa-edit" style="color:#b7b7b7"></i> Seus Dados Pessoais</h3>
						</div>
					</div>	
					<div class="col-6 mb-3">
						<small class="text-label">Nome:</small>
						<input type="text" name="nome" value="{{$cliente->nome_razao_social}}" class="form-campo"> 
					</div>	
							
					<div class="col-3 mb-3">
						 <small class="text-label">CPF:</small>
						 <input type="text" name="cpf" value="{{$cliente->cpf_cnpj}}" class="form-campo"> 
					</div>
					<div class="col-3 mb-3">
						 <small class="text-label">Telefone:</small>
						 <input type="text" name="telefone" value="{{$cliente->telefone}}" class="form-campo"> 
					</div>								
				</div>
				
				<div class="rows pt-3">		
					<div class="col-12 mb-3 thead titulo h6 text-capitalize">
						<div>
							<h3><i class="fas fa-edit" style="color:#b7b7b7"></i> Seus Dados de acesso</h3>
						</div>
					</div>	
					<div class="col-6 mb-3">
						<small class="text-label">Email:</small>
						<input type="text" name="email" value="{{$cliente->email}}" class="form-campo"> 
					</div>				
					<div class="col-6 mb-3">
						 <small class="text-label">Senha:</small>
						 <input type="password" name="senha"  class="form-campo"> 
					</div>
					
					<div class="col-3 m-auto text-center">
						<input type="hidden" name="cliente_id" value="{{$cliente->id}}" class="form-campo">
						<input type="submit"  value="Atualizar dados" class="btn btn-vermelho d-block w-100">
					</div>
				</div>
			</form>	
			</div>
		</div>
		
		
		
		<div id="aba-02">
			<div class="card px-2 mt-3 pb-4">
				<div class="rows">		
					<div class="col-12 mb-3 thead titulo h6 text-capitalize">
						<div>
							<h3> Meus pedidos</h3>
						</div>
					</div>	
					<div class="col-12 px-3">
					<div class="rows">
					@foreach($pedidos as $p)
						<div class="col-4 mb-3">
							<div class=" bg-title3 p-2 radius-4 width-100">
								<table cellpadding="0" cellspacing="0" border="0" class="table limpa">             
									<thead>
										<tr>
											<th class="text-left border-bottom">Num</th>
											<th class="text-left border-bottom">Data</th>
											<th class="text-right border-bottom">Total</th>
										</tr>
									</thead>            
									<tbody>
										<tr>
											<td class="text-left">{{ zeroEsquerda($p->id,5)}}</td>
											<td class="text-left">{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y H:i')}}</td>
											<td class="text-right">R$ {{number_format($p->valor_venda, 2, ',', '.')}}</td>
										</tr>
									</tbody>
								</table>
								<a href="{{route('acompanhar', $p->uuid)}}" class="btn btn-verde btn-pequeno mt-3 d-inline-block"><i class="fas fa-eye"></i> ver Detalhes</a>
								@if($p->status_id != config('constantes.status.FINALIZADO'))
								  <a href="{{route('carrinho.retomar', $p->uuid)}}" class="btn btn-laranja btn-pequeno mt-3 d-inline-block"><i class="fa fa-arrow-right"></i> Retomar</a>
								@endif 
							</div>		
						</div>	
					@endforeach			
					</div>		
					</div>		
				</div>
			</div>
		</div>
		
		
		<div id="aba-03">
			<div class="card px-2 mt-3 pb-4">
				<div class="rows">		
					<div class="col-12 mb-3 thead titulo h6 text-capitalize">
						<div>
							<h3> Meus endereços cadastrados</h3>
						</div>
					</div>	
				</div>

				<div class="rows">							
					<div class="col-12 mb-3 px-3">
						<div>
							<button onclick="inserirEndereco()" class="btn btn-azul">
								<i class="fa fa-plus"></i> Novo Endereço
							</button>
						</div>
					</div>
					<div class="col-12 px-3">
					<div class="rows">
					@foreach($enderecos as $e)
						<div class="col-6 mb-3">
							<div class=" bg-title3 p-2 radius-4 width-100">
								<table cellpadding="0" cellspacing="0" border="0" class="table limpa">             
									<thead>
										<tr>
											<th class="text-left border-bottom" colspan="2">Endereço</th>
										</tr>
									</thead>            
									<tbody>
										<tr><th class="text-left" style="font-size:.8rem;width: 42px;">End.</th><td>{{$e->logradouro}}, {{$e->numero}} - {{$e->bairro}}</td></tr>
										<tr><th class="text-left" style="font-size:.8rem;width: 42px;">Cidade.</th><td>{{$e->cidade}} - {{$e->uf}}</td></tr>
										<tr><th class="text-left" style="font-size:.8rem;width: 42px;">Cep.</th><td>{{$e->cep}}</td></tr>
									</tbody>
								</table>
		
								<button onclick="alterarEndereco({{$e->id}})" class="btn btn-verde btn-pequeno mt-3 d-inline-block">
									<i class="fa fa-edit"></i>
									Editar
								</button>
							</div>		
						</div>
						@endforeach
								
					</div>		
					</div>		
				</div>				
		
			</div>
		</div>
		
		
	</div>
				
</div>

<!--endereço-->
<form action="{{route('cliente.salvarEnderecoCliente')}}" method="post">
@csrf
<div class="window medio" id="novo">
	<span class="titulo">Adicionar endereço</span>
	<div class="p-3 px-md">
		<div class="rows">
			<div class="col-4 mb-3">
				<span class="text-label">CEP</span>
				<input type="text" name="cep" id="cep" required class="form-campo busca_cep mascara-cep"> 
			</div>
			
			<div class="col-8 mb-3">
				<span class="text-label">Rua</span>
				<input type="text" name="logradouro" required id="rua" class="form-campo rua"> 
			</div>
			<div class="col-3 mb-3">
				<span class="text-label">Número</span>
				<input type="text" name="numero" id="numero"  required class="form-campo"> 
			</div>
			<div class="col-9 mb-3">
				<span class="text-label">Bairro</span>
				<input type="text" name="bairro" id="bairro" required  class="form-campo bairro"> 
			</div>
			
			<div class="col-9 mb-3">
				<span class="text-label">Cidade</span>
				<input type="text" name="cidade" id="cidade" required class="form-campo cidade"> 
			</div>
			<div class="col-3 mb-3">
				<span class="text-label">UF</span>
				<input type="text" name="uf" id="uf" required class="form-campo estado"> 
			</div>
			<div class="col-9 mb-3">
				<span class="text-label">Complemento</span>
				<input type="text" name="complemento" id="complemento" class="form-campo"> 
			</div>
			
			<div class="col-2 mb-3">
				<span class="text-label">Ibge</span>
				<input type="text" name="ibge" id="ibge" required class="form-campo ibge"> 
			</div>
		</div>
	</div>
	<div class="tfooter end">
		<a href="javascript:;" onclick="fecharModal()" class="fechar btn btn-neutro">Fechar</a>
		<input type="hidden" name="endereco_id" id="endereco_id" > 
		<input type="hidden" name="cliente_id" value="{{$cliente->id}}">
		<button type="submit" class="btn btn-laranja">Cadastrar</button>
	</div>
</div>

</form>
<div id="fundo_preto"></div>

<script>
	function inserirEndereco(){
		$("#endereco_id").val("");
		limpar();
		abrirModal('#novo');
	}
	
	function alterarEndereco(id){
	$("#endereco_id").val(id);
	 $.ajax({
		  url: base_url + "cliente/enderecoJs/" + id,
		  type: "GET",
		  dataType: "json",
		  data:{},
		  success: function (data){
			  preencher(data); 
			  abrirModal('#novo');
		  }
	   });	
	}

function preencher(data){
	$("#endereco_id").val(data.id);	
	$("#cep").val(data.cep);
	$("#rua").val(data.logradouro);
	$("#numero").val(data.numero);
	$("#bairro").val(data.bairro);
	$("#complemento").val(data.complemento);
	$("#cidade").val(data.cidade);
	$("#bairro").val(data.bairro);
	$("#uf").val(data.uf);
	$("#ibge").val(data.ibge);
}

function limpar(){
	$("#endereco_id").val("");	
	$("#cep").val("");
	$("#rua").val("");
	$("#numero").val("");
	$("#bairro").val("");
	$("#complemento").val("");
	$("#cidade").val("");
	$("#bairro").val("");
	$("#uf").val("");
}
	
</script>
@endsection
	