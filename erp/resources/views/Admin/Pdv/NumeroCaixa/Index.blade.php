@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
	
    <div class="col-12">
    <div class="caixa">
		<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
			<span class="h5 mb-0  d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista  Número de PDV </span>
		</div>				
            
		 @if(isset($numerocaixa))    
           <form action="{{route('admin.numerocaixa.update', $numerocaixa->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.numerocaixa.store')}}" method="Post" >
        @endif
        	@csrf
            
            <div class="px-2 pt-2">	
				  <div class="  bg-padrao mt-2 p-2 radius-4">
				  <div class="rows">
                            <div class="col-2">	
                                    <label class="text-label d-block text-branco">Número</label>
                                    <input type="number" min="0" name="num_caixa" value="{{isset($numerocaixa->num_caixa) ? $numerocaixa->num_caixa : old('num_caixa')}}"  class="form-campo">
                            </div>  
                            <div class="col-4">	
                                    <label class="text-label d-block text-branco">Descrição </label>
                                    <input type="text" name="descricao" value="{{isset($numerocaixa->descricao) ? $numerocaixa->descricao : old('descricao')}}"  class="form-campo">
                            </div> 
                                                             
                            
                			
                			<div class="col-2 mb-3">
                             	<label class="text-label text-vermelho">Transmitir NFCE  </label>
                                 <div class="radio d-flex">
                					 <label class="d-block"><input type="radio" name="transmitir_nfce" value="S" checked> Sim</label>
                					 <label class="d-block ml-3"><input type="radio" name="transmitir_nfce" value="N"> Não</label>
                				</div>  
                			</div>
                		<!--	<div class="col-2 mb-3">
                             	<label class="text-label text-vermelho">Gerar Estoque </label>
                                 <div class="radio d-flex">
                					 <label class="d-block"><input type="radio" name="gerar_estoque" value="S" checked> Sim</label>
                					 <label class="d-block ml-3"><input type="radio" name="gerar_estoque" value="N"> Não</label>
                				</div>  
                			</div>
                			
                			
                		  	
                			<div class="col-8 mb-3">
                             	<label class="text-label text-vermelho">Após finalizar a venda </label>
                                 <div class="radio d-flex">
                					 <label class="d-block"><input type="radio" name="apos_a_venda" value="pdf" > Mostrar PDF</label>
                					 <label class="d-block ml-3"><input type="radio" name="apos_a_venda"  value = "impressora" checked> Imprimir direto da impressora</label>
                					 <label class="d-block ml-3"><input type="radio" name="apos_a_venda"  value = "perguntar"> Perguntar o que fazer</label>
                					 <label class="d-block ml-3"><input type="radio" name="apos_a_venda"  value = "nada"> Não fazer Nada</label>
                				</div>  
                			</div>
                		-->
                            <div class="col-2 mt-1 pt-1">
                                    <input type="submit" value="Salvar" class="width-100 btn btn-roxo text-uppercase">
                            </div>
                    </div>
                    </div>
            </div>
        </form>
    </div>
    </div>

		<div class="col-12">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                     
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                    <tr>
                                       
                                       <th align="center" width="20">Id</th>
                                       <th class="text-left" >Número</th>
                                       <th class="text-left" >Descrição</th>
                                        <th class="text-left" >Transmitir NFCE</th>
                                        <th align="center" width="70">Editar</th>
                                       <th align="center" width="30">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $cat)                                     
                             <tr>
								<td align="center">{{$cat->id}}</td>
                                <td align="left">{{$cat->num_caixa}}</td>	
                                <td align="left">{{$cat->descricao}}</td>
                                <td align="left">{{$cat->transmitir_nfce}}</td>
                                 <td align="center"><a href="{{route('admin.numerocaixa.edit', $cat->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno" title="Editar"><i class="fas fa-edit"></i> </a>                              </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$cat->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.numerocaixa.destroy', $cat->id)}}" method="POST" id="apagar{{$cat->id}}">
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

                
                </div>

        </div>
        </div>
        @endsection