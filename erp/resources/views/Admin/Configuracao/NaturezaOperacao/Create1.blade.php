<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Cadastrar Natureza de Operação</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>
    @if(isset($natureza))    
   <form action="{{route('admin.naturezaoperacao.update', $natureza->id)}}" method="POST">
       <input name="_method" type="hidden" value="PUT"/>
     @else                       
    	<form action="{{route('admin.naturezaoperacao.store')}}" method="Post">
    @endif
    	@csrf
    
   <div class="p-2 mt-3">
		<fieldset class="mt-4">
        <legend>Dados Gerais</legend>		
		<div class="rows">  
				    	    
                 <div class="col-4 mb-3">
						<label class="text-label">Descricao</label>	
						<input type="text" name="descricao" value="{{$natureza->descricao ?? old('descricao') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						 <label class="text-label">Tipo</label>	
						 <select name="tipo" class="form-campo">
						 	<option value="S">Saída</option>
						 	<option value="E">Entrada</option>
						 </select>
				 </div>
				 
				  <div class="col-2  mb-3">
                        <label class="text-label">Indicador de Presença</label>
                        <select class="form-campo" name="indPres" id="indPres">
                            <option value="0" {{ (($natureza->indPres ?? null) == "0") ? "selected" : null }}>0 - NÃO SE APLICA</option>
                            <option value="1" {{ (($natureza->indPres ?? null) == "1") ? "selected" : null }}>1 - OPERAÇÃO PRESENCIAL</option>
                            <option value="2" {{ (($natureza->indPres ?? null) == "2") ? "selected" : null }}>2 - OPERAÇÃO NÃO PRESENCIAL, PELA INTERNET</option>
                            <option value="3" {{ (($natureza->indPres ?? null) == "3") ? "selected" : null }}>3 - OPERAÇÃO NÃO PRESENCIAL, TELEATENDIMENTO</option>
                            <option value="5" {{ (($natureza->indPres ?? null) == "5") ? "selected" : null }}>5 - OPERAÇÃO PRESENCIAL, FORA DO ESTABELECIMENTO</option>
                            <option value="9" {{ (($natureza->indPres ?? null) == "9") ? "selected" : null }}>9 - OPERAÇÃO NÃO PRESENCIAL, OUTROS</option> 
                        </select>
                </div>
               
                <div class="col-2 mb-3">
                        <label class="text-label">Devolução ?</label>	
                        <select class="form-campo" name="devolucao" id="devolucao">
                                <option value="0" {{ (($natureza->indFinal ?? null) == "0") ? "selected" : null }}> NÃO</option>
                                <option value="1" {{ (($natureza->indFinal ?? null) == "1") ? "selected" : null }}>SIM</option>
                        </select>
                </div>
                
                <div class="col-2 mb-3">
                        <label class="text-label">Padrão</label>	
                        <select class="form-campo" name="padrao" id="padrao">
                        <option value="">Selecionar</option>
                       		   @foreach(ConstanteService::listaPadraoNatureza() as $chave=>$valor)
									<option value="{{$chave}}" {{($natureza->padrao ?? null) == $chave ? "selected" : null }}>{{$chave}} - {{$valor}}</option>
								@endforeach
                        </select>
                </div>
        
		</div>
		</fieldset>
		</div>
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">ICMS</a></li>
		<li><a href="#tab-2">IPI</a></li>
		<li><a href="#tab-3">PIS</a></li>
		<li><a href="#tab-4">COFINS</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>ICMS</legend>	
				<div class="rows">
				
					<div class="col-6 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstIcms" id="cstIcms" onchange="selecionarIcms()" >							
								@foreach($lista_cstIcms as $chave=>$valor)
									<option value="{{$chave}}" {{($natureza->cstIcms ?? null) == $chave ? "selected" : null }}>{{$chave}} - {{$valor}}</option>
								@endforeach
							</select>	
								
						</div>                                    
						<div class="col-2 mb-3">
								<label class="text-label">CFOP (intraestadual)</label>	
								<input type="text" name="cfop" maxlength="4"  id="cfop" value="{{$natureza->cfop ?? old('cfop') }}" class="form-campo">
						</div>
						<div class="col-2 mb-3">
								<label class="text-label">Modalidade BC</label>	
								<select class="form-campo" name="modBC" id="modBC" >							
								@foreach(ConstanteService::listaModalidade() as $chave=>$valor)
									<option value="{{$chave}}" {{($natureza->modBC ?? null) == $chave ? "selected" : null }}> {{$valor}}</option>
								@endforeach
							</select>							
						</div>
						<div class="col-2 mb-3">
								<label class="text-label">Alíquota ICMS</label>	
								<input type="text" name="pICMS"   id="pICMS" value="{{$natureza->pICMS ?? old('pICMS') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Red. BC ICMS (%)</label>	
								<input type="text" name="pRedBC"   id="pRedBC" value="{{$natureza->pRedBC ?? old('pRedBC') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Modalidade BC ICMSST</label>	
								<select class="form-campo" name="modBCST" id="modBCST" >							
								@foreach(ConstanteService::listaModalidade() as $chave=>$valor)
									<option value="{{$chave}}" {{($natureza->modBC ?? null) == $chave ? "selected" : null }}> {{$valor}}</option>
								@endforeach
							</select>							
						</div>
						<div class="col-2 mb-3">
								<label class="text-label">Valor BC ICMS ST</label>	
								<input type="text" name="vBCST"   id="vBCST" value="{{$natureza->vBCST ?? old('vBCST') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Alíquota do ICMS ST</label>	
								<input type="text" name="pICMSST"   id="pICMSST" value="{{$natureza->pICMSST ?? old('pICMSST') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">MVA ICMS ST(%)</label>	
								<input type="text" name="pMVAST"   id="pMVAST" value="{{$natureza->pMVAST ?? old('pMVAST') }}" class="form-campo mascara-float ">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Red. BC ICMS ST(%)</label>	
								<input type="text" name="pRedBCST"   id="pRedBCST" value="{{$natureza->pRedBCST ?? old('pRedBCST') }}" class="form-campo mascara-float ">
						</div>				
						
						<div class="col-2 mb-3">
								<label class="text-label">Vr. ICMS Substituto</label>	
								<input type="text" name="vICMSSubstituto" id="vICMSSubstituto" value="{{$natureza->vICMSSubstituto ?? old('vICMSSubstituto') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Aliq. FCP (%)</label>	
								<input type="text" name="pFCP" id="pFCP" value="{{$natureza->pFCP ?? old('pFCP') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Aliq. FCP ST(%)</label>	
								<input type="text" name="pFCPST" id="pFCPST" value="{{$natureza->pFCPST ?? old('pFCPST') }}"  class="form-campo mascara-float">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Aliq. FCP ST Ret.(%)</label>	
								<input type="text" name="pFCPSTRet" id="pFCPSTRet" value="{{$natureza->pFCPSTRet ?? old('pFCPSTRet') }}"  class="form-campo mascara-float">
						</div>
						<div class="col-2 mb-3">
								<label class="text-label">Perc do Diferimento (%)</label>	
								<input type="text" name="pDif" id="pDif" value="{{$natureza->pDif ?? old('pDif') }}"  class="form-campo mascara-float">
						</div>
						
						
                        @isset($natureza)
                        <div class="col-12 text-right pb-0 pt-2">
                			<a href="javascript:;" onclick="abrirModal('#formIcms')" class="btn btn-azul d-inline-block"> <i class="fas fa-plus-circle"></i> Inserir Novo </a>
                		</div>
                		@endisset                                          
            </div>
      @isset($natureza)
           <div class="rows">
			<div class="col-12"> 
            <fieldset class="mt-3 mb-0 p-0 border-0">              
                <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Cst</th>
                                    <th align="center">Cfop</th>
                                    <th align="center">Opções</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($natureza->tributacaoIcms as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->cstIcms}}</td>
                            		<td align="center">{{$v->cfop}}</td>
                            		<td align="center" width="400">
                            			<a href="javascript:;" onclick="abriTelaProdutoIcms({{$v->id}})" class="btn btn-azul btn-pequeno d-inline-block">Produtos</a>
                            			<a href="javascript:;" onclick="telaEstadoIcms({{$v->id}})"  class="btn btn-roxo btn-pequeno d-inline-block">Estados</a>
                            			<a href="" class="btn btn-vermelho btn-pequeno d-inline-block">Excluir</a>
                            			<a href="" class="btn btn-verde btn-pequeno d-inline-block">Editar</a>
                            		</td>
                            	</tr>
                            @endforeach
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
                </div>
                </div>
               @endisset
</fieldset>
	
		
		</div>
	  </div>
	  
	  
  <div id="tab-2">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>IPI</legend>	
				<div class="rows">	
					<div class="col-6 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstIpi" id="cstIpi" >							
								@foreach(ConstanteService::listaCST_IPI() as $chave=>$valor)
									<option value="{{$chave}}" {{($natureza->cstIpi ?? null) == $chave ? "selected" : null }}>{{$chave}} - {{$valor}}</option>
								@endforeach
							</select>		
								
						</div>
						                                    
						<div class="col-2 mb-3">
								<label class="text-label">Aliquota %</label>	
								<input type="text" name="pIPI"  id="pIPI" value="{{$natureza->pIPI ?? old('pIPI') }}" class="form-campo mascara-float">
						</div>		
						
					
						
						<div class="col-2 mb-3">
							<label class="text-label">Tipo de cálculo</label>
							<select class="form-campo" name="tipo_calc_ipi" id="tipo_calc_ipi">	
								<option value="0" {{ (($natureza->tipo_calc_ipi ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($natureza->tipo_calc_ipi ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($natureza->tipo_calc_ipi ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						
						<div class="col-4 mb-3">
								<label class="text-label">CNPJ do produtor</label>	
								<input type="text" name="CNPJProd" id="CNPJProd" maxlength="60" value="{{$natureza->cSelo?? old('cSelo') }}"  class="form-campo ">
						</div>						
						
						
						<div class="col-4 mb-3">
								<label class="text-label">Código do selo de controle</label>	
								<input type="text" name="cSelo" id="cSelo" maxlength="60" value="{{$natureza->cSelo?? old('cSelo') }}"  class="form-campo ">
						</div>
						
						<div class="col-4 mb-3">
								<label class="text-label">Qtde. do selo de controle</label>	
								<input type="text" name="qSelo" id="qSelo" maxlength="12" value="{{$natureza->qSelo ?? old('qSelo') }}"  class="form-campo">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Qtde na Unidade</label>	
								<input type="text" name="qUnidIPI" id="qUnidIPI" maxlength="10" value="{{$natureza->qUnidIPI ?? old('qUnidIPI') }}"  class="form-campo">
						</div>
						
						<div class="col-2 mb-3">
								<label class="text-label">Valor por Unidade</label>	
								<input type="text" name="vUnidIPI" id="vUnidIPI" maxlength="10" value="{{$natureza->vUnidIPI ?? old('vUnidIPI') }}"  class="form-campo">
						</div>
						
						
						<div class="col-2 mb-3">
                               <label class="text-label">Cód. de Enquadramento</label>	
                               <input type="text" name="cEnq" id="cEnq" maxlength="3" value="{{$natureza->cEnq ??  old('cEnq') }}"  class="form-campo">
                       </div>
                       
                      
                       @isset($natureza)
                        <div class="col-12 text-right pb-0 pt-2">
                			<a href="javascript:;" onclick="abrirModal('#formIpi')"  class="btn btn-azul d-inline-block"> <i class="fas fa-plus-circle"></i>  Inserir Novo </a>
                		</div> 
                	@endisset                      
           </div>  
      @isset($natureza)    
         <div class="rows">
			<div class="col-12"> 
            <fieldset class="mt-3 mb-0 p-0 border-0">            
                <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Cst</th>
                                    <th align="center">Aliquota</th>
                                    <th align="center">Base</th>
                                    <th align="center" width="400">Opções</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($natureza->tributacaoIpi as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->cstIpi}}</td>
                            		<td align="center">{{$v->aliquota_ipi}}</td>
                            		<td align="center">{{$v->base_ipi}}</td>
                            		<td align="center">
                            			<a href="javascript:;" onclick="abriTelaProdutoIpi({{$v->id}})" class="btn btn-azul btn-pequeno d-inline-block">Produtos</a>
                            			<a href="javascript:;" onclick="telaEstadoIcms({{$v->id}})" class="btn btn-roxo btn-pequeno d-inline-block">Estados</a>
                            			<a href=""class="btn btn-vermelho btn-pequeno d-inline-block">Excluir</a>
                            			<a href="" class="btn btn-verde btn-pequeno d-inline-block">Editar</a>
                            		</td>
                            	</tr>
                            @endforeach
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
                </div>
                </div>
         @endisset
</fieldset>
	
		
		</div>
	  </div>
	  
     <div id="tab-3">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>PIS</legend>	
				<div class="rows">	
					<div class="col-12 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstPis" id="cstPis" >							
								@foreach(ConstanteService::listaCST_PIS_COFINS() as $chave=>$valor)
									<option value="{{$chave}}" {{($natureza->cstCofins ?? null) == $chave ? "selected" : null }}>{{$chave}} - {{$valor}}</option>
								@endforeach
							</select>		
								
						</div> 
						<div class="col-2 mb-3">
							<label class="text-label">Modalidade Pis</label>
							<select class="form-campo" name="tipo_calc_pis" id="tipo_calc_pis">	
								<option value="0" {{ (($natureza->tipo_calc_pis ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($natureza->tipo_calc_pis ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($natureza->tipo_calc_pis ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-2 mb-3">
								<label class="text-label">Alíquota PIS %</label>	
								<input type="text" name="pPIS"  id="pPIS" value="{{$natureza->pPIS ?? old('pPIS') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-2 mb-3">
								<label class="text-label">Valor Alíquota (R$)</label>	
								<input type="text" name="vAliqProd_pis"  id="vAliqProd_pis" value="{{$natureza->vAliqProd_pis ?? old('vAliqProd_pis') }}" class="form-campo mascara-float">
						</div>			
											
						
						<div class="col-2 mb-3">
							<label class="text-label">Modalidade Pis ST</label>
							<select class="form-campo" name="tipo_calc_pis" id="tipo_calc_pis" >	
								<option value="0" {{ (($natureza->tipo_calc_pis ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($natureza->tipo_calc_pis ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($natureza->tipo_calc_pis ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-2 mb-3">
								<label class="text-label">Alíquota PIS ST (%)</label>	
								<input type="text" name="pPISST"  id="pPISST" value="{{$natureza->pPISST ?? old('pPISST') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-2 mb-3">
								<label class="text-label">Valor Alíquota ST (R$)</label>	
								<input type="text" name="vAliqProd_pisst"  id="vAliqProd_pisst" value="{{$natureza->vAliqProd_pisst ?? old('vAliqProd_pisst') }}" class="form-campo mascara-float">
						</div>			
									
                       <div class="col-2 mb-3">
								<label class="text-label">pCofinsst %</label>	
								<input type="text" name="pCofinsst"  id="pCofinsst" value="{{$natureza->pCofinsst ?? old('pCofinsst') }}" class="form-campo mascara-float">
						</div>
                       
                       @isset($natureza)
                        <div class="col-12 text-right pb-0 pt-2">
                			<a href="javascript:;" onclick="abrirModal('#formPis')"  class="btn btn-azul d-inline-block"> <i class="fas fa-plus-circle"></i> Inserir Novo </a>
                		</div> 
                	@endisset
          </div> 
     @isset($natureza)             
        <div class="rows">
			<div class="col-12"> 
            <fieldset class="mt-3 mb-0 p-0 border-0">          
                <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Cst</th>
                                    <th align="center">Aliquota</th>
                                    <th align="center">Base</th>
                                    <th align="center">Opções</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($natureza->tributacaoPis as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->cstPis}}</td>
                            		<td align="center">{{$v->aliquota_pis}}</td>
                            		<td align="center">{{$v->base_pis}}</td>
                            		<td align="center" width="400">
                            			<a href="javascript:;" onclick="abriTelaProdutoPis({{$v->id}})" class="btn btn-azul btn-pequeno d-inline-block">Produtos</a>
                            			<a href="javascript:;" onclick="telaEstadoIcms({{$v->id}})" class="btn btn-roxo btn-pequeno d-inline-block">Estados</a>
                            			<a href="" class="btn btn-vermelho btn-pequeno d-inline-block">Excluir</a>
                            			<a href="" class="btn btn-verde btn-pequeno d-inline-block">Editar</a>
                            		</td>
                            	</tr>
                            @endforeach
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
                </div>                     
                   
				
			</div>
	@endisset
</fieldset>
	
		
		</div>
	  </div>    

  <div id="tab-4">
		<div class="p-2 mt-3 px-0">			
				
				<fieldset>
				<legend>COFINS</legend>	
				<div class="rows">
					<div class="col-12 mb-3">
							<label class="text-label">CST</label>
							<select class="form-campo" name="cstCofins" id="cstCofins" >							
								@foreach(ConstanteService::listaCST_PIS_COFINS() as $chave=>$valor)
									<option value="{{$chave}}" {{($natureza->cstCofins ?? null) == $chave ? "selected" : null }}>{{$chave}} - {{$valor}}</option>
								@endforeach
							</select>		
								
						</div>                                    
						<div class="col-2 mb-3">
							<label class="text-label">Modalidade Cofins</label>
							<select class="form-campo" name="tipo_calc_cofins" id="tipo_calc_cofins" >	
								<option value="0" {{ (($natureza->tipo_calc_cofins ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($natureza->tipo_calc_cofins ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($natureza->tipo_calc_cofins ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-2 mb-3">
								<label class="text-label">Alíq. Cofins (%)</label>	
								<input type="text" name="pCofins"  id="pCofins" value="{{$natureza->pCofins ?? old('pCofins') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-2 mb-3">
								<label class="text-label">Alíq. Cofins (R$)</label>	
								<input type="text" name="vAliqProd_cofins"  id="vAliqProd_cofins" value="{{$natureza->vAliqProd_cofins?? old('vAliqProd_cofins') }}" class="form-campo mascara-float">
						</div>			
						
						
						<div class="col-2 mb-3">
							<label class="text-label">Modalidade Cofins ST</label>
							<select class="form-campo" name="tipo_calc_cofinsst" id="tipo_calc_cofinsst"  >	
								<option value="0" {{ (($natureza->tipo_calc_cofins ?? null) == "0") ? "selected" : null }}>Selecione</option>
                                <option value="1" {{ (($natureza->tipo_calc_cofins ?? null) == "1") ? "selected" : null }}>Porcentagem</option>                                                 
                                <option value="2" {{ (($natureza->tipo_calc_cofins ?? null) == "2") ? "selected" : null }}>Em valor</option>
							</select>	
						</div>
						                                   
						<div class="col-2 mb-3">
								<label class="text-label">Alíq. Cofins ST (%)</label>	
								<input type="text" name="pCofins"  id="pCofinsst" value="{{$natureza->pCofinsst ?? old('pCofinsst') }}" class="form-campo mascara-float">
						</div>	
						
						<div class="col-2 mb-3">
								<label class="text-label">Alíq. Cofins ST (R$)</label>	
								<input type="text" name="vAliqProd_cofinsst"  id="vAliqProd_cofinsst" value="{{$natureza->vAliqProd_cofinsst?? old('vAliqProd_cofinsst') }}" class="form-campo mascara-float">
						</div>	
						
						
                       @isset($natureza)
                        <div class="col-12 text-right pb-0 pt-2">
                			<a href="javascript:;" onclick="abrirModal('#formCofins')"  class="btn btn-azul d-inline-block"> <i class="fas fa-plus-circle"></i> Inserir Novo </a>
                		</div>  
                	@endisset
            </div>  
    @isset($natureza)         
         <div class="rows">
			<div class="col-12"> 
            <fieldset class="mt-3 mb-0 p-0 border-0" >              
                <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" id="" width="100%">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Cst</th>
                                    <th align="center">Aliquota</th>
                                    <th align="center">Base</th>
                                    <th align="center" width="400">Opções</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body">
                            @foreach($natureza->tributacaoPis as $v)
                            	<tr>
                            		<td align="center">{{$v->id}}</td>
                            		<td align="center">{{$v->cstPis}}</td>
                            		<td align="center">{{$v->aliquota_pis}}</td>
                            		<td align="center">{{$v->base_pis}}</td>
                            		<td align="center">
                            			<a href="javascript:;" onclick="abriTelaProdutoCofins({{$v->id}})" class="btn btn-azul btn-pequeno d-inline-block">Produtos</a>
                            			<a href="javascript:;" onclick="telaEstadoIcms({{$v->id}})" class="btn btn-roxo btn-pequeno d-inline-block">Estados</a>
                            			<a href="" class="btn btn-vermelho btn-pequeno d-inline-block">Excluir</a>
                            			<a href="" class="btn btn-verde btn-pequeno d-inline-block">Editar</a>
                            		</td>
                            	</tr>
                            @endforeach
							</tbody>
                            </table>
								
                   </div>

                </fieldset>
                </div>                     
             </div>
      @endisset
</fieldset>
	
		
		</div>
	  </div> 	  
         
 </div>
 
    <div class="p-2 mt-0">	
		<div class="rows">         	    
                 <div class="col-12 mb-3">
				 <fieldset>
						<legend>Informações complementares</legend>	
						<textarea rows="5"  name="obs" class="form-campo">{{isset($natureza->descricao) ?? old('numero_serie_nfe') }}</textarea>
					</fieldset>
				</div>
				<div class="col-12 mb-3">
				 <fieldset>
						<legend>Informações adicionais de interesse do fisco</legend>	
						<textarea rows="5"  name="infAdFisco" class="form-campo">{{isset($natureza->descricao) ?? old('numero_serie_nfe') }}</textarea>
					</fieldset>
				</div>
			</div>
		</div>		
		
		<div class="col-12 text-center pb-4">
			<input type="hidden" id="natureza_operacao_id"  value="{{$natureza->id ?? null}}">   
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
</div>



@include("Admin.Configuracao.NaturezaOperacao.modalIcms")
@include("Admin.Configuracao.NaturezaOperacao.modalIpi")
@include("Admin.Configuracao.NaturezaOperacao.modalPis")
@include("Admin.Configuracao.NaturezaOperacao.modalCofins")

@include("Admin.Configuracao.NaturezaOperacao.modalProdutoIcms")

<script>
	function abriTelaProdutoIcms(id){
		$("#tributacao_id").val(id);
		$("#tabela").html('Icms');
		buscarListaProdutoTributacao('Icms', id);
		abrirModal('#telaProduto');
	}
	
	function abriTelaProdutoIpi(id){
		$("#tributacao_id").val(id);
		$("#tabela").html('Ipi');	
		buscarListaProdutoTributacao('Ipi', id);
		abrirModal('#telaProduto');
	}
	
	function abriTelaProdutoPis(id){
		$("#tributacao_id").val(id);
		$("#tabela").html('Pis');
		buscarListaProdutoTributacao('Pis', id);
		abrirModal('#telaProduto');
	}
	
	function abriTelaProdutoCofins(id){
		$("#tributacao_id").val(id);
		$("#tabela").html('Cofins');
		buscarListaProdutoTributacao('Cofins', id);
		abrirModal('#telaProduto');
	}
	
	function buscarListaProdutoTributacao(tabela, id){
		$.ajax({
		   url: base_url + "admin/naturezaoperacao/listaProdutoTributacao/" + tabela + "/" + id,
		   type: "GET",
		   dataType: "json",
		   data:{},
			 success: function(data){
				 lista_produto_tributacao(data.retorno);
			 }
			
		});
	}

</script>
@endsection