<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Cadastro de Credenciador de Meios de Pagamento</span>
	<div class="d-flex">
		<a href="{{route('admin.compra.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	
	</div>
</span>                      


			<div class="p-2 pb-0">
			<div class="rows">
			
			<div class="col-12">
                <div class="caixa"> 
                    <fieldset class="pt-0 bg-padrao mb-0">
						 <div class="">							  
							<span class="titulo text-branco px-0">Dados da Credenciadora </span>
							<div class="mt-2 radius-4">
							 <div class="rows">								 	
                                        
							 		  	<div class="col-3">	
                                            <label class="text-label d-block text-branco">Descricao</label>
                                            <input type="text"  value="{{$administradora->descricao ?? null}}" class="form-campo ">
                                        </div> 
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Operadora</label>
                                            <input type="text"  value="{{$administradora->operadora->nome ?? null}}" class="form-campo ">
                                        </div> 
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Conta Corrente</label>
                                            <input type="text"  value="{{$administradora->contaCorrente->descricao ?? null}}" class="form-campo ">
                                        </div>
                                        
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Dias p/ Recebimento</label>
                                            <input type="text"  value="{{$administradora->dias_para_recebimento ?? null}}" class="form-campo ">
                                        </div>                                     
                                        
                                        
                                                                                 
                                </div>
                                </div>
							</div>
                        </fieldset>   
					             
                </div>
			</div>
		</div>
	  </div>
   <div id="tab">	
	  <div id="tab-1">
		<div class="p-2">
			<div class="rows">
			<div class="col-12">		
	
                <fieldset class="mt-3 mb-0">                 
				<legend>Formas de Parcelamento</legend>
				@if(isset($formaparcelamento))    
                   <form action="{{route('admin.formaparcelamento.update', $formaparcelamento->id)}}" method="POST" >
                   <input name="_method" type="hidden" value="PUT"/>
                 @else                       
                	<form action="{{route('admin.formaparcelamento.store')}}" method="Post" >
                @endif
                	@csrf
                    <div class="pt-0">
						<div class="rows">	
						
                                                       
                          <div class="col-2">	
                            <label class="text-label d-block ">Tipo</label>
                            <select name="tipo_parcelamento_id" class="form-campo">
                            	<option value="1">Crédito</option>
                            	<option value="2">Débito</option>
                            </select>
                        </div>
                                                               
                         <div class="col-2">	
                            <label class="text-label d-block ">Parcela de</label>
                            <input type="number" name="parcela_de" min="1"  class="form-campo ">
                        </div>
                        
                        <div class="col-2">	
                            <label class="text-label d-block ">Parcela Até</label>
                            <input type="number" name="parcela_ate"  min="1" class="form-campo ">
                        </div>
                                                        
                        
                        <div class="col-2">	
                            <label class="text-label d-block ">Taxa</label>
                            <input type="text" name="taxa"  class="form-campo mascara-float">
                        </div> 
                        
                         <div class="col-2 mb-3">
                             <label class="text-label">Acrescimo (%)</label>
                             <input type="text" name="acrescimo"  class="form-campo mascara-float">
                        </div> 
                        
                        <div class="col-2 mb-3">
                             <label class="text-label">Desconto (%)</label>
                             <input type="text" name="desconto"     class="form-campo mascara-float">
                        </div>  
                      
                        <div class="col-2 mb-3">
                                 <label class="text-label">Valor Mínimo</label>
                                 <input type="text" name="valor_minimo"   class="form-campo mascara-float">
                        </div>
                        
                        
						   
                        <div class="col-2 mt-1">
                        <input type="hidden" name="administradora_cartao_id" value="{{$administradora->id}}" >
                        <input type="submit" value="Inserir"  class=" btn btn-roxo text-uppercase">
                                                   
                     </div>
                    
                </div>
               </div>
           </form>     
                <div class="tabela-responsiva pb-4 prod table border-top mt-4 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Tipo</th>
                                    <th align="center">Parcela de</th>
                                    <th align="center">Parcela até</th>
                                    <th align="center">Taxa</th>                                    
                                    <th align="center">Acréscimo</th>
                                    <th align="center">Desconto</th>
                                    <th align="center">Valor Mínimo</th>
                                
                                    <th align="center">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($lista as $l)                                     
                             <tr>
								<td align="center">{{$l->id}}</td>
                                <td align="center">{{$l->tipo->nome}}</td>	
                                <td align="center">{{$l->parcela_de}}</td>				
                                <td align="center">{{$l->parcela_ate}}</td>		
                                <td align="center">{{$l->taxa}}</td>
                                <td align="center">{{$l->acrescimo}}</td>		
                                <td align="center">{{$l->desconto}}</td>
                                <td align="center">{{$l->valor_minimo}}</td>
                                  <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-circulo btn-vermelho btn-pequeno" title="Ecluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.administradora.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{csrf_field()}}
                                    </form>
                                 </td>
								 	
                             </tr>                                       
                         @endforeach
                         
							</tbody>
                            </table>
								
                   </div>

                </fieldset>


	
			</div>
		</div>
	  </div>
	  </div>
	  		
 </div>  
		
</div>

@endsection