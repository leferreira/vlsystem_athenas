@extends("template")
@section("conteudo")

<div class="conteudo">
				<div class="caixa">
		<div class="rows">	
			<div class="col-12">
					<div class="caixa-titulo py-1 d-flex width-100 justify-content-space-between center-middle">
						<span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Sangria do Caixa</span>
						<a href="" class="btn btn-pequeno btn-azul"><i class="fas fa-arrow-left"></i> Voltar</a>
					
					</div>
					
					
					<div class="pt-2 px-2 pb-5 width-100 d-inline-block">
					<form action="{{route('sangria.store')}}" method="POST">
					<div class="border">
					<span class="d-block p-2 h4 border-bottom">Sangria</span>
                         <div class="rows">
                                <div class="col-2">
                                        <label class="text-label">Valor da Retirada</label>
                                        <input type="text" name="valor" value="<?php echo isset($produto) ? $produto->preco: "" ?>"  class="form-campo">
                                </div>
                                <div class="col-4">
                                        <label class="text-label">Descrição</label>
                                        <input type="text" name="descricao" value="<?php echo isset($produto) ? $produto->preco: "" ?>"  class="form-campo">
                                </div>
                                <div class="col-2 mt-4  pb-5">                                   
                                         <input type="submit" value="Salvar" class="btn btn-verde btn-medio d-block width-100">
                                </div>                                 												
       					</div>
				
				</div>
				</form>
				</div>
				
				
			</div>
				
				<div class="col-12">
				<div class="px-5 pb-5 width-100 d-inline-block">
					<div class="tabela-responsiva">
					
						<table cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <th align="left">Id</th>
                                    <th align="left" >Valor</th>
                                    <th align="left" >superior</th>
                                    <th align="left" >Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                          
                            @if($lista)
                             @foreach ($lista as $f)                    
								<tr>
									<td align="left">{{ $f->id_sangria  }}</td>
									<td align="left">{{ $f->valor }}</td>
									<td align="left">{{ $f->usuario }}</td>	
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

@endsection