@extends("template_loja")
@section("conteudo")

<div class="col-12">
				<div class="det_prod">
					<div class="titulo alt">
						<div><a href="" class="migalha">Home <i class="fas fa-angle-double-right"></i></a> <a href="" class="migalha">{{$produto->categoria->categoria ?? "Sem Categoria"}} <i class="fas fa-angle-double-right"></i></a> <span class="migalha">{{$produto->nome}} </span></div>
						
					</div>
					<div class="rows">
						<div class="col-6 d-flex">
						
							
						@if(count($imagens) > 0)
					
							<div class="caixa-img">
    							<div class="galeria">
    								<?php $i=1; ?>
    								@foreach($imagens as $im)
    									<img src="{{ getenv('APP_IMAGEM_PRODUTO') .$im->img }}" class="img-fluido" id="imagem-{{$i++}}"/>
    								@endforeach								
    								
    							</div>
    						
    							<div class="miniaturas">
    							<?php $j=1; ?>
    							@foreach($imagens as $img)    								
    								<a href="#" id="{{$j++}}"><img src="{{getenv('APP_IMAGEM_PRODUTO') .$img->img}}" alt="" /></a>
    							@endforeach
    							</div>					
							
							</div>
						@else	
							<div class="caixa-img"> 
							<div class="galeria">   													
    								<img src="{{getenv('APP_IMAGEM_PRODUTO') .$produto->imagem}}" class="img-fluido" id="imagem-1"/>		
    						</div>				
    						</div>
						@endif	
							
							
						</div>
						
						
						<div class="col-6">
							<div class="caixa-prod">
								<span class="h4">{{$produto->nome}}</span>		
								<div id="produto_com_cupom" style="display:none">						
    								<hr></hr>
    								<div class="valor_venda alt d-flex" style="align-items:center"  >
    									<div class="mr-3">
    										<small>Por apenas<br> <strong style="color:#242413;" class="h4">R$ <span id="valor_desconto"></span></strong></small> 
    										<strong class="text-vermelho" style="opacity: .6;">de <strike>R$ {{number_format($produto->valor_venda,2,",",".")}} </strike></strong>
    									</div>
    									<div class="cupomaplicado mr-3">
    										<small>O código de cupom <b id="codigo_do_cupom"></b> foi aplicado</small>
    									</div>
    									
    									<div><img src="{{asset('assets/loja/img/bandeiras.png')}}" height="15"></small></div>
    								</div>
    							</div>
    							<div id="produto_sem_cupom" style="display:display">
								<hr></hr>
								
								<div class="valor_venda alt d-flex" style="align-items:center">
									<div class="mr-3">
										<small>Por apenas<br> <strong style="color:#242413;" class="h4">R$ {{number_format($produto->valor_venda,2,",",".")}}</strong> 
										<strong class="" style="opacity: .6;">à vista</strong>
									</div>									
									<div><img src="{{asset('assets/loja/img/bandeiras.png')}}" height="15"></small></div>
								</div>
								</div>
								<hr></hr>
							@if($grade)
								<div class="mais_opcoes">
									<span class="titulo h6 mb-0 border-0">{{$grade->variacao_linha ?? null}}:</span>
								
									<div class="EscolherOpcoes" >
										@foreach($grade->linhas as $linha)
											<a href="javascript:;" onclick="selecionarLinha({{$linha->id}})" id="linha_{{$linha->id}}" class="opcx linha_da_grade">{{$linha->valor}}</a>
										@endforeach
									</div>									
								
									<hr></hr>
									<div class="tamanhos alt d-block" style="background:none">
									<strong class="d-block">{{$grade->variacao_coluna ?? null}}</strong>
									<div class="EscolherOpcoes">
										@foreach($grade->colunas as $coluna)
											<a href="javascript:;" onclick="selecionarColuna({{$coluna->id}})" id="coluna_{{$coluna->id}}" class="opcx coluna_da_grade">{{$coluna->valor}}</a>
										@endforeach
									</div>										
								</div>
								</div>
							@endif	
						<form method="post"  action="{{route('carrinho.add')}}" id="frmCarrinho">
                   		{{ csrf_field() }}		
								<div class="tamanhos p-2 pb-0 d-block" style="height:auto;min-height:auto">
									<div class="rows">
										<div class="col-3 mb-2">
										<strong class="d-block">Quantidade:</strong>
										<input type="number" name="qtde" id="qtde" value="1" style="width:85px"> 
										
										<input type="hidden" name="produto_uuid" value="{{$produto->uuid}}">
								<input type="hidden" name="produto_id" value="{{$produto->id}}" id="produto_id">
                                <input type="hidden" name="produto_titulo" value="{{$produto->nome}}"> 
                                <input type="hidden" name="produto_imagem" value="{{$produto->imagem}}"> 
                                <input type="hidden" name="peso_bruto" value="{{$produto->peso_bruto}}"> 
                                <input type="hidden" name="comprimento" value="{{$produto->comprimento}}"> 
                                <input type="hidden" name="altura" value="{{$produto->altura}}"> 
                                <input type="hidden" name="largura" value="{{$produto->largura}}"> 
                                <input type="hidden" name="valor_venda" value="{{$produto->valor_venda}}">  
                                <input type="hidden" name="usa_grade" id="usa_grade" value="{{$produto->usa_grade}}"> 
                                <input type="hidden" name="linha_id" id="linha_id" value="0">
                                <input type="hidden" name="coluna_id" id="coluna_id" value="0">
                                <input type="hidden" id="variacao_linha"  value="{{$grade->variacao_linha ?? null}}">
                                <input type="hidden" id="variacao_coluna"  value="{{$grade->variacao_coluna ?? null}}">
                           
                                
                                
										</div>
										<div class="col-9 mb-2">
											<strong class="d-block">.</strong>
											<div class="col-9">
        										<input class="btn btn-laranja width-100" type="button" onclick="adicionarCarrinho()" value="ADICIONAR ao carrinho">
        									</div>
										</div>
										<!--<div class="col-9 mb-3">
										<strong class="d-block">Observação:</strong>
											<textarea class="form-campo" placeholder="Escreva uma observação adicional"></textarea>
										</div>-->
									</div>									
								</div>
								

								
                    
								
								
						</form>		
							</div>
							
						</div>
						
						<div class="col-12 mt-4">
							<div class="titulo">
								<div><span>Descrição do produto <i class="fas fa-angle-double-right"></i></span></div>								
							</div>
							<div class="desc-det">
								<div>{{$produto->descricao}}</div>
							</div>
						<!--  	<div class="desc-det">
									<strong>DETALHES DO PRODUTO</strong>
									<ul>
										<li><i class="fas fa-angle-double-right"></i> MODELO Nº: 9952174 - vermelho VENDIDO E ENTREGUE POR: lojavirtual</li>
										<li><i class="fas fa-angle-double-right"></i> Produzido: Brasil</li>
										<li><i class="fas fa-angle-double-right"></i> Modelagem: Decote Careca, Manga Curta</li>
										<li><i class="fas fa-angle-double-right"></i> Tipo Estampa: Localizada</li>
										<li><i class="fas fa-angle-double-right"></i> Material: Algodão</li>
										<li><i class="fas fa-angle-double-right"></i> Cor: Vermelho, verde, azul,roxo, verde</li>
										<li><i class="fas fa-angle-double-right"></i> Marca: Calvin Klein</li>
										<li><i class="fas fa-angle-double-right"></i> Personagem: Sem personagem</li>
									</ul>
							</div>
						-->	
						
							<div class="prod-semelhantes categorias">							
							<div class="titulo">
								<div><span>Produtos semelhantes <i class="fas fa-angle-double-right"></i></span></div>								
							</div>
								<div class="demo">
									<div class="item">
										<ul id="content-slider-video" class="content-slider">
									@foreach($semelhantes as $prod)
									@php $img = getenv("APP_IMAGEM_PRODUTO") .$prod->imagem; @endphp
										<li class="col-3">
											<div class="caixa-prod">
													<img src="{{asset($img)}}" class="img-fluido">
													<span>{{$prod->nome}}</span>
													<strong>R$ {{$prod->valor_venda}}</strong>
													<div class="guardar">
														<ul class="favorito">
															<li><a href=""><i class="fas fa-star"></i></a></li>
															<li><a href=""><i class="fas fa-star"></i></a></li>
															<li><a href=""><i class="fas fa-star"></i></a></li>
															<li><a href=""><i class="far fa-star"></i></a></li>
															<li><a href=""><i class="far fa-star"></i></a></li>
														</ul>
														<ul class="gostei">
															<li><a href="" title="Meu favorito"><i class="fas fa-heart"></i></a></li>
															<li><a href="" title="Minha lista"><i class="fas fa-align-left"></i></a></li>
															<li><a href="" title="Colocar no carrinho"><i class="fas fa-shopping-cart"></i></a></li>
														</ul>
													</div>
													<div class="btn-comprar">
														<a href="{{route('produto.detalhe',$prod->semelhante_id)}}" class="btn btn-vermelho">Ver Detalhes</a>
													</div>
												</div>
										</li>
										@endforeach
										
										</ul>
									</div>
								</div>
							</div>
							
						</div>
				</div>				
			</div>
			
			
		</div>
@endsection
<script>

function aplicarCupom(){
	var produto_id 	= $("#produto_id").val();
	var qtde 		= $("#qtde").val();
	var codigo 		= $("#codigo_cupom").val();
	$.ajax({
	   url: base_url + "produto/aplicarCupom",
	   type: "POST",
	   dataType: "json",
	   data:{
	   		"produto_id" : produto_id,
	   		"qtde"	     : qtde,
	   		"codigo"	 : codigo
	   		
	   },
		 success: function(data){
		 	$("#giragiraCupom").hide();
			 console.log(data);
			 if(data.tem_erro == true){
			 	$("#produto_com_cupom").hide();
			 	$("#produto_sem_cupom").show();
			 	$("#valor_desconto").html(0);
			 	$("#codigo_do_cupom").html(null);
			 	$("#cupom_desconto_id").val(null);			 	
			 	alert(data.erro);
			 }else{
			 	$("#produto_com_cupom").show();
			 	$("#produto_sem_cupom").hide();
			 	$("#valor_desconto").html(data.item_com_desconto);
			 	$("#codigo_do_cupom").html(codigo);
			 	$("#cupom_desconto_id").val(data.cupom_desconto_id);
			 }
		 },
		 beforeSend: function (){
		 		$("#giragiraCupom").css("style", "flex");
		 }
		
	});	
 }

</script>
	