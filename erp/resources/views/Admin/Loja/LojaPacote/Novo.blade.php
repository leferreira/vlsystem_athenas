@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">
	<div class="col-12">	

    <div class="rows">	
        <div class="col-12">
            <div class="caixa">
				<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
					<span class="d-flex center-middle"><i class="fas fa-search mr-1"></i> Pacote  </span>			
                    <a href="{{route('admin.lojapacote.index')}}" class="btn btn-verde btn-pequeno float-right "><i class="fas fa-arrow-left mb-0"></i> Voltar</a>
                </div>
                </div>
                    <div class="py-4 px-4">
                       
                    </div>
            </div>
        </div>      
       
        
        
            <div class="col-12">
                    <div class="caixa border radius-4">
                    <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Itens do Pacote</span>
                    <div class="col-12 mb-3">
                            <div class="border p-3 radius-4 pb-4">
                                <div class="rows">
                                    <div class="col-4 position-relative">
										<label class="text-label">Produto</label>
										<input type="text" name="produtopacote" id="produtopacote" class="form-campo">									
                                    </div>
                                  
                                  	<div class="col-1">
										<label class="text-label">Valor</label>
										<input type="text"  id="preco" readonly="readonly" class="form-campo">
                                    </div>
                                    
                                    <div class="col-1">
										<label class="text-label">Qtde</label>
										<input type="text" value="1" id="qtde" class="form-campo">
                                    </div>
                                  

                                    <div class="col-2 mt-1 pt-1">
                                    	<input type="hidden" id="produto_id" name="produto_id">
										<input type="button"  class="btn btn-verde width-100" value="Inserir" id="btnInserirItemNoPacote">
                                    </div>
                                </div>
                                </div>

                            </div>
                            
                    <div class="tabela-responsiva ">
                            <table cellpadding="0" cellspacing="0" class="table-bordered prod">
                                    <thead>
                                            <tr>
    											  <th align="center">#</th>
    											  <th align="center">ID</th>
    											  <th align="left" width="290">Produto</th>
    											  <th align="center">Qtde</th>      
    											  <th align="center">Valor</th>      
    											  <th align="center">Subtotal</th>
    											  <th align="center" width="100">Excluir</th>
    											</tr>
                                    </thead>
                                    <tbody id="lista_item_ordem_compras">                               
										
                                    </tbody>
                            </table>
                          
                    </div>
                    
                  

                   
            </div>

    </div>     
        
         <div class="col-12">
                    <div class="caixa border radius-4">
                    <span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Dados do Pacote</span>
                    <div class="col-12 mb-3">
                            <div class="border p-3 radius-4 pb-4">
                                <div class="rows">
                                    <div class="col-6 position-relative">
										<label class="text-label">Título</label>
										<input type="text" id="nome" value="" class="form-campo">
									
                                    </div>
                                    <div class="col-2">
										<label class="text-label">Preço Pacote</label>
										<input type="text" id="valor" value="" class="form-campo">
                                    </div>
                                    <div class="col-2">
										<label class="text-label">Total Itens</label>
										<input type="text" id="totalItens" readonly="readonly"  class="form-campo">
                                    </div>
                                    
                                    <div class="col-2 mb-3">
                                        <label class="text-label">Status </label>
                                        <select class="form-campo" id="status_id">
                                        @foreach(config('constantes.status') as $chave=>$valor)                                            
                                          	<option value="{{$valor}}">{{$chave}}</option>
                                       @endforeach
                                          
                    				   </select>
                                </div>
                                   
                                <div class="col-12 mb-3">
                                        <label class="text-label">Descrição</label>
                                        <textarea rows="10" cols="150" id="descricao" class="form-campo">{{isset($produto->descricao) ? $produto->descricao : old('descricao')}}</textarea>
                                </div>
                              
                                </div>
                                </div>
                            </div>                           
                   
                    
                     <div class="caixa p-2">                   
                        <div class="caixa-rodape">						
							<input type="hidden" value="" name="id_ordem" />
							<a href="javascript:;" onclick="salvarPacote()" class="btn btn-verde btn-medio d-inline-block">Finalizar</a>                 
						</div>
                    </div>

                   
            </div>

    </div>

    </div>
  
</div>
</div>

  @endsection