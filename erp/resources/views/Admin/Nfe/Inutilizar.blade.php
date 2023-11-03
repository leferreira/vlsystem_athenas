@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Inutilizar Numeração</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>                     
    
   <form action="{{route('admin.nfe.inutilizarNfe')}}" method="POST" >
	@csrf
	<div class="p-2 mt-4">
		<div class="rows">					
			
				 <div class="col-12 m-auto px-2">
				 <div class="border radius-4 p-2">
                   <div class="rows">
						
					
                   <div class="col-12">
					   <div class="rows">
							<div class="col-3 mb-3">
        						<label class="text-label">Série</label>	
        						<input type="text" name="nSerie" id="nSerie"  class="form-campo" >
        					</div>
        					<div class="col-3 mb-3">
        						<label class="text-label">Início</label>	
        						<input type="text" name="nIni" id="nIni" class="form-campo" >
        					</div>
        					<div class="col-3 mb-3">
        						<label class="text-label">Fim</label>	
        						<input type="text" name="nFin" id="nFin"  class="form-campo" >
        					</div>
        					
        					<div class="col-12 mb-3">
        						<label class="text-label">Justificativa</label>	
        						<input type="text" name="justificativa" id="justificativa"  class="form-campo" >
        					</div> 
							<div class="col-12 text-center pb-4">										
								<input type="submit" value="Inutilizar" class="btn btn-azul m-auto">
							</div>									
						</div>     	
                    </div>     	
                </div>			
                   
                </div>
                </div>
		</div>	 
		</div>
</form>		
	  </div>
	


<script>
function upload_banner(){
	var data 	 = new FormData();	
	var arquivos = $('#img_perfil')[0].files;
	var id = $('#id').val();
	
	if(arquivos.length > 0) {		
		data.append('file', arquivos[0]);
		data.append('id', id);
		
		$.ajax({
			type:'POST',
			url:base_url + 'lojaadmin/lojaproduto/salvarImagemJs',
			data:data,
			contentType:false,
			processData:false,
			dataType: "json",
			beforeSend: function(){
				$('#uploadStatus').html('<img src=' + base_url + '"assets/img/loading.gif"/>');
			},
            error:function(){
                alert("erro");
            },
			success:function(data){	
				lista_imagem(data);
			}
		});
	}
}

function lista_imagem(data){
	html="";
	for(var i in data){
	var path = base_url + 'storage/upload/' + $('#cnpj').val() +'/imagens_produtos/' + data[i].img;	   
	html +='<div class="col-3 mb-3">'+
		'<div class="banner-thumb">'+
			'<img src="' + path + '" class="img-fluido">'+
		'</div>'+
	'</div>';
	}
			   
   $("#lista_imagens").html(html);
}

</script>
@endsection