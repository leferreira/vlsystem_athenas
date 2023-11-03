<?php
use App\Service\ConstanteService;
?>
<div class="window form" id="modalCadastroCategoriaCompleto">
	<div class="p-2 px-4">
			<span class="d-block h3 border-bottom fw-700">Dados do Produto</span>
		 <div class="rows">
                          
								
                                
                             	 
                                <div class="col-4 mb-3">
                                        <label class="text-label">Categoria Principal<span class="text-vermelho">*</span></label>
									<div class="group-btn">
                                        <select class="form-campo" name="categoria_id" id="cb_categoria_id" onchange="listarSubcategoriaPelaCategoria(1)">                                        
                                          @foreach($categorias as $cat)
                                          	<option value="{{$cat->id}}" >{{$cat->categoria}}</option>
                                          @endforeach                                              
                                        </select>
										<a href="javascript:;" onclick="abrirModal('#modalCadCategoria')" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
									</div> 
                                </div>
                                
                              <div class="col-4 mb-3">
                                    <label class="text-label">SubCategoria 1 </label>
									<div class="group-btn">                                       
                                        <select class="form-campo" id="cb_subcategoria_id"  name="subcategoria_id" onchange="listarSubSubcategoriaPelaSubCategoria(1)">
                                        	<option value=""></option>
                                        </select>
										<a href="javascript:;" onclick="abrirModalSubCategoria(1)" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova categoria"></a>
									</div> 
                                </div>
                                
                                <div class="col-4 mb-3">
                                    <label class="text-label">SubCategoria 2</label>
									<div class="group-btn">                                       
                                        <select class="form-campo" name="subsubcategoria_id" id="cb_subsubcategoria_id" >
                                        	<option value=""></option>
                                        </select>
										<a href="javascript:;" onclick="abrirModalSubSubCategoria(1)" class="btn btn-azul btn-circulo ml-1 fas fa-plus" title="Inserir nova subcategoria"></a>
									</div>  
                                </div>
                                                              
                                 
                                
                                
                        </div>	     					           					
    	
         </div>
		 <div class="tfooter end">
			<a href="fecharModal()" class="btn btn-neutro fechar">Fechar</a>
            <input type="hidden" id="nfe_item_temp_id_para_categoria"  >
			<input type="button" onclick="selecionarCategoriaNota()" class="btn btn-azul border-bottom" value="Marcar como Selecionado">  
		 </div>
	</div>
