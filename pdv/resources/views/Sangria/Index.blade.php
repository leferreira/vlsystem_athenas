@extends("template")
@section("conteudo")

<div class="conteudo">
				<div class="caixa">
		<div class="rows pb-4">	
			<div class="col-12">
					<div class="caixa-titulo py-1 d-flex width-100 justify-content-space-between center-middle">
						<span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Sangria do Caixa</span>
						<a href="{{route('caixa.caixasAberto')}}" class="btn btn-pequeno btn-azul"><i class="fas fa-arrow-left"></i> Voltar</a>
					
					</div>					
			</div>					
				<div class="col-4 mt-2 d-flex pl-4">
					<div class="border width-100" style="background: #31718e;">		
						<div class="d-inline-block">
							<form action="{{route('sangria.store')}}" method="POST">
							@csrf
							<span class="d-block p-2 h4 border-bottom text-branco">Sangria</span>
								 <div class="rows px-4">
										<div class="col-12">
												<label class="text-label text-branco">Valor da Retirada</label>
												<input type="text" name="valor"  class="form-campo mascara-float grande">
										</div>
										<div class="col-12">
												<label class="text-label text-branco">Descrição</label>
												<input type="text" name="descricao"  class="form-campo grande">
										</div>
										<div class="col-12 mt-2 pb-5"> 
												<input type="hidden" name="caixa_id" value="{{$caixa_id}}">                                  
												 <input type="submit" value="Salvar" class="btn btn-verde btn-medio d-block width-100">
										</div>                                 												
								</div>					
							</form>
						</div>
					</div>
				</div>
				
				<div class="col-8 mt-2 caixaAberto">
				<div class="width-100 d-inline-block">
					<div class="tabela-responsiva py-0">					
						<div class="cx">					
							<table cellpadding="0" cellspacing="0" >
								<thead>
									<tr>
										<th align="left">Id</th>
										<th align="left" >Valor</th>
										<th align="left" >Descrição</th>
									</tr>
								</thead>
								<tbody>
							  
								@if($lista)
								 @foreach ($lista as $f)                    
									<tr>
										<td align="left">{{ $f->id  }}</td>
										<td align="left">{{ $f->valor }}</td>
										<td align="left">{{ $f->descricao }}</td>								
									</tr>                    
								@endforeach              
							@endif		     					
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