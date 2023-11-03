@extends("template")
@section("conteudo")
<section class="pdv-livre">
<div class="conteudo">
	
		<div class="base-pdv">	
		<div class="rows">	
				<div class="col-12 d-flex m-auto">		
					<div class="caixa width-100 bg-title2 p-2 mb-1 iciniarCaixa" style="height:auto">			
						<div class="rows">
							<h1>Os Seguintes requisitos são necessários:</h1>						
							<ul>
							<?php foreach($requisitos as $r){
							   
							     echo "<li>$r </li>";
							}?>
							</ul>
							
						</div>	
								
					</div>	
				</div>						
		</div>
	</div>
</div>
</section>
@endsection