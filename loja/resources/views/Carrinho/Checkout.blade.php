@extends("template_loja")
@section("conteudo")

<div class="conteudo">
<div class="produtos">
<div class="carrinho">
<div class="base-detalhes">
	<div class="base-carrinho">
			
		<div class="rows">
		<div class="col-12">
			<span class="titulo">Confirme seus dados </span>
		</div>	
		
		
		
	 <div class="col-6 d-flex mb-3">	
	<div class="card width-100">
	<div class="rows">
		<div class="col-12">
		<div class="titulo border-top-0 h6 d-flex">
			<span class="h6 mb-0">Dados de Cadastro</span>
			<a href="{{route('login')}}" class="link-azul text-capitalize">Já sou Cadastrado</a>
		</div>	
		</div>	
		<div class="col-12">
			<div class="p-2">
				<form action="{{route('cliente.salvar')}}" method="post">	
				@csrf
							<input type="hidden" value="{{$carrinho->id}}" name="pedido_id">
							<small style="color:red">(*) campo obrigatório</small>
							<h3 class="h6">Dados Pessoais</h3>
								<div class="rows">
									<div class="col-12 mb-2">
										<span class="text-label">Nome:</span>
										<input type="text" name="nome" value="{{old('nome')}}" class="form-campo min"> 
										 @if($errors->has('nome'))
                                            <label class="text-vermelho p-1 d-block">{{ $errors->first('nome') }}</label>
                                          @endif
									</div>
									
								 </div>
								 
								<div class="rows">	
									<div class="col-6 mb-2">
									<span class="text-label">CPF:<small style="color:red">*</small></span>
									 <input type="text" value="{{old('cpf')}}" data-mask="000.000.000-00" data-mask-reverse="true" name="cpf" class="form-campo min"> 
									 @if($errors->has('cpf'))
                                    	<label class="text-vermelho p-1 d-block">{{ $errors->first('cpf') }}</label>
                                     @endif
                                    
									</div>
									<div class="col-6 mb-2">
									<span class="text-label">Telefone:</span>
									 <input type="text" data-mask="(00) 00000-0000" value="{{old('telefone')}}" name="telefone" class="form-campo min"> 
									 @if($errors->has('telefone'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('telefone') }}</label>
                                    @endif
									</div>
							   </div>
							   <div class="rows">
									<div class="col-8 mb-2">
									 <span class="text-label">E-mail: <small style="color:red">*</small></span>
									 <input type="email" value="{{old('email')}}" name="email"  class="form-campo min"> 
									 @if($errors->has('email'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('email') }}</label>
                                    @endif
									</div>
									
									<div class="col-4 mb-2">
									<span class="text-label">Senha:<small style="color:red">*</small></span>
									 <input name="senha" value="{{old('senha')}}" type="password" class="form-campo min">
									 @if($errors->has('senha'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('senha') }}</label>
                                    @endif 
									 </div>
								 </div>
								<br>
								<h3 class="h6">Informações de Endereço</h3>
							   
							   <div class="rows">
									<div class="col-4 mb-2">
									<span class="text-label">CEP: <small style="color:red">*</small></span>
									 <input type="text"  data-mask-reverse="true" value="{{{ $carrinho->observacao != '' ? $carrinho->observacao : old('cep') }}}" name="cep" class="form-campo min busca_cep mascara-cep">
									@if($errors->has('cep'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('cep') }}</label>
                                    @endif
									</div>
									
									<div class="col-6 mb-2">
									<span class="text-label">Rua: <small style="color:red">*</small></span>
									 <input type="text" value="{{ old('rua') }}" name="rua" class="form-campo min rua">
									 @if($errors->has('rua'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('rua') }}</label>
                                    @endif
									</div>
									
									<div class="col-2 mb-2">
									 <span class="text-label">Nº: <small style="color:red">*</small></span>
									 <input type="text" value="{{ old('numero') }}" name="numero" class="form-campo min">
									 @if($errors->has('numero'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('numero') }}</label>
                                    @endif
								   </div>
							   </div>
							  
							   <div class="rows">
								<div class="col-4 mb-2"> 
								 <span class="text-label">Complemento:</span>
								 <input type="text" value="{{ old('complemento') }}" name="complemento" class="form-campo min">
								  @if($errors->has('complemento'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('complemento') }}</label>
                                    @endif
								</div>
									<div class="col-8 mb-2">
									<span class="text-label">Bairro:<small style="color:red">*</small></span>
									 <input type="text" value="{{ old('bairro') }}" name="bairro" class="form-campo min bairro">
									 @if($errors->has('bairro'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('bairro') }}</label>
                                    @endif
									</div>
									<div class="col-6 mb-2">
									 <span class="text-label">Cidade: <small style="color:red">*</small></span>
									 <input type="text" value="{{  old('cidade') }}" name="cidade" class="form-campo min cidade">
									 @if($errors->has('cidade'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('cidade') }}</label>
                                    @endif
									</div>
									<div class="col-3 mb-2">
									<span class="text-label">Estado: <small style="color:red">*</small></span>
									<input type="text" name="uf" value="{{ old('uf') }}" class="form-campo min estado">
									@if($errors->has('uf'))
                                    <label class="text-vermelho p-1 d-block">{{ $errors->first('uf') }}</label>
                                    @endif						
								   </div>
								   <div class="col-3 mb-2">
									<span class="text-label">IBGE: <small style="color:red">*</small></span>
									<input type="text" name="ibge" readonly value="{{ old('ibge') }}" class="form-campo min ibge">
													
								   </div>
									
									<div class="col-4 mb-2 m-auto pt-3">
											<button type="submit" class="width-100 btn btn-vermelho medio">SALVAR</button>
									
									</div>
							   </div>
				</form>										
		</div>
		</div>
	</div>		  
				
															
</div>
</div>	

<div class="col-6 d-flex mb-3">
		<div class="card width-100">
			<span class="titulo h6 border-top-0">Produtos do Carrinho</span>
			
			<table cellpadding="0" cellspacing="0" border="0" class="table">             
				<thead>
					<tr>
						<th align="left" width="60">itens</th>
						<th align="left">Preço</th>
						<th align="center">Produto</th>
						<th align="center">Quantidade</th>
						<th align="center">Total</th>
					</tr>
				</thead>
				<tbody>
					
						@if($carrinho)
						@foreach($itens as $item)	
							@php $img = getenv("APP_IMAGEM_PRODUTO") .$item->produto->imagem; @endphp
												
					
					<tr>
						<td align="left">
							<div class="thumb"><img src="{{$img}}" class="img-fluido"></div>								
						</td>
						<td class="text-left">{{$item->produto->nome}}</td>
						<td class="text-center">R$ {{number_format($item->valor,2)}}</td>
						<td class="text-center"><input type="number" value="{{$item->quantidade}}" class="qtd" disabled="" style="width:50px"> </td>
						<td class="text-center">R$ {{number_format($item->subtotal, 2)}} </td>
						
					</tr>
				
				@endforeach 
				@endif														
        			
					<tr>
						<td class="text-left" colspan="5"><span class="valores">Valor a Pagar:</span> <strong class="resultado totalpagar">R$ {{number_format($carrinho->valor_venda, 2, ',', '.')}}</strong>  </p> </td>
						
				</tbody>
			</table>
		 
		</div>
		</div>
								 
				
				
				
				</div>			 
		
			</div>
		 
			
	</div>
</div>
</div>
</div>

	

@endsection
	