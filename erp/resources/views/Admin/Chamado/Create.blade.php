@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-lock-open"></i> Chamado</span>
		<div class="d-flex">		
			<a href="{{route('admin.chamado.index')}}" class="btn btn-pequeno btn-roxo" title="Voltar"><i class="fas fa-arrow-left"></i></a>
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul ml-1" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>                     
    
      @if(isset($chamado))    
       <form action="{{route('admin.chamado.update', $cliente->id)}}" method="POST" enctype="multipart/form-data">
       <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.chamado.store')}}" method="Post" enctype="multipart/form-data">
        @endif
        	@csrf
		<div class="p-2 mt-4">
				<div class="rows">					
					
						 <div class="col-10 m-auto px-2">
						 <div class="border radius-4 p-4 px-5">
                           <div class="rows">								
							
                           <div class="col-12">
							   <div class="rows">
									<div class="col-12 mb-3">
											<label class="text-label">Assunto</label>
											<input type="text" name="assunto" value="{{isset($chamado->assunto) ? $chamado->assunto : old('assunto')}}"  class="form-campo" placeholder="Assunto">
									</div>
									<div class="col-12 mb-3">
											<label class="text-label">Descrição</label>
											<textarea rows="10" cols="4" name="descricao" class="form-campo"  placeholder="Descrição">{{isset($chamado->descricao) ? $chamado->descricao : old('descricao')}}</textarea>
									</div>
									<div class="col-12 mb-3">
										<label class="text-label">Anexo</label>
    									<input type="file" name="file" id="img_perfil"  class="form-campo carregar-label">
									</div> 
									<div class="col-12 text-center pb-4">										
										<input type="submit" value="Salvar" class="btn btn-azul m-auto">
									</div>									
								</div>     	
                            </div>     	
                        </div>			
                           
                        </div>
                        </div>
				</div>	 
		</div>
		
	  </div>
	
</form>

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