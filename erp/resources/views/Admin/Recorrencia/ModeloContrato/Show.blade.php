<?php
use App\Models\Empresa;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" mb-0 h5"><i class="fas fa-plus-circle"></i> Cadastrar Modelo de Contratos</span>
		<div>
			<a href="{{route('admin.modelocontrato.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>		
		</div>
	</div>                 

   <div id="tab">
	  <div id="tab-1">
		<div class="p-2 mt-1">
			<?php
			 $procura = $dicionario->chaves;
			 $troca   = $dicionario->valor;
			
			 $textoBase= $venda->modeloContrato->conteudo ."<br>";
			 $textoBase = str_replace($procura, $troca, $textoBase);
			 echo $textoBase ."<br>";
			
			?>
				{{$venda->modeloContrato->conteudo }}		
    
		</div>
	  </div>
         
 </div>
		
	  </div>
	


<script>
$('#escolher_campo').change(function() {	
    if ($(this).val() != "0")
    	$("#valor_campo").val($(this).val());
        
    $(this).prop('selectedIndex', 0);
    
});
</script>

@endsection