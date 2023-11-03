@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
	
    <div class="col-12">
    <div class="caixa">
	<div class="p-2  bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Lista de Variação de Grade</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>				
            
		 @if(isset($variacaograde))    
           <form action="{{route('admin.variacaograde.update', $variacaograde->id)}}" method="POST" >
           <input name="_method" type="hidden" value="PUT"/>
         @else                       
        	<form action="{{route('admin.variacaograde.store')}}" method="Post" >
        @endif
        	@csrf
            
            <div class="px-2 pt-2">	
				  <div class=" {{isset($variacaograde) ? 'bg-orange' : 'bg-padrao' }}  mt-2 p-2 radius-4">
				  <div class="rows">
                            <div class="col-10">	
                                    <label class="text-label d-block text-branco">Nome </label>
                                    <input type="text" name="variacao" value="{{isset($variacaograde->variacao) ? $variacaograde->variacao : null}}"  class="form-campo">
                            </div>                                    
                            
                            <div class="col-2 mt-1 pt-1">
                                    <input type="submit" value="{{isset($variacaograde) ? 'Alterar' : 'Inserir' }}" class="width-100 btn btn-roxo text-uppercase">
                            </div>
                    </div>
                    </div>
            </div>
        </form>
    </div>
    </div>

		<div class="col">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                     
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                    <tr>
                                       
                                       <th align="center" width="20">Id</th>
                                       <th class="text-left" >Nome</th>
                                       <th align="center" width="70">Editar</th>
                                       <th align="center" width="30">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $cat)                                     
                             <tr>
								<td align="center">{{$cat->id}}</td>
                                <td align="left">{{$cat->variacao}}</td>											
                                <td align="center"><a href="{{route('admin.variacaograde.edit', $cat->id)}}" class="d-inline-block btn btn-circulo btn-verde btn-pequeno" title="Editar"><i class="fas fa-edit"></i></a>  </td>									
                                <td align="center">

                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$cat->id}}').submit() : '';" class="d-inline-block btn btn-circulo btn-vermelho btn-pequeno" title="Ecluir"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.variacaograde.destroy', $cat->id)}}" method="POST" id="apagar{{$cat->id}}">
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
				
				<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
		<div class="col-2 MostraOpcoes sm-mx" id="opcoes_cliente">
		
			<ul class="cx-opcoes" >
				<li class="titulo bg-padrao text-branco d-flex center-middle justify-content-space-between">
					<span>Categoria: <span id="id_cliente"></span> </span> 
					<a href="javascript:;" onClick="fechar_opcoes_cliente()" title="Fechar Opções" class="text-vermelho position-inherit p-0"><i class="fas fa-times position-inherit"></i></a>
				</li>
				
				<li><a href="javascript:;" onClick="salvarNfePorVenda()" title="Gerar Nota Fiscal"><i class="fas fa-scroll"></i> Gerar Nota Fiscal</a></li>
				<li><a href="javascript:;" onclick="verContaReceber()" class="" title="Visualizar Contas a Receber"><i class="fas fa-dollar-sign"></i> Ver Contas a Receber</a></li>
				<li><a href="javascript:;" onclick="verDetalhe()"><i class="fas fa-eye"></i> Ver Detalhes</a></li>
					
			<!-- AQUI AS DIVISÕES COM CATEGORIAS---
				<li class="titulo text-escuro pt-4 border-0">Subcat 01</li>
				<li class="ml-3 mr-3"><a href="javascript:;" onClick="salvarNfePorVenda()" title="Gerar Nota Fiscal"><i class="fas fa-arrow-right"></i> Gerar Nota Fiscal</a></li>
				<li class="ml-3 mr-3"><a href="javascript:;" onclick="verContaReceber()" class="" title="Visualizar Contas a Receber"><i class="fas fa-arrow-right"></i> Ver Contas a Receber</a></li>
				<li class="ml-3 mr-3"><a href="javascript:;" onclick="verDetalhe()"><i class="fas fa-arrow-right"></i> Ver Detalhes</a></li>
										

				<li class="titulo text-escuro pt-4 border-0">Subcat 02</li>
				<li class="ml-3 mr-3"><a href="javascript:;" onClick="salvarNfePorVenda()" title="Gerar Nota Fiscal"><i class="fas fa-arrow-right"></i> Gerar Nota Fiscal</a></li>
				<li class="ml-3 mr-3"><a href="javascript:;" onclick="verContaReceber()" class="" title="Visualizar Contas a Receber"><i class="fas fa-arrow-right"></i> Ver Contas a Receber</a></li>
				<li class="ml-3 mr-3"><a href="javascript:;" onclick="verDetalhe()"><i class="fas fa-arrow-right"></i> Ver Detalhes</a></li>
				
-->				

			</ul>
		</div>

        </div>
        </div>
<script>
var cliente_id = 0;
function abrir_opcoes_cliente(id){
	cliente_id = id;
	$("#id_cliente").html(id);
	mostrar_opcoes('opcoes_cliente')
	
}

function fechar_opcoes_cliente(){
	esconder_opcoes('opcoes_cliente');
}
</script>
        @endsection