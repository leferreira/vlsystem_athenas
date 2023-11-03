<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Tributações: {{$natureza->descricao ?? old('descricao') }} - {{ $natureza->tipo == "S" ? "Saída" : "Entrada"}}</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>
	
    

   <div id="tab">
	  
	  <div id="tab-1">
		<div class="p-2 mt-3 px-0">			
				<div class="col-12 text-right pb-0 pt-2">
        			<a href="javascript:;" onclick="abrirTelaInserirTributacaoLucro()"> + Inserir Tributação </a>
        		</div>
				<fieldset>
				<legend>Tributação</legend>
				<div class="rows">
        			<div class="col-12"> 
                    <fieldset class="mt-3 mb-0 p-0 border-0">              
                        <div class="tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                            <table cellpadding="0" cellspacing="0" id="" width="100%">
                                    <thead>
                                     <tr>
                                            <th align="center">#</th>
                                            <th align="center">Descrição</th>
                                            <th align="center">Cfop</th>
                                            <th align="center">CST ICMS</th>
                                            <th align="center">CST IPI</th>
                                            <th align="center">CST PIS</th>
                                            <th align="center">CST COFINS</th>
											<th align="center">Padrão</th>
                                            <th align="center">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody class="datatable-body">
                                    @foreach($natureza->tributacoes as $v)
                                    	<tr>
                                    		<td align="center">{{$v->id}}</td>
                                    		<td align="center">{{$v->descricao}}</td>
                                    		<td align="center">{{$v->cfop}}</td>
                                    		<td align="center">{{$v->cstICMS}}</td>
                                    		<td align="center">{{$v->cstIPI}}</td>
                                    		<td align="center">{{$v->cstPIS}}</td>
                                    		<td align="center">{{$v->cstCOFINS}}</td>                                    		
                                    		@if($v->padrao== 'S')
												<td align="center">Sim</td>
											@else
												<td><a href="javascript:;" onclick="tornarPadrao({{$v->id}})" title="Tornar Padrão" class="btn btn-azul btn-pequeno d-inline-block">Não</a></td>
											@endif
											
											<td align="center" width="400">
												@if($v->padrao=='N')	
													<a href="javascript:;" onclick="abrirTelaProduto({{$v->id}})" class="btn btn-azul btn-pequeno d-inline-block">Produtos</a>
												@else
													<a href="#" class="btn btn-cinza btn-pequeno d-inline-block">Produtos</a>
												@endif	
												<a href="javascript:;" onclick="abrirTelaIva({{$v->id}})" class="btn btn-azul btn-pequeno d-inline-block">IVA</a>												
												<a href="javascript:;" onclick="excluirTributacao({{$v->id}},'{{$v->padrao}}')" class="btn btn-vermelho btn-pequeno d-inline-block">Excluir</a>
												<a href="javascript:;" onclick="editarTributacaoLucro({{$v->id}})" class="btn btn-verde btn-pequeno d-inline-block">Editar</a>
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

@include("Admin.Configuracao.NaturezaOperacao.modalTributacaoLucro")
@include("Admin.Configuracao.NaturezaOperacao.modalProduto")
@include("Admin.Configuracao.NaturezaOperacao.modalIva")
<script>
	

	function buscarCstIpi(tipo){
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