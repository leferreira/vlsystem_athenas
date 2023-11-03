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
                    
	<form action="{{route('admin.produto.store')}}" method="Post" enctype="multipart/form-data">
	@csrf
   <div id="tab">	     
	  <div>
		<div class="p-2 pt-4">
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
							
							<input type="file" name="file" id="img_perfil" onChange="valida_imagem('img_perfil')" class="d-none">

							<span>Carregar imagem</span>
							</label>
						</div>
                        <div class="col-9 px-2">
                           <div class="rows">
                          
								
                                <div class="col-6 mb-3">
                                        <label class="text-label">Nome do produto<span class="text-vermelho">*</span></label>
                                        <input type="text" id="nome" name="nome" required maxlength="100" value="{{isset($produto->xProd) ? $produto->xProd : old('xProd')}}"   class="form-campo">
                                </div>
                                <div class="col-3 mb-3">
                                        <label class="text-label">Código (SKU)<span class="text-vermelho">*</span></label>
                                        <input type="text" name="sku"   required value="{{isset($produto->cProd) ? $produto->cProd : old('sku')}}"  class="form-campo">
                                </div>                         
                             	 <div class="col-3 mb-3">
                                        <label class="text-label">Código Barra/GTIN/EANTrib</label>
                                        <input type="text" name="gtin" value="{{isset($produto->gtin) ? $produto->gtin : old('gtin')}}"  class="form-campo">
                                </div>
                                
                                <div class="col-3 mb-3">
                                        <label class="text-label">Código Barra(interno)<span class="text-vermelho">*</span></label>
                                        <div class="group-btn">
                                        	<input type="text" required name="codigo_barra" id="codigo_barra" required value="{{isset($produto->codigo_barra) ? $produto->codigo_barra : old('codigo_barra')}}"  class="form-campo">
                                        <a href="javascript:;" onclick="gerarBarras()" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
									</div>
                                </div>
                               <div class="col-3 mb-3">
                                        <label class="text-label">NCM<span class="text-vermelho">*</span></label>
                                        <input type="text" name="ncm" data-mask="0000.00.00" maxlength="10" required value="{{isset($produto->NCM) ? $produto->NCM : old('ncm')}}"  class="form-campo">
                                </div>
                                <div class="col-3 mb-3">
                                        <label class="text-label">Cest</label>
                                        <input type="text" name="cest" maxlength="7"  value="{{$produto->CEST ?? old('cest')}}"  class="form-campo ">
                                </div>
                             
                                <div class="col-3 mb-3">
                                        <label class="text-label">Origem </label>
                                        <select class="form-campo" name="origem">
                                            @foreach(ConstanteService::listaOrigem() as $chave=>$valor)
                                          	<option value="{{$chave}}" {{($produto->origem ?? NULL) == $valor }}>{{$chave}} - {{$valor}}</option>
                                          @endforeach 
									   </select>
                                </div> 
                                 <div class="col-2 mb-3">
                                        <label class="text-label">Unidade </label>
                                        <select class="form-campo" name="unidade" id="unidade" required onchange="mostrarUnidade()">
                                        	<option value="">Selecione</option>
                                            @foreach($unidades as $unidade)
                                          	<option value="{{$unidade}}" {{($produto->unidade ?? null) == $unidade ? 'selected' : ''}}>{{$unidade}}</option>
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
                                        <input type="text" name="estoque_inicial"   value="{{isset($produto->qCom) ? $produto->qCom : old('qCom')}}"  class="form-campo mascara-float">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Estoque Máx</label>
                                        <input type="text" name="estoque_maximo"  value="{{isset($parametro->estoque_maximo_padrao) ? $parametro->estoque_maximo_padrao: old('estoque_maximo')}}"  class="form-campo mascara-float">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Estoque Mín</label>
                                        <input type="text" name="estoque_minimo"  value="{{isset($parametro->estoque_minimo_padrao) ? $parametro->estoque_minimo_padrao : old('estoque_minimo')}}"  class="form-campo mascara-float">
                                </div>
                                
                                <div class="col-3 mb-3">
                                	<label class="text-label">Preço Custo<span class="text-vermelho">*</span></label>
                                	<input type="text" name="valor_custo" id="valor_custo" onkeyup="calcularPreco()" required value="{{isset($produto->vUnCom) ? $produto->vUnCom : old('vUnCom')}}"  class="form-campo  mascara-float">
                                </div>
                                
                                <div class="col-3 mb-3">
                                	<label class="text-label">%Margem Lucro<span class="text-vermelho">*</span></label>
                                	<input type="text" name="margem_lucro" id="margem_lucro" onkeyup="calcularPreco()" required value="{{isset($parametro->margem_lucro) ? $parametro->margem_lucro : old('margem_lucro')}}"  class="form-campo  mascara-float">
                                </div>
        				   
        				   
        				   		<div class="col-3 mb-3">
                                        <label class="text-label">Preço Venda<span class="text-vermelho">*</span></label>
                                        <input type="text" name="valor_venda" id="valor_venda" onkeyup="calcularMargem()" required value="{{isset($produto->vUnCom) ? formataNumeroBr(calcularPrecoVenda($produto->vUnCom, $parametro->margem_lucro)) : old('valor_venda')}}"  class="form-campo  mascara-float">
                                </div> 
                             
                             	<div class="col-3 mb-3">
                                        <label class="text-label">Preço Alto (Loja)<span class="text-vermelho">*</span></label>
                                        <input type="text" name="valor_maior" id="valor_maior"   value="{{isset($produto->valor_maior) ? $produto->valor_maior : old('valor_maior')}}"  class="form-campo  mascara-float">
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
                                
                                
                           
                           	<!--  <div class="col-4 mb-3">
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
										 <label class="d-block"><input type="radio" name="produto_loja"  value="S" > Sim</label>
										 <label class="d-block ml-3"><input type="radio" name="produto_loja"  value = "N" checked> Não</label>
									</div>            						
            					</div>
            					
            					<div class="col-3 mb-3">				   
            						<label class="text-label text-vermelho">Vender no Delivery </label>
									<div class="radio d-flex">
										 <label class="d-block"><input type="radio" name="produto_delivery"  value="S" > Sim</label>
										 <label class="d-block ml-3"><input type="radio" name="produto_delivery"  value = "N" checked> Não</label>
									</div>            						
            					</div>
                                
                                
                        </div>
                        </div>
			</div>
			</fieldset>
			
		<ul>
			<li><a href="#tab-1">Fragmentação -</a></li>
			<li><a href="#tab-2">Dados Fiscais</a></li>
			<li><a href="#tab-3">Dados para loja</a></li>
		</ul>	
		
		<div id="tab-1" class="py-4">								
			<div class="rows">
        <div class="col-12">
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
                                  	<option value="{{$unidade}}" {{($produto->fragmentacao_unidade ?? null) == $unidade ? 'selected' : ''}}>{{$unidade}}</option>
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
    									<option value="S"  >Tributado</option>
    									<option value="N" >Isento</option>                                          
    							   </select>
    						</div>
    						
    						<div class="col-2 mb-3">
    								<label class="text-label">IPI</label>
    								<select class="form-campo" name="tributado_ipi">                                            
    									<option value="S"  >Tributado</option>
    									<option value="N" >Isento</option>                                            
    							   </select>
    						</div>
    						
    						<div class="col-2 mb-3">
    								<label class="text-label">PIS</label>
    								<select class="form-campo" name="tributado_pis">                                            
    									<option value="S"  >Tributado</option>
    									<option value="N"  >Isento</option>                                            
    							   </select>
    						</div>
    						<div class="col-2 mb-3">
    								<label class="text-label">COFINS</label>
    								<select class="form-campo" name="tributado_cofins">                                            
    									<option value="S"  >Tributado</option>
    									<option value="N"  >Isento</option>                                            
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
    									<option value="S"  >Sim</option>
    									<option value="N" >Não</option>                                          
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
							
								
								   
								<div class="col-12">
										<label class="text-label">Descrição</label>
										<textarea rows="7" cols="150" name="descricao" class="form-campo">{{isset($produto->descricao) ? $produto->descricao : old('descricao')}}</textarea>
								</div>                            
						</div>
					</fieldset>
				</div>
              
         </div>
		</div>
		

		
	
		
		</div>
	  </div>

	 
	  
	
         
 </div>
		<div class="col-12 text-center pb-4">	
			<input type="hidden" name="fornecedor_id" value="{{$produto->fornecedor_id ?? null}}">	
			<input type="hidden" name="nfe_item_id" value="{{$produto->id ?? null}}">
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	
	
</form>
</div>


<script>
var eh_modal_categoria = 0; 
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

function lista_imagem(data){
	html="";
	for(var i in data){
	var path = base_url + 'storage/upload/' + $('#cnpj').val() +'/imagens_produtos/' + data[i].img;	   
	html +='<div class="col-3 mb-3">'+
		'<div class="banner-thumb">'+
			'<img src="' + path + '" class="img-fluido">'+
		'</div>'+
	'</div>';
	}
			   
   $("#lista_imagens").html(html);
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


</script>




@include("Admin.Cadastro.Produto.modal.modalCadastroCategoriaCompleto")
@include("Admin.Cadastro.Categoria.modal.modalCategoria")
@include("Admin.Cadastro.SubCategoria.modal.modalSubCategoria")
@include("Admin.Cadastro.SubSubCategoria.modal.modalSubSubCategoria")
@include("Admin.Cadastro.Localizacao.modal.modalLocalizacao")
@endsection


