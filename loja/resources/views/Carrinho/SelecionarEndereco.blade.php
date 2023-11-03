@extends("template_loja")
@section("conteudo")
<div class="carrinho col-12 produtos">
<div class="base-detalhes">
	<div class="base-carrinho">
		<span class="etapas etapa03"></span>
		
		
		<div class="caixa-carrinho">
		<span class="titulo">Finalizar compra</span>
		<form method="get" action="{{route('carrinho.pagamento')}}">		
			
			<input type="hidden" value="{{$carrinho->id}}" name="pedido_id">
		<div class="rows">
			<div class="col-9">
			<a href="javascript:;" onclick="abrirModal('#novo')" class="btn btn-azul d-inline-block">Novo Endereço</a>
		<?php $i = 1?>
		@foreach($enderecos as $p)
		
			<div class="card width-100 mb-2">
				<div class="caixa endereco">
						<span class="titulo" style="border-top:0">Endereço {{$i++}}</span>
						<div class="p-4 py-2">
						
							<ul class="end-text mt-2">
								<li>
									<span>{{$p->logradouro}},</span> <span>{{$p->numero}} - {{$p->bairro}}</span>
									<span>{{$p->cidade}} - ({{$p->uf}})</span> <span>{{$p->cep}}</span>
								</li>
								
								<li class="radio">								
									<label><input @if($tipoFrete == 'sedex') checked @endif id="sedex" type="radio" value="{{json_encode($p)}}"  name="endereco"> <b>SEDEX</b> R$ {{$p->preco_sedex}} - entrega em {{$p->prazo_sedex}} dias úteis</label>
								</li>
								
								<li class="radio">
									<label><input @if($tipoFrete == 'pac') checked @endif id="pac" type="radio" value="{{json_encode($p)}}"  name="endereco"> <b>PAC</b> R$ {{$p->preco}} - entrega em {{$p->prazo}} dias úteis</label>
								</li>
								
								@if($p->frete_gratis)
								<li class="radio">
									<input id="gratis" type="radio" value="{{json_encode($p)}}" name="endereco"><b> Frete Gratis</b> - entrega em {{$p->prazo}} dias úteis
								</li>
								@else
								<br>
								 @endif
								 
							</ul> 
						</div>
				</div>
			</div>
			
			@endforeach
			<input type="hidden" id="tipo" name="tipo" >
			</div>
		
			<div class="col-3 d-flex mb-2">
				<div class="card width-100" style="background: #ebebe94d;">
					<span class="titulo">Seu Pedido</span>
					<div class="px-md-2 pb-4">
						<table cellpadding="0" cellspacing="0" border="0" class="table">             
							<tbody>
								<tr>
									<td align="left" width=""><b>Produto	</b></td>
									<td align="right" ><b >{{number_format($carrinho->valor_venda, 2, ',', '.')}}	</b></td>
								</tr>
								<tr>
									<td align="left" width=""><b>Frete	</b></td>
									<td align="right" ><b id="vFrete"> R$ {{number_format($carrinho->valor_frete, 2, ',', '.')}}</b></td>
								</tr>
								<tr>
									<td align="left" width=""><b >Total	</b></td>
									<td align="right" ><b id="vTotal">R$ {{ $carrinho != null ? number_format($carrinho->valor_venda + $carrinho->valor_frete, 2, ',', '.') : '0,00'}}</b></td>
								</tr>
							</tbody>
							
						</table>
						
					<div class="mt-3">
						 <input type="hidden" id="total" value="{{$carrinho->valor_venda}}" name="total_itens">
						 <input type="hidden" id="uuid" value="{{$carrinho->uuid}}" name="uuid">
						 <button type="submit" class="btn btn-laranja finaliza m-auto"> Pronto </button>
					 </div>
					</div>
				</div>
		</div>
		</div>
		

	 </form>
	
	        	
	</div>
	</div>
</div>
</div>
<form action="{{route('cliente.salvarEnderecoCliente')}}" method="post">
	@csrf
        <div class="window medio" id="novo">
        	<span class="titulo">Adicionar endereço</span>
        	<div class="p-3 px-md">
        		<div class="rows">
        			<div class="col-3 mb-3">
        				<span class="text-label">CEP</span>
        				<input type="text" name="cep" class="form-campo busca_cep mascara-cep"> 
        			</div>
        			
        			<div class="col-9 mb-3">
        				<span class="text-label">Rua</span>
        				<input type="text" name="logradouro" class="form-campo rua"> 
        			</div>
        			<div class="col-9 mb-3">
        				<span class="text-label">Bairro</span>
        				<input type="text" name="bairro" class="form-campo bairro"> 
        			</div>
        			
        			<div class="col-3 mb-3">
        				<span class="text-label">Número</span>
        				<input type="text" name="numero" class="form-campo"> 
        			</div>
        			<div class="col-9 mb-3">
        				<span class="text-label">Cidade</span>
        				<input type="text" name="cidade" class="form-campo cidade"> 
        			</div>
        			<div class="col-3 mb-3">
        				<span class="text-label">UF</span>
        				<input type="text" name="uf" class="form-campo estado"> 
        			</div>
        			
        			<div class="col-12 mb-3">
        				<span class="text-label">Complemento</span>
        				<input type="text" name="complemento" class="form-campo"> 
        				<input type="hidden" name="ibge" class="form-campo ibge">
        			</div>
        		</div>
        	</div>
        	<div class="tfooter end">
        		<input type="hidden" value="{{ $cliente->id }}" id="cliente_id" name="cliente_id">
        		<a href="javascript:;" onclick="fecharModal()" class="fechar btn btn-neutro">Fechar</a>
        		<input type="submit" class="btn btn-laranja" value="Salvar">
        	</div>
        </div>
 </form>
<div id="fundo_preto"></div>

<script >

    var TOTAL= 0;
    var FRETE= 0;
    $('document').ready(function(){
        TOTAL = $('#total').val();
        radioClick();
    });

    function radioClick(){
    
        let sedex = $('#sedex').is(':checked')
        let pac = $('#pac').is(':checked')
        if(sedex || pac){
            let v = null;
            let id = null;
            if(sedex){
                v = $('#sedex').val()
                id = 'sedex'
            }

            if(pac){
                v = $('#pac').val()
                id = 'pac'
            }
            v = JSON.parse(v)

            $('#tipo').val(id)
            if(id == 'pac'){
                FRETE = v.preco
            }else if(id == 'sedex'){
                FRETE = v.preco_sedex
            }else{
                FRETE = '0';
            }

            $('#vFrete').html('R$ ' + formatReal(FRETE))

            somaTotal();
        }
    }
    $('input:radio').change((target) => {
		
        let v = target.target.value
        let id = target.target.id

        v = JSON.parse(v)

        $('#tipo').val(id)
        if(id == 'pac'){
            FRETE = v.preco
        }else if(id == 'sedex'){
            FRETE = v.preco_sedex
        }else{
            FRETE = '0';
        }

        $('#vFrete').html('R$ ' + formatReal(FRETE))

        somaTotal();
    });

    function somaTotal(){
        let f = FRETE.replace(',', '.');

        f = parseFloat(f);
        let t = parseFloat(TOTAL)
        console.log(t + f)

        $('#vTotal').html(formatReal(t + f))

    }

    function formatReal(v){
        return v.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
    }
</script>
@endsection


	