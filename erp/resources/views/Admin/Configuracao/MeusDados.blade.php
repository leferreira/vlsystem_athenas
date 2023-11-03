@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Meus dados</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>                     
    
   <form action="{{route('admin.meus_dados.salvar')}}" method="POST" enctype="multipart/form-data">
	@csrf
		<div class="p-2 mt-4">
				<div class="rows">					
					
						 <div class="col-8 m-auto px-2">
						 <div class="border radius-4 p-2">
                           <div class="rows">
								<div class="col-4 mb-3 text-center">
								<label class="banner-thumb">
								@if(!$usuario->foto)
									<img src="{{asset('assets/admin/img/img-usuario.svg')}}" class="img-fluido" id="imgUp">
								@else									
									<img src="{{ url($usuario->foto) }}" class="img-fluido" id="imgUp">
								@endif	
									
									<input type="file" name="file" id="img_perfil" onChange="valida_imagem('img_perfil')" class="d-none">

									<span>Carregar imagem</span>
								</label>
								</div>
							
                           <div class="col-8">
							   <div class="rows">
									<div class="col-12 mb-3">
											<label class="text-label">Nome</label>
											<input type="text" name="name" value="{{isset($usuario->name) ? $usuario->name : old('name')}}"  class="form-campo">
									</div>
									
									<div class="col-12 mb-3">
											<label class="text-label">Email</label>
											<input type="text" name="email" value="{{isset($usuario->email ) ? $usuario->email  : old('email ')}}"  class="form-campo">
									</div>
									<div class="col-6 mb-3">
											<label class="text-label">Senha</label>
											<input type="password" name="password"  class="form-campo">
									</div>
									<div class="col-6 mb-3">
											<label class="text-label">Telefone</label>
											<input type="text" name="telefone" value="{{isset($usuario->telefone) ? $usuario->telefone : old('telefone')}}"  class="form-campo">
									</div> 
									<div class="col-12 text-center pb-4">
										<input type="hidden" name="id" value="{{$usuario->id}}" >
										<input type="hidden" name="senha" value="{{$usuario->password}}">
										
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