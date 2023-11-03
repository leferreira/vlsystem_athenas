@extends("template")
@section("conteudo")
<section class="pdv-livre">
<div class="conteudo">
	
		<div class="base-pdv">	
		<div class="rows">	
				<div class="col-8 d-flex m-auto">		
					<div class="caixa width-100 msg msg-azul p-2 pb-4 mb-1 submn" style="height:auto">		
							<h1 class="text-center h4 text-vermelho"><i class="fas fa-info-circle"></i> Os seguintes requisitos são necessários:</h1>						
							<ul>
							
							<?php 
								$i=0;
								foreach($requisitos as $r){							   
							     echo "<li class='mb-3 d-block'>$r <span class='d-block ml-4'>$caminho[$i]</li>";
								 $i++;
								}
							?>
							</ul>
								
					</div>	
				</div>						
		</div>
	</div>
</div>
</section>
@endsection