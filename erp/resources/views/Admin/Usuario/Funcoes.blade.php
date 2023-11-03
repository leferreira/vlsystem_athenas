@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i>Lista de Funções do Usuário: {{$usuario->name}}</span>
	<div class="d-flex">
		<a href="{{route('admin.usuario.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	
	</div>
</span> 

<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                                         
					  
                       <form action="{{route('admin.funcaousuario.store')}}" method="POST">
                    
                    	@csrf
                        
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                          
                                        
                                        <div class="col-4">	
                                                <label class="text-label d-block text-branco">Selecione a Função </label>
                                                <div class="group-btn">	
                                					<select class="form-campo" id="funcao_id" name="funcao_id" required>
                                                        @foreach($funcoes as $f)
                                                            <option value="{{$f->id}}">{{$f->nome}}</option>
                                                        @endforeach
                                                    </select>
                                                 <a href="javascript:;" onclick="abrirModal('#modalCadFuncao')"  class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir novo Cliente"></a>
                							</div>
                                        </div>                                    
                                        
                                        <div class="col-2 mt-1 pt-1">
                                        		<input type="hidden" name="user_id" value="{{isset($usuario->id) ? $usuario->id: NULL }}">
                                                <input type="submit" value="Inserir Função" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
                </div>

		    <div class="col-12">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" >Função</th>
                                    <th align="left" >Permissões</th>
                                    <th align="left" >Menus</th>
                                    <th align="center">Excluir</th>
                            </tr>
                    </thead>
                    <tbody>	
                   	 	@foreach($funcoesusuario as  $p)
						<tr>
							<td align="center">{{$p->id}}</td>
							<td align="left">{{$p->funcao->nome}}</td>		
							<td align="center"><a href="{{route('admin.funcao.permissao',$p->funcao_id)}}" class="btn btn-azul"><i class="fas fa-plus-circle"></i>Ver Permissões</a></td>
							<td align="center"><a href="{{route('admin.funcao.menu',$p->funcao_id)}}" class="btn btn-azul"><i class="fas fa-plus-circle"></i>Ver Menus</a></td>
											
							 <td align="center">
                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar-{{$p->id}}').submit() : '';" class="btn btn-vermelho d-inline-block"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.funcaousuario.destroy', $p->id)}}" method="POST" id="apagar-{{$p->id}}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="perfil" value="{{$p->nome}}">
                                        {{csrf_field()}}
                                    </form>
                                 </td>						
                            </tr>
						@endforeach
					</tbody>
			</table>   
	</div>
					
							</div>

        </div>
        </div>
        @endsection
@include("Admin.Usuario..modal.modalFuncao")
<script>
function salvarFuncao(){ 
		eh_modal = 1;       
        $.ajax({
         url: base_url + "admin/funcao/salvarJs",
         type: "POST",
         data:$("#frmCadFuncao").serialize(),
         dataType:"Json",
         success: function(data){			
			if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
				 html = "";
				  for (i = 0; i < data.length; i++) {	
					  html +="<option value='"+ data[i].id +"'>" + data[i].nome + "</option>";
				  }				  				  
				  $("#funcao_id").html(html);
				  $("#nome").val("");
				  $("#descricao").val("");
			}             
         },
		  beforeSend: function () {
			giraGira();
	     },error: function (data) {
			fecharGiraGira(eh_modal);
			if(data.status== 422){
				var errors = $.parseJSON(data.responseText);
				$('#listaErroModal').html('');					
	        	$.each(errors.errors, function (key, erro) {					 
					 $('#listaErroModal').append('<li>' + erro + '</li>');
					 abrirModalLivre("#modalLivreListaComErros");
	        	});
			}else{
				
			}	        
		}        
     })
}
</script>