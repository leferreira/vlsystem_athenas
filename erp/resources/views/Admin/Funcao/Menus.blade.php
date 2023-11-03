<?php
use App\Service\PermissaoService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
	<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Permissão de menu</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
		</div> 		
	</div>
	<input type="hidden" id="funcao_id" value="{{$funcao->id}}"> 
		<div class="p-4 col-9 m-auto">	               
			<div class="border radius-4">	               
			<div class="rows">	               
				<div class="col-4 pr-0">	               
					<div class="border-right">	               
						<div class="border-bottom mb-0">	               
							<span class="d-block bg-title p-1"><h4 class="text-uppercase text-center h5 mb-0">Menu principal</h4></span>
						</div> 
						<div class="p-1 menuprincipal permitir position-inherit width-100">
							<ul class="menu-ul">
								<li class="{{$menu->id==1 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>1])}}" title="Configurações"><i class="icon fas fa-cog"></i> Configurações </a></li>								
								<li class="{{$menu->id==2 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>2])}}" title="Cadastro"><i class="icon fas fa-file"></i> Cadastro </a></li>								
								<li class="{{$menu->id==3 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>3])}}" title="Compras"><i class="icon fas fa-cart-plus"></i> Compras </a></li>									
								<li class="{{$menu->id==4 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>4])}}" title="Venda"><i class="icon fas fa-donate"></i> Venda </a></li>
								<li class="{{$menu->id==5 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>5])}}" title="Ordem de Serviço"><i class="icon fas fa-donate"></i> Ordem de Serviço </a></li>								
								<li class="{{$menu->id==6 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>6])}}" title="Pedido de Cliente"><i class="icon fas fa-parking"></i> Pedido de Cliente </a></li>
								<li class="{{$menu->id==7 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>7])}}" title="Loja virtual"><i class="icon fas fa-shopping-basket"></i> Loja Virtual </a></li>
								<li class="{{$menu->id==8 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>8])}}" title="Estoque"><i class="icon fas fa-cubes"></i> Estoque </a></li>
								<li class="{{$menu->id==9 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>9])}}" title="NFE"><i class="icon fas fa-copyright"></i> Notas Fiscais </a></li>
								<li class="{{$menu->id==10 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>10])}}" title="PDV"><i class="icon fas fa-cash-register"></i> PDV </a></li>
								<li class="{{$menu->id==11 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>11])}}" title="Financeiro/contabil"><i class="icon fas fa-hand-holding-usd"></i> Financeiro </a></li>
								<li class="{{$menu->id==12 ? 'ativado' : ''}}"><a href="{{route('admin.funcao.menu',['id'=>$funcao->id,'id_menu'=>12])}}" title="Relatorios"><i class="icon fas fa-hand-holding-usd"></i> Relatórios </a></li>					
													
							</ul>
						</div>
					</div>            
				</div> 
				          
				<div class="col-8 pl-0">	               
					<div class="border-bottom mb-0">	               
						<span class="d-block bg-title p-1"><h4 class="text-uppercase text-center h5 mb-0">Marque as opções desejadas</h4></span>
					</div>
					<div class="p-1">					
					<table cellpadding="0" cellspacing="0" width="100%" class="table border radius-4">
						<thead>
							<tr>
								<th align="center" width="60">Marcar</th>
								<th align="left">Opção</th>
							</tr>
						</thead>
						@foreach($submenus as $sub)
						<?php 
						  $tem_permissao = PermissaoService::tem_permissao($funcao->id, $sub->cod);
						?>
						<tr>
							<td  align="center">
								<div class="check justify-content-center"><input type="checkbox"  id="submenu_{{$sub->id}}" value="S" onclick="marcarSubMenu({{$sub->menu_id}},{{$sub->id}},'{{$sub->cod}}')" {{$tem_permissao ? 'checked': ''}}></div>
							</td>
							<td><label>{{$sub->submenu}}</label></td>
						</tr>
						@endforeach
					</table>
				</div>
				</div>
			</div>
			</div>
        </div>
        </div>
        @endsection
        
        <script>
        function marcarSubMenu(menu_id, submenu_id, descricao){
        	var submenu = $("#submenu_"+submenu_id).is(':checked');        	
        	$.ajax({
                 url: base_url + "admin/funcaopermissao/salvar" ,
                 type: "Post",
                 dataType:"Json",
                 data:{
                 	"opcao" 	: submenu,
                 	"menu_id"	: menu_id,
                 	"submenu_id": submenu_id,
                 	"funcao_id"	: $("#funcao_id").val(),
                 	"descricao"	: descricao
                 },
                 success: function(data){
        			  //
                 },
                 beforeSend: function(){           
                     
                }
                 
             });     
       
        	
        }
        
        </script>