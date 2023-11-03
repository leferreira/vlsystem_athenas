<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Cadastrar parâmetro</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>                  
 @if(isset($grupoproduto))    
   <form action="{{route('admin.grupoproduto.update', $grupoproduto->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.grupoproduto.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	 
	  <div id="tab-1">
		<fieldset class="p-2 mt-4">
				<legend class="h5">Configurações Gerais</legend>				
				
				<div class="rows">									
					<div class="col-4 mb-3">
							<label class="text-label">Descrição</label>	
							<input type="text" name="nome" id="nome"  value="{{isset($grupoproduto->nome) ? $grupoproduto->nome : old('nome') }}" class="form-campo">
					</div>                                    
					<div class="col-2 mb-3">
							<label class="text-label">NCM</label>	
							<input type="text" name="ncm"  id="ncm"  value="{{isset($grupoproduto->ncm) ? $grupoproduto->ncm : old('ncm') }}" class="form-campo">
					</div>	
					<div class="col-3 mb-3">
                        <label class="text-label">Tipo de Produto</label>	
                        <select class="form-campo" name="tipo_produto">
                        	@foreach(ConstanteService::tipo_produto() as $ch=>$valor)
                        		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                        	@endforeach
                        </select>
                     </div>
                     
                     <div class="col-3 mb-3">
                        <label class="text-label">Origem</label>	
                        <select class="form-campo" name="tipo_produto">
                        	@foreach(ConstanteService::listaOrigem() as $ch=>$valor)
                        		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                        	@endforeach
                        </select>
                     </div>
             			
									
			</div>
		</fieldset>	  
		
		<fieldset class="p-2 mt-4">									
        <legend class="h5">Tributação ICMS para o PDV</legend>										
        <div class="rows">	
             <div class="col-2 mb-3">
                <label class="text-label">NFC-e</label>	
                <select class="form-campo" name="nfce">
                	<option value=''>Não definido</option>
                	@foreach(ConstanteService::listaCstNfce() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                	@endforeach
                </select>
             </div>
             <div class="col-2 mb-3">
					<label class="text-label">% ICMS</label>	
					<input type="text" name="nfce_icms"  id="nfce_icms"  value="{{isset($grupoproduto->nfce_icms) ? $grupoproduto->nfce_icms : old('nfce_icms') }}" class="form-campo">
			</div>
			 <div class="col-2 mb-3">
					<label class="text-label">% FCP</label>	
					<input type="text" name="nfce_fcp"  id="nfce_fcp"  value="{{isset($grupoproduto->nfce_fcp) ? $grupoproduto->nfce_fcp : old('nfce_fcp') }}" class="form-campo">
			</div>
			 <div class="col-2 mb-3">
					<label class="text-label">% Red. ICMS</label>	
					<input type="text" name="nfce_redicms"  id="nfce_redicms"  value="{{isset($grupoproduto->nfce_redicms) ? $grupoproduto->nfce_redicms : old('nfce_redicms') }}" class="form-campo">
			</div>
			 <div class="col-2 mb-3">
					<label class="text-label">Benficio Fiscal</label>	
					<input type="text" name="nfce_benefiscal"  id="nfce_benefiscal"  value="{{isset($grupoproduto->nfce_benefiscal) ? $grupoproduto->nfce_benefiscal : old('nfce_benefiscal') }}" class="form-campo">
			</div>
			
			<div class="col-2 mb-3">
                <label class="text-label">Motivo Desoneração</label>	
                <select class="form-campo" name="nfce_mot_deson">
                	<option value=''>Não definido</option>
                	@foreach(ConstanteService::motivoDesoneracao() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$valor}}</option>
                	@endforeach
                </select>
             </div>
             
           </div>
                            	 
        </fieldset>
		
		
		<fieldset class="p-2 mt-4">									
        <legend class="h5">Tributação ICMS para a NF-e</legend>										
        <div class="rows">	
             <div class="col-4 mb-3">
                <label class="text-label">Situação tributária Saída</label>	
                <select class="form-campo" name="nfe_st_saida">
                	<option value=''>--Selecione--</option>
                	@foreach(ConstanteService::listaCST() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                	@endforeach
                </select>
             </div>
             
             <div class="col-4 mb-3">
                <label class="text-label">Situação tributária Entrada</label>	
                <select class="form-campo" name="nfe_st_entrada">
                	<option value=''>--Selecione--</option>
                	@foreach(ConstanteService::listaCST() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                	@endforeach
                </select>
             </div>
             
             <div class="col-2 mb-3">
					<label class="text-label">% ICMS</label>	
					<input type="text" name="nfe_icms"  id="nfe_icms"  value="{{isset($grupoproduto->nfe_icms) ? $grupoproduto->nfe_icms : old('nfe_icms') }}" class="form-campo">
			</div>
			
			 <div class="col-2 mb-3">
					<label class="text-label">% Red. ICMS</label>	
					<input type="text" name="nfe_redicms"  id="nfe_redicms"  value="{{isset($grupoproduto->nfe_redicms) ? $grupoproduto->nfe_redicms : old('nfe_redicms') }}" class="form-campo">
			</div>
			 <div class="col-2 mb-3">
					<label class="text-label">% FCP</label>	
					<input type="text" name="nfe_fcp"  id="nfe_fcp"  value="{{isset($grupoproduto->nfe_fcp) ? $grupoproduto->nfe_fcp : old('nfe_fcp') }}" class="form-campo">
			</div>
			 <div class="col-2 mb-3">
					<label class="text-label">Benficio Fiscal</label>	
					<input type="text" name="nfe_benefiscal"  id="nfe_benefiscal"  value="{{isset($grupoproduto->nfe_benefiscal) ? $grupoproduto->nfe_benefiscal : old('nfe_benefiscal') }}" class="form-campo">
			</div>
			
			<div class="col-3 mb-3">
                <label class="text-label">Motivo Desoneração</label>	
                <select class="form-campo" name="nfe_mot_deson">
                	<option value=''>Não definido</option>
                	@foreach(ConstanteService::motivoDesoneracao() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$valor}}</option>
                	@endforeach
                </select>
             </div>
             
           </div>
                            	 
        </fieldset>
        
        
        <fieldset class="p-2 mt-4">									
        <legend class="h5">MVA</legend>										
        <div class="rows">	
             <div class="col-4 mb-3">
                <label class="text-label">Modalidade BC do ICMS ST</label>	
                <select class="form-campo" name="mva_modbc_icmsst">
                	<option value=''>--Selecione--</option>
                	@foreach(ConstanteService::listaModalidade() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                	@endforeach
                </select>
             </div>
             
             <div class="col-2 mb-3">
					<label class="text-label">% MVA ou Preço de pauta</label>	
					<input type="text" name="mva"  id="mva"  value="{{isset($grupoproduto->mva) ? $grupoproduto->mva : old('mva') }}" class="form-campo">
			</div>
			
			<div class="col-2 mb-3">
					<label class="text-label">% Redução de MVA</label>	
					<input type="text" name="mva_reducao"  id="mva_reducao"  value="{{isset($grupoproduto->mva_reducao) ? $grupoproduto->mva_reducao : old('mva_reducao') }}" class="form-campo">
			</div>
						
			 <div class="col-2 mb-3">
					<label class="text-label">Cest</label>	
					<input type="text" name="cest"  id="cest"  value="{{isset($grupoproduto->cest) ? $grupoproduto->cest : old('cest') }}" class="form-campo">
			</div>
			
             
           </div>
                            	 
        </fieldset>
        
         <fieldset class="p-2 mt-4">									
        <legend class="h5">IPI</legend>										
        <div class="rows">	
             <div class="col-4 mb-3">
                <label class="text-label">Cst IPI de Saída</label>	
                <select class="form-campo" name="ipi_cst_saida">
                	<option value=''>--Selecione--</option>
                	@foreach(ConstanteService::listaCST_IPI() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                	@endforeach
                </select>
             </div>
             
             <div class="col-4 mb-3">
                <label class="text-label">Modo de Cálculo</label>	
                <select class="form-campo" name="ipi_mod_calc_saida">
                	<option value=''>--Selecione--</option>
                	<option value='1'>Alíquota</option>
                	<option value='2'>Valor Por Unidade</option>
                </select>
             </div>
             
             
             <div class="col-2 mb-3">
					<label class="text-label">% IPI</label>	
					<input type="text" name="ipi_entrada"  id="ipi_entrada"  value="{{isset($grupoproduto->ipi_entrada) ? $grupoproduto->ipi_entrada : old('ipi_entrada') }}" class="form-campo">
			</div>
		
		
		<div class="col-4 mb-3">
                <label class="text-label">Cst IPI de Entrada</label>	
                <select class="form-campo" name="ipi_cst_entrada">
                	<option value=''>--Selecione--</option>
                	@foreach(ConstanteService::listaCST_IPI_ENTRADA() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                	@endforeach
                </select>
             </div>
             
             <div class="col-4 mb-3">
                <label class="text-label">Modo de Cálculo</label>	
                <select class="form-campo" name="ipi_mod_calc_entrada">
                	<option value=''>--Selecione--</option>
                	<option value='1'>Alíquota</option>
                	<option value='2'>Valor Por Unidade</option>
                </select>
             </div>
             
             
             <div class="col-2 mb-3">
					<label class="text-label">% IPI</label>	
					<input type="text" name="ipi_saida"  id="ipi_saida"  value="{{isset($grupoproduto->ipi_saida) ? $grupoproduto->ipi_saida : old('ipi_saida') }}" class="form-campo">
			</div>
			
			
             
           </div>
                            	 
        </fieldset>
        
        
         <fieldset class="p-2 mt-4">									
        <legend class="h5">CST PIS / COFINS</legend>										
        <div class="rows">	
             <div class="col-6 mb-3">
                <label class="text-label">Cst Saída</label>	
                <select class="form-campo" name="cst_pis_confins_saida">
                	<option value=''>--Selecione--</option>
                	@foreach(ConstanteService::listaCST_PIS_COFINS() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$ch}} - {{$valor}}</option>
                	@endforeach
                </select>
             </div>
             
             
             <div class="col-3 mb-3">
					<label class="text-label">% PIS</label>	
					<input type="text" name="pis_saida"  id="pis_saida"  value="{{isset($grupoproduto->pis_saida) ? $grupoproduto->pis_saida : old('pis_saida') }}" class="form-campo">
			</div>
			
			<div class="col-3 mb-3">
					<label class="text-label">% COFINS</label>	
					<input type="text" name="cofins_saida"  id="cofins_saida"  value="{{isset($grupoproduto->cofins_saida) ? $grupoproduto->cofins_saida : old('cofins_saida') }}" class="form-campo">
			</div>
		
		
		<div class="col-6 mb-3">
                <label class="text-label">Cst Entrada</label>	
                <select class="form-campo" name="cst_pis_confins_entrada">
                	<option value=''>--Selecione--</option>
                	@foreach(ConstanteService::listaCST_PIS_COFINS_ENTRADA() as $ch=>$valor)
                		<option value='{{$ch}}'>{{$valor}}</option>
                	@endforeach
                </select>
             </div>
             
             <div class="col-3 mb-3">
					<label class="text-label">% PIS</label>	
					<input type="text" name="pis_entrada"  id="pis_entrada"  value="{{isset($grupoproduto->pis_entrada) ? $grupoproduto->pis_entrada : old('pis_entrada') }}" class="form-campo">
			</div>
			
			<div class="col-3 mb-3">
					<label class="text-label">% COFINS</label>	
					<input type="text" name="cofins_entrada"  id="cofins_entrada"  value="{{isset($grupoproduto->cofins_entrada) ? $grupoproduto->cofins_entrada : old('cofins_entrada') }}" class="form-campo">
			</div>
			
             
           </div>
                            	 
        </fieldset>
        
        
		<div class="col-12 text-center pb-4 mt-4">
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
        </div>
	  </div>
         
 </div>
	  </div>
	
</form>
</div>
@endsection