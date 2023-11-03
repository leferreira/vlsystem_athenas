 <script>
        var id_nfe = "<?php echo $notafiscal->id_nfe ?>";
    </script>

<section class="conteudo">			
	<div class="conteudo-fluido">
				<div class="rows">	
                <div class="col-12">
                <form action="<?php echo URL_BASE ."NotaFiscal/finalizar"?>" method="post">
                <div class="caixa">                   

                <div class="p-2 pb-4 pt-4 width-100 float-left">
					<div id="tab">
                         <ul class="tabs">
                                <li><a href="#tab-1">Dados gerais</a></li>
                                <li><a href="#tab-2">Emitente</a></li>
                                <li><a href="#tab-3">Destinatário</a></li>
                                <li><a href="#tab-4">Produtos</a></li>
                                <li><a href="#tab-5">Totais</a></li>
                                <li><a href="#tab-6">Transporte</a></li>
                                <li><a href="#tab-7">Cobrança</a></li>
                                <li><a href="#tab-8">Adicionais</a></li>
                                <li><a href="#tab-9">Pagamentos</a></li>
                                <li><a href="#tab-10">Exportação</a></li>
                                <li><a href="#tab-11">Autorizados</a></li>
                        </ul>		
     
						 <script src="<?php echo URL_BASE ."assets/js/NFE/tabDestinatario_js.js" ?>"> </script>
						 <script src="<?php echo URL_BASE ."assets/js/NFE/tabIdentificacao_js.js" ?>"> </script>
						 <script src="<?php echo URL_BASE ."assets/js/NFE/tabDuplicata_js.js" ?>"> </script>
						 <script src="<?php echo URL_BASE ."assets/js/NFE/tabCobranca_js.js" ?>"> </script> 
						 <script src="<?php echo URL_BASE ."assets/js/NFE/tabAdicionais_js.js" ?>"> </script>    
						 <script src="<?php echo URL_BASE ."assets/js/NFE/tabPagamento_js.js" ?>"> </script>  
						 <script src="<?php echo URL_BASE ."assets/js/NFE/tabExportacao_js.js" ?>"> </script>  
						 <script src="<?php echo URL_BASE ."assets/js/NFE/tabAutorizado_js.js" ?>"> </script>            
		
		
				<div id="tab-1" class="cx-tab">                                        
							<?php include "TabIdentificacao.php" ?>
				</div>		
				
				<div id="tab-2" class="cx-tab">             
					 <?php include "TabEmitente.php" ?>
				</div>	

				<div id="tab-3" class="cx-tab">          
					<?php include "TabDestinatario.php" ?>
				</div> 
			
				<div id="tab-4" class="cx-tab">									
					<?php include "TabProduto.php" ?>
				</div>
							
				<div id="tab-5" class="cx-tab">									
					<?php include "TabTotalizadores.php" ?>
				</div>

				<div id="tab-6" class="cx-tab">		
					<?php include "TabTransporte.php" ?>			   
				</div>  

				<div id="tab-7" class="cx-tab">									
					<?php include "TabCobranca.php" ?>	
				</div> 
				
				<div id="tab-8" class="cx-tab">									
					<?php include "TabAdicionais.php" ?>	
				</div>
				  
				<div id="tab-9" class="cx-tab">									
					<?php include "TabPagamento.php" ?>	
				</div> 
				
				<div id="tab-10" class="cx-tab">									
					<?php include "TabExportacao.php" ?>	
				</div> 
				<div id="tab-11" class="cx-tab">									
					<?php include "TabAutorizado.php" ?>	
				</div>        
		
				</div>            
		</div>

    <div class="d-inline-block width-100 mb-5 mt-4" style="clear:both">
        <input type="hidden" name="id_nfe" value="1">
        <input type="submit" value="Finalizar NOTA" class="btn btn-azul btn-grande d-block m-auto">
    </div>
    </form>	
    </div>


    </div>
    </div>
</div>

</section>
<!--carregar modal-->
    <div class="window carregar" id="carregar">
        <div class="caixa mb-0">
                <img src="<?php echo URL_BASE ."assets/img/ajax-loader_1.gif"?>" width="55" height="55">
                <span>Aguarde carregando...</span>
        </div>
    </div>


	
	<!--cadastro de produto-->
	<div class="window" id="janela_produto">
		<div class="caixa mb-0">
			<div class="caixa-titulo">
					Cadastrar Produto
			</div>
			<div class="rows p-4">
                <div class="col-12">
                        <label class="text-label">Titulo do produto</label>
                        <input type="text" value="" name="produto" placeholder="Digite aqui..." class="form-campo">
                </div>
                <div class="col-4">
                        <label class="text-label">Categoria</label>
                        <select class="form-campo" name="id_categoria">
                             
                            <option value="1"> Panela</option><option value="2"> Cuzcuzeira</option><option value="3"> Copo</option><option value="4"> Caneca</option><option value="5"> Papeiro</option><option value="6"> Leiteira</option><option value="7"> Frigideira</option><option value="8"> Bacia</option><option value="9"> Balde</option><option value="10"> Assadeira</option>                                                
                        </select>
                </div>
                <div class="col-4">
                        <label class="text-label">Código Personalizado</label>
                        <input type="text" name="codigo_personalizado" value="" placeholder="Digite aqui..." class="form-campo">
                </div>
                <div class="col-4">
                        <label class="text-label">Unidade</label>
                        <select class="form-campo" name="id_unidade">
                                <option value="1"> Unidade</option><option value="3"> Pacote</option><option value="4"> Kilograma</option>                                        </select>
                </div>
               
                <div class="col-6">
                        <label class="text-label">Upload da imagem</label>
                        <input type="file" name="arquivo" class="form-campo">
                </div>
                <div class="col-6">
                        <label class="text-label">Nome do arquivo</label>
                        <input type="text" value="" name="nome_do_arquivo" placeholder="Digite aqui..." class="form-campo">
                </div>
                <div class="col-4">
                        <label class="text-label">Preço Alto</label>
                        <input type="text" name="preco_alto" value="" placeholder="Digite aqui..." class="form-campo">
                </div>
                <div class="col-4">
                        <label class="text-label">Preço atual</label>
                        <input type="text" name="preco" value="" placeholder="Digite aqui..." class="form-campo">
                </div>												

                <div class="col-4">
                        <label class="text-label">Ativo</label>
                        <select class="form-campo" name="ativo">
                                <option value="S">Sim</option>                                                 
                                <option value="N">Não</option> 
                        </select>
                </div>
            </div>  
			<div class="caixa-rodape text-right">
					<input type="submit" value="Salvar" class="btn d-inline-block">
					<button class="btn btn-vermelho d-inline-block fechar">Fechar</button>
			</div>
		</div>
	</div>
        
        

	
	<?php 
            include "janela/salvar_produto.php" ;
            include "janela/lista_emitente.php" ;
            include "janela/lista_contato.php" ;
            include "janela/lista_generica.php" ;
            include "janela/lista_transportadora.php" ;
            include "janela/create_duplicata.php" ;
        
        ?>
	
      
<div id="fundo_preto"></div>