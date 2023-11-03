@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
  <div class="p-2 py-1 bg-title text-light text-uppercase d-flex justify-content-space-between center-middle">
		<span class=" mb-0 h5"><i class="fas fa-plus-circle"></i> Cadastrar clientes</span>
		<div>
			<a href="{{route('admin.cliente.index')}}" class="btn btn-azul d-inline-block btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
			<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>		
		</div>
	</div>                 

   <div id="tab">
    <ul>
		<li><a href="#tab-1">Dados Gerais</a></li>
		<li><a href="#tab-2">Endereços</a></li>
	  </ul>
	  
	  <div id="tab-1">
		<div class="p-2 mt-1">
			<small class="d-block text-right text-vermelho">(*) Campos obrigatórios</small>
			<fieldset style="background: #f3f3f3;">
				<legend>Pesquisar Por CNPJ</legend>
				<div class="rows">
				<div class="col-2 mb-3">
							<label class="text-label">Tipo Cliente</label>	
							<select  name="tipo_cliente" id="tipo_cliente" class="form-campo" onchange ="tipoCliente()"  >
								<option value="J">Juridica</option>
								<option value="F">Física</option>
															
							</select>
					</div>
					
					<div class="col-6" id="div_pesquisar">
						<label class="text-label">Pesquisa CNPJ</label>
						<div class="grupo-form-btn">
							<input type="text" id="codigocnpj" class="form-campo mascara-cnpj">
							<input type="button" onclick="pesquisarCnpjCliente(0)" value="Pesquisar CNPJ" class="btn btn-azul d-block m-auto">
						</div>
					</div>
				</div>
			</fieldset>
			 @if(isset($cliente))    
               <form action="{{route('admin.cliente.update', $cliente->id)}}" method="POST">
               <input name="_method" type="hidden" value="PUT"/>
             @else                       
            	<form action="{{route('admin.cliente.store')}}" method="Post">
            @endif
            	@csrf
	
			<fieldset>
				<legend>Informações básicas</legend>
				
				<div class="rows">
					<div class="col-4 mb-3">
							<label class="text-label" id="lblRazaoSocial">Razão Social<span class="text-vermelho">*</span></label>	
							<input type="text" name="nome_razao_social" maxlength="60"  required id="nome_razao_social" value="{{isset($cliente->nome_razao_social) ? $cliente->nome_razao_social : old('nome_razao_social') }}" class="form-campo">
					</div> 
					
					<div class="col-4 mb-3">
							<label class="text-label">Email</label>	
							<input type="text" name="email" id="email" maxlength="60"  value="{{isset($cliente->email) ? $cliente->email : old('email') }}" autocomplete="new-email" class="form-campo">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Senha</label>	
							<input type="password" name="senha" id="senha"  value="{{isset($cliente->senha) ? $cliente->senha : old('senha') }}"  autocomplete="new-password" class="form-campo">
					</div>
					
					<div class="col-2 mb-3">
							<label class="text-label" id="lblCnpj">CNPJ<span class="text-vermelho">*</span></label>	
							<input type="text" name="cpf_cnpj" id="cnpj" required value="{{isset($cliente->cpf_cnpj) ? $cliente->cpf_cnpj : old('cpf_cnpj') }}"  class="form-campo">
					</div>
																	
					                                   
					<div class="col-3 mb-3" id="divFantasia">
							<label class="text-label" >Nome Fantasia</label>	
							<input type="text" name="nome_fantasia" maxlength="60" id="nome_fantasia" value="{{isset($cliente->nome_fantasia) ? $cliente->nome_fantasia : old('nome_fantasia') }}" class="form-campo">
					</div>					
					
						
					<div class="col-3 mb-3" id="div_tipo_contribuinte">
							<label class="text-label">Tipo de Contribuinte</label>	
							<select  name="tipo_contribuinte" id="tipo_contribuinte" class="form-campo">
								<option value="1">Contribuinte ICMS</option>
								<option value="9">Não Contribuinte</option>								
								<option value="2">Contribuinte Isento</option>
							</select>
					</div>
					
					<div class="col-2 mb-3" >
							<label class="text-label">Consumidor Final</label>	
							<select  name="indFinal" id="indFinal" class="form-campo">
								<option value="0" {{($cliente->indFinal ?? null) == '0' ? 'selected' : null }}>Não</option>	
								<option value="1" {{($cliente->indFinal ?? null) == '1' ? 'selected' : null }}>Sim</option>	
																						
							</select>
					</div>
					
					<div class="col-2 mb-3" >
							<label class="text-label" id="lblInscEstadual">Inscrição Estadual</label>	
							<input type="text" name="rg_ie" maxlength="14" id="rg_ie" value="{{isset($cliente->rg_ie) ? $cliente->rg_ie : old('rg_ie') }}"  class="form-campo">
					</div>
					
					<div class="col-2 mb-3" id="divIscMunicipal">
							<label class="text-label">Insc. Municipal</label>	
							<input type="text" name="im" id="im" maxlength="15" value="{{isset($cliente->im) ? $cliente->im : old('im') }}"  class="form-campo">
					</div>
					
					<div class="col-3 mb-3" id="divSuframa">
							<label class="text-label">Suframa</label>	
							<input type="text" name="suframa" id="suframa" value="{{isset($cliente->suframa) ? $cliente->suframa : old('suframa') }}"  class="form-campo">
					</div>
					
					<div class="col-3 mb-3" id="idestrangeiro">
							<label class="text-label">Doc. Estrangeiro</label>	
							<input type="text" name="idestrangeiro" maxlength="20" id="suframa" value="{{$cliente->idestrangeiro ?? old('idestrangeiro') }}"  class="form-campo">
					</div>					
								

					<div class="col-2 mb-3">
							<label class="text-label">Fone</label>	
							<input type="text" name="telefone" maxlength="14" id="telefone" value="{{isset($cliente->telefone) ? $cliente->telefone : old('telefone') }}"  class="form-campo mascara-fone">
					</div>
					<div class="col-2 mb-3">
							<label class="text-label">Celular</label>	
							<input type="text" name="celular" id="celular" value="{{isset($cliente->celular) ? $cliente->celular : old('celular') }}"  class="form-campo mascara-celular">
					</div>
					
					
				</div>
			</fieldset>
			<fieldset>
					<legend>Endereço</legend>
													
					<div class="rows">	
							<div class="col-2 mb-3">
                            <label class="text-label">Cep<span class="text-vermelho">*</span></label>	
                            <input type="text" name="cep" id="cep" required value="{{isset($cliente->cep) ? $cliente->cep : old('cep') }}"  class="form-campo busca_cep mascara-cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="logradouro" maxlength="60" required id="logradouro" value="{{isset($cliente->logradouro) ? $cliente->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="numero" required id="numero" value="{{isset($cliente->numero) ? $cliente->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="bairro"  maxlength="60" id="bairro" value="{{isset($cliente->bairro) ? $cliente->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento" maxlength="60" id="complemento" value="{{isset($cliente->complemento) ? $cliente->complemento : old('complemento') }}"  class="form-campo">
                             </div>	                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="uf" id="uf" required  value="{{isset($cliente->uf) ? $cliente->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="cidade" maxlength="60" required id="cidade" value="{{isset($cliente->cidade) ? $cliente->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge" required id="ibge" value="{{isset($cliente->ibge) ? $cliente->ibge : old('ibge') }}"  class="form-campo ibge ">
                             </div>  
					</div>
					
				</fieldset>
				
				<fieldset>
					<legend>Opções de Crédito</legend>
						<?php                 	       
						$credito_liberado       = ($cliente->credito_liberado) ?? "N" ;
                	     ?>							
					<div class="rows">	
							<div class="col-2 mb-3">				   
            						<label class="text-label text-vermelho">Crédito Liberado </label>
									<div class="radio d-flex">
										 <label class="d-block"><input type="radio" name="credito_liberado" {{($credito_liberado == 'S') ? 'checked' : ''}} value="S" > Sim</label>
										 <label class="d-block ml-3"><input type="radio" name="credito_liberado" {{($credito_liberado == 'N') ? 'checked' : ''}} value = "N"> Não</label>
									</div>            						
            					</div>
                            
                            <div class="col-3 mb-3">
                                    <label class="text-label">Limte de Crédito<span class="text-vermelho">*</span></label>	
                                    <input type="text" name="limite_credito"   id="limite_credito" value="{{isset($cliente->limite_credito) ? $cliente->limite_credito : old('limite_credito') }}"  class="form-campo mascara-float">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Crédito Utilizado<span class="text-vermelho">*</span></label>	
                                    <input type="text" readonly="readonly" value="{{isset($cliente->credito_utilizado) ? $cliente->credito_utilizado : old('credito_utilizado') }}"  class="form-campo mascara-float">
                            </div>
                            <div class="col-2 mb-3">
                                     <label class="text-label">Crédito Disponível</label>	
                                     <input type="text" readonly="readonly" value="{{isset($cliente->credito_disponivel) ? $cliente->credito_disponivel : old('credito_disponivel') }}"  class="form-campo mascara-float">
                             </div>
                             <div class="col-2 mb-3">
                                     <label class="text-label">Crédito de Devolução </label>	
                                     <input type="text" readonly="readonly" value="{{isset($cliente->credito_devolucao) ? $cliente->credito_devolucao : old('credito_devolucao') }}"  class="form-campo mascara-float">
                             </div>	                            
        						 
                              
					</div>
					<div class="col-12 text-center pb-4">	
            			<input type="hidden" name="eh_modal" id="eh_modal" value="0">
            			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
            		</div>
				</fieldset>
				
				</form>
		</div>
	  </div>
	  
	  <div id="tab-2">
		<div class="p-2">
		
			<div class="rows">
    			<div class="col-12">
            		<fieldset>
					<legend>Lista de Endereço</legend>
            		<div class="tabela-responsiva pb-4 prod table border-top mt-4 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Logradouro</th>
                                    <th align="center">Bairro</th>
                                    <th align="center">Cidade</th>
                                    <th align="center">Uf</th>
                                    <th align="center">Ibge</th>
                                    <th align="center">Editar</th>
                                    <th align="center">Excluir</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($cliente->enderecos as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->logradouro}} - Num: {{$v->numero}}</td>
                            		<td align="center">{{$v->bairro}}</td>
                            		<td align="center">{{$v->cidade}}</td>
                            		<td align="center">{{$v->uf}}</td>
                            		<td align="center">{{$v->ibge}}</td>
                                	<td align="center"><a href="{{route('admin.enderecocliente.edit', $v->id)}}"  title="Editar">Editar</a></td>									
                            		<td align="center">
                                        <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$v->id}}').submit() : '';" title="Excluir">Excluir</a>
                                            <form action="{{route('admin.enderecocliente.destroy', $v->id)}}" method="POST" id="apagar{{$v->id}}">
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
	



<script>
	function tipoCliente(){
		var tp = $("#tipo_cliente").val();
		
		if(tp=="F"){
			$("#div_pesquisar").hide();
            $("#divIscEstadual").hide();
            $("#divSuframa").hide();
            $("#divFantasia").hide();
            
            $("#lblInscEstadual").html("RG");
            $("#lblCnpj").html('CPF');
            $("#lblRazaoSocial").html('Nome');
            $("#cnpj").mask('000.000.000-00', {reverse: true});
            $("#indFinal option:contains(Sim)").attr('selected', true);
            $("#tipo_contribuinte option:contains(Não)").attr('selected', true);
        }else{
			$("#div_pesquisar").show();
            $("#divIscEstadual").show();
            $("#divSuframa").show();
            $("#divFantasia").show();
            
            $("#lblInscEstadual").html("Inscrição Estadual");
            $("#lblCnpj").html('CNPJ');
            $("#lblRazaoSocial").html('Razão Social');
            $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
          	
          	$("#lblCnpj").html('CNPJ');
          	$("#indFinal option:contains(Não)").attr('selected', true);
          	$("#tipo_contribuinte option:contains(ICMS)").attr('selected', true);
          	
		}
	}
</script>
@endsection