@extends("Admin.template")
@section("conteudo")


<div class="col-9 central mb-3">
	<div class="rows">
	  <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Pedidos do Delivery </span>						
					</div>
                        
					 @if(isset($categoria))    
                       <form action="{{route('admin.categoriaadicional.update', $categoria->id)}}" method="POST" >
                       <input name="_method" type="hidden" value="PUT"/>
                     @else                       
                    	<form action="{{route('admin.categoriaadicional.store')}}" method="Post" >
                    @endif
                    	@csrf
                        
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-4">	
                                                <label class="text-label d-block text-branco">Data Inicial </label>
                                                <input type="date" name="nome" value="{{isset($categoria->nome) ? $categoria->nome : null}}"  class="form-campo">
                                        </div>
                                        <div class="col-4">	
                                                <label class="text-label d-block text-branco">Data Final </label>
                                                <input type="date" name="limite_escolha" value="{{isset($categoria->limite_escolha) ? $categoria->limite_escolha : null}}" class="form-campo">
                                        </div>
                                        
                                        
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Filtrar" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
                </div>
                	 
            <div class="col-12">
            <div class="caixa">
           
            <div class="rows p-4"> 
			
				
				
              
						
						
				<div class="col-12 mt-4">
					<div class="p-2 py-1 bg-title text-light text-uppercase h5 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Pedidos do Status </span>
                    </div>
                    <div class="border radius-bx">
                    <div class="rows pt-3 pb-4 px-2" id="lista_engenharia">
               @foreach($pedidosPorStatus as $s)
               @if($s->id<6)
                    <div class="col-3 d-flex">                                      
							<div class="caixa width-100 border radius-4">
                                <div class="tabela-responsiva sm">
                                    <table cellpadding="0" cellspacing="0" class="mb-0 width-100 table">
                                       <thead>
                                           <tr>
                                              <th align="center" colspan="2" class="bg-padrao text-branco"><span class="h5 mb-0">{{$s->status_pedido }}</span></th>    
                                           </tr>                                           
                                       </thead>
                                           <tbody id="lista_insumos">
                                          
                                              @foreach($s->pedidos as $p)
                                              
                                                <tr>                                                 
                                                    <td><a href="{{route('deliverypedido.show', $p->id)}}">Ped: {{$p->id }}, Cliente: {{$p->cliente->nome }} - Valor R$ {{number_format($p->somaItens(), 2, ',', '.')}} -  
														Hora: {{ \Carbon\Carbon::parse($p->data_registro)->format('H:i:s')}}</a> </td>     
                                                </tr>
                                             
											@endforeach
                                           </tbody>
                                    </table>								
								</div>
                            </div>
                        </div>
                       @endif
                 @endforeach
							
                    </div>
                    </div>
                    
				</div>
				
	
    
	</div>
    </div>
</div>


		
</div>
</div>

@endsection