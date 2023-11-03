@if(Session::has('janela_atencao1'))  
    <div class="window menor" id="janela_atencao1">
    	<div class="p-3 text-center pt-4">
			<span class="h1 text-center"><i class="fas fa-info-circle" style="font-size:5rem; color: #ffbc00;"></i></span>
			<span class="d-block text-center h2 text-vermelho"> <b>Atenção!</b></span>
    		<p class="mb-3">{{Session::get('janela_atencao1')}}</p>
    	</div>
    	
    	<div class="tfooter center border-0 pb-5">
    		<a href="" class="btn btn-vermelho fechar">Fechar</a> 
    	</div>
    </div>
@endif


@if(Session::has('janela_excluir'))
<div class="window menor" id="janela_excluir">
	<span class="tmodal msg msg-vermelho text-branco"><i class="fas fa-trash"></i> <b>Excluir item</b></span>
	<div class="p-3 text-center">
		<p class="mb-3">Tem certeza que deseja excluir este item?</p>
	</div>
	
	<div class="tfooter end">
		<a href="" class="btn btn-vermelho fechar">Não</a> 
		<a href="" class="btn btn-verde">Sim</a> 
	</div>
</div>
@endif

@if(Session::has('janela_excluir11'))

<div class="window menor" id="janela_atencao2">
    	<span class="tmodal msg msg-vermelho text-branco"><i class="fas fa-trash"></i> <b>Excluir item</b></span>
    	<div class="p-3 text-center">
    		<p class="mb-3">Tem certeza que deseja excluir este item?</p>
    	</div>
    	
    	<div class="tfooter end">
    		<a href="" class="btn btn-vermelho fechar">Não</a> 
    		<a href="" class="btn btn-verde">Sim</a> 
    	</div>
    </div>
@endif

@if(Session::has('janela_atencao1'))  
    <script>
    	abrirModal("#janela_atencao1");
    </script>
@endif

<div id="modalLivreListaComErros" class="modal_livre msg-vermelho medio">
    <div class="p-2">
     <a href="javascript:;" title="Fechar" class="fechar_livre">x</a>
			<i class="fas fa-bullhorn"></i> <b>Atenção!</b> Aconteceram os seguintes Erros
				<ol id="listaErroModal"></ol>	
    </div>
  </div>
  
<div id="modalLivreErro" class="modal_livre msg-vermelho medio">
    <div class="text-center box">
     <a href="javascript:;" title="Fechar" class="fechar_livre">x</a>
    	<i class="fas fa-bug h1 " aria-hidden="true"></i> 
    	<span class="d-block h5"><b>Ops!</b><span id="erroModalLivre">Por favor, insira algum item antes</span></span>	
    </div>
</div>

