@extends("Delivery.Web.template")
@section("conteudo")

<div class="conteudo">
	<div class="base-prod-home">
		<div class="carrinho">
		<div class="base-detalhe">
				<div class="base-carrinho">
								<span class="etapas etapa03"></span>	
							
								<div class="caixa-carrinho">
									<div class="finalizar">
										<i class="iconefinal"></i>
										<h1><span>PARABÉNS! </span>
											Seu pedido foi realizado com sucesso.</h1>
											<p>OBrigado pela sua compra, você receberá um email com mais detalhes de sua compra e o número do seu pedido é: xxx
				para acompanhar o andamento do produto entre na sua área de cliente</p>
											<div class="limpar"></div>
											<a href="{{route('delivery.web.home')}}" class="btn"> voltar para compra</a>
									</div>
								</div>
				</div>
		</div>
	</div>
</div>
</div>

@endsection
	