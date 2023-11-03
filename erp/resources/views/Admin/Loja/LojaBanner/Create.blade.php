@extends("Admin.template")
@section("conteudo")

<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
						<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Cadastrar banner </span>
						<div>
							<a href="{{route('admin.lojabanner.index')}}" class="btn btn-azul btn-pequeno mx-1 d-inline-block" title="Voltar"><i class="fas fa-arrow-left"></i> </a>

						</div>
					</div>
 @if(isset($banner))    
   <form action="{{route('admin.lojabanner.update', $banner->id)}}" method="POST" enctype="multipart/form-data">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.lojabanner.store')}}" method="Post" enctype="multipart/form-data">
@endif
	@csrf
	<div class="p-2 px-md">						
	<div class="rows">	
	
			<div class="col-12 mb-3">
				<label class="banner-thumb">
					@php
						$img_banner = ($banner->path) ?? null ;
						$id_produto = ($banner->produto_id) ?? null ;
						$id_pacote  = ($banner->pacote_id) ?? null ;
						
					@endphp
					@if($img_banner)
						<img src="{{asset($img_banner)}}" class="img-fluido" id="imgUp">
					@else
						<img src="{{asset('assets/admin/img/bn.svg')}}" class="img-fluido" id="imgUp">
					@endif
					<input type="file" name="file" id="img_loja_banner" onChange="valida_imagem('img_loja_banner')" class="d-none">
				</label>
			</div>	
			
			<div class="col-12 mb-3">	
				<span class="text-vermelho">* <small>Campos obrigatórios</small>
			</div>
		<div class="col-6">
		
		<div class="rows">			
			<div class="col-6 mb-3">	
				<label class="text-label d-block ">Produto </label>                                            
				<select name="produto_id" class="form-campo">
					<option value="">Selecione</option>
					@foreach($produtos as $p)
						<option value="{{$p->id}}" {{($p->id==$id_produto) ? 'selected' : '' }}>{{$p->nome}}</option>
					@endforeach
				</select>
					
			</div>
			<div class="col-6 mb-3">	
				<label class="text-label d-block ">Pacote </label>                                            
				<select name="loja_pacote_id" class="form-campo">
				<option value="">Selecione</option>
					@foreach($pacotes as $pac)
						<option value="{{$pac->id}}"  {{($pac->id==$loja_pacote_id ) ? 'selected' : '' }}>{{$pac->nome}}</option>
					@endforeach
				</select>
					
			</div>
											
			<div class="col-12 mb-3">	
					<label class="text-label d-block">Título <span class="text-vermelho">*</span></label>
					<input type="text" name="titulo" value="{{isset($banner->titulo) ? $banner->titulo : old('titulo')}}"  class="form-campo">
			</div>        
			
			 <div class="col-6 mb-3">
					<label class="text-label">Status </label>
					<select class="form-campo" name="status_id">				                                    
						<option value="{{config('constantes.status.ATIVO')}}">Ativo</option>
						<option value="{{config('constantes.status.INDISPONIVEL')}}">Inativo</option>
				   </select>
			</div>

			 <div class="col-6 mb-3">
					<label class="text-label">Ordem do banner no slide </label>
					<select class="form-campo" name="ordem">                                           
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
				   </select>
			</div>
						
			</div>			
       </div>			
		<div class="col-6">
		   <div class="rows">
				<div class="col-12 mb-3">
					<label class="text-label">Descrição</label>
					<textarea rows="11" cols="150" name="descricao" placeholder="Descrição aqui" class="form-campo">{{$banner->descricao ?? old('descricao')}}</textarea>
				</div> 
			</div>
		</div>
		                                            
        <div class="col-4 pt-3 pb-4 m-auto">
            <input type="hidden" name="path" value="{{($banner->path) ?? null }}" >
            <input type="submit" value="Salvar Dados" class="btn btn-azul d-block m-auto">
        </div>
    </div>
    </div>
    </form>

</div>
<script>
function upload_banner(){
	var data 	 = new FormData();	
	var arquivos = $('#img_loja_banner')[0].files;
	var produto_id = $('#produto_id').val();
	
	if(arquivos.length > 0) {		
		data.append('file', arquivos[0]);
		data.append('produto_id', produto_id);
		
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