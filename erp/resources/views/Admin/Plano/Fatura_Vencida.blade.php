@extends("Admin.template")
@section("conteudo")
<div class="central">
	<div class="conteudo obrigado vencido">
		<div class="rows">
			<div class="col-12 m-auto text-center">
				<i class="fas fa-times"></i>
				<span class="d-block text-center text-escuro mt-0 h1 mb-0">Sua Fatura Venceu</span>
				<span class="d-block text-center h4 text-escuro">faça o pagamento para que seu acesso seja liberado</span>
				<p class="text-escuro h5">Assim que confirmarmos seu pagamento liberaremos sua assinatura</p>
				<a href="{{route('admin.fatura.confirmarPagamento', $fatura->id)}}" class="btn btn-verde d-inline-block h5"><i class="fas fa-arrow-up"></i> Pagar Fatura</a>
			</div>
		</div>
	</div>
</div>

@endsection