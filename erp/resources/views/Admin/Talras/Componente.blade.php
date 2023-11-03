@extends("Admin.template")
@section("conteudo")
<div class="col-12 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Componentes</span>
	<div class="p-2">
	<div class="rows mb-4">
		<div class="col-12">
			<span class="d-block h4 border-bottom">Modais livres</span>
			<span class="d-block h6">Links</span>
		</div>
			<div class="col-12">
			<div class="rows">
				<div class="col-4">
					<a href="#modalSucesso" >Modal livre sucesso </a> </br></br>
					<a href="#modalErro" >Modal livre erro </a> </br></br>
					<a href="#modallista" >Modal mensagem com lista </a> </br></br>
				</div>
				<div class="col-4">
					<a href="#giragira" >Modal gira gira </a> </br></br>
					<a href="#formModal" >formulário modal livre </a> </br></br>
					<a href="#modaltabela" >modal tabela</a> </br></br>
				</div>
			</div>
			</div>
		</div>
		<div class="rows">
		<div class="col-12">
		<span class="d-block h4 border-bottom">Componentes modais</span>
		<span class="d-block h6">Links</span>
			<div class="rows">
				<div class="col-4">
					<a href="javascript:;" onclick="abrirModal('#carregar')">Gira gira com Modal </a> </br></br>
					<a href="javascript:;" onclick="abrirModal('#mensagem')">Mensagem com modal</a> </br></br>
					<a href="javascript:;" onclick="abrirModal('#formulario')">Formulário Modal </a> </br></br>
					<a href="javascript:;" onclick="abrirModal('#notafiscal')">NOTA FISCAL ELETRÔNICA	</a> </br></br>
					<a href="javascript:;" onclick="abrirModal('#opcao1')">Modal com 1 botão</a> </br></br>
					<a href="javascript:;" onclick="abrirModal('#opcao2')">Modal com 2 botão</a> </br></br>
				</div>
			</div>
		</div>
		<div class="col-12 mt-4">
			<span class="d-block h4 border-bottom">Componentes mensagens estáticas</span>
			<span class="msg msg-verde"><i class="fas fa-check"></i> <b>Parabéns!</b> cadastro realizado com sucesso <a href="" class="sair">x</a></span>
			<span class="msg msg-vermelho"><i class="fas fa-bug"></i> <b>Ops!</b> ocorreu um erro no seu cadastro <a href="" class="sair">x</a></span>
			<span class="msg msg-amarelo"><i class="fas fa-info-circle"></i> <b>Importante!</b> cadastro realizado com sucesso <a href="" class="sair">x</a></span>
			<span class="msg msg-azul"><i class="fas fa-bullhorn"></i> <b>Aviso!</b> cadastro realizado com sucesso <a href="" class="sair">x</a></span>
		</div>
		<div class="col-12 mt-4">
			<span class="msg msg-azul">
				<i class="fas fa-bullhorn"></i> <b>Aviso!</b> mensagens com lista
				<ul>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
				</ul>
				<a href="" class="sair">x</a>
			
			</span>
			<span class="msg msg-verde">
				<i class="fas fa-check"></i> <b>Parabéns!</b> mensagens com lista
				<ul>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
				</ul>
				<a href="" class="sair">x</a>			
			</span>
			<span class="msg msg-amarelo">
				<i class="fas fa-info-circle"></i> <b>Importante!</b> mensagens com lista
				<ul>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
				</ul>
				<a href="" class="sair">x</a>			
			</span>
			<span class="msg msg-vermelho">
				<i class="fas fa-bug"></i> <b>Ops!</b> mensagens com lista
				<ul>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
				</ul>
				<a href="" class="sair">x</a>			
			</span>
		</div>
		
		<div class="col-12 my-4">
			<span class="d-block h4 border-bottom">Componentes Carregamento estaticos</span>
			<span class="d-inline-block mr-4"><img src="{{asset('assets/Componentes/img/load.gif')}}" width="20"></span>
			<span class="d-inline-block mx-4"><img src="{{asset('assets/Componentes/img/load.gif')}}" width="30"></span>
			<span class="d-inline-block mx-4"><img src="{{asset('assets/Componentes/img/load.gif')}}" width="40"></span>
			<span class="d-inline-block ml-4"><img src="{{asset('assets/Componentes/img/load.gif')}}" width="60"></span>
		</div>
	</div> 
	</div>
	

<!--Mensagens de alerta flutuante-->
<!--mensagem de erro--><span class="msg msg-vermelho position-fixed left top"><i class="fas fa-bug"></i> <b>Ops!</b> ocorreu um erro no seu cadastro1 <a href="" class="sair">x</a></span>
<!--mensagem de sucesso--><span class="msg msg-verde position-fixed right top"><i class="fas fa-check"></i> <b>Parabéns!</b> cadastro realizado com sucesso2 <a href="" class="sair">x</a></span>
<!--mensagem de importabte--><span class="msg msg-amarelo position-fixed bottom left"><i class="fas fa-info-circle"></i> <b>Importante!</b> cadastro realizado com sucesso3 <a href="" class="sair">x</a></span>
<!--mensagem de alerta ou aviso--><span class="msg msg-azul position-fixed bottom right"><i class="fas fa-bullhorn"></i> <b>Aviso!</b> cadastro realizado com sucesso4 <a href="" class="sair">x</a></span>



<!--MODAL GIRA GIRA-->
<div class="window load" id="carregar">
	<span class="text-load">Carregando</span>
</div>

<!--MODAL MENSAGEM-->
<div class="window msg msg-verde" id="mensagem">
	<i class="fas fa-check"></i> <b>Parabéns!</b> cadastro realizado com sucesso <a href="" class="sair fechar">x</a>
</div>

<!--MODAL NOTA FISACAL ELETRONICA-->
<div class="window medio" id="notafiscal">
	<div class="p-2 px-4">
			<span class="pt-4 d-block h3 border-bottom fw-700">Nota fiscal eletrônica</span>
		<div class="rows">
			<div class="col-12 mb-4"><span>Nota Nº 0000005 - Manoel jailton sousa</span></div>
                 <div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Selecione o serviço desejado</span>
                        <div class="width-100 border radius-4 d-flex center-middle">
							<div class="check radio p-4 d-block width-50">
								<label class="d-flex mb-1"><input type="checkbox" name="marcar" checked> Enviar nota fiscal por email</label>
								<label class="d-flex mb-1"><input type="checkbox" name="marcar"> Lançar estoque</label>
								<label class="d-flex"><input type="checkbox" name="marcar"> Lançar contas</label>
							</div>
							<span class="d-inline-block  width-50 text-center"><img src="{{asset('assets/Componentes/img/load.gif')}}" width="70"></span>
						</div>
                 </div>
				 <div class="col-12">
					<span class="msg msg-verde d-block"><i class="fas fa-check"></i> <b>Parabéns!</b> cadastro realizado com sucesso2 <a href="" class="sair">x</a></span>
					
					<span class="msg msg-vermelho d-block"><i class="fas fa-bug"></i> <b>Ops!</b> ocorreu um erro no seu cadastro1 <a href="" class="sair">x</a></span>
				 </div>
                                
         </div>
		 <div class="tfooter border-0 between">
			<div class="d-flex">
				<input type="submit" name="" class="btn btn-verde border-bottom" value="Enviar nota fiscal">  
				<input type="submit" name="" class="btn btn-azul border-bottom" value="botão 2">  
				<input type="submit" name="" class="btn btn-azul border-bottom" value="botão 3">  
		 </div>
			<a href="" class="btn btn-vermelho fechar">Fechar</a>
		 </div>
	</div>
</div>
</div>


<!--MODAL MENSAGEM-->
<div class="window form" id="formulario">
	<div class="p-2 px-4">
			<span class="d-block h3 border-bottom fw-700">Nota fiscal eletrônica</span>
		<div class="rows">
            	<div class="col-6 mb-3">
                         <span class="text-label">Produto</span>
                         <select class="form-campo" name="produto_id">
                           	<option value=""></option>                                     
                         </select>
                 </div>
                 <div class="col-4 mb-3">
                         <span class="text-label">Categoria</span>
                         <select class="form-campo" name="categoria_id">
                           	<option value=""></option>                                   
                         </select>
                 </div>
                 <div class="col-2 mb-3">
                         <span class="text-label">Preço Venda</span>
                         <input type="text" name="preco" placeholder="Digite aqui..." class="form-campo">
                 </div>
                 
                 <div class="col-4 mb-3">
                         <span class="text-label">Largura (cm)</span>
                         <input type="text" name="largura" placeholder="Digite aqui..." class="form-campo">
                 </div>
                 <div class="col-2 mb-3">
                         <span class="text-label">Altura(cm)</span>
					<div class="radio">
                         <label class="d-block"><input type="radio" name="marcar" checked> Marcar</label>
                         <label class="d-block"><input type="radio" name="marcar"> Marcar</label>
					</div>
                 </div>
                 <div class="col-6 mb-3">
                         <span class="text-label">Peso Bruto</span>
                        <div class="check">
							<label class="d-flex"><input type="checkbox" name="marcar" checked> Marcar</label>
							<label class="d-flex"><input type="checkbox" name="marcar"> Marcar</label>
							<label class="d-flex"><input type="checkbox" name="marcar"> Marcar</label>
							<label class="d-flex"><input type="checkbox" name="marcar"> Marcar</label>
						</div>
                 </div>
                                               
                   
                 <div class="col-3 mb-3">
                         <span class="text-label">Destaque</span>
                         <select class="form-campo" name="destaque">                                            
                           	<option value="S">Sim</option>
                           	<option value="N" selected>Não</option>                                          
        			   </select>
                 </div>
                 <div class="col-3 mb-3">
                         <span class="text-label">Controla Estoque </span>
                         <select class="form-campo" name="controlar_estoque">                                            
                           	<option value="S">Sim</option>
                           	<option value="N">Não</option>
                           
        			   </select>
                 </div>
                  <div class="col-6 mb-3">
                         <span class="text-label">imagem </span>
                         <input type="file" name="" class="form-campo">
                 </div>
                    
                 <div class="col-12 mb-3">
                         <span class="text-label">Descrição</span>
                         <textarea rows="10" cols="60" name="descricao" class="form-campo"></textarea>
                 </div>
         </div>
		 <div class="tfooter end">
			<a href="" class="btn btn-neutro fechar">Fechar</a>
			<input type="submit" name="" class="btn btn-azul border-bottom" value="Cadastrar">  
		 </div>
	</div>
</div>


<!--MODAL OPÇÃO	-->
<div class="window menor" id="opcao1">
	<span class="tmodal msg msg-verde"><i class="fas fa-check"></i> <b>Parabéns!</b></span>
	<div class="p-3 text-center">
		<p class="mb-3">Parabéns! Clique no botão abaixo para continuar</p>
		<input type="submit" name="" class="btn btn-azul m-auto" value="Ok"> 
	</div>
	
	<div class="tfooter end">
		<a href="" class="btn btn-neutro fechar p-0">Fechar</a> 
	</div>
</div>

<!--MODAL OPÇÃO	-->
<div class="window menor" id="opcao2">
	<span class="tmodal msg msg-vermelho text-branco"><i class="fas fa-trash"></i> <b>Excluir item</b></span>
	<div class="p-3 text-center">
		<p class="mb-3">Tem certeza que deseja excluir este item?</p>
	</div>
	
	<div class="tfooter end">
		<a href="" class="btn btn-vermelho fechar">Não</a> 
		<a href="" class="btn btn-verde">Sim</a> 
	</div>
</div>

/*modal Livre sucesso*/
<div id="modalSucesso" class="modal verde">
<div class="text-center box">
 <a href="#fechar" title="Fechar" class="fecharModal">x</a>

	<!-- ESTE QUANDO SUCESSO --->
	<i class="fas fa-check h1" aria-hidden="true"></i> 
	<span class="d-block h5"><b>Parabens!</b> Sua venda foi completada com sucesso</span>
</div>
</div>

/*modal erro erro*/
<div id="modalErro" class="modal vermelho">
<div class="text-center box">
 <a href="#fechar" title="Fechar" class="fecharModal">x</a>
	<i class="fas fa-bug h1 " aria-hidden="true"></i> 
	<span class="d-block h5"><b>Ops!</b> Por favor, insira algum item antes</span>	
</div>
</div>

/*modal erro lista*/
<div id="modallista" class="modal azul"><!--Aqui troca a cor tambem verde, amarelo, vermelho e azul-->
<div class="box">
 <a href="#fechar" title="Fechar" class="fecharModal">x</a>
				<i class="fas fa-bullhorn"></i> <b>Aviso!</b> mensagens com lista
				<ul>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
					<li>Lista de mensagens</li>
				</ul>		
</div>
</div>

/*modal gira gira*/
<div id="giragira" class="modal">
<div class="box">
 <a href="#fechar" title="Fechar" class="fecharModal">x</a>
	<div class="load"></div>
	<span class="text-load">Carregando</span>
</div>
</div>


<!--FORMULARIO MODAL-->
<div class="modal form" id="formModal">
	<div class="box">
 <a href="#fechar" title="Fechar" class="fecharModal">x</a>
		<span class="d-block h3 border-bottom fw-700">formulario</span>
		<div class="rows">
            	<div class="col-6 mb-3">
                         <span class="text-label">Produto</span>
                         <select class="form-campo" name="produto_id">
                           	<option value=""></option>                                     
                         </select>
                 </div>
                 <div class="col-4 mb-3">
                         <span class="text-label">Categoria</span>
                         <select class="form-campo" name="categoria_id">
                           	<option value=""></option>                                   
                         </select>
                 </div>
                 <div class="col-2 mb-3">
                         <span class="text-label">Preço Venda</span>
                         <input type="text" name="preco" placeholder="Digite aqui..." class="form-campo">
                 </div>
                 
                 <div class="col-4 mb-3">
                         <span class="text-label">Largura (cm)</span>
                         <input type="text" name="largura" placeholder="Digite aqui..." class="form-campo">
                 </div>
                 <div class="col-2 mb-3">
                         <span class="text-label">Altura(cm)</span>
					<div class="radio">
                         <label class="d-block"><input type="radio" name="marcar" checked> Marcar</label>
                         <label class="d-block"><input type="radio" name="marcar"> Marcar</label>
					</div>
                 </div>
                 <div class="col-6 mb-3">
                         <span class="text-label">Peso Bruto</span>
                        <div class="check">
							<label class="d-flex"><input type="checkbox" name="marcar" checked> Marcar</label>
							<label class="d-flex"><input type="checkbox" name="marcar"> Marcar</label>
							<label class="d-flex"><input type="checkbox" name="marcar"> Marcar</label>
							<label class="d-flex"><input type="checkbox" name="marcar"> Marcar</label>
						</div>
                 </div>
                                               
                   
                 <div class="col-3 mb-3">
                         <span class="text-label">Destaque</span>
                         <select class="form-campo" name="destaque">                                            
                           	<option value="S">Sim</option>
                           	<option value="N" selected>Não</option>                                          
        			   </select>
                 </div>
                 <div class="col-3 mb-3">
                         <span class="text-label">Controla Estoque </span>
                         <select class="form-campo" name="controlar_estoque">                                            
                           	<option value="S">Sim</option>
                           	<option value="N">Não</option>
                           
        			   </select>
                 </div>
                  <div class="col-6 mb-3">
                         <span class="text-label">imagem </span>
                         <input type="file" name="" class="form-campo">
                 </div>
                    
                 <div class="col-12 mb-3">
                         <span class="text-label">Descrição</span>
                         <textarea rows="10" cols="60" name="descricao" class="form-campo"></textarea>
                 </div>
         </div>
		 <div class="tfooter end">
			<a href="" class="btn btn-neutro fechar">Fechar</a>
			<input type="submit" name="" class="btn btn-azul border-bottom" value="Cadastrar">  
		 </div>
	</div>
</div>


/*Mdal com tabela*/
<div id="modaltabela" class="modal maior">
<div class="box">
 <a href="#fechar" title="Fechar" class="fecharModal">x</a>
<div clas="">
	<table cellpadding="0" cellspacing="0" class="table" id="dataTable" width="100%">
		<thead>
			<tr>
				<th>Exemplo 1</th>
				<th>Exemplo 1</th>
				<th>Exemplo 1</th>
				<th>Exemplo 1</th>
				<th>Exemplo 1</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td align="center">Exemplo 1</td>
				<td align="center">Exemplo 1</td>
				<td align="center">Exemplo 1</td>
				<td align="center">Exemplo 1</td>
				<td align="center">
					<a href="" class="btn btn-verde d-inline-block btn-pequeno" >Editar</a>
					<a href="" class="btn btn-vermelho d-inline-block btn-pequeno" >Excluir</a>
				</td>
			</tr>
			<tr>
				<td align="center">Exemplo 1</td>
				<td align="center">Exemplo 1</td>
				<td align="center">Exemplo 1</td>
				<td align="center">Exemplo 1</td>
				<td align="center">
					<a href="" class="btn btn-verde d-inline-block btn-pequeno" >Editar</a>
					<a href="" class="btn btn-vermelho d-inline-block btn-pequeno" >Excluir</a>
				</td>
			</tr>
			<tr>
				<td align="center">Exemplo 1</td>
				<td align="center">Exemplo 1</td>
				<td align="center">Exemplo 1</td>
				<td align="center">Exemplo 1</td>
				<td align="center">
					<a href="" class="btn btn-verde d-inline-block btn-pequeno" >Editar</a>
					<a href="" class="btn btn-vermelho d-inline-block btn-pequeno" >Excluir</a>
				</td>
			</tr>
		</tbody>
	</table>
</div>
</div>
</div>


<!--Fundo Preto-->
<div id="fundo_preto"></div>

 
</div>
@endsection