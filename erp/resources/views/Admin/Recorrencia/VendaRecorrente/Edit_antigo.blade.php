@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" h5 mb-0 "><i class="fas fa-plus-circle"></i> Cadastrar Venda Recorrente</span>
		<div>
			<a href="{{route('admin.vendarecorrente.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>	
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>			
		</div>
	</div>                 
 
   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
			@if(isset($vendarecorrente))    
               <form action="{{route('admin.vendarecorrente.update', $vendarecorrente->id)}}" method="POST">
               <input name="_method" type="hidden" value="PUT"/>
             @else                       
            	<form action="{{route('admin.vendarecorrente.store')}}" method="Post">
            @endif
            	@csrf
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">
					<div class="col-2 mb-3">
							<label class="text-label">Data Cadastro</label>	
							<input type="date" name="data_contrato"  value="{{isset($vendarecorrente->data_contrato) ? $vendarecorrente->data_contrato : hoje() }}"  class="form-campo ">
					</div>
					                    
                    <div class="col-4 mb-3">
							<label class="text-label"  >Cliente<span class="text-vermelho">*</span></label>	
							<select name="cliente_id" class="form-campo">
								@foreach($clientes as $v)
									<option value="{{$v->id}}">{{$v->nome_razao_social}}</option>
								@endforeach
							</select>
					</div>
																	
					<div class="col-4 mb-3">
							<label class="text-label">Produto Recorrente<span class="text-vermelho">*</span></label>						
							<select name="produto_recorrente_id" class="form-campo">							
								@foreach($produtos as $r)
									<option value="{{$r->id}}">{{$r->descricao}}  - R$ {{$r->valor}} </option>
								@endforeach
							</select>
					
					</div>                                    
					<div class="col-2 mb-3">
						<label class="text-label">Dia Vencimento</label>	
						<select name="dia_vencimento" class="form-campo">
    						@for($i=1; $i <= 31; $i++)
    							<option value="{{$i}}">{{ zeroEsquerda($i, 2) }}</option>
    						@endfor
						</select>
					</div>
					<div class="col-4 mb-3">
						<label class="text-label"  >Tipo Recorrência<span class="text-vermelho">*</span></label>	
						<select name="tipo_cobranca_id" class="form-campo">
							@foreach($tipos as $t)
								<option value="{{$t->id}}">{{$t->tipo_cobranca}}</option>
							@endforeach
						</select>
					</div>				
													
					<div class="col-2 mb-3">
							<label class="text-label">Primeira Parcela</label>	
							<input type="text" name="valor_primeira_parcela"  value="{{isset($vendarecorrente->valor_primeira_parcela) ? $vendarecorrente->valor_primeira_parcela : old('valor_primeira_parcela') }}"  class="form-campo mascara-float">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label">Valor Recorrente</label>	
							<input type="text" name="valor_recorrente"  value="{{isset($vendarecorrente->valor_recorrente) ? $vendarecorrente->valor_recorrente : old('valor_recorrente') }}"  class="form-campo mascara-float">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label">.</label>	
							<input type="submit" value="Atualizar Dados" class="btn btn-azul m-auto">
					</div>
									
					
				</div>
			</fieldset>
			</form>
			<form action="{{ route('admin.vendarecorrente.gerarCobranca')}}" id="frmCobranca" method="post">
    			@csrf
			<fieldset>
				<legend>Inserir Cobrança</legend>
				
    				<div class="rows">
    					<div class="col-3 mb-3">
    						<label class="text-label">Descrição da Cobranca</label>
    						 <input type="text" name="descricao" required="required"  id="descricao"  class="form-campo">												
    					</div>
    														
                            
                         <div class="col-2 mb-3">
    						<label class="text-label">Tipo Recorrencia<span class="text-vermelho">*</span></label>						
    						<select name="tipo_cobranca_id" class="form-campo">							
    							@foreach($tipos as $t)
    								<option value="{{$t->id}}" {{$t->qtde_dias==30 ? 'selected' : ''}}>{{$t->tipo_cobranca}}</option>
    							@endforeach
    						</select>					
    					</div>
    					                                  
    					<div class="col-2 mb-3">
    							<label class="text-label">Primeiro Vencimento</label>	
    							<input type="date" name="primeiro_vencimento" required value="{{isset($vendarecorrente->primeiro_vencimento) ? $vendarecorrente->primeiro_vencimento : hoje() }}"  class="form-campo ">
    					</div>				
    									
    					
    					<div class="col-2 mb-3">
    							<label class="text-label">Valor Recorrente</label>	
    							<input type="text" name="valor_recorrente" value="{{$vendarecorrente->valor_recorrente}}" required   class="form-campo mascara-float">
    					</div>
    					
    					<div class="col-1 mb-3">
    							<label class="text-label">Qtde</label>	
    							<input type="number" name="qtde" required value="6"  class="form-campo mascara-float">							
    					</div>
                        
                     
    				    <div class="col-1 text-center">	
    				    	<label class="text-label">.</label>	
    				    	<input type="hidden" name="venda_recorrente_id" required value="{{$vendarecorrente->id}}"  class="form-campo mascara-float"> 
                			<input type="submit" value="Gerar Cobrança" class="btn btn-azul btn-medio d-block m-auto" />                   
                		</div>	
    				</div>
    				
			</fieldset>
			</form>
			
			
			<fieldset>
			<legend>Lista de Cobranças</legend>
			<div class="col-12">

				<div class="px-2">
					<div class="rows">
					<div class="col">
						<div class="tabela-responsiva pb-4">
						<table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
								<thead>
								 <tr>
										<th align="center">#</th>
										<th align="left">Descrição</th>
										<th align="center">Vencimento</th>
										<th align="center">Valor</th>
										<th align="center">Status Venda</th>
										<th align="center">Status Financeiro</th>
										<th align="center">Edit</th>
										<th align="center">Excluir</th>
									</tr>
								</thead>
								<tbody>
							
								
								<?php $total = 0; $i=1; ?>
							   @foreach($lista as $c)
							                                      
								 <tr>
									<td align="center">{{$c->id}}</td>
									<td align="center">{{$c->descricao}}</td>
									<td align="center">{{ databr($c->data_vencimento)}}</td>
									
									<td align="center">{{ $c->valor  }}	</td>
									<td align="center"><span class="{{ strtolower($c->status->status) }}">{{ $c->status->status }}</span></td>									
									<td align="center"><span class="{{ strtolower($c->status_financeiro->status) }}">{{ $c->status_financeiro->status }}</span></td>
									<td align="center"><a href="{{route('admin.cobranca.edit', $c->id)}}" class="btn btn-verde d-inline-block"><i class="fas fa-edit" title="Editar"></i></a></span></td>
									<td align="center">
										<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$c->id}}').submit() : '';" class="d-inline-block btn btn-circulo btn-vermelho btn-pequeno" title="Ecluir"><i class="fas fa-trash-alt"></i></a>
                                        <form action="{{route('admin.cobranca.destroy', $c->id)}}" method="POST" id="apagar{{$c->id}}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{csrf_field()}}
                                        </form>
									</td>								
									
								 </tr>
								 
							@endforeach  								
				 
							</tbody>
							 </table>
									
							</div>
						</div>						
						<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
						<div class="col-2 MostraOpcoes" id="opcoes_ordemservico">
							<ul class="cx-opcoes" >
								<li>Ordem de Serviço:<span id="id_ordemservico"></span></li>
								
								<li class="concreto"><a href="javascript:;" onclick="editarVenda()"><i class="fas fa-eye"></i> Ver/Editar</a></li>
							
							</ul>
						</div>
						
						
					</div>
                </div>
			</div>
			
			</fieldset>
		</div>
	  </div>
	  
	  
	  </div>
	

</div>
  @include ("Admin.Cadastro.Cliente.modal.modalCadastroCliente")
<script>
	function tipoCliente(){
		var tp = $("#tipo_cliente").val();
		
		if(tp=="F"){
			$("#div_pesquisar").hide();
            $("#div_tipo_contribuinte").hide();
            $("#divIscEstadual").hide();
            $("#divSuframa").hide();
            $("#divFantasia").hide();
            
            $("#lblInscEstadual").html("RG");
            $("#lblCnpj").html('CPF');
            $("#lblRazaoSocial").html('Nome');
            $("#cnpj").mask('000.000.000-00', {reverse: true});
       
            
		}else{
			$("#div_pesquisar").show();
            $("#div_tipo_contribuinte").show();
            $("#divIscEstadual").show();
            $("#divSuframa").show();
            $("#divFantasia").show();
            
            $("#lblInscEstadual").html("Inscrição Estadual");
            $("#lblCnpj").html('CNPJ');
            $("#lblRazaoSocial").html('Razão Social');
            $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
          
		}
	}
</script>
@endsection