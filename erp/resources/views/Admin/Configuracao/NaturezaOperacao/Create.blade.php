<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
		<span class="mb-0 h5"><i class="fas fa-cog"></i> Cadastrar Natureza de Operação</span>
		<div class="d-flex">		
			<a href="{{route('admin.index')}}" class="btn btn-pequeno btn-azul" title="Voltar home"><i class="fas fa-home"></i></a>
			<a href="" class="retorna btn btn-pequeno btn-roxo ml-1" title="Ver menu"><i class="fas fa-bars"></i></a>
		</div> 		
	</div>
	
    @if(isset($natureza))    
   <form action="{{route('admin.naturezaoperacao.update', $natureza->id)}}" method="POST">
       <input name="_method" type="hidden" value="PUT"/>
     @else                       
    	<form action="{{route('admin.naturezaoperacao.store')}}" method="Post">
    @endif
    	@csrf
    
   <div class="p-2 mt-3">
		<fieldset class="mt-4">
        <legend>Dados Gerais</legend>		
		<div class="rows">  
				    	    
                 <div class="col-4 mb-3">
						<label class="text-label">Descricao</label>	
						<input type="text" name="descricao" value="{{$natureza->descricao ?? old('descricao') }}"  class="form-campo">
				</div>
				<div class="col-2 mb-3">
						 <label class="text-label">Tipo</label>	
						 <select name="tipo" id="tipo" class="form-campo" >
						   <option value="">Selecione</option>
						 	<option value="S" {{ (($natureza->tipo ?? null) == "S") ? "selected" : null }}>Saída</option>
						 	<option value="E" {{ (($natureza->tipo ?? null) == "E") ? "selected" : null }}>Entrada</option>
						 </select>
				 </div>
				 
				  <div class="col-3  mb-3">
                        <label class="text-label">Indicador de Presença</label>
                        <select class="form-campo" name="indPres" id="indPres">
                            <option value="0" {{ (($natureza->indPres ?? null) == "0") ? "selected" : null }}>0 - NÃO SE APLICA</option>
                            <option value="1" {{ (($natureza->indPres ?? null) == "1") ? "selected" : null }}>1 - OPERAÇÃO PRESENCIAL</option>
                            <option value="2" {{ (($natureza->indPres ?? null) == "2") ? "selected" : null }}>2 - OPERAÇÃO NÃO PRESENCIAL, PELA INTERNET</option>
                            <option value="3" {{ (($natureza->indPres ?? null) == "3") ? "selected" : null }}>3 - OPERAÇÃO NÃO PRESENCIAL, TELEATENDIMENTO</option>
                            <option value="5" {{ (($natureza->indPres ?? null) == "5") ? "selected" : null }}>5 - OPERAÇÃO PRESENCIAL, FORA DO ESTABELECIMENTO</option>
                            <option value="9" {{ (($natureza->indPres ?? null) == "9") ? "selected" : null }}>9 - OPERAÇÃO NÃO PRESENCIAL, OUTROS</option> 
                        </select>
                </div>
               
               <div class="col-3 mb-3">
                    <label class="text-label">Finalidade da emissão</label>	
                    <select class="form-campo" name="finNFe" id="finNFe" onclick="verDocReferenciado()">
                        <option value="1" {{ (($natureza->finNFe ?? null) == "1") ? "selected" : null }}>1 - NORMAL</option>
                        <option value="2" {{ (($natureza->finNFe ?? null) == "2") ? "selected" : null }}>2 - COMPLEMENTAR</option>
                        <option value="3" {{ (($natureza->finNFe ?? null) == "3") ? "selected" : null }}>3 - DE AJUSTE</option>
                        <option value="4" {{ (($natureza->finNFe ?? null) == "4") ? "selected" : null }}>4 - DEVOLUÇÃO DE MERCADORIA</option>
                    </select>
              </div>
          
                <div class="col-2 mb-3">
                        <label class="text-label">Devolução ?</label>	
                        <select class="form-campo" name="devolucao" id="devolucao">
                                <option value="0" {{ (($natureza->devolucao ?? null) == "0") ? "selected" : null }}> NÃO</option>
                                <option value="1" {{ (($natureza->devolucao ?? null) == "1") ? "selected" : null }}>SIM</option>
                        </select>
                </div>
                
                <div class="col-3 mb-3">
                        <label class="text-label">Padrão</label>	
                        <select class="form-campo" name="padrao" id="padrao">
                        <option value="">Selecionar</option>
                       		   @foreach(ConstanteService::listaPadraoNatureza() as $chave=>$valor)
									<option value="{{$chave}}" {{($natureza->padrao ?? null) == $chave ? "selected" : null }}>{{$chave}} - {{$valor}}</option>
								@endforeach
                        </select>
                </div>
        
		</div>
		</fieldset>
		</div>

 
    <div class="p-2 mt-0">				
		
		<div class="col-12 text-center pb-4">
			<input type="hidden" id="natureza_operacao_id"  value="{{$natureza->id ?? null}}">   
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
</div>






<script>
	
	function abriTelaProdutoIcms(id){
		$("#tributacao_id").val(id);
		$("#tabela").html('Icms');
		buscarListaProdutoTributacao('Icms', id);
		abrirModal('#telaProduto');
	}
	
	function abriTelaProdutoIpi(id){
		$("#tributacao_id").val(id);
		$("#tabela").html('Ipi');	
		buscarListaProdutoTributacao('Ipi', id);
		abrirModal('#telaProduto');
	}
	
	function abriTelaProdutoPis(id){
		$("#tributacao_id").val(id);
		$("#tabela").html('Pis');
		buscarListaProdutoTributacao('Pis', id);
		abrirModal('#telaProduto');
	}
	
	function abriTelaProdutoCofins(id){
		$("#tributacao_id").val(id);
		$("#tabela").html('Cofins');
		buscarListaProdutoTributacao('Cofins', id);
		abrirModal('#telaProduto');
	}
	
	function buscarListaProdutoTributacao(tabela, id){
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