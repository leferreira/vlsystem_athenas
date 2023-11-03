@extends("Admin.template")
@section("conteudo")


<section class="col-12 central mb-3">	
	<div class="">
	 <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                            <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Nota NFE <span class="text-orange"></span></span>
                    </div>

				<div class="rows">	
                <div class="col-12">               
                <div class="p-2 pb-0 pt-4 width-100 float-left">
					<div id="tab" style="padding:0!important">
                         <ul class="tabs">
                                <li><a href="#tab-1">Dados gerais</a></li>
                                <li><a href="#tab-2">Emitente</a></li>
                        </ul>                       
                        <script src="{{asset('assets/js/NFE/tabIdentificacao_js.js')}}"></script>			        
		
				<div id="tab-1" class="cx-tab">                                        
					@include("Admin.Nfe.TabIdentificacaoNovo")
				</div>		
				
				<div id="tab-2" class="cx-tab">             
					 @include("Admin.Nfe.TabEmitente")
				</div>	
       
			
				</div>            
		</div>

    <div class="d-inline-block width-100 mb-5 mt-0" style="clear:both">
        <input type="hidden" name="id_nfe" value="1">
        <input type="submit" value="Finalizar NOTA" class="btn btn-azul d-block m-auto">
    </div>
    </div>


    </div>
    </div>
</div>

</section>
<!--carregar modal-->
    <div class="window carregar" id="carregar">
        <div class="caixa mb-0">
                <img src="{{asset('assets/img/ajax-loader_1.gif')}}" width="55" height="55">
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
@endsection