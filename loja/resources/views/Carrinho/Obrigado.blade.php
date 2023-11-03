@extends("template_loja")
@section("conteudo")

<div class="conteudo">
	<div class="Finalizado">
		<div class="carrinho">
								<div class="rows">
									<div class="col-6 m-auto text-center">
										<i class="fas fa-check-circle "></i>
										<h1><span>PARABÉNS! </span>
											Seu pedido foi realizado com sucesso.</h1>
											<p>Obrigado pela sua compra, você receberá um email com mais detalhes de sua compra e o número do seu pedido é: <strong>{{zeroEsquerda($id_pedido,4)}}</strong>
				para acompanhar o andamento do produto entre na sua área de cliente</p>
											<div class="limpar"></div>
											<a href="{{route('home')}}" class="btn btn-laranja d-inline-block"><i class="fas fa-arrow-left"></i> voltar para compra</a>
									</div>
								</div>
		</div>
</div>
</div>

@endsection
	