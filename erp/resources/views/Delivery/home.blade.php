@extends("templates.template_delivery")
@section("conteudo")
@if(session()->has('message_sucesso'))
<div class="p-3 mb-2 bg-success text-white">{{ session()->get('message_sucesso') }}</div>
@endif

@if(session()->has('message_erro'))
<div class="p-3 mb-2 bg-danger text-white">{{ session()->get('message_erro') }}</div>
@endif
<div class="col-9 base-categoria">			
		<div class="caixa-prod-home categorias mb-4">	
			<span class="titulo mb-3">Linha Hotel</span>
			<div class="rows">	
			@foreach($produtos as $produto)										
						<div class="col-3 d-flex">
							<div class="thumb"><img src="{{asset('assets/loja/upload/PANELA_LONGA.jpg')}}">
								<span class="ttp">{{$produto->nome}}</span>
								<span class="tpc">R$ {{$produto->valor_venda}}</span>
								<div class="base-btn">            
									<a href="{{route('delivery.produto.detalhe',$produto->id)}}" class="btn">Comprar</a>
                                
                            </div>
							</div>
						</div>	
			@endforeach	
			</div>		
		</div>
	
		
		
</div>
@endsection
	