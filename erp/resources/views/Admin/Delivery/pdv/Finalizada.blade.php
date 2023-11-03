@extends("pdv/template")
@section("conteudo")
<div class="Home">
	<div class="conteudo">
		<div class="rows">
			<div class="col-12 mb-3">

						<div class="rows">
							<div class="col-6 mb-3 m-auto py-4">
								<div class="home alt text-center sucesso">
									<i class="far fa-check-circle h1"></i>
									<div class="titulo text-center d-block mb-4 h3" style="border:0">Venda emitida com sucesso</div>
									<a href="{{route('nfce.transmitir',$vendaid['venda_id'])}}" class="btn btn-azul d-inline-block mb-3"><i class="fas fa-print"></i> Imprimir cupom</a>
									<a href="" class="btn btn-claro d-inline-block"><i class="fas fa-plus-circle"></i> Nova venda</a>
							</div>

						</div>
					</div>

			</div>
		</div>
	</div>
	</div>
	@endsection

