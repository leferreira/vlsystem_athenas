@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Pedido Deliverry</span>
                      

   <div id="tab">
	
	  <div id="tab-1">
		<div class="p-2">
			<div class="rows">	
			<div class="col-12"><span class="titulo">Dados do Cliente</span>	</div>
			<div class="col-12">
                <div class="caixa"> 
                    <div class="pt-0">
						 <div class=" mt-2">
							<div class="border mt-2 p-2 radius-4">
							<form action="{{route('frentedelivery.store')}}" method="POST">
							  @csrf
							 <div class="rows">
							  			<div class="col-4">	
                                            <label class="text-label d-block ">Cliente</label>
                                            <select id="cliente_id" name="cliente_id" class="form-campo select2 fornecedor">
												<option value="--">Selecione o Cliente</option>
												@foreach($clientes as $f)
												<option value="{{$f->id}}">{{$f->nome}} {{$f->sobre_nome}}</option>
												@endforeach
											</select>
                                        </div>                                   
													
                                        
                                        <div class="col-6">	
                                            <label class="text-label d-block ">Endereços</label>
                                            <select id="kt_select2_2" name="produto" class="form-campo select2 produto">
                                           	 <option value="NULL">Balcão</option>
												@foreach($enderecos as $p)
													<option value="{{$p->id}} - {{$p->nome}}">{{$p->id}} - {{$p->rua}}</option>
												@endforeach
											</select>
                                        </div>
                                                                                
                                        <div class="col-2 mt-1">
                                        	<input type="submit" class="btn btn-azul m-auto" value="Salvar" >
                                        </div>
                               
                                </div>
                                </form>
                                </div>
                        </div>
                    
                </div>
                </div>
                
              


			</div>
		</div>
	  </div>
	  </div>
	  
	  
	  

      
 </div>
		
</div>
	
@endsection