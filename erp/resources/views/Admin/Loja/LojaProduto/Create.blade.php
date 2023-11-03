@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
	<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de produto </span></span>
	<div>
		<!--<a href="javascript:;" onclick="abrirModal('#add')" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Cadastrar categoria</a>-->
		<a href="{{route('admin.lojaproduto.index')}}" class="btn btn-azul btn-pequeno mx-1 d-inline-block"><i class="fas fa-arrow-left"></i> Volta</a>
	</div>
</div>                      
 @if(isset($produto))    
   <form action="{{route('admin.lojaproduto.update', $produto->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.loja.lojaproduto.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Produto</a></li>
		@isset($imagens)
			<li><a href="#tab-2">Imagens</a></li>
		@endisset
	  </ul>
	  <div id="tab-1">
		<div class="pt-4">
			<fieldset>
				<legend>Informações básicas</legend>
                           <div class="rows">
                           	<div class="col-6 mb-3">
                           	<?php 
                           	    $id_produto   = ($produto->produto_id) ?? null;
                           	    $id_categoria = ($produto->categoria_id) ?? null;
                           	?>
                                        <label class="text-label">Produto</label>
                                        <select class="form-campo" name="produto_id">
                                          @foreach($produtos as $p)
                                          	<option value="{{$p->id}}" {{($id_produto==$p->id) ? 'selected' : ''}}>{{$p->nome}}</option>
                                          @endforeach                                              
                                        </select>
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">Categoria</label>
									<div class="group-btn">
                                        <select class="form-campo" name="categoria_id">
                                          @foreach($categorias as $cat)
                                          	<option value="{{$cat->id}}" {{($id_categoria==$cat->id) ? 'selected' : ''}}>{{$cat->nome}}</option>
                                          @endforeach                                              
                                        </select>
										<a href="javascript:;" onclick="abrirModal('#add')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
									</div>                               
                                </div>                               
                                
                                <div class="col-2 mb-3">
                                        <label class="text-label">Largura (cm)</label>
                                        <input type="text" name="largura" value="{{isset($produto->largura) ? $produto->largura : old('largura')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col mb-3">
                                        <label class="text-label">Altura(cm)</label>
                                        <input type="text" name="altura" value="{{isset($produto->altura) ? $produto->altura : old('altura')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col mb-3">
                                        <label class="text-label">Comprimento(cm)</label>
                                        <input type="text" name="comprimento" value="{{isset($produto->comprimento) ? $produto->comprimento : old('comprimento')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col mb-3">
                                        <label class="text-label">Peso Líquido</label>
                                        <input type="text" name="peso_liquido" value="{{isset($produto->peso_liquido) ? $produto->peso_liquido : old('peso_liquido')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col mb-3">
                                        <label class="text-label">Peso Bruto</label>
                                        <input type="text" name="peso_bruto" value="{{isset($produto->peso_bruto) ? $produto->peso_bruto : old('peso_bruto')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>         
                                <div class="col mb-3">
                                        <label class="text-label">Destaque</label>
                                        <select class="form-campo" name="destaque">                                            
                                          	<option value="S">Sim</option>
                                          	<option value="N" selected>Não</option>                                          
                    				   </select>
                                </div>
                                <div class="col mb-3">
                                        <label class="text-label">Controla Estoque </label>
                                        <select class="form-campo" name="controlar_estoque">                                            
                                          	<option value="S">Sim</option>
                                          	<option value="N">Não</option>
                                          
                    				   </select>
                                </div>
                                 <div class="col mb-3">
                                        <label class="text-label">Status </label>
                                        <select class="form-campo" name="status_id">
                                        @foreach(config('constantes.status') as $chave=>$valor)                                            
                                          	<option value="{{$valor}}">{{$chave}}</option>
                                       @endforeach
                                          
                    				   </select>
                                </div>
                                   
                                <div class="col-12">
                                        <label class="text-label">Descrição</label>
                                        <textarea rows="7" cols="150" name="descricao" class="form-campo">{{isset($produto->descricao) ? $produto->descricao : old('descricao')}}</textarea>
                                </div>                            
                        </div>
			</fieldset>
		</div>
	  </div>
	@isset($imagens)  
	   <div id="tab-2">
		<div class="pt-4">
			<fieldset>
				<legend>Imagen produto</legend>
				<div class="m-auto">
					
					<div class="bg-gray-light p-2 pt-2 radius-4">
					<div class="rows center-middle">					
                        <div class="col-2">
							<div class="banner-thumb radius-4 border" style="background:#ccc;padding:3px">
								<label for="img_loja_produto"><img src="{{asset('assets/admin/img/img-prod-loja.svg')}}" class="img-fluido" id="imgUp"></label>
							</div>
						</div> 
						<div class="col-4 my-4 text-center"> 
							<label class="carregar-label"><i class="fas fa-images"></i> carregar imagem<input type="file" id="img_loja_produto" onChange="valida_imagem('img_loja_produto')" class="d-none"></label>
							<small class="d-block mt-2 text-escuro">O tamanho da imagem deve ser de (275 x 344) pixel</small>
						</div>	
						<div class="col-2 mb-4 text-center"> 
							<label class="btn btn-verde"><i class="fas fa-arrow-up"></i> Subir imagem<input type="button" onClick="upload_produto()" class="d-none"></label>
						</div> 	                        	
                            
                    </div>
                    </div>
                    <div class="radius-4 p-2 pt-4" style="background: #e9e9e9!important; margin-top: 1rem;">
					<div class="rows" id="lista_imagens">
					@foreach($imagens as $img)
                        <div class="col-2 d-flex mb-3">
							<div class="banner-thumb radius-4 p-2 border" style="background:#fff">
								<img src="{{asset('storage/upload/'.$produto->empresa->cpf_cnpj.'/imagens_produtos/'.$img->img)}}" class="img-fluido">
								<a href="" class="btn btn-vermelho btn-circulo"><i class="fas fa-times"></i></a>
							</div>
						</div>  	                        	
                    @endforeach       
                    </div>
                    </div>
				</div>
			</fieldset>
		</div>
	  </div>
	 @endisset
 </div>
		<div class="col-12 text-center pb-4">
		    <input type="hidden" id="produto_id" value="{{($produto->id) ?? null }}" >	
		    <input type="hidden" id="cnpj" value="{{($produto->empresa->cpf_cnpj) ?? null }}" >	
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
</div>

<div class="window medio" id="add">
	<span class="d-block titulo mb-0"><i class="fas fa-plus-circle"></i> Adicionar nova categoria</span>
	<form action="" method="">
		<div class="p-3">
			<div class="rows">
                <div class="col-12">	
                        <label class="text-label d-block">Nome </label>
                        <input type="text" name="categoria" value="" class="form-campo" placeholder="Inserir categoria">
                </div> 
                <div class="col-2 mt-1 pt-1">
                </div>
			</div>
		</div>
		<div class="tfooter end">
			<button class="btn btn-vermelho fechar">Fechar</button>
            <input type="submit" value="Inserir categoria" class="btn btn-azul text-uppercase">
		</div>
	</form>

</div>

<div id="fundo_preto"></div>
<script>
function upload_produto(){
	var data 	 = new FormData();	
	var arquivos = $('#img_loja_produto')[0].files;
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
	html +='<div class="col-2 d-flex mb-3">'+
		'<div class="banner-thumb radius-4 p-2 border" style="background:#fff">'+
			'<img src="' + path + '" class="img-fluido">'+
		'</div>'+
	'</div>';
	}
			   
   $("#lista_imagens").html(html);
}

</script>
@endsection