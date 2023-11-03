@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Cadastrar emitente</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>
   <form action="{{route('admin.emitente.update', $emitente->id)}}" method="POST" enctype="multipart/form-data" >
   <input name="_method" type="hidden" value="PUT"/>
	@csrf
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Dados Pessoais</a></li>
		<li><a href="#tab-2">Nfe/Nfce</a></li>
		<li><a href="#tab-3">Outros</a></li>
		<li><a href="#tab-4">Pessoas Autorizadas</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2 mt-3">				
				<div class="rows">
					<div class="col-6">
					<fieldset style="background: #f3f3f3;">
						<legend>Pesquisar Por CNPJ</legend>
						<div class="grupo-form-btn">
							<input type="text" id="codigocnpj"   class="form-campo">
							<input type="button" onclick="pesquisarCnpj()" value="Pesquisar CNPJ" class="btn btn-azul d-block m-auto">
						</div>
					</fieldset>
					</div>
				</div>
				<fieldset>
				<legend>Dados pessoais</legend>	
				<div class="rows">
					<div class="col-12">			
					</div>	
					<div class="col-6 mb-3">
										<label class="text-label">Razão Social</label>	
										<input type="text" name="razao_social" maxlength="60" id="razao_social" value="{{isset($emitente->razao_social) ? $emitente->razao_social : old('razao_social') }}" class="form-campo">
								</div>                                    
								<div class="col-6 mb-3">
										<label class="text-label">Nome Fantasia</label>	
										<input type="text" name="nome_fantasia" maxlength="60"  id="nome_fantasia" value="{{isset($emitente->nome_fantasia) ? $emitente->nome_fantasia : old('nome_fantasia') }}" class="form-campo">
								</div>					
								
														
								<div class="col-3 mb-3">
										<label class="text-label">CNPJ</label>	
										<input type="text" name="cnpj" id="cnpj" value="{{isset($emitente->cnpj) ? $emitente->cnpj : old('cnpj') }}"  class="form-campo">
								</div>
								
								<div class="col-3 mb-3">
										<label class="text-label">Insc. Estadual</label>	
										<input type="text" name="ie" value="{{isset($emitente->ie) ? $emitente->ie : old('ie') }}"  class="form-campo">
								</div>
							
							
                             
                                <div class="col-6 mb-3">
                                        <label class="text-label">Regime Tributário</label>	
                                        <select class="form-campo" name="crt">
                                                <option value="1" {{($emitente->crt=="1") ? "selected" : ""}}>Simples Nacional</option> 
                                                <option value="2" {{($emitente->crt=="2") ? "selected" : ""}}>Lucro Presumido</option> 
                                                <option value="3" {{($emitente->crt=="3") ? "selected" : ""}}>Lucro Real</option> 
                                        </select>
                                </div>
                                <div class="col-3 mb-3">
        							<label class="text-label">Email</label>	
        							<input type="text" name="email" id="email" value="{{isset($emitente->email) ? $emitente->email : old('email') }}"  class="form-campo">
        						</div>
        						
        						
        						
                                <div class="col-3 mb-3">
    							<label class="text-label">Fone</label>	
    							<input type="text" name="fone" maxlength="14" id="telefone" value="{{isset($emitente->fone) ? $emitente->fone : old('fone') }}"  class="form-campo">
    					</div>
				
			</div>
</fieldset>
	<fieldset>
        <legend>Endereço</legend>										
        <div class="rows">	
              <div class="col-2 mb-3">
                            <label class="text-label">Cep</label>	
                            <input type="text" name="cep" id="cep" value="{{isset($emitente->cep) ? $emitente->cep : old('cep') }}"  class="form-campo busca_cep">
                            </div>
                            
                            <div class="col-4 mb-3">
                                    <label class="text-label">Logradouro</label>	
                                    <input type="text" name="logradouro" maxlength="60" id="logradouro" value="{{isset($emitente->logradouro) ? $emitente->logradouro : old('logradouro') }}"  class="form-campo rua">
                            </div>
                            <div class="col-2 mb-4">
                                    <label class="text-label">Numero</label>	
                                    <input type="text" name="numero" id="numero" value="{{isset($emitente->numero) ? $emitente->numero : old('numero') }}"  class="form-campo">
                            </div>
                            <div class="col-4 mb-3">
                                     <label class="text-label">Bairro</label>	
                                     <input type="text" name="bairro" id="bairro" maxlength="60" value="{{isset($emitente->bairro) ? $emitente->bairro : old('bairro') }}"  class="form-campo bairro">
                             </div>
                             <div class="col-4 mb-3">
                                     <label class="text-label">Complemento</label>	
                                     <input type="text" name="complemento"  maxlength="60" value="{{isset($emitente->complemento) ? $emitente->complemento : old('complemento') }}"  class="form-campo">
                             </div>	
                            
        						 
                             <div class="col-2 mb-2">
                                 <label class="text-label">UF</label>	
                                 <input type="text" name="uf" id="uf" value="{{isset($emitente->uf) ? $emitente->uf : old('uf') }}"   class="form-campo estado"> 
                             </div>                    
                             
                             <div class="col-4 mb-3">
                                     <label class="text-label">Cidade</label>	
                                     <input type="text" name="cidade" maxlength="60" id="cidade" value="{{isset($emitente->cidade) ? $emitente->cidade : old('cidade') }}"  class="form-campo cidade">
                             </div>	
                             <div class="col-2 mb-3">
                                     <label class="text-label">Ibge</label>	
                                     <input type="text" name="ibge" id="ibge" value="{{isset($emitente->ibge) ? $emitente->ibge : old('ibge') }}"  class="form-campo ibge ">
                             </div>  
        </div>
		</fieldset>
		
		</div>
	  </div>
	  
	  
    <div id="tab-2">
		<div class="p-2 mt-3">
		<fieldset class="mt-4">
        <legend>NFE</legend>		
		<div class="rows">
         	    <div class="col-3 mb-3">
                    <label class="text-label">Ambiente</label>	
                    <select class="form-campo" name="ambiente_nfe">
                            <option value="2" {{($emitente->ambiente_nfe=="2") ? "selected" : ""}}>2 - Homologação</option> 
                            <option value="1" {{($emitente->ambiente_nfe=="1") ? "selected" : ""}}>1 - Produção</option>  
                    </select>
                 </div>
                 <div class="col-1 mb-3">
						<label class="text-label">Nº Serie</label>	
						<input type="text" name="numero_serie_nfe" value="{{isset($emitente->numero_serie_nfe) ? $emitente->numero_serie_nfe : old('numero_serie_nfe') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						 <label class="text-label">Ultimo Nº NFE</label>	
						 <input type="text" name="ultimo_numero_nfe" value="{{isset($emitente->ultimo_numero_nfe) ? $emitente->ultimo_numero_nfe : old('ultimo_numero_nfe') }}"  class="form-campo">
				 </div>
				 
				 <div class="col-3 mb-3">
                        <label class="text-label">Alíq. Crédito Simples Nacional</label>	
                        <input type="text" name="pCredSN"  value="{{isset($emitente->pCredSN) ? $emitente->pCredSN  : old('pCredSN') }}"  class="form-campo mascara-float">
                </div>
				 
		</div>
		</fieldset>
		
		<fieldset class="mt-4">
        <legend>NFCE</legend>		
		<div class="rows">
                <div class="col-3 mb-3">
                    <label class="text-label">Ambiente</label>	
                    <select class="form-campo" name="ambiente_nfce">
                            <option value="2" {{($emitente->ambiente_nfce=="2") ? "selected" : ""}}>2 - Homologação</option> 
                            <option value="1" {{($emitente->ambiente_nfce=="1") ? "selected" : ""}}>1 - Produção</option>  
                    </select>
                 </div>
                 <div class="col-1 mb-3">
						<label class="text-label">Nº Serie</label>	
						<input type="text" name="numero_serie_nfce" value="{{isset($emitente->numero_serie_nfce) ? $emitente->numero_serie_nfce : old('numero_serie_nfce') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						 <label class="text-label">Ultimo Nº NFCE</label>	
						 <input type="text" name="ultimo_numero_nfce" value="{{isset($emitente->ultimo_numero_nfce) ? $emitente->ultimo_numero_nfce : old('ultimo_numero_nfce') }}"  class="form-campo">
				 </div>
			                         
                                                
                <div class="col-4 mb-3">
                         <label class="text-label">CSC</label>	
                         <input type="text" name="csc" value="{{isset($emitente->csc) ? $emitente->csc : old('csc') }}"  class="form-campo">
                 </div>
                 <div class="col-2 mb-3">
                         <label class="text-label">CSC ID</label>	
                         <input type="text" name="csc_id" value="{{isset($emitente->csc_id) ? $emitente->csc_id : old('csc_id') }}"  class="form-campo">
                 </div>
                 
                 <div class="col-3">	
                     <label class="text-label d-block ">Conta Corrente Loja </label>
                    <select name="loja_conta_corrente_id" class="form-campo">
                       @foreach($contas as $conta) 
                        	<option value="{{$conta->id}}" {{$emitente->loja_conta_corrente_id==$conta->id ? 'selected' : ''}}>{{$conta->descricao}}</option>  
                       @endforeach                                                  
                    </select>
                 </div>
                 
                 <div class="col-3">	
                     <label class="text-label d-block ">Classificação Financeira da Loja</label>
                    <select name="loja classificacao_financeira_id" class="form-campo">
                       @foreach($classificacoes as $c) 
                        	<option value="{{$c->id}}" {{$emitente->loja_classificacao_financeira_id==$c->id ? 'selected' : ''}}>{{$c->codigo}} - {{$c->descricao}}</option>  
                       @endforeach                                                  
                    </select>
                 </div>
                 
                 <div class="col-3">	
                     <label class="text-label d-block ">Conta Padrão Pdv </label>
                    <select name="pdv_conta_corrente_id" class="form-campo">
                       @foreach($contas as $conta) 
                        	<option value="{{$conta->id}}" {{$emitente->pdv_conta_corrente_id==$conta->id ? 'selected' : ''}}>{{$conta->descricao}}</option>  
                       @endforeach                                                  
                    </select>
                 </div>
                 
                 <div class="col-3">	
                     <label class="text-label d-block ">Classificação Financeira do Pdv</label>
                    <select name="pdv_classificacao_financeira_id" class="form-campo">
                       @foreach($classificacoes as $c) 
                        	<option value="{{$c->id}}" {{$emitente->pdv_classificacao_financeira_id==$c->id ? 'selected' : ''}}>{{$c->codigo}} - {{$c->descricao}}</option>  
                       @endforeach                                                  
                    </select>
                 </div>
                
        </div>
		</fieldset>
        </div>
	  </div>
	  
       
	  
	   <div id="tab-3">	
	   <div class="p-2 mt-3">
		<fieldset>
        <legend>Dados Adicionais da Nota</legend>										
        <div class="rows">	
              	<div class="col mb-6">
					<label class="text-label">Informações para o Fisco</label>	                   
					<textarea rows="5" name="infAdFisco" id="infAdFisco"   class="form-campo">{{ $emitente->infAdFisco ?? null }}</textarea>
				</div>
						 
				<div class="col mb-6">
					<label class="text-label">Informações complementares interesse contribuinte</label>	                   
					<textarea rows="5" name="infCpl" id="infCpl"  class="form-campo">{{ $emitente->infCpl ?? null }}</textarea>
				</div>
               
        </div>
        </fieldset>
        </div>
        
        
	   <div class="p-2 mt-3">
		<fieldset>
        <legend>Intermediador</legend>										
        <div class="rows">	
              	<div class="col-4 mb-3">
                    <label class="text-label">Indicador de Intermediador</label>	
                    <select class="form-campo" name="indIntermed" id="indIntermed" >
                            <option value="0" {{ (($emitente->indIntermed ?? null) == "0") ? "selected" : null  }}>0 - Operação sem intermediador </option>
                            <option value="1" {{ (($emitente->indIntermed ?? null) == "1") ? "selected" : null  }}>1 - Operação em site ou plataforma de terceiros</option>
                    </select>
                </div>
                
                <div class="col-4 mb-3">
                    <label class="text-label">CNPJ </label>	
                    <input type="text" name="cnpjIntermed" id="cnpjIntermed" value="{{ $emitente->cnpjIntermed ?? null }}"  class="form-campo">
                </div>
                <div class="col-4 mb-3">
                    <label class="text-label">Identificação do Intermediador </label>	
                    <input type="text" name="idCadIntTran" id="idCadIntTran" value="{{ $emitente->idCadIntTran ?? null }}"  class="form-campo">
                </div>
               
        </div>
        </fieldset>
        </div>

        
        
	   <div class="p-2 mt-3">
		<fieldset>
        <legend>Responsável Técnico</legend>										
        <div class="rows">	
              <div class="col-6 mb-3">
                <label class="text-label">Nome </label>	
                <input type="text" name="resp_xContato" id="resp_xContato" value="{{isset($emitente->resp_xContato) ? $emitente->resp_xContato : old('resp_xContato') }}"  class="form-campo">
               </div>
                
                <div class="col-3 mb-3">
                        <label class="text-label">CNPJ</label>	
                        <input type="text" name="resp_CNPJ"  value="{{isset($emitente->resp_CNPJ) ? $emitente->resp_CNPJ : old('resp_CNPJ') }}"  class="form-campo">
                </div>
                <div class="col-3 mb-3">
                        <label class="text-label">Fone</label>	
                        <input type="text" name="resp_fone"  value="{{isset($emitente->resp_fone) ? $emitente->resp_fone : old('resp_fone') }}"  class="form-campo">
                </div>
                <div class="col-3 mb-3">
                        <label class="text-label">CSRT</label>	
                        <input type="text" name="resp_CSRT"  value="{{isset($emitente->resp_CSRT) ? $emitente->resp_CSRT : old('resp_CSRT') }}"  class="form-campo">
                </div>
                <div class="col-3 mb-3">
                        <label class="text-label">idCSRT</label>	
                        <input type="text" name="resp_idCSRT"  value="{{isset($emitente->resp_idCSRT) ? $emitente->resp_idCSRT : old('resp_idCSRT') }}"  class="form-campo">
                </div>
                <div class="col-6 mb-3">
                        <label class="text-label">Email </label>	
                        <input type="text" name="resp_email"  value="{{isset($emitente->resp_email) ? $emitente->resp_email : old('resp_email') }}"  class="form-campo">
                </div>
        </div>
        </fieldset>
        </div>
        	
	
	  </div>
	  
	     <div id="tab-4">	
	
		<div class="p-2 mt-3">
		<fieldset>
            <legend>Pessoas Autorizadas a acessar o XML</legend>										
            <div class="rows">	
                  <div class="col-4 mb-3">
                    	<label class="text-label">Nome</label>	
                    	<input type="text"  id="aut_contato" value="{{($emitente->aut_contato) ?? old('aut_contato') }}"  class="form-campo">
                    </div>
                    
                    <div class="col-4 mb-3">
                        <label class="text-label">CPF/CNPJ</label>	
                        <input type="text"  id="aut_cnpj" value="{{($emitente->aut_cnpj) ?? old('aut_cnpj') }}"  class="form-campo">
                    </div>
                    <div class="col-2 mt-1 pt-1"> 
                    	<input type="button" onclick="inserirAutorizado()" value="Inserir" class="btn btn-azul width-100" />                              
                    </div> 
            </div>
            <div class="col-12">
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0"  class="table-bordered">
                            <thead>
                                    <tr>
                                        <th align="center">ID</th>
                                        <th align="center">Contato</th>
                                        <th align="center">CPF/CNPJ</th>
                                        <th align="center">Excluir</th>
                                  </tr>
                            </thead>
                           <tbody id="lista_autorizado">
                               <?php foreach($autorizados as $item){ ?>
                                <tr>
                                    <td align="center"><?php echo $item->id  ?></td>
                                    <td align="center"><?php echo $item->aut_contato ?></td>
                                    <td align="center"><?php echo $item->aut_cnpj ?></td>
                                    <td align="center"><a href="javascript:;" onclick="excluirAutorizado(<?php echo $item->id ?>)" class="btn btn-vermelho btn-pequeno d-inline-block" title="Excluir"><i class="fas fa-trash"></i></a></td>
                                </tr>
                               <?php } ?>
							   
                       </tbody>
                    </table>
                  
            </div>
            </div>
        </fieldset>
        </div>
	  </div>
         
 </div>

		<div class="col-12 text-center pb-4">
		  <input type="hidden"  id="id_emitente" value="{{($emitente->id) ?? null }}"  class="form-campo">		
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
</div>

<script>
$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN': _token
	}
});

 function inserirAutorizado(){
    $.ajax({
         url: base_url + "admin/emitente/inserirAutorizado",
         type: "post",
         dataType:"Json",
         data:{
        	 emitente_id   			: $("#id_emitente").val(),
        	 aut_contato			: $("#aut_contato").val(), 
        	 aut_cnpj				: $("#aut_cnpj").val(),      	
         },
         success: function(data){ 
        	 lista_autorizado(data);
             fecharModal();                 
             
         },
         beforeSend: function(){           
            giraGira(); 
        }
         
     });
   
 } 
 
 function lista_autorizado(data){
	    var html = "";
	    for(var i in data){
	        html += "<tr> " +
	               "<td align='center' >" + data[i].id + "</td>" +
	               "<td align='center' >" + data[i].aut_contato + "</td>" +
	               "<td align='center' >" + data[i].aut_cnpj + "</td>" +
	               "<td align='center' ><a href='javascript:;' onclick='excluirAutorizado("+ data[i].id +")'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'><i class='fas fa-trash'></i></a></td>" +
	       "</tr>"; 
	    }
	    $("#lista_autorizado").html(html);
	    
	}
 
 function excluirAutorizado(id){
     $.ajax({
       url: base_url + "admin/emitente/excluirAutorizado/" + id ,
       type: "GET",
       data: {  },
       dataType:"Json",
       success: function(data){
    	   lista_autorizado(data);
       }
       
   });
}
	
</script>

@endsection