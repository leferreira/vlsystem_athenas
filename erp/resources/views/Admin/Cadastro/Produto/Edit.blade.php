<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
	<span class="d-flex center-middle h5 mb-0"><i class="far fa-list-alt mr-1"></i> Cadastrar produto </span>
	<div>
		<!--<a href="javascript:;" onclick="abrirModal('#add')" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Cadastrar categoria</a>-->
		<a href="{{route('admin.produto.index')}}" class="btn btn-azul btn-pequeno d-inline-block" title="Volta"><i class="fas fa-arrow-left"></i></a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
		
	</div>
</div>                      
 @if(isset($produto))    
   <form action="{{route('admin.produto.update', $produto->id)}}" method="POST" enctype="multipart/form-data">
   <input name="_method" type="hidden" value="PUT"/>   
 @else                       
	<form action="{{route('admin.produto.store')}}" method="Post" enctype="multipart/form-data">
@endif
	@csrf
   <div id="tab">

	  <?php 
	       $id_cat             = ($produto->categoria_id) ?? null ;
	       $controlar_estoque  = ($produto->controlar_estoque) ?? "S" ;
	       $produto_loja       = ($produto->produto_loja) ?? "N" ;
	       $produto_delivery   = ($produto->produto_delivery) ?? "N" ;
	       $destaque           = ($produto->destaque) ?? null ;
	     ?>
		<input type="hidden" id="produto_id" value="{{$produto->id}}" >		     
	  <div>
		<div class="p-2 pt-4">
			
			
		<ul>
			<li><a href="#tab-1">Dados Gerais</a></li>
			<li><a href="#tab-2">Dados Fiscais</a></li>
			<li><a href="#tab-3">Dados para loja</a></li>
			<li><a href="#tab-4">Composição</a></li>
			<li><a href="#tab-5">Produtos Semelhantes</a></li>
			<li><a href="#tab-6">Grade</a></li>
			<li><a href="#tab-7">Imagens</a></li>
			<li><a href="#tab-8">Tabela de Preço</a></li>
			<li><a href="#tab-9">Fornecedores</a></li>
		
		</ul>	
		
		<div id="tab-1" class="py-4">								
			<div class="rows">
        <div class="col-12">
        	<small class="d-block text-right text-vermelho">(*) Campos obrigatórios</small>
			<fieldset>
				<legend>Informações básicas</legend>
				<div class="rows">	
						 <div class="col-3 mb-3 text-center">
							<label class="banner-thumb">
							<?php 
							     $imagem = ($produto->imagem) ?? "assets/admin/img/img-prod-loja.svg";
							?>								
							<img src="{{asset($imagem)}}" class="img-fluido" id="imgUp">								
							
							<input type="file" name="file" id="img_perfil" onChange="valida_imagem('img_perfil','imgUp')" class="d-none">

							<span>Carregar imagem</span>
							</label>
						</div>
                        <div class="col-9 px-2">
                           <div class="rows">
                          
								
                                <div class="col-6 mb-3">
                                        <label class="text-label">Nome do produto<span class="text-vermelho">*</span></label>
                                        <input type="text" id="nome" name="nome" required maxlength="100" value="{{isset($produto->nome) ? $produto->nome : old('nome')}}"   class="form-campo">
                                </div> 
                                <div class="col-3 mb-3">
                                        <label class="text-label">Código (SKU)<span class="text-vermelho">*</span></label>
                                        <input type="text" name="sku"   required value="{{isset($produto->sku) ? $produto->sku : old('sku')}}"  class="form-campo">
                                </div>
                                                        
                             	 <div class="col-3 mb-3">
                                        <label class="text-label">Código Barra/GTIN/EANTrib</label>
                                        <input type="text" name="gtin" value="{{isset($produto->gtin) ? $produto->gtin : old('gtin')}}"  class="form-campo">
                                </div>
                                
                                <div class="col-3 mb-3">
                                        <label class="text-label">Código Barra(interno)</label>
                                        <div class="group-btn">
                                        	<input type="text" required name="codigo_barra" id="codigo_barra" value="{{isset($produto->codigo_barra) ? $produto->codigo_barra : old('codigo_barra')}}"  class="form-campo">
                                        <a href="javascript:;" onclick="gerarBarras()" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
									</div>
                                </div>
                                
                               <div class="col-3 mb-3">
                                        <label class="text-label">NCM<span class="text-vermelho">*</span></label>
                                        <input type="text" name="ncm" data-mask="0000.00.00" maxlength="10" required value="{{isset($produto->ncm) ? $produto->ncm : old('ncm')}}"  class="form-campo">
                                </div>
                                <div class="col-3 mb-3">
                                        <label class="text-label">Cest</label>
                                        <input type="text" name="cest" maxlength="7"  value="{{$produto->cest ?? old('cest')}}"  class="form-campo ">
                                </div>
                               
                                <div class="col-3 mb-3">
                                        <label class="text-label">Origem </label>
                                        <select class="form-campo" name="origem">
                                            @foreach(ConstanteService::listaOrigem() as $chave=>$valor)
                                          	<option value="{{$chave}}">{{$chave}} - {{$valor}}</option>
                                          @endforeach 
									   </select>
                                </div> 
                                 <div class="col-2 mb-3">
                                        <label class="text-label">Unidade </label>
                                        <select class="form-campo" name="unidade" id="unidade" required onchange="mostrarUnidade()">
                                        	<option value="">Selecione</option>
                                            @foreach($unidades as $unidade)
                                          	<option value="{{$unidade->unidade}}" {{($produto->unidade ?? null) == $unidade->unidade ? 'selected' : ''}}>{{$unidade->unidade}}</option>
                                          @endforeach 
									   </select>
                                </div> 
                               
                             	 
                                <div class="col-4 mb-3">
                                        <label class="text-label">Categoria Principal<span class="text-vermelho">*</span></label>
									<div class="group-btn">
                                        <input type="text"  id="desc_categoria" value="{{$produto->categoria->categoria ?? null}}" class="form-campo">
                                        <input type="hidden" name="categoria_id"   id="categoria_id" value="{{isset($produto->categoria_id) ? $produto->categoria_id : old('categoria_id')}}">
										<a href="javascript:;" onclick="abrirModalCadastroCategoria(1)" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
									</div> 
                                </div>
                                <div class="col-3 mb-3">
                                    <label class="text-label">SubCategoria 1 </label>
                                        <select class="form-campo" id="subcategoria_id"  name="subcategoria_id" onchange="listarSubSubcategoriaPelaSubCategoria(0)">
                                        	<option value="">Selecione uma opção</option>
                                        	@foreach($subcategorias as $subcategoria)
            				  					<option value='{{$subcategoria->id}}' {{($produto->subcategoria_id ?? null)== $subcategoria->id ? 'selected': '' }} >{{$subcategoria->subcategoria}}</option>
            				  				@endforeach	
                                        </select>
                                </div>
                                
                                <div class="col-3 mb-3">
                                    <label class="text-label">SubCategoria 2</label>
                                        <select class="form-campo" name="subsubcategoria_id" id="subsubcategoria_id" >
                                        	<option value="">Selecione uma opção</option>
                                        	@foreach($subsubcategorias as $subsubcategoria)
            				  					<option value='{{$subsubcategoria->id}}' {{($produto->subsubcategoria_id ?? null)== $subsubcategoria->id ? 'selected': '' }} >{{$subsubcategoria->subsubcategoria}}</option>
            				  				@endforeach	
                                        </select>
                                </div>
                                
                                
                                
                                 
                                
                                   					           					
            					                
                                <div class="col-2 mb-3">
                                        <label class="text-label">Estoque Ini</label>
                                        <input type="text" name="estoque_inicial"   value="{{isset($produto->estoque_inicial) ? $produto->estoque_inicial : old('estoque_inicial')}}"  class="form-campo mascara-float">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Estoque Máx</label>
                                        <input type="text" name="estoque_maximo"  value="{{isset($produto->estoque_maximo) ? $produto->estoque_maximo : old('estoque_maximo')}}"  class="form-campo mascara-float">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Estoque Mín</label>
                                        <input type="text" name="estoque_minimo"  value="{{isset($produto->estoque_minimo) ? $produto->estoque_minimo : old('estoque_minimo')}}"  class="form-campo mascara-float">
                                </div>
                                
                                <div class="col-3 mb-3">
                                	<label class="text-label">Preço Custo<span class="text-vermelho">*</span></label>
                                	<input type="text" name="valor_custo" id="valor_custo" onkeyup="calcularPreco()" required value="{{isset($produto->valor_custo) ? $produto->valor_custo : old('valor_custo')}}"  class="form-campo  mascara-float">
                                </div>
                                
                                <div class="col-3 mb-3">
                                	<label class="text-label">%Margem Lucro<span class="text-vermelho">*</span></label>
                                	<input type="text" name="margem_lucro" id="margem_lucro" onkeyup="calcularPreco()" required value="{{isset($produto->margem_lucro) ? $produto->margem_lucro : old('margem_lucro')}}"  class="form-campo  mascara-float">
                                </div>
        				   
        				   		<div class="col-3 mb-3">
                                        <label class="text-label">Preço Venda<span class="text-vermelho">*</span></label>
                                        <input type="text" name="valor_venda" id="valor_venda" onkeyup="calcularPreco()" required value="{{isset($produto->valor_venda) ? $produto->valor_venda : old('valor_venda')}}"  class="form-campo  mascara-float">
                                </div>
                                <div class="col-3 mb-3">
                                        <label class="text-label">Preço Alto (loja)</label>
                                        <input type="text" name="valor_maior" id="valor_maior"  required value="{{isset($produto->valor_maior) ? $produto->valor_maior : old('valor_maior')}}"  class="form-campo  mascara-float">
                                </div>
                                
                                <div class="col-3 mb-3">
                                        <label class="text-label">Preço Venda Atacado</label>
                                        <input type="text" name="valor_venda_atacado" id="valor_venda_atacado"   value="{{isset($produto->valor_venda_atacado) ? $produto->valor_venda_atacado : old('valor_venda_atacado')}}"  class="form-campo  mascara-float">
                                </div>
                                
                                <div class="col-3 mb-3">
                                        <label class="text-label">A partir de (qtde) </label>
                                        <input type="text" name="valor_atacado_apartir" id="valor_atacado_apartir"   value="{{isset($produto->valor_atacado_apartir) ? $produto->valor_atacado_apartir : old('valor_atacado_apartir')}}"  class="form-campo  mascara-float">
                                </div>
                                
                                <div class="col-3 mb-3">
                                        <label class="text-label">Comissão (%) </label>
                                        <input type="text" name="comissao" id="comissao"   value="{{isset($produto->comissao) ? $produto->comissao : old('comissao')}}"  class="form-campo  mascara-float">
                                </div>
                                
                                <div class="col-3 mb-3">
                                        <label class="text-label">Validade </label>
                                        <input type="date" name="validade" id="validade"   value="{{isset($produto->validade) ? $produto->validade : old('validade')}}"  class="form-campo ">
                                </div>
                                
                                <div class="col-3 mb-3">
                                        <label class="text-label">Última Compra </label>
                                        <input type="date" name="ultima_compra" id="ultima_compra"   value="{{isset($produto->ultima_compra) ? $produto->ultima_compra : old('ultima_compra')}}"  class="form-campo ">
                                </div>
                                
                                <!--  
                              	<div class="col-4 mb-3">
                                    <label class="text-label">Localização</label>
                                    <div class="group-btn">
                                        <select class="form-campo" name="localizacao_id" id="localizacao_id" >
                                        	<option value="">Selecione uma opção</option>
                                        	@foreach($localizacoes as $localizacao)
            				  					<option value='{{$localizacao->id}}' {{($produto->localizacao_id ?? null)== $localizacao->id ? 'selected': '' }} >{{$localizacao->localizacao}}</option>
            				  				@endforeach	
                                        </select>
                                    <a href="javascript:;" onclick="abrirModal('#modalCadLocalizacao')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova localizacao"></a>
									</div>
                                </div>
                                -->
                          	 	<div class="col-3 mb-3">				   
            						<label class="text-label text-vermelho">Vender na Loja Virtual </label>
									<div class="radio d-flex">
										 <label class="d-block"><input type="radio" name="produto_loja" {{($produto_loja == 'S') ? 'checked' : ''}} value="S" > Sim</label>
										 <label class="d-block ml-3"><input type="radio" name="produto_loja" {{($produto_loja == 'N') ? 'checked' : ''}} value = "N"> Não</label>
									</div>            						
            					</div>
                                
                                <div class="col-3 mb-3">				   
            						<label class="text-label text-vermelho">Vender na Loja Virtual </label>
									<div class="radio d-flex">
										 <label class="d-block"><input type="radio" name="produto_delivery" {{($produto_delivery == 'S') ? 'checked' : ''}} value="S" > Sim</label>
										 <label class="d-block ml-3"><input type="radio" name="produto_delivery" {{($produto_delivery == 'N') ? 'checked' : ''}} value = "N"> Não</label>
									</div>            						
            					</div>
            				                                
                                
                        </div>
                        </div>
			</div>
			</fieldset>
        	<fieldset>
			<legend>Fragmentação</legend>	
				   <div class="rows">				   
				   		<div class="center-middle col-3 d-flex justify-content-center mb-3">
							<div class="width-100 border p-3 radius-4">
								<strong class="text-label text-right h5 mb-0">1 <span id="txt_unidade" class="text-vermelho">{{$produto->unidade ?? old('unidade')}}</span> =  </strong>
							</div>
					</div>
                        
				   
				   		<div class="col-2 mb-3">
                                <label class="text-label">Quantidade</label>
                                <input type="text" name="fragmentacao_qtde"  value="{{$produto->fragmentacao_qtde ?? old('fragmentacao_qtde')}}"  class="form-campo  mascara-float">
                        </div>                        
                        
                        <div class="col-4 mb-3">
                                <label class="text-label">Unidade </label>
                                <select class="form-campo" name="fragmentacao_unidade">
                                <option value="">Selecione</option>
                                    @foreach($unidades as $unidade)
                                  	<option value="{{$unidade->unidade}}" {{($produto->fragmentacao_unidade ?? null) == $unidade->unidade ? 'selected' : ''}}>{{$unidade->unidade}}</option>
                                  @endforeach 
							   </select>
                        </div>
                        
                        <div class="col-2 mb-3">
                                <label class="text-label">Valor da Venda</label>
                                <input type="text" name="fragmentacao_valor"  value="{{ $produto->fragmentacao_valor ?? old('fragmentacao_valor')}}"  class="form-campo  mascara-float">
                        </div> 				                                  
						                            
				</div>
			</fieldset>
            </div>
                  
         </div>
         </div>
         
         <div id="tab-2" class="py-4">	
             <div class="rows">
            <div class="col-12">
            	<fieldset>
    			<legend>Dados Fiscais</legend>	
    				   <div class="rows">	                        
    				   		<div class="col-2 mb-3">
    								<label class="text-label">Icms</label>
    								<select class="form-campo" name="tributado_icms">                                            
    									<option value="S" {{($produto->tributado_icms ?? null) == 'S' ? 'selected' : ''}} >Tributado</option>
    									<option value="N" {{($produto->tributado_icms ?? null) == 'N' ? 'selected' : ''}}>Isento</option>                                          
    							   </select>
    						</div>
    						
    						<div class="col-2 mb-3">
    								<label class="text-label">IPI</label>
    								<select class="form-campo" name="tributado_ipi">                                            
    									<option value="S" {{($produto->tributado_ipi ?? null) == 'S' ? 'selected' : ''}} >Tributado</option>
    									<option value="N" {{($produto->tributado_ipi ?? null) == 'N' ? 'selected' : ''}}>Isento</option>                                            
    							   </select>
    						</div>
    						
    						<div class="col-2 mb-3">
    								<label class="text-label">PIS</label>
    								<select class="form-campo" name="tributado_pis">                                            
    									<option value="S" {{($produto->tributado_pis ?? null) == 'S' ? 'selected' : ''}} >Tributado</option>
    									<option value="N" {{($produto->tributado_pis ?? null) == 'N' ? 'selected' : ''}} >Isento</option>                                            
    							   </select>
    						</div>
    						<div class="col-2 mb-3">
    								<label class="text-label">COFINS</label>
    								<select class="form-campo" name="tributado_cofins">                                            
    									<option value="S" {{($produto->tributado_cofins ?? null) == 'S' ? 'selected' : ''}} >Tributado</option>
    									<option value="N" {{($produto->tributado_cofins ?? null) == 'N' ? 'selected' : ''}} >Isento</option>                                            
    							   </select>
    						</div>
    						<div class="col-2 mb-3">
                                    <label class="text-label">ICMS (%)</label>
                                    <input type="text" name="pICMS"  value="{{ $produto->pICMS ?? old('pICMS')}}"  class="form-campo  mascara-float">
                            </div> 
                            <div class="col-2 mb-3">
                                    <label class="text-label">PIS (%)</label>
                                    <input type="text" name="pPIS"  value="{{ $produto->pPIS ?? old('pPIS')}}"  class="form-campo  mascara-float">
                            </div> 
                            <div class="col-2 mb-3">
                                    <label class="text-label">COFINS (%)</label>
                                    <input type="text" name="pCOFINS"  value="{{ $produto->pCOFINS ?? old('pCOFINS')}}"  class="form-campo  mascara-float">
                            </div> 
    						<div class="col-2 mb-3">
                                    <label class="text-label">IPI (%)</label>
                                    <input type="text" name="pIPI"  value="{{ $produto->pIPI ?? old('pIPI')}}"  class="form-campo  mascara-float">
                            </div> 
                            
    						<div class="col-2 mb-3" >
    								<label class="text-label">Red. BC ICMS (%)</label>	
    								<input type="text" name="pRedBC"   id="pRedBC" value="{{$produto->pRedBC ?? old('pRedBC') }}" class="form-campo mascara-float ">
    						</div>
    						
    						<div class="col-2 mb-3" >
    								<label class="text-label">Red. BC ICMSST (%)</label>	
    								<input type="text" name="pRedBCST"   id="pRedBCST" value="{{$produto->pRedBCST ?? old('pRedBCST') }}" class="form-campo mascara-float ">
    						</div>	
    						
    						<div class="col-2 mb-3">
                                    <label class="text-label">MVAST (%)</label>
                                    <input type="text" name="pMVAST"  value="{{ $produto->pMVAST ?? old('pMVAST')}}"  class="form-campo  mascara-float">
                            </div> 
                            
                            
                            <div class="col-3 mb-3" id="divPDif">
        							<label class="text-label">Perc do Diferimento (%)</label>	
        							<input type="text" name="pDif" id="pDif" value="{{$produto->pDif ?? old('pDif') }}"  class="form-campo mascara-float">
        					</div>
						
    				   		                        
                            
                            <div class="col-2 mb-3">
    								<label class="text-label">IndEscala</label>
    								<select class="form-campo" name="indescala">                                            
    									<option value="S" {{($destaque == 'S') ? 'selected' : ''}} >Sim</option>
    									<option value="N" {{($destaque == 'N') ? 'selected' : ''}}>Não</option>                                          
    							   </select>
    						</div>
                           
                           <div class="col-2 mb-3">
                                    <label class="text-label">Cnpj Fabricante</label>
                                    <input type="text" name="cnpjfabricante"  value="{{ $produto->cnpjfabricante ?? old('cnpjfabricante')}}"  class="form-campo  ">
                            </div>
                            
                            <div class="col-2 mb-3">
                                    <label class="text-label">Código Benefício</label>
                                    <input type="text" name="cbenef"  value="{{ $produto->cbenef ?? old('cbenef')}}"  class="form-campo  ">
                            </div>
                            
                            			                                  
    						                            
    				</div>
    			</fieldset>
                </div>
                  
         </div>
      	</div>
         
		
		<div id="tab-3"  class="py-4">									
			<div class="rows">	
				<div class="col-12">        
				<fieldset>
					<legend>Dados para Loja</legend>	
						   <div class="rows">				                                  
								
								<div class="col-2 mb-3">
										<label class="text-label">Largura (10 - 100 cm)</label>
										<input type="text" name="largura" value="{{isset($produto->largura) ? $produto->largura : old('largura')}}"  class="form-campo  mascara-float">
								</div>
								<div class="col-2 mb-3">
										<label class="text-label">Altura(1 - 100 cm)</label>
										<input type="text" name="altura" value="{{isset($produto->altura) ? $produto->altura : old('altura')}}"  class="form-campo  mascara-float">
								</div>
								<div class="col-2 mb-3">
										<label class="text-label">Comprimento(15 - 100 cm)</label>
										<input type="text" name="comprimento" value="{{isset($produto->comprimento) ? $produto->comprimento : old('comprimento')}}"  class="form-campo  mascara-float">
								</div>
								<div class="col-2 mb-3">
										<label class="text-label">Peso Líquido</label>
										<input type="text" name="peso_liquido" value="{{isset($produto->peso_liquido) ? $produto->peso_liquido : old('peso_liquido')}}"  class="form-campo  mascara-float">
								</div>
								<div class="col-2 mb-3">
										<label class="text-label">Peso Bruto</label>
										<input type="text" name="peso_bruto" value="{{isset($produto->peso_bruto) ? $produto->peso_bruto : old('peso_bruto')}}"  class="form-campo mascara-float">
								</div>         
								<div class="col-2 mb-3">
										<label class="text-label">Destaque</label>
										<select class="form-campo" name="destaque">                                            
											<option value="S" {{($destaque == 'S') ? 'selected' : ''}} >Sim</option>
											<option value="N" {{($destaque == 'N') ? 'selected' : ''}}>Não</option>                                          
									   </select>
								</div>
								
								   
								<div class="col-12">
										<label class="text-label">Descrição</label>
										<textarea rows="7" cols="150" name="descricao" class="form-campo">{{isset($produto->descricao) ? $produto->descricao : old('descricao')}}</textarea>
								</div>                            
						</div>
					</fieldset>
				</div>
              
         </div>
		</div>
		
	
		
		
		<div id="tab-4"  class="py-4">									
			<div class="rows">	
				<div class="col-12">        
				   							
			<div class="rows">
                <div class="col-12">
                	<fieldset>
        			<legend>Composição do Produto</legend>	
        			
    				   <div class="rows">                        
    				   		<div class="col-6 mb-3">
                                    <label class="text-label">Produtos</label>
                                    <select id="produto_filho_id"  class="form-campo">
                                        @foreach($produtos as $p)
                                          	<option value="{{$p->id}}" >{{$p->nome}}</option>
                                        @endforeach 
                                    </select>
                            </div>
                            <div class="col-2 mb-3">
									<label class="text-label">Qtde</label>
									<input type="text" id="qtde" value="1"  class="form-campo mascara-float">
							</div>
                            <div class="col-3 mt-1 pt-1"> 
                            	<input type="hidden" id="produto_pai_id" value="{{$produto->id ?? null }}" class="btn btn-azul width-100" />                              
                            	<input type="button" onclick="inserirProdutoComposicao()" value="Inserir Produto" class="btn btn-azul width-100" />                              
                            </div>                                                
    					</div>
    				
        			<div class="rows">
        			<div class="col-12"> 
                    <fieldset class="mt-3 mb-0 p-0 border-0">              
                        <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                            <table cellpadding="0" cellspacing="0" id="" width="100%">
                                    <thead>
                                     <tr>
                                            <th align="center">#</th>
                                            <th align="center">Nome</th>
                                            <th align="center">Qtde</th>
                                            <th align="center">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody class="datatable-body" id="lista_produto_composicao">
                                    @foreach($composicao as $v)
                                    	<tr>
                                    		<td align="center">{{$v->id}}</td>
                                    		<td align="center">{{$v->produtoFilho->nome}}</td>
                                    		<td align="center">{{$v->qtde}}</td>
                                    		
                                    		<td align="center" width="400">                                    			
                                    			<a href="javascript:;" onclick="excluirProdutoComposicao({{$v->id}})" class="btn btn-vermelho btn-pequeno d-inline-block">Excluir</a>
                                    		</td>
                                    	</tr>
                                    @endforeach
        							</tbody>
                                    </table>
        								
                           </div>
        
                        </fieldset>
                        </div>
                </div>
        			</fieldset>
                    </div>                  
         	</div>
         
				</div>
              
         </div>
		</div>
	
		
		<div id="tab-5"  class="py-4">									
			<div class="rows">	
				<div class="col-12">        
				   							
			<div class="rows">
                <div class="col-12">
                	<fieldset>
        			<legend>Produtos  Semelhante</legend>	
        			
    				   <div class="rows">                        
    				   		<div class="col-6 mb-3">
                                    <label class="text-label">Produtos</label>
                                    <select id="produto_semelhante_id"  class="form-campo">
                                        @foreach($produtos as $p)
                                          	<option value="{{$p->id}}" >{{$p->id}} - {{$p->nome}}</option>
                                        @endforeach 
                                    </select>
                            </div>
                        
                            <div class="col-3 mt-1 pt-1"> 
                            	<input type="hidden" id="produto_principal_id" value="{{$produto->id ?? null }}" class="btn btn-azul width-100" />                              
                            	<input type="button" onclick="inserirProdutoSemelhante()" value="Inserir Produto" class="btn btn-azul width-100" />                              
                            </div>                                                
    					</div>
    				
        			<div class="rows">
        			<div class="col-12"> 
                    <fieldset class="mt-3 mb-0 p-0 border-0">              
                        <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                            <table cellpadding="0" cellspacing="0" id="" width="100%">
                                    <thead>
                                     <tr>
                                            <th align="center">#</th>
                                            <th align="center">Nome</th>
                                            <th align="center">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody class="datatable-body" id="lista_produto_semelhante">
                                    @foreach($semelhantes as $v)
                                    	<tr>
                                    		<td align="center">{{$v->id}}</td>
                                    		<td align="center">{{$v->produtoSemelhante->nome}}</td>                                    		
                                    		<td align="center" width="400">                                    			
                                    			<a href="javascript:;" onclick="excluirProdutoSemelhante({{$v->id}})" class="btn btn-vermelho btn-pequeno d-inline-block">Excluir</a>
                                    		</td>
                                    	</tr>
                                    @endforeach
        							</tbody>
                                    </table>
        								
                           </div>
        
                        </fieldset>
                        </div>
                </div>
        			</fieldset>
                    </div>                  
         	</div>
         
				</div>
              
         </div>
		</div>
		
		
	
		<div id="tab-6"  class="py-4">									
			<div class="rows">	
				<div class="col-12">        
				   							
			<div class="rows">
                <div class="col-12">
                	<fieldset>
        			<legend>Grade de Produto</legend>	
        			
    				   <div class="rows">                        
    				   		<div class="col-3 mb-3">
                                    <label class="text-label">Linha</label>
                                   <div class="group-btn">
                                    <select id="linha_id"  class="form-campo" {{$produto->usa_grade=="S" ? "disabled": ""}} >
                                        @foreach($variacoes as $v)
                                          	<option value="{{$v->id}}" {{$variacao_grade_linha_id == $v->id ? 'selected' : null }} >{{$v->id}} - {{$v->variacao}}</option>
                                        @endforeach 
                                    </select>
                                    <a href="javascript:;" onclick="abrirModalCadVariacaoGrade()" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova variacaograde"></a>
								</div>
                            </div>
                            
                            <div class="col-3 mb-3">
                                    <label class="text-label">Coluna</label>
                                    <select id="coluna_id"  class="form-campo" {{$produto->usa_grade=="S" ? "disabled": ""}}>
                                         @foreach($variacoes as $v)
                                          	<option value="{{$v->id}}" {{$variacao_grade_coluna_id == $v->id ? 'selected' : null }}>{{$v->id}} - {{$v->variacao}}</option>
                                        @endforeach 
                                    </select>
                            </div>
                        
                            <div class="col-3 mt-1 pt-1">  
                            	<a href="javascript:;" onclick="mostrarListaGrade()" class=" btn btn-azul width-100" title="Ver menu">Inserir Grade</a>                           
                             </div>                                                
    					</div>
    				
    				<div class="rows">
    				
    					      
             <div class="col-12 px-0">
				
				<div class="px-2 mb-4 selecaoCor">
				<div class="p-2 radius-4 border">
					<div class="rows ">					
						<div class="col-12">
							<div class="TamanhoH scroll  alt">	
						@foreach($linha as $l)	
							<div class="scrollH">	
								@foreach($coluna as $c)	
									<?php
									      $id             = $grade_produto[$l->id][$c->id]->id;
										  $estoque        = $grade_produto[$l->id][$c->id]->estoque;
										  $codigo_barra   = $grade_produto[$l->id][$c->id]->codigo_barra;
									?>						
									<div class="cols">
										<input type="hidden" id="barra_{{ $id }}" value="{{ $codigo_barra }}">
										<div class="border cxCor">													
											<a href="javascript:;" onclick="excluirGrade({{$id}})" class="fas fa-trash lixo" title="Excluir"></a>
											<div>
												<small>{{$id}} - {{$variacao_linha}}: {{$l->valor}}</small>
												<small>{{$variacao_coluna}}: {{$c->valor}} </small>
												<span class="tt" id="estoque_{{$id}}">Estoque <b>{{$estoque}}</b></span>
												<span class="tt" >Cód .Barra: <b><span id="codigo_barra_grade_{{$id}}">{{$codigo_barra}}</span></b></span>
											</div>
											<div class="mt-1 align-items-center">
												<a href="javascript:;" onclick="abrirModalDistribuirEstoque({{$id}})"  class="btn btn-azul btn-menor ml-1 d-inline-block">Estoque inicial</a>
												<a href="javascript:;" onclick="abrirModalCodigoBarra({{$id}})"  class="btn btn-verde btn-menor ml-1 d-inline-block">Cód. Barra</a>
												
											</div>
										</div>
									</div>	
								@endforeach
							</div>
						@endforeach							
						
						
						</div>
					</div>
				</div>
				</div>
			</div>


        </div>
    				
    				</div>
    				
        
			
        			</fieldset>
                    </div>                  
         	</div>
         
				</div>
              
         </div>
		</div>
		
		
		<div id="tab-7">
		<div class="pt-4">
			<fieldset>
				<legend>Imagen produto</legend>
				<div class="m-auto">
					<div class="rows">					
                        <div class="col-3">
							<div class="banner-thumb radius-4 border" style="background:#ccc;padding:3px">
								<label for="img_loja_produto">
								<img src="{{asset('assets/admin/img/img-prod-loja.svg')}}" class="img-fluido" id="imgUp1">
								<span>Carregar imagem</span>
								</label>
							</div>
						</div>
						<div class="col-9">
							<div class="rows mx-0">
								<div class="col-10 text-center"> 
									<div  class="carregar-label  d-flex justify-content-space-between align-items-center p-0" style="overflow:hidden">
										<label class="d-block width-50"><i class="fas fa-images"></i> carregar nova imagem<input type="file" id="img_loja_produto" onChange="valida_imagem('img_loja_produto','imgUp1')" class="d-none"></label>
										<label class="btn btn-azul width-30"><i class="fas fa-arrow-up"></i> Subir imagem<input type="button" onClick="upload_produto()" class="d-none"></label>
									</div>
								</div>
								<div class="col-10"><small class="d-block mt-2 text-escuro">O tamanho da imagem deve ser de (275 x 344) pixel</small></div>
							</div>		                        	
							
								<div class="col-12 px-0">
									<div class="radius-4 p-2 cxImgProd" style="background: #dddddd54;margin-top: 10px;">
										<div class="rows" id="lista_imagens">
											@foreach($imagens as $img)
												<div class="col-2 d-flex mb-3">
													<div class="banner-thumb radius-4 p-1 border" style="background:#fff">
														<img src="{{asset($img->img)}}" class="img-fluido">
														<a href="javascript:;" onclick="excluirImagem({{$img->id}})" class="btn btn-vermelho btn-circulo"><i class="fas fa-times"></i></a>
													</div>
												</div>  	                        	
											@endforeach       
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>
			</fieldset>
		</div>
	  </div>
	  
	  <div id="tab-8"  class="py-4">									
			<div class="rows">	
				<div class="col-12">        
				   							
			<div class="rows">
                <div class="col-12">
                	<fieldset>
        			<legend>Tabela de Preço</legend>	
        			
    				   <div class="rows">                        
    				   		<div class="col-3 mb-3">
                                <label class="text-label">Tabela</label>
                                <select id="tabela_preco_id"  class="form-campo">
                                    @foreach($precos as $p)
                                      	<option value="{{$p->id}}" >{{$p->id}} - {{$p->nome}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-2 mb-3">
									<label class="text-label">Preço</label>
									<input type="text" id="preco"   class="form-campo mascara-float">
							</div>
							<div class="col-2 mb-3">
									<label class="text-label">Data Atualização</label>
									<input type="date" id="data_atualizacao" value="{{hoje()}}"  class="form-campo">
							</div>
                        
                            <div class="col-3 mt-1 pt-1">                            
                            	<input type="button" onclick="inserirTabelaPreco()" value="Inserir Preco" class="btn btn-azul width-100" />   
                            	                           
                            </div>                                                
    					</div>
    				
        			<div class="rows">
        			<div class="col-12"> 
                    <fieldset class="mt-3 mb-0 p-0 border-0">              
                        <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                            <table cellpadding="0" cellspacing="0" id="" width="100%">
                                    <thead>
                                     <tr>
                                            <th align="center">#</th>
                                            <th align="center">Nome</th>
                                            <th align="center">Valor</th>
                                            <th align="center">Última Atualização</th>
                                            <th align="center">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody class="datatable-body" id="lista_tabela_preco">
                                    @foreach($lista_precos as $t)
                                    	<tr>
                                    		<td align="center">{{$t->id}}</td>
                                    		<td align="center">{{$t->tabela_preco->nome}}</td>  
                                    		<td align="center">{{$t->valor}}</td>
                                    		<td align="center">{{databr($t->data_atualizacao)}}</td>                                  		
                                    		<td align="center" width="400">                                    			
                                    			<a href="javascript:;" onclick="excluirTabelaPreco({{$t->id}})" class="btn btn-vermelho btn-pequeno d-inline-block">Excluir</a>
                                    		</td>
                                    	</tr>
                                    @endforeach
        							</tbody>
                                    </table>
        								
                           </div>
        
                        </fieldset>
                        </div>
                </div>
        			</fieldset>
                    </div>                  
         	</div>
         
				</div>
              
         </div>
		</div>
		
		
		<div id="tab-9"  class="py-4">									
			<div class="rows">	
				<div class="col-12">        
				   							
			<div class="rows">
                <div class="col-12">
                	<fieldset>
        			<legend>Fornecedores</legend>	
        			
    				   <div class="rows">                        
    				   		<div class="col-6 mb-3">
                                <label class="text-label">Fornecedor</label>
                                <div class="group-btn">
                                <select id="tabela_preco_id"  class="form-campo">
                                    @foreach($fornecedores as $f)
                                      	<option value="{{$f->id}}" >{{$f->id}} - {{$f->razao_social}}</option>
                                    @endforeach 
                                </select>
                            	<a href="{{route('admin.fornecedor.create')}}" target="_blank" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova Fornecedor"></a>
								</div>
                            </div>
                                        
									
                            <div class="col-2 mb-3">
									<label class="text-label">Código do Produto</label>
									<input type="text" id="cProd"   class="form-campo mascara-float">
							</div>
							
							<div class="col-2 mb-3">
									<label class="text-label">Código Barra</label>
									<input type="text" id="codigo_barra"   class="form-campo mascara-float">
							</div>							
							
                        
                            <div class="col-2 mt-1 pt-1">                            
                            	<input type="button" onclick="inserirFornecedor()" value="Inserir" class="btn btn-azul width-100" />   
                            </div>                                                
    					</div>
    				
        			<div class="rows">
        			<div class="col-12"> 
                    <fieldset class="mt-3 mb-0 p-0 border-0">              
                        <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                            <table cellpadding="0" cellspacing="0" id="" width="100%">
                                    <thead>
                                     <tr>
                                            <th align="center">#</th>
                                            <th align="center">Fornecedor</th>
                                            <th align="center">cProd</th>
                                            <th align="center">Código Barra</th>
                                            <th align="center">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody class="datatable-body" id="lista_tabela_preco">
                                    @foreach($fornecedores_produto as $t)
                                    	<tr>
                                    		<td align="center">{{$t->id}}</td>
                                    		<td align="center">{{$t->fornecedor->razao_social}}</td>  
                                    		<td align="center">{{$t->cProd}}</td>
                                    		<td align="center">{{$t->codigo_barra}}</td>                                  		
                                    		<td align="center" width="400">                                    			
                                    			<a href="javascript:;" onclick="excluirFornecedor({{$t->id}})" class="btn btn-vermelho btn-pequeno d-inline-block">Excluir</a>
                                    		</td>
                                    	</tr>
                                    @endforeach
        							</tbody>
                                    </table>
        								
                           </div>
        
                        </fieldset>
                        </div>
                </div>
        			</fieldset>
                    </div>                  
         	</div>
         
				</div>
              
         </div>
		</div>
		
		
		</div>
	  </div>

	 
	  
	
         
 </div>
		<div class="col-12 text-center pb-4">
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	
	
</form>
</div>

<!--MOdal-->
		<div class="window medio" id="modal_grade">
		<form action="{{route('admin.grade.store')}}" name="frmGrade" method="POST">
		@csrf
			<div class="titulo" style="font-size: 1.1rem!important;">Faça a montagem da Grade</div>
			<input type="hidden" id="variacao_grade_linha_id" name="variacao_grade_linha_id">
			<input type="hidden" id="variacao_grade_coluna_id" name="variacao_grade_coluna_id">
			<input type="hidden" id="produto_grade_id" name="produto_grade_id">
			<div class="p-2 cadSelect">
				<div class="rows">
					<div class="col-6">
						<div class="scroll">
							<table cellpadding="0" cellspacing="0" class="table-bordered">
								<thead>
									<tr>
										<th align="left"><span class="nome_linha"></span></th>
									</tr>
								</thead>
								<tbody id="linha">
									<tr>
										<td align="left"><label><input type="checkbox" name="linhas[]" > 01</label></td>
									</tr>
								
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-6">
						
						<div class="scroll">
							<table cellpadding="0" cellspacing="0" class="table-bordered">
								<thead>
									<tr>
										<th align="left"><span class="nome_coluna"></span></th>
									</tr>
								</thead>
								<tbody id="coluna">
									<tr>
										<td align="left"><label><input type="checkbox" name="colunas[]" > Marron</label></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="tfooter justify-content-space-between">
				<div class="d-flex">
					<a href="javascript:;" onclick="abrirItemVariacao('linha')" class="btn btn-azul btn-menor" title="Cadastrar tamanho"><i class="fas fa-plus-circle"></i> <span class="nome_linha"></span></a>
					<a href="javascript:;" onclick="abrirItemVariacao('coluna')" class="btn btn-azul btn-menor ml-1" title="Cadastrar cor"><i class="fas fa-plus-circle"></i> <span class="nome_coluna"></span></a>
				</div>
				
				<div class="d-flex">
					<input type="submit" value="Gerar Grade" class="btn btn-verde btn-menor">
					<a href="" class="btn btn-vermelho btn-menor fechar ml-1"  title="Cadastrar cancelar"><i class="fas fa-times"></i> Cancelar</a>
				</div>
			</div>
		</form>
		</div>


<!--modal dicionar tamanho-->
		<div class="modal_livre menor" id="addLinha">
			<div class="titulo" style="font-size: 1.1rem!important;"><span class="nome_linha"></span> <a href="#" class="fechar_livre text-vermelho">X</a></div>
			<div class="p-2 cadSelect">
				<form>
					<div class="rows">
						<div class="col-9">
							<input type="text" id="valor_linha" class="form-campo">
						</div>
						<div class="col-3">
							<a href="javascript:;" onclick="inserirItemVariacao('linha')" class="btn btn-azul btn-menor ml-1" title="Cadastrar cor">Salvar</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		
		<!--modal dicionar cor-->
		<div class="modal_livre menor" id="addColuna">
			<div class="titulo" style="font-size: 1.1rem!important;"><span class="nome_coluna"></span> <a href="#" class="fechar_livre text-vermelho">X</a></div>
			<div class="p-2 cadSelect">
				<form>
					<div class="rows">
						<div class="col-9">
							<input type="text" id="valor_coluna" class="form-campo">
						</div>
						<div class="col-3">
							<a href="javascript:;" onclick="inserirItemVariacao('coluna')" class="btn btn-azul btn-menor ml-1" title="Cadastrar cor">Salvar</a>
						</div>
					</div>
				</form>
			</div>
		</div>


<div class="window pequeno menor" id="modalDistribuirEstoque">	
	<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-plus"></i> Inserir estoque Inicial</span>		
	</div>
	<div class="p-4">
		<div class="rows">
			<div class="col-12">
				
				<input type="text"   required name="qtde_estoque" id="qtde_estoque"  class="form-campo mascara-float">								
			</div>
		</div>
	</div>
	<div class="tfooter end">
		<div class="d-flex h4 d-inline-block mb-0 align-items-center">
			<input type="hidden" name="eh_modal" id="eh_modal" value="1">
			<input type="hidden" name="grade_id" id="grade_id" >
			<a href="javascript:;" onclick="salvarEstoque()" class="btn btn-azul"><i class="fas fa-check"></i> Inserir</a>
			<a href="" class="btn btn-vermelho btn-menor fechar ml-1" title="Cadastrar cancelar"><i class="fas fa-times"></i> Cancelar</a>
		</div>
	</div>
</div>
			
			

<div class="window pequeno menor" id="modalAlterarCodigoBarra">	
	<form id="frmCadVariacaoGrade">
			<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
				<span class="mb-0 h5"><i class="fas fa-plus"></i> Alterar Código Barra</span>		
			</div>
		
			<div class="p-4">
				<div class="rows">
					<div class="col-6">
						<span class="text-label ">Código Anterior</span>
						<input type="text"  maxlength="100"  readonly="readonly"  id="codigo_barra_anterior"  class="form-campo">								
					</div>
					
					<div class="col-6">
						<span class="text-label ">Código Novo</span>
						<input type="text"  maxlength="100" maxlength="13" required  id="codigo_barra_grade"  class="form-campo">								
					</div>
				</div>
			</div>
			<div class="tfooter end">
				<div class="d-flex h4 d-inline-block mb-0 align-items-center">
					<a href="javascript:;" onclick="alterarCodigoBarra()" class="btn btn-azul"><i class="fas fa-check"></i> Salvar</a>
					<a href="" class="btn btn-vermelho btn-menor fechar ml-1" title="Cadastrar cancelar"><i class="fas fa-times"></i> Cancelar</a>
				</div>
			</div>
		</form>
</div>			

		

<script>
var eh_modal_categoria = 0;

function abrirModalCodigoBarra(id){
	$("#grade_id").val(id);
	var anterior = 	$("#barra_"+id).val();
	$("#codigo_barra_anterior").val(anterior);	
	abrirModal("#modalAlterarCodigoBarra");
}

function alterarCodigoBarra(){
	var grade_id	= $("#grade_id").val();
	var barra		= $("#codigo_barra_grade").val();	
		
	if(barra==""){
		alert("digite um valor para o código");
		return false;
	}
	$.ajax({
		url: base_url + "admin/grade/alterarCodigoBarra",
	   type: "POST",
	   dataType: "json",
	   data:{	
	   		grade_id	:grade_id,
	   		codigo_barra: barra,
	   	},
		 success: function(data){
			 if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
				$("#codigo_barra_grade_"+grade_id).html(barra);
			} 
		 }, error: function (e) {
			var response = JSON.parse(e.responseText);			
			$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
		
	});
} 
function abrirItemVariacao(tipo){
	if(tipo=='linha'){
		$("#valor_linha").val('');
		abrirModal('#addLinha')
	}
	
	if(tipo=='coluna'){
		$("#valor_coluna").val('');
		abrirModal('#addColuna')
	}

}
function mostrarListaGrade(){
	var linha_id  	= $("#linha_id").val();
	var coluna_id 	= $("#coluna_id").val();
	var produto_id 	= $("#produto_id").val();
	
	$("#variacao_grade_linha_id").val(linha_id);
	$("#variacao_grade_coluna_id").val(coluna_id);
	$("#produto_grade_id").val(produto_id);
	
	if(linha_id=="" || linha_id == null || linha_id == 'null' ){
		alert('Selecione uma Linha');
		return;
	}
	
	if(coluna_id=="" || coluna_id == null || coluna_id == 'null'){
		alert('Selecione uma Coluna');
		return;
	}	
	
	if(linha_id== coluna_id ){
		alert('O nome da Coluna não pode ser igual ao nome da Linha');
		return;
	}	
	
	$.ajax({
         url: base_url + "admin/itemvariacaograde/lista/" + linha_id + "/" + coluna_id + "/" + produto_id ,
         type: "get",
         dataType:"Json",
         data:{},
         success: function(data){         	  
			  fecharGiraGira(eh_modal);
			  html_linha = "";
			  for (i = 0; i < data.linhas.length; i++) {
			  	  if(data.linhas[i].selecionado=="S"){
			  	  	  html_linha +="<tr><td align='left'><label><input type='checkbox' checked name='linhas[]' value='" + data.linhas[i].id + "'>" + data.linhas[i].valor + "</label></td></tr>";
			  	  }else{
			  	  	  html_linha +="<tr><td align='left'><label><input type='checkbox' name='linhas[]' value='" + data.linhas[i].id + "'>" + data.linhas[i].valor +  "</label></td></tr>";
				  }
			  }
        	  
        	  html_coluna = "";
        	  for (i = 0; i < data.colunas.length; i++) {
        	  	if(data.colunas[i].selecionado=="S"){
				  html_coluna +="<tr><td align='left'><label><input type='checkbox' checked name='colunas[]' value='" + data.colunas[i].id + "'>" + data.colunas[i].valor +   "</label></td></tr>";
				}else{
				  html_coluna +="<tr><td align='left'><label><input type='checkbox' name='colunas[]' value='" + data.colunas[i].id + "'>" + data.colunas[i].valor +   "</label></td></tr>";
				}
			  }
			  
        	  $("#linha").html(html_linha);
        	  $("#coluna").html(html_coluna);
        	  
        	  $(".nome_linha").html(data.linha.variacao);
        	  $(".nome_coluna").html(data.coluna.variacao);
        	  
        	  
        	  abrirModal("#modal_grade");
									
         },
         beforeSend: function(){           
            giraGira(); 
        }         
     });
	
}


function verGradeProduto(){
	var linha_id  	= $("#linha_id").val();
	var coluna_id 	= $("#coluna_id").val();
	var produto_id 	= $("#produto_id").val();
	
	$("#variacao_grade_linha_id").val(linha_id);
	$("#variacao_grade_coluna_id").val(coluna_id);
	$("#produto_grade_id").val(produto_id);
	
	if(linha_id=="" || linha_id == null || linha_id == 'null' ){
		alert('Selecione uma Linha');
		return;
	}
	
	if(coluna_id=="" || coluna_id == null || coluna_id == 'null'){
		alert('Selecione uma Coluna');
		return;
	}	
	
	if(linha_id== coluna_id ){
		alert('O nome da Coluna não pode ser igual ao nome da Linha');
		return;
	}	
	
	$.ajax({
         url: base_url + "admin/itemvariacaograde/lista/" + linha_id + "/" + coluna_id + "/" + produto_id ,
         type: "get",
         dataType:"Json",
         data:{},
         success: function(data){         	  
			  fecharGiraGira(eh_modal);
			  html_linha = "";
			  for (i = 0; i < data.linhas.length; i++) {
			  		var id_linha = 'linha_clicavel_' +data.linhas[i].id ; 
			  	  	 html_linha +="<tr><td align='left'><a href='javascript:;' onclick='selecionarLinhaGrade('" + data.linhas[i].id + "')'><span id='" + id_linha + "'>" + data.linhas[i].valor + "</span></a></td></tr>";
			  }
        	  
        	  html_coluna = "";
        	  for (i = 0; i < data.colunas.length; i++) {
     			  	var id_coluna = 'coluna_clicavel_' +data.colunas[i].id ; 
			  	  	 html_coluna +="<tr><td align='left'><a href='javascript:;' onclick='selecionarColunaGrade('" + data.colunas[i].id + "')'><span id='" + id_coluna + "'>" + data.colunas[i].valor + "</span></a></td></tr>";
		  		}
			  
        	  $("#linha").html(html_linha);
        	  $("#coluna").html(html_coluna);
        	  
        	  $(".nome_linha").html(data.linha.variacao);
        	  $(".nome_coluna").html(data.coluna.variacao);
        	  
        	  
        	  abrirModal("#modal_grade");
									
         },
         beforeSend: function(){           
            giraGira(); 
        }         
     });
	
}

function inserirItemVariacao(tipo){
	var produto_id 				= $("#produto_id").val();
	var linha_id 				= $("#linha_id").val();
	var coluna_id 				= $("#coluna_id").val();
	if(tipo=="linha"){
		var variacao_grade_id 	= $("#linha_id").val();
		var valor 				= $("#valor_linha").val();
	}
	if(tipo=="coluna"){
		var variacao_grade_id = $("#coluna_id").val();
		var valor 			  = $("#valor_coluna").val();
	}
	
	if(valor!=""){
		$.ajax({
         url: base_url + "admin/itemvariacaograde/salvarJs",
         type: "post",
         dataType:"Json",
         data:{
         	produto_id: produto_id,
         	linha_id: linha_id,
         	coluna_id: coluna_id,
         	variacao_grade_id: variacao_grade_id,
         	valor: valor
         },
         success: function(data){
         	if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharGiraGira(1);
			  fecharModalLivre();
			  html_linha = "";
			  for (i = 0; i < data.lista.linhas.length; i++) {
			  	  if(data.lista.linhas[i].selecionado=="S"){
			  	  	  html_linha +="<tr><td align='left'><label><input type='checkbox' checked name='linhas[]' value='" + data.lista.linhas[i].id + "'>" + data.lista.linhas[i].valor + "</label></td></tr>";
			  	  }else{
			  	  	  html_linha +="<tr><td align='left'><label><input type='checkbox' name='linhas[]' value='" + data.lista.linhas[i].id + "'>" + data.lista.linhas[i].valor +  "</label></td></tr>";
				  }
			  }
        	  
        	  html_coluna = "";
        	  for (i = 0; i < data.lista.colunas.length; i++) {
        	  	if(data.lista.colunas[i].selecionado=="S"){
				  html_coluna +="<tr><td align='left'><label><input type='checkbox' checked name='colunas[]' value='" + data.colunas[i].id + "'>" + data.lista.colunas[i].valor +   "</label></td></tr>";
				}else{
				  html_coluna +="<tr><td align='left'><label><input type='checkbox' name='colunas[]' value='" + data.lista.colunas[i].id + "'>" + data.lista.colunas[i].valor +   "</label></td></tr>";
				}
			  }
			  
        	  $("#linha").html(html_linha);
        	  $("#coluna").html(html_coluna);
        	  
        	  $(".nome_linha").html(data.linha.variacao);
        	  $(".nome_coluna").html(data.coluna.variacao); 
        	  
        	  $("#valor_linha").val("");   
        	  $("#valor_coluna").val(""); 
			}
			
		},
         beforeSend: function(){           
            giraGira(); 
        },error: function (data) {
			fecharGiraGira(eh_modal);
			if(data.status== 422){
				var errors = $.parseJSON(data.responseText);
				$('#listaErroModal').html('');					
	        	$.each(errors.errors, function (key, erro) {					 
					 $('#listaErroModal').append('<li>' + erro + '</li>');
					 abrirModalLivre("#modalLivreListaComErros");
	        	});
			}else{
				
			}	        
		}          
     });
	
	}
	
	
}

function abrirModalDistribuirEstoque(id){
	$("#grade_id").val(id);
	$("#qtde_estoque").val("");
	abrirModal('#modalDistribuirEstoque');	
}

function abrirModalCadVariacaoGrade(){
	$("#variacao").val("");
	abrirModal('#modalCadVariacaoGrade');	
}
function salvarEstoque(){
	var id = $("#grade_id").val();
	var qtde = $("#qtde_estoque").val();
	$.ajax({
         url: base_url + "admin/grade/inserirEstoque" ,
         type: "POST",
         dataType:"Json",
         data:{
         	id: id,
         	qtde:qtde,         	
         },
         
         success: function(data){
			fecharModal();
			if(data.tem_erro ==true){
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
			   $("#estoque_"+id).html(qtde);				
			   $("#soma_estoque").html(converteFloatMoeda(data.total));
			}
         },
         beforeSend: function(){           
            giraGira(); 
        }         
     });
	
}

function upload_banner(){
	var data 	 = new FormData();	
	var arquivos = $('#img_perfil')[0].files;
	var id = $('#id').val();
	
	if(arquivos.length > 0) {		
		data.append('file', arquivos[0]);
		data.append('id', id);
		
		$.ajax({
			type:'POST',
			url:base_url + 'lojaadmin/lojaproduto/salvarImagemJs',
			data:data,
			contentType:false,
			processData:false,
			dataType: "json",
			beforeSend: function(){
				$('#uploadStatus').html('<img src=' + base_url + '"assets/img/loading.gif"/>');
			},
            error:function(){
                alert("erro");
            },
			success:function(data){	
				lista_imagem(data);
			}
		});
	}
}



function abrirModalCadastroCategoria(eh_modal){
	var id_categoria = $("#categoria_id").val();	
	if(id_categoria !=""){
		mostrarCategoriasSelecionada(eh_modal, id_categoria);;
	}else{
		mostrarCategoriasNaoSelecionada(eh_modal);
	}
	
}

function mostrarCategoriasNaoSelecionada(eh_modal){
	$.ajax({
         url: base_url + "admin/categoria/listarCategoria" ,
         type: "get",
         dataType:"Json",
         data:{},
         success: function(data){
			  fecharGiraGira(eh_modal);
        	  html = "<option value=''>selecione</option>";
			  for (i = 0; i < data.length; i++) {	
				  html +="<option value='"+ data[i].id +"'>" + data[i].categoria + "</option>";
			  }			 
			 abrirModal("#modalCadastroCategoriaCompleto");
			 $("#cb_categoria_id").html(html);
         },
         beforeSend: function(){           
            giraGira(); 
        }         
     });
	
}

function mostrarCategoriasSelecionada(eh_modal, id_categoria){
	var cat_selecionado = "";
	$.ajax({
         url: base_url + "admin/categoria/selecionarCategoria/"  + id_categoria ,
         type: "GET",
         data: {  },
         dataType:"Json",
         success: function(data){
			 console.log(data);             
			 
			 html_cat = "<option value=''>selecione</option>";
			  for (i = 0; i < data.categorias.length; i++) {
			  	  selecionado = (id_categoria == data.categorias[i].id) ? "selected" : "";	
				  html_cat +="<option value='" + data.categorias[i].id +"'>" + data.categorias[i].categoria + "</option>";
			  }
			 $("#cb_categoria_id").html(html_cat);
			 
			 html = "<option value=''>selecione</option>";
			  for (i = 0; i < data.subcategorias.length; i++) {	
				  html +="<option value='"+ data.subcategorias[i].id +"'>" + data.subcategorias[i].subcategoria + "</option>";
			  }
			 $("#cb_subcategoria_id").html(html);
			 
			 html2 = "<option value=''>selecione</option>";
			  for (i = 0; i < data.subsubcategorias.length; i++) {	
				  html2 +="<option value='"+ data.subsubcategorias[i].id +"'>" + data.subsubcategorias[i].subsubcategoria + "</option>";
			  }
			 $("#cb_subsubcategoria_id").html(html2);
			 abrirModal("#modalCadastroCategoriaCompleto");
         }
         
     });
	
}


function salvarVariacaoGrade(){ 
		var variacao = $("#variacao").val();
		eh_modal = 1;       
        $.ajax({
         url: base_url + "admin/variacaograde/salvarJs",
         type: "POST",
         data:{
         	variacao: variacao
         },
         dataType:"Json",
         success: function(data){			
			if(data.tem_erro ==true){
				fecharGiraGira(eh_modal);
				$("#erroModalLivre").html(data.erro);
				abrirModalLivre("#modalLivreErro");				
			}else{
				fecharModal();
				$("#mostrarUmErro").html(MostrarUmaMsgSucesso(" Registro Inserido com Sucesso"));
				 html = "";
				  for (i = 0; i < data.lista.length; i++) {	
					  html +="<option value='"+ data.lista[i].id +"'>" + data.lista[i].variacao + "</option>";
				  }
				  
				  $("#linha_id").html(html);
				  $("#coluna_id").html(html);
			}             
         },
		  beforeSend: function () {
			giraGira();
	     },error: function (data) {
			fecharGiraGira(eh_modal);
			if(data.status== 422){
				var errors = $.parseJSON(data.responseText);
				$('#listaErroModal').html('');					
	        	$.each(errors.errors, function (key, erro) {					 
					 $('#listaErroModal').append('<li>' + erro + '</li>');
					 abrirModalLivre("#modalLivreListaComErros");
	        	});
			}else{
				
			}	        
		}        
     })
}

</script>




@include("Admin.Cadastro.Produto.modal.modalCadastroCategoriaCompleto")
@include("Admin.Cadastro.Produto.modal.modalGradeProduto")
@include("Admin.Cadastro.Categoria.modal.modalCategoria")
@include("Admin.Cadastro.SubCategoria.modal.modalSubCategoria")
@include("Admin.Cadastro.SubSubCategoria.modal.modalSubSubCategoria")
@include("Admin.Cadastro.VariacaoGrade.modal.modalVariacao")
@include("Admin.Cadastro.Localizacao.modal.modalLocalizacao")

@endsection


