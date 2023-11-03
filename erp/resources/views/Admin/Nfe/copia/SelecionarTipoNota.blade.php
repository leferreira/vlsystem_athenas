@extends("Admin.template")
@section("conteudo")


<section class="col-12 central mb-3">	
	<div class="">
	 <div class="caixa">
            <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                    <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Qual tipo de Nota Fiscal deseja Criar ? <span class="text-orange"></span></span>
            </div>
			<fieldset style="background: #f3f3f3;">
				<div class="rows">
					<div class="col-6 mb-3">
						<a href="{{route('admin.notafiscal.notaPorVenda')}}" class="btn btn-azul d-block m-auto">Venda</a>
					</div>
					<div class="col-6 mb-3">
							<a href="" class="btn btn-azul d-block m-auto">Compra</a>
					</div>
					<div class="col-6 mb-3">
							<a href="" class="btn btn-azul d-block m-auto">Transferência</a>
					</div>
					<div class="col-6 mb-3">
							<a href="" class="btn btn-azul d-block m-auto">Industrialização</a>
					</div>
					<div class="col-6 mb-3">
							<a href="" class="btn btn-azul d-block m-auto">Cobrança</a>
					</div>
					<div class="col-6 mb-3">
							<a href="" class="btn btn-azul d-block m-auto">Referenciada</a>
					</div>
					<div class="col-6 mb-3">
							<a href="" class="btn btn-azul d-block m-auto">Saída</a>
					</div>
					<div class="col-6 mb-3">
							<a href="" class="btn btn-azul d-block m-auto">Entrada</a>
					</div>				
					
				</div>
			</fieldset>
    </div>
</div>

</section>


	
	<!--cadastro de produto-->
	      
@endsection