@extends("template")
@section("conteudo")
<div class="conteudo">
		<div class="rows">	
			<div class="col-12">
				<div class="caixa">					
					<form action="{{route('caixa.abrir')}}" method="POST">
					@csrf
					<div class="pt-2 px-5 pb-5 width-100 d-inline-block">
			
					<div class="">
                         <div class="rows p-4">
							 <div class="col-6 m-auto d-flex">
									<div class="caixa width-100 p-4">
									<div class="rows">                                                   
										<div class="col-12">
											<span class="d-block h4 text-uppercase">Abertura de caixa</span>
										</div>
										<!--<div class="col-12">
												<span class="text-label grande">Usuário</span>
												<label><i class="fas fa-user ico-input"></i>
												<input type="text" value="" name="usuario"  class="form-campo grande pl-5" placeholder="Digite o usiário">
												</label>
										</div>
										<div class="col-12">
												<span class="text-label grande">Senha</span>
												<label><i class="fas fa-lock ico-input"></i>
												<input type="text" value="" name="senha"  class="form-campo grande pl-5" placeholder="Digite sua senha">
												</label>
										</div>  -->                                                             
										<div class="col-12">
												<span class="text-label grande">Número Caixa</span>
												<label><i class="fas fa-cash-register ico-input"></i>
												<select class="form-campo grande pl-5" name="caixa_numero_id">
													@foreach($numeros as $n){
														<option value='{{$n->id}}'  > {{$n->descricao}}</option>
													@endforeach      
												</select>
												</label>
										</div>                            
									   
										<div class="col-12">
											<span class="text-label grande">Valor em Caixa</span>
											<label><i class="fas fa-dollar-sign ico-input"></i>
												<input type="text" name="valor_abertura"  class="form-campo grande  pl-5 mascara-float" >
											</label>
										</div>
										<div class="col-12 mt-4  pb-1 text-right">                   
											<a href="#" class="btn btn-laranja btn-grande d-inline-block btn-laranja"><i class="fas fa-arrow-left mb-0"></i> Voltar</a>                
											<input type="submit" value="Abrir caixa" class="btn btn-verde btn-grande d-inline-block">
										</div> 	
									</div>
									</div>
							</div>
							
							 <div class="col-6 alt-6">
								<img src="{{asset('assets/pdv/img/img-abertura-caixa.png')}}" class="img-fluido">
							 </div>
                        </div>
				
				</div>
			</div>
			</form>
			</div>
		</div>
	</div>
	</div>
	@endsection