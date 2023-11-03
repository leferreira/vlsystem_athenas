@extends("Delivery.Web.template")
@section("conteudo")
<div class="carrinho col-12">
<div class="base-detalhes">
	<div class="base-carrinho">
		<span class="etapas etapa03"></span>
		
		
		<div class="caixa-carrinho">
		<span class="titulo">Finalizar compra</span>
		
		<table cellpadding="0" cellspacing="0" border="0" class="tabela-border">             
			
			<tbody>
				             				
				<tr>					
                    <td align="center" width="20%" colspan="5"><a href="{{route('loja.home')}}" class="btn voltar">Novo Endereço</a><a></a></td>                               
										
				</tr>
				
		   </tbody>
     </table>
	 
	<form method="get" action="{{route('carrinho.pagamento')}}">
	<input type="hidden" value="" name="empresa_id">
     <input type="hidden" value="{{$carrinho->id}}" name="pedido_id">
      @csrf
	<div class="rows">
	<div class="col-6 d-flex">
			@foreach($enderecos as $p)
				<div class="caixa endereco">
					<span class="titulo">Endereço</span>
				<ul>
					<li>
						<span>{{$p->rua}},</span> <span>{{$p->numero}} - {{$p->bairro}}</span>
                        <span>{{$p->cidade}} - ({{$p->uf}})</span> <span>{{$p->cep}}</span>
					</li>
					<li>
						<input @if($tipoFrete == 'sedex') checked @endif id="sedex" type="radio" value="{{$p}}" name="endereco"> <b>SEDEX</b> R$ {{$p->preco_sedex}} - entrega em {{$p->prazo_sedex}} dias úteis
                    </li>
					<li>
                    <input @if($tipoFrete == 'pac') checked @endif id="pac" type="radio" value="{{$p}}" name="endereco"> <b>PAC</b> R$ {{$p->preco}} - entrega em {{$p->prazo}} dias úteis
                    </li>

                    @if($p->frete_gratis)
                    <li>
						<input id="gratis" type="radio" value="{{$p}}" name="endereco"><b> Frete Gratis</b> - entrega em {{$p->prazo}} dias úteis
                   </li>
                    @else
                    <br>
					 @endif 
					</ul> 
				</div>
				@endforeach
				<input type="hidden" id="tipo" name="tipo" value="">
	</div>
			
		<div class="col-6 d-flex">
		<div class="caixa endereco">
			<div class="checkout__order">
                            <span class="titulo">Seu Pedido</span>
							<ul class="mb-4">
                            <li class="checkout__order__products">Produtos <span>{{number_format($carrinho->somaItens(), 2, ',', '.')}}</span></li>

                            <li class="checkout__order__subtotal">Frete <span id="vFrete">R$ {{number_format($carrinho->valor_frete, 2, ',', '.')}}</span></li>
                            <li class="checkout__order__total">Total <span id="vTotal">R$ {{ $carrinho != null ? number_format($carrinho->somaItens() + $carrinho->valor_frete, 2, ',', '.') : '0,00'}}</span></li>
							</ul>
                            <input type="hidden" id="total" value="{{$carrinho->somaItens()}}" name="">
                            <button type="submit" class="btn finaliza">Pronto</button>
                        </div>
			</div>
		</div>		
		
		
									
			
		</div>
	 </form>
	</div>
	        	
	</div>
	</div>
</div>


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


	