@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
	
    <div class="col-12">
    <div class="caixa">
	<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Lista de Cupom de Descontos</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>				
            
		 @if(isset($cupomdesconto))    
           <form action="{{route('admin.cupomdesconto.update', $cupomdesconto->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.cupomdesconto.store')}}" method="Post" >
        @endif
        	@csrf
            
            <div class="px-2 pt-2">	
				  <div class=" {{isset($cupomdesconto) ? 'bg-orange' : 'bg-padrao' }}  mt-2 p-2 radius-4">
				  <div class="rows">
				 		 <div class="col-3">
				 		 <label class="text-label d-block text-branco">Categoria </label>
				  			<select class="form-campo" name="categoria_id" id="categoria_id" >
				 		 	<option value="">Selecione</option>
				  				@foreach($categorias as $categoria)
				  					<option value='{{$categoria->id}}' {{($cupomdesconto->categoria_id ?? null)== $categoria->id ? 'selected': '' }} >{{$categoria->categoria}}</option>
				  				@endforeach				  			
				  			</select>
				  		</div>
				  		
				  		<div class="col-3">
				 		 <label class="text-label d-block text-branco">Produto </label>
				 		 	
				  			<select class="form-campo" name="produto_id" id="produto_id" >
				  			<option value="">Selecione</option>
				  				@foreach($produtos as $produto)
				  					<option value='{{$produto->id}}' {{($cupomdesconto->produto_id ?? null)== $produto->id ? 'selected': '' }} >{{$produto->nome}}</option>
				  				@endforeach				  			
				  			</select>
				  		</div>
				  		
                        <div class="col-2">	
                                <label class="text-label d-block text-branco">Código </label>
                                <input type="text" name="codigo" value="{{isset($cupomdesconto->codigo) ? $cupomdesconto->codigo: null}}"  class="form-campo">
                        </div>
                        
				  		<div class="col-4">	
                                <label class="text-label d-block text-branco">Descrição </label>
                                <input type="text" name="descricao" value="{{isset($cupomdesconto->descricao) ? $cupomdesconto->descricao: null}}"  class="form-campo">
                        </div>
                        
                        <div class="col-2">	
                                <label class="text-label d-block text-branco">Valor Mínimo </label>
                                <input type="text" name="valor_minimo" value="{{isset($cupomdesconto->valor_minimoo) ? $cupomdesconto->valor_minimo : null}}"  class="form-campo mascara-float">
                        </div>
                        
                        <div class="col-2">	
                                <label class="text-label d-block text-branco">Desconto Valor (R$) </label>
                                <input type="text" name="desconto_por_valor" value="{{ $cupomdesconto->desconto_por_valor ?? null}}"  class="form-campo mascara-float">
                        </div>
				  		
				  		<div class="col-2">	
                                <label class="text-label d-block text-branco">Desconto Percento (%) </label>
                                <input type="text" name="desconto_percentual" value="{{$cupomdesconto->desconto_percentual ?? null}}"  class="form-campo mascara-float">
                        </div>	
                         <div class="col-2">	
                                <label class="text-label d-block text-branco">Data Limite </label>
                                <input type="date" name="data_validade" value="{{isset($cupomdesconto->data_validade) ? $cupomdesconto->data_validade: null}}"  class="form-campo">
                        </div>     
                        <div class="col-2">	
                                <label class="text-label d-block text-branco">Qtde Limite </label>
                                <input type="text" name="qtde_limite" value="{{isset($cupomdesconto->qtde_limite) ? $cupomdesconto->qtde_limite: null}}"  class="form-campo">
                        </div>
                        
                        <div class="col-2">
				 		 <label class="text-label d-block text-branco">Ativo </label>
				 		 	
				  			<select class="form-campo" name="ativo" id="ativo" >
				  				<option value="S">Sim</option>	
				  				<option value="N">Não</option>		  			
				  			</select>
				  		</div>
				  		                               
                            
                            <div class="col-2 mt-1 pt-1">
                                    <input type="submit" value="{{isset($cupomdesconto) ? 'Alterar' : 'Inserir' }}" class="width-100 btn btn-roxo text-uppercase">
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
                                       <th class="text-left" >Código</th>
                                       <th class="text-left" >Produto</th>
                                       <th class="text-left" >Categoria</th>
                                       <th class="text-left" >Descrição</th>
                                       <th class="text-left" >Valor Mínimo</th>
                                       <th class="text-left" >Valor (R$)</th>
                                       <th class="text-left" >Valor (%)</th>
                                       <th class="text-left" >Validade</th>
                                       <th class="text-left" >Qtde</th>
                                       <th class="text-left" >Ativo</th>
                                       <th align="center" width="70">Editar</th>
                                       <th align="center" width="30">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $cat)                                     
                             <tr>
								<td align="center">{{$cat->id}}</td>
								<td align="left">{{$cat->codigo}}</td>
                                <td align="left">{{$cat->produto->nome ?? '--'}}</td>	
                                <td align="left">{{$cat->categoria->categoria ?? '--'}}</td>	
                                <td align="left">{{$cat->descricao}}</td>	
                                <td align="left">{{$cat->valor_minimo}}</td>
                                <td align="left">{{$cat->desconto_por_valor}}</td>	
                                <td align="left">{{$cat->desconto_percentual}}</td>	
                                <td align="left">{{$cat->data_validade}}</td>
                                <td align="left">{{$cat->qtde_limite}}</td>		
                                <td align="left">{{$cat->ativo}}</td>										
                                <td align="center"><a href="{{route('admin.cupomdesconto.edit', $cat->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>                              </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$cat->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.cupomdesconto.destroy', $cat->id)}}" method="POST" id="apagar{{$cat->id}}">
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