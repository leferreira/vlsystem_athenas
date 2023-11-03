<?php
use App\Service\ConstanteService;
?>
<form id="frmCadTributacao" method="post">

<div class="window medio" id="modalTributacaoSimples">

	<div class="p-2 px-4">
			<span class="d-block h3 border-bottom fw-700">Tributação Simples Nacional</span>
		<div class="rows">
						<div class="col-8 mb-3">
    						<label class="text-label">Descrição</label>	
    						<input type="text" name="descricao" id="descricao"  class="form-campo">
        				</div>
        				<div class="col-4 mb-3">
								<label class="text-label">CFOP </label>	
								<input type="text" name="cfop" maxlength="4"  id="cfop" value="{{$natureza->cfop ?? old('cfop') }}" class="form-campo">
						</div>						
						<div class="col-6 mb-3">
							<label class="text-label">CST ICMS</label>
							<select class="form-campo" name="cstICMS" id="cstICMS"  >							
								@foreach($lista_cstIcms as $c)
									<option value="{{$c->cst}}" {{($natureza->cstICMS ?? null) == $c->cst ? "selected" : null }}>{{$c->descricao}}</option>
								@endforeach
							</select>									
						</div>                                     
										
						<div class="col-6 mb-3">
							<label class="text-label">CST IPI</label>
							<select class="form-campo" name="cstIPI" id="cstIPI" >							
								@foreach($lista_cst_ipi as $l)
									<option value="{{$l->cst}}" {{($natureza->cstIPI ?? null) == $l->cst ? "selected" : null }}>{{$l->descricao}}</option>
								@endforeach
								
							</select>	
						</div>
						
						<div class="col-6 mb-3">
							<label class="text-label">CST Pis</label>
							<select class="form-campo" name="cstPIS" id="cstPIS" >							
								@foreach($lista_cstPis as $l)
									<option value="{{$l->cst}}" {{($natureza->cstPIS ?? null) == $l->cst ? "selected" : null }}>{{$l->descricao}}</option>
								@endforeach
								<option value="99">99 - Outras Operações</option>
							</select>	
						</div> 
						<div class="col-6 mb-3">
							<label class="text-label">CST Cofins</label>
							<select class="form-campo" name="cstCOFINS" id="cstCOFINS">							
								@foreach($lista_cstCofins as $l)
									<option value="{{$l->cst}}" {{($natureza->cstCOFINS ?? null) == $l->cst ? "selected" : null }}>{{$l->descricao}}</option>
								@endforeach
								<option value="99">99 -Outras Operações</option>
							</select>		
								
						</div>		
						
						<div class="col-4 mb-3" >
								<label class="text-label">Modalidade BC</label>	
								<select class="form-campo" name="modBC" id="modBC" >							
									@foreach(ConstanteService::listaModalidade() as $chave=>$valor)
    									<option value="{{$chave}}" {{($nfeItem->modBC ?? null) == $chave ? "selected" : null }}>{{$chave}} -  {{$valor}}</option>
    								@endforeach							
    							</select>							
						</div>
						
						<div class="col-4 mb-3" >
								<label class="text-label">Modalidade BCST</label>	
								
								<select class="form-campo" name="modBCST" id="modBCST" >	
								<option value="">Selecione um valor</option>						
									@foreach(ConstanteService::listaModalidadeSt() as $chave=>$valor)
    									<option value="{{$chave}}" {{($nfeItem->modBC ?? null) == $chave ? "selected" : null }}>{{$chave}} -  {{$valor}}</option>
    								@endforeach							
    							</select>							
						</div>
						
						<div class="col-3 mb-3" id="divPFCP">
								<label class="text-label">Alíquota FCP</label>	
								<input type="text" name="pFCP"   id="pFCP" value="{{$nfeItem->pFCP ?? old('pFCP') }}" class="form-campo mascara-float ">
						</div>
			 				
			         
         </div>
			
         </div>
		 <div class="tfooter end">
			<a href="" class="btn btn-neutro fechar">Fechar</a>	
			<input type="hidden" name="natureza_operacao_id" id="natureza_operacao_id"  value="{{$natureza->id ?? null}}"> 	
			<input type="hidden"  id="id"  name="id"> 				
			<input type="button" id="btnInserirTributacao" value="Salvar" class="btn btn-azul">  
		 </div>
	</div>
</form>