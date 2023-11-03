@extends("Delivery.Web.template")
@section("conteudo")

<div class="conteudo">
<div class="base-prod-home">
<div class="carrinho">
<div class="base-detalhes">
	<div class="base-carrinho">
			<span class="etapas etapa02"></span>
			<span class="ttd">
			<small>CATEGORIA</small>
			<small>URSO PRINCÍPE</small>
			<small class="ativo">carrinho</small>
			</span>
			
			
		<div class="caixa-carrinho">
			<span class="titulo">Confirmar compra</span>
			
			<table cellpadding="0" cellspacing="0" border="0">             
				<thead>
					<tr>
						<th align="left" width="40%">itens</th>
						<th align="center">PREÇO</th>
						<th align="center">QUANTIDADE</th>
						<th align="center">total</th>
					</tr>
				</thead>
				<tbody>
									<tr>
						<td align="left">
							<div class="thumb"><img src="https://mjailton.com.br/testes/erp_oficial/versao02/upload/PANELA_LONGA.jpg"></div>
							<span class="produto">Panela Longa</span>
						</td>
						<td align="center">R$ 100.00</td>
						<td align="center"><input type="number" value="1" class="qtd" disabled=""> </td>
						<td align="center">R$ 100 </td>
						
					</tr>
						
				</tbody>
			</table>
		 <table cellpadding="0" cellspacing="0" border="0">	
			<tbody>
				<tr>
					<td colspan="4">					  
						<!--<p><span class="valores">SubTotal:</span> 		<strong class="resultado">R$ 150,00</strong>             </p>     
						<p><span class="valores">Frete:</span> 		<strong class="resultado">R$ 30,00</strong>                  </p>
						<p><span class="valores">Desconto:</span> 		<strong class="resultado desconto">2%</strong>          </p>  -->
						<p><span class="valores">Valor a Pagar:</span> <strong class="resultado totalpagar">R$ 100</strong>  </p>                
					</td>
				</tr>
			</tbody>
		</table>
		 
		</div>
	 <div class="caixa-carrinho">
	<dl> 
	<div class="rows">
		<div class="col-12 d-flex justify-content-space-between">
			<span class="titulo">cadastro de contato</span>	<a href="{{route('loja.login')}}" class="btn" style="margin:initial">Já sou Cadastrado</a>
		</div>	
		<div class="col-12">
			<div class="caixa-entrega form-contato">
				<form action="{{route('carrinho.salvarCliente')}}" method="post">	
				@csrf
							<input type="hidden" value="{{$carrinho->id}}" name="pedido_id">
							<small style="color:red">(*) campo obrigatório</small>
							<h3>Dados Pessoais</h3>
								<div class="rows">
									<div class="col-4">
										<strong>Nome:</strong>
										<input type="text" name="nome" value="{{old('nome')}}"> 
										 @if($errors->has('nome'))
                                            <label class="text-vermelho p-1 d-block">{{ $errors->first('nome') }}</label>
                                          @endif
									</div>
									<div class="col-8">
										<strong>Sobre Nome:</strong>
										<input type="text" name="sobre_nome" value="{{old('sobre_nome')}}"> 
										 @if($errors->has('sobre_nome'))
                                            <label class="text-vermelho p-1 d-block">{{ $errors->first('sobre_nome') }}</label>
                                          @endif
									</div>
								 </div>
								 
								<div class="rows">	
									<div class="col-6">
									 <strong>CPF:<small style="color:red">*</small></strong>
									 <input type="text" value="{{old('cpf')}}" data-mask="000.000.000-00" data-mask-reverse="true" name="cpf"> 
									 @if($errors->has('cpf'))
                                    	<label class="text-vermelho p-1 d-block">{{ $errors->first('cpf') }}</label>
                                     @endif
                                    
									</div>
									<div class="col-6">
									 <strong>Telefone:</strong>
									 <input type="text" data-mask="(00) 00000-0000" value="{{old('telefone')}}" name="telefone"> 
									 @if($errors->has('telefone'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('telefone') }}</label>
                                    @endif
									</div>
							   </div>
							   <div class="rows">
									<div class="col-6">
									 <strong>E-mail: <small style="color:red">*</small></strong>
									 <input type="email" value="{{old('email')}}" name="email" > 
									 @if($errors->has('email'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('email') }}</label>
                                    @endif
									</div>
									
									<div class="col-6">
									 <strong>Senha:<small style="color:red">*</small></strong>
									 <input name="senha" value="{{old('senha')}}" type="password">
									 @if($errors->has('senha'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('senha') }}</label>
                                    @endif 
									 </div>
								 </div>
								<br><br> 
								<h3>Informações de Endereço</h3>
							   
							   <div class="rows">
									<div class="col-4">
									 <strong>CEP: <small style="color:red">*</small></strong>
									 <input type="text" data-mask="00000-000" data-mask-reverse="true" value="{{{ $carrinho->observacao != '' ? $carrinho->observacao : old('cep') }}}" name="cep">
									@if($errors->has('cep'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('cep') }}</label>
                                    @endif
									</div>
									
									<div class="col-4">
									 <strong>Rua: <small style="color:red">*</small></strong>
									 <input type="text" value="{{ old('rua') }}" name="rua">
									 @if($errors->has('rua'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('rua') }}</label>
                                    @endif
									</div>
									
									<div class="col-2">
									 <strong>Número: <small style="color:red">*</small></strong>
									 <input type="text" value="{{ old('numero') }}" name="numero">
									 @if($errors->has('numero'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('numero') }}</label>
                                    @endif
								   </div>
								   
									<div class="col-2">
									<strong>Estado: <small style="color:red">*</small></strong>
									<input type="text" name="uf" value="{{ old('uf') }}">
									@if($errors->has('uf'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('uf') }}</label>
                                    @endif						
								   </div>
							   </div>
							  
							   <div class="rows">
								<div class="col-4"> 
								 <strong>Complemento:</strong>
								 <input type="text" value="{{ old('complemento') }}" name="complemento">
								  @if($errors->has('complemento'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('complemento') }}</label>
                                    @endif
								</div>
									<div class="col-4">
									 <strong>Bairro:<small style="color:red">*</small></strong>
									 <input type="text" value="{{ old('bairro') }}" name="bairro">
									 @if($errors->has('bairro'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('bairro') }}</label>
                                    @endif
									</div>
									<div class="col-4">
									 <strong>Cidade: <small style="color:red">*</small></strong>
									 <input type="text" value="{{  old('cidade') }}" name="cidade" >
									 @if($errors->has('cidade'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('cidade') }}</label>
                                    @endif
									</div>
							   </div>
							   <button type="submit" class="btn">SALVAR</button>
				</form>										
		</div>
		</div>
	</div>
					  
				
															
				</dl></div>			 
		
			</div>
		 
			
	</div>
</div>
</div>
</div>

	

@endsection
	