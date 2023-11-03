<div class="conteudo px-4">
	<div class="rows">	
        <div class="col-12">
           <div class="caixa">
                    <div class="caixa-titulo py-1 d-inline-block width-100">
                        <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Adicionar produto</span>
                    </div>
					
                <div class="p-2 pb-0 pt-4  mb-4 width-100 float-left">
					<div id="tab">
                         <ul class="tabs tab-alt">
                                <li><a href="#tab-1">Dados</a></li>
                                <li><a href="#tab-2">Tributos</a></li>
                                <li><a href="#tab-3">Informações adicionais</a></li>
                                <li><a href="#tab-4">Declarações de importação</a></li>
                                <li><a href="#tab-5">Exportação</a></li>
                                <li><a href="#tab-6">veículo</a></li>
                                <li><a href="#tab-7">Medicamentos/materia prima</a></li>
                                <li><a href="#tab-8">Armamentos</a></li>
                                <li><a href="#tab-9">Combustivel</a></li>
                                <li><a href="#tab-10">Papel imune</a></li>
                                <li><a href="#tab-11">Rastreabilidade</a></li>
                        </ul>		
       
                    
			<div id="tab-1" class="cx-tab">				
                <div class="rows pb-4">
                        <div class="col-12 mb-0">
                            <label class="text-label"><span class="text-vermelho">*</span> Código</label>
							<div class="text-between d-flex">
                                <input type="text" name="numero_nfe" value="00000001" placeholder="Digite aqui..." class="form-campo">
								<input type="submit" value="pesquisar" class="ml-2 btn">
							</div>
                        </div>
                        <div class="col-12 mb-0">
                                <label class="text-label"><span class="text-vermelho">*</span> Descrição </label>	
                                <input type="text" name="id_pedido" value="1" placeholder="Digite aqui..." class="form-campo">
                        </div>

                        <div class="col-3 mb-0">
                                <label class="text-label"><span class="text-vermelho">*</span> NCM</label>	                                
                                <input type="text" name="" value="1" placeholder="Digite aqui..." class="form-campo">
                        </div>

                        <div class="col-3 mb-0">
                                <label class="text-label">EX TIPI</label>	                      
                                <input type="text" name="" value="1" placeholder="Digite aqui..." class="form-campo">                              
                        </div>
                        <div class="col-3 mb-0">
                                <label class="text-label">CEST </label>	
                                 <select class="form-campo" name="id_cfop" id="id_cfop">
                                    <option value="">Selecione uma Opção</option>
                                </select>  
                        </div>
                                 <div class="col-3 mb-0">
                                    <label class="text-label"><span class="text-vermelho">*</span> CFOP</label>	
									<select class="form-campo" name="id_cfop" id="id_cfop">
										<option value="">Selecione uma Opção</option>
									</select>   
                                </div>
                                <div class="col-3 mb-0">
                                        <label class="text-label"><span class="text-vermelho">*</span>Uni. comercial</label>	
                                        <input type="text" name="data_emissao_nfe" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-3 mb-0">
                                        <label class="text-label"><span class="text-vermelho">*</span>Qtd. comercial</label>	
                                        <input type="text" name="hora_emissao_nfe" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>                             
                    
                                <div class="col-3 mb-0">
                                        <label class="text-label"><span class="text-vermelho">*</span>Valor unit. comercial</label>	
                                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>                     
                                <div class="col-3 mb-0">
                                    <label class="text-label"><span class="text-vermelho">*</span> Uni. trib</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>               
                                <div class="col-3 mb-0">
                                    <label class="text-label"><span class="text-vermelho">*</span> Qtd. trib</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>       
                                <div class="col-3 mb-0">
                                    <label class="text-label"><span class="text-vermelho">*</span> Valor. unit. trib</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>     
                                <div class="col-3 mb-0">
                                    <label class="text-label"> Tot. seguro</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-3 mb-0">
                                    <label class="text-label"> Desconto</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>
                    
                                <div class="col-3 mb-0">
                                    <label class="text-label"> Tot. frete</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>
								
                                <div class="col-3 mb-0">
                                    <label class="text-label"> EAN</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-3 mb-0">
                                    <label class="text-label"> EAN trib.</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-3 mb-0">
                                    <label class="text-label"> Outras despesas acessorios</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-2 mb-0">
                                    <label class="text-label"> Valor tot. bruto </label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-6 mt-4">										
                                    <input type="checkbox" name="" value="" class="d-inline-block">
                                    <label class="text-label d-inline-block"><b> O valor total Bruto compõe o valor total dos produtos e serviços</b> </label>
                                </div>
                                <div class="col-4 mb-0">
                                    <label class="text-label"> Pedido de compra </label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-4 mb-0">
                                    <label class="text-label"> Número do item do pedido de compra </label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div> 
                                <div class="col-4 mb-0">
                                    <label class="text-label"> Produto especifico</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div> 
                                <div class="col-4 mb-0">
                                    <label class="text-label"> Número de controle da FCI</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>                                  
                                <div class="col-12 mt-4">										
                                    <input type="checkbox" name="" value="" class="d-inline-block">
                                    <label class="text-label d-inline-block"> <b>Indicador de escala relevante </b></label>
                                </div>                                      
                                <div class="col-6 mb-0">										
                                    <label class="text-label"> CNPJ do fabricante</label>	
                                    <input type="date" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>                                       
                                <div class="col-6 mb-0">										
                                    <label class="text-label"> Código de beneficio da UF</label>	
                                    <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                                </div>                                        
							
							<div class="col-12 mt-4">
								<div class=" border radius-4 p-2 py-1">	
										<div class="col-12 position-relative">
											<label class="text-label"> Inserir NVE</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											<button class="btn position-absolute" style="right:10px;top:1.4rem">Inserir</button>
										</div>
									<div class="col-12 ">
									<div class="tabela-responsiva  scroll-200 px-0">
										<table cellpadding="0" cellspacing="0" class="table border">
											<thead>
												<tr>
													<th width="30">
														Selecionar todos
													</th>
													<th width="5">Item</th>
													<th>NVE</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td align="center">
														<input type="checkbox" name="" value="" class="d-inline-block">
														<label class="text-label d-inline-block"></label>
													</td>
													<td align="left">Item</td>
													<td align="center">NVE</td>
												</tr>
											</tbody>
										</table>
										
									</div>
									</div>
								</div>
							</div>
                </div>
        </div>
                    
		<div id="tab-2" class="cx-tab">				
            <div class="rows pb-4 pt-2">
				<div class="col-12 d-flex">
					<span>Valor total dos tributos</span>
					<div class="ml-3"><input typr="text" value="" class="form-campo"></div>
				</div>
				
				<div class="col-12 mt-3">
					<input type="radio" name="mudar" value="icms" id="icms"><label for="icms" class="pr-4">ICMS</label>
					<input type="radio" name="mudar" value="issqn" id="issqn"><label for="issqn">ISSQN</label>
					<!--abas internas-->
				<div class="mt-3">
						<div id="tabs">
							<ul>
								<li><a href="#aba-1">ICMS</a></li>
								<li><a href="#aba-2">IPI</a></li>
								<li><a href="#aba-3">PIS</a></li>
								<li><a href="#aba-4">CONFIS</a></li>
								<li><a href="#aba-5">Imposto de importação</a></li>
								<li><a href="#aba-6">ISSQN</a></li>
								<li><a href="#aba-7">IPI devolvido</a></li>
								<li><a href="#aba-8">ICMS em operações interestaduais</a></li>
							</ul>
							<div id="aba-1">
								<div class="col-12 mb-0">
									<label class="text-label"><span class="text-vermelho">*</span> Regime simples</label>
									<select class="form-campo">
										<option>Selecionar</option>
									</select>
								</div>
								<div class="col-12">
									<fieldset class="p-2">
										<legend>Simples nacional</legend>
									<div class="rows">
										<div class="col-6 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> Situação triburaria</label>
											<select class="form-campo">
												<option>Selecionar</option>
											</select>
										</div>
										<div class="col-6 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> Origem</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> Alíquota aplicavel de calculo do crédito</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> Crédito do ICMS que pode ser aproveitado</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
									</div>
									</fieldset>
									
									<fieldset class="p-2">
										<legend>ICMS</legend>
									<div class="rows">
										<div class="col-6 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> Modalida. determ. da BC ICMS</label>
											<select class="form-campo">
												<option>Selecionar</option>
											</select>
										</div>
										<div class="col-6 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> BC ICMS</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> Alíquota do ICMS</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> ICMS</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
									</div>
									</fieldset> 
								</div>
								
							</div>
							<div id="aba-2">
								<div class="col-12">
									<fieldset class="p-2">
										<legend>IPI</legend>
									<div class="rows">
										<div class="col-6 mb-0">
											<label class="text-label">Situação triburaria</label>
											<select class="form-campo">
												<option>Selecionar</option>
											</select>
										</div>
										<div class="col-6 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> Código de enquadramento</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">CNPJ do produtor</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">Código do selo de controle</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">Qtf. do selo de controle</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">Tipo de cálculo</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-3 mb-0">
											<label class="text-label">Alíquota</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-3 mb-0">
											<label class="text-label">Qtd. total unidade padrão</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-3 mb-0">
											<label class="text-label">Valor por unidade</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-3 mb-0">
											<label class="text-label">Valor do IPI</label> 
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-12 mt-4">
											<label class="text-label"><small>A informação do código de selo, quando aplicavel, deve ser informada utilizando a codificação prevista nos atos normativos editados pela Receita Federal.</small></label> 
										</div>
									</div>
									</fieldset>
								</div>
							</div>
							
							<div id="aba-3">
								<div class="rows">
									<div class="col-6">
										<fieldset class="p-2">
										<legend>PIS</legend>
									<div class="rows">
										<div class="col-12 mb-0">
											<label class="text-label"><span class="text-vermelho">*</span> Situação triburaria</label>
											<select class="form-campo">
												<option>Selecionar</option>
											</select>
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">Tipo de cálculo</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">Valor da base de cálculo</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">Alíquota (percentual)</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">Alíquota (em reais)</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">Quantidade vendida</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div>
										<div class="col-6 mb-0">
											<label class="text-label">Valor PIS</label>
											<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
										</div> 
									</div>
									</fieldset>
									</div>
									
									<div class="col-6 d-flex">
									<fieldset class="p-2 width-100">
										<legend>PIS ST</legend>
										<div class="rows">
											<div class="col-6 mb-0">
												<label class="text-label">Tipo de cálculo</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor da base de cálculo</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Alíquota (percentual)</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Alíquota (em reais)</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Quantidade vendida</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor PIS ST</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div> 
										</div>
									</fieldset>
									</div>
								</div>
							</div>
							
							<div id="aba-4">
								<p>É A mesma estrutura do anrterior</p>
							</div>
							
							<div id="aba-5">								
									<div class="col-12">
									<fieldset class="p-2 width-100">
										<legend>Imposto de importação</legend>
										<div class="rows">
											<div class="col-6 mb-0">
												<label class="text-label">Valor da base de cálculo</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor despesas aduaneiras</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor do IOF</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor imposto de importação</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
										</div>
									</fieldset>
									</div>
							</div>
							
							<div id="aba-6">
								<p>Conteudo da aba 6.</p>
							</div>
							
							<div id="aba-7">
								<div class="col-12">
									<fieldset class="p-2 width-100">
										<legend>IPI devolvido</legend>
										<div class="rows">
											<div class="col-6 mb-0">
												<label class="text-label">Percentual da mercadoria devolvida</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor do IPI devolvido</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
										</div>
									</fieldset>
								</div>
							</div> 
							
							<div id="aba-8">
								<div class="col-12">
									<fieldset class="p-2 width-100">
										<legend>IPI devolvido</legend>
										<div class="rows">
											<div class="col-6 mb-0">
												<label class="text-label">Percentual ICMS relativo ao FCP na UF de destino</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor da base cálculo na UF de destinatário</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor da base cálculo  FCP na UF do destinatário</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Alíquota interna da UF do destinatário</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Alíquota interestadual</label>
												<select class="form-campo">
													<option>Selecionar</option>
												</select>
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Percentual provisória de partilha</label>
												<select class="form-campo">
													<option>Selecionar</option>
												</select>
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor ICMS de partilha para UF do destinatário</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor ICMS de partilha para UF do remetente</label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
											<div class="col-6 mb-0">
												<label class="text-label">Valor ICMS relativo ao FCP da UF de destino<label>
												<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
											</div>
										</div>
									</fieldset>
								</div>
							</div>
							
					</div>  
				</div>
				</div>
		</div>
		</div>
                    
		<div id="tab-4" class="cx-tab">				
            <div class="rows pb-4">
			<div class="col-12">
				<div class="tabela-responsiva  rolagem-340 border radius-4">
					<span class="d-block text-label">Declarações de importação (100 no máximmo)</span>
					<table cellpadding="0" cellspacing="0" class="table border">
						<thead>
							<tr>
								<th width="120">
									<input type="checkbox" name="" value="" class="d-inline-block">
									Marcar todos
								</th>
								<th width="5">Item</th>
								<th>Número</th>
								<th>Data</th>
								<th>UF desemb. aduaneiro</th>
								<th>Local desemb. aduaneiro</th>
								<th>Data desemb. aduaneiro</th>
								<th>Exportador</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
						</tbody>
					</table>										
				</div>
				<div class="mt-2">
					<a  href="#janela" rel="modal" class="btn d-inline-block">Incluir</a>
					<a href="" class="btn btn-vermelho d-inline-block">Excluir</a>
				</div>
				</div>
			</div>
		</div>
				
			      
		<div id="tab-5" class="cx-tab">				
            <div class="rows pb-4">
			<div class="col-12">
				<div class="tabela-responsiva  rolagem-340 border radius-4">
					<span class="d-block text-label">Detalhe de exportação (500 no máximmo)</span>
					<table cellpadding="0" cellspacing="0" class="table border">
						<thead>
							<tr>
								<th width="120">
									<input type="checkbox" name="" value="" class="d-inline-block">
									Marcar todos
								</th>
								<th width="5">Item</th>
								<th>Drawback</th>
								<th>Registro e exportação</th>
								<th>Chave acesso NF-e</th>
								<th>Quantidade exportada</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
						</tbody>
					</table>										
				</div>
				<div class="mt-2">
					<a href="#janela-exportacao" rel="modal" class="btn d-inline-block">Incluir</a>
					<a href="" class="btn btn-vermelho d-inline-block">Excluir</a>
				</div>
				</div>
			</div>
		</div> 
		
		
		<div id="tab-6" class="cx-tab">				
            <div class="rows pb-4 pt-3">
				<div class="col-6">				
				<div class="rows">				
					<div class="col-12 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Tipo de operação</label>	
                         <select class="form-campo" name="id_cfop" id="id_cfop">
                            <option value="">Selecione uma Opção</option>
                         </select>  
                     </div> 				
					<div class="col-12 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Chassi</label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div> 				
					<div class="col-4 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Série</label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div> 				
					<div class="col-4 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Potência (CV) </label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>				
					 		
					<div class="col-4 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Peso liq. </label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div> 
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Capacidade de tração </label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>				
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Tipo de combustivel </label>	
						<select class="form-campo" name="id_cfop" id="id_cfop">
                            <option value="">Selecione uma Opção</option>
                         </select>  
                     </div>	
					 
					<div class="col-4 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Código marca/modelo </label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>	
					<div class="col-4 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Código cor DENATRAM</label>	
                        <select class="form-campo" name="id_cfop" id="id_cfop">
                            <option value="">Selecione uma Opção</option>
                         </select>  
                     </div>	
					<div class="col-4 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Tipo de pintura</label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>	
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Especie de veículo</label>	
                       <select class="form-campo" name="id_cfop" id="id_cfop">
                            <option value="">Selecione uma Opção</option>
                         </select> 
                     </div>	
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Restrição</label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>	
				</div>
				</div>
				
				<div class="col-6">	
				<div class=" rows">	
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Condição do veículo</label>	
						<select class="form-campo" name="id_cfop" id="id_cfop">
                            <option value="">Selecione uma Opção</option>
                         </select> 
                     </div>	
					 <div class="col-6 mt-3">										
                           <input type="checkbox" name="" value="" class="d-inline-block">
                           <label class="text-label d-inline-block"><b> Chassi remarcado</b> </label>
                     </div>
					 
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Número do motor</label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Cilindradas (cm3)</label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>	
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Peso bruto</label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Distância entre eixos</label>	
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Tipo de veiculos</label>	
                       <select class="form-campo" name="id_cfop" id="id_cfop">
                            <option value="">Selecione uma Opção</option>
                         </select> 
                     </div>	
					<div class="col-6 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Ano fabricação</label>	                      
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>	
					<div class="col-4 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Ano modelo fabricação</label>	                      
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>	
					<div class="col-4 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Código cor montadora</label>	                      
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>	
					<div class="col-4 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Lotação</label>	                      
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>
					<div class="col-12 mb-0">
                        <label class="text-label"><span class="text-vermelho">*</span>Descrição da cor</label>	                      
                        <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
                     </div>	
				</div>
				</div>
				</div>
			</div>
		
		
		<div id="tab-7" class="cx-tab">				
            <div class="rows pb-4 mt-3">				
				<div class="col-8 m-auto">	
					<div class="rows">				
						<div class="col-12 mb-0">
							<label class="text-label">Código de produtos ANVISA</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>					
						<div class="col-12 mb-0">
							<label class="text-label">Motivação da isenção da ANVISA</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>						
						<div class="col-12 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span>Preço max. consumidor</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>	
					</div>
				</div>
			</div>
		</div>
		
		<div id="tab-8" class="cx-tab">				
            <div class="rows pb-4 mt-3">				
				<div class="col-12 m-auto">	
					<div class="rows">				
						<div class="col-4 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span> Tipo de arma</label>	                      
							<select class="form-campo">
								<option>Selecionar</option>
							</select>
						</div>					
						<div class="col-4 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span> Série da arma</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>						
						<div class="col-4 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span>Série do cano</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>						
						<div class="col-12 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span>Descrição</label>	                      
							<textarea rows="10" class="form-campo"></textarea>
						</div>	
					</div>
				</div>
			</div>
		</div>
		
		<div id="tab-9" class="cx-tab">
			<fieldset class="p-2 mt-3">
            <div class="rows pb-4">			
						<div class="col-3 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span> Código ANP</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>						
						<div class="col-3 mb-0">
							<label class="text-label"> CODIF</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>						
						<div class="col-3 mb-0">
							<label class="text-label"> UF</label>	                      
							<select class="form-campo">
								<option>Selecionar</option>
							</select>
						</div>
						<div class="col-3 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span>Valor de partida</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>						
						<div class="col-12 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span> Descrição do produto conforme ANP</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>						
						<div class="col-4 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span>Percentual do GLP derivado do petróleo no produto GLP</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>	
								
						<div class="col-4 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span>Percentual de gás natural nacioal GLGNn</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>
						<div class="col-4 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span>Percentual de gás natural importado GLGNi</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>
					</div>		
			</fieldset>
			<fieldset class="p-2 mt-1"><legend>CID</legend>
            <div class="rows pb-4">			
						<div class="col-4 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span> Base de cálculo</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>						
						<div class="col-4 mb-0">
							<label class="text-label"> Alíquota</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>	
						<div class="col-4 mb-0">
							<label class="text-label"><span class="text-vermelho">*</span>Valor</label>	                      
							<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo">
						</div>	
					</div>							
			</div>
			</div>
			</fieldset>
								
			</div>
		</div>
		
		<div class="d-inline-block width-100 mb-5 mt-4" style="clear:both">
        <input type="hidden" name="id_nfe" value="21">
      <a href="#carregar" rel="modal" class="btn btn-azul btn-grande d-table m-auto px-5">Finalizar</a>
    </div>
    </div>
    </div>   

    
      
</div>

    </div>
    </div>



<!--modal importação-->
<div class="window caixa" id="janela">
	<div class="caixa-titulo py-1 d-inline-block width-100">
        <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Declaração de importação</span>
    </div>
	<div class="rows p-3">
		<div class="col-4">
			<span class="text-label"><b class="text-vermelho">*</b> Número DI/DSI/DA/DRI-E</span>
            <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
		</div>
		<div class="col-4">
			<span class="text-label"><b class="text-vermelho">*</b> Data registro</span>
            <input type="date" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
		</div>
		<div class="col-4">
			<span class="text-label"><b class="text-vermelho">*</b> Código exportador</span>
            <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
		</div>
		<div class="col-4">
			<span class="text-label"><b class="text-vermelho">*</b> Via transporte inter.</span>
            <select class="form-campo menor">
				<option>área - 40</option>
				<option>área - 40</option>
			</select>
		</div>
		<div class="col-4">
			<span class="text-label"> Valor da AFRMM</span>
            <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
		</div>
		<div class="col-4">
			<span class="text-label"><b class="text-vermelho">*</b> Tipo importação</span>
            <select class="form-campo menor">
				<option>área - 40</option>
				<option>área - 40</option>
			</select>
		</div>
		<div class="col-12 mt-2">
			<fieldset class="border radius-4">
				<legend class="pl-2 pr-2 text-center">Desembaraço aduaneiro</legend>
				<div class="p-2 py-1 rows pt-0">					
					<div class="col-4">
						<span class="text-label mt-0"><b class="text-vermelho">*</b> UF</span>
						<select class="form-campo menor">
							<option>área - 40</option>
							<option>área - 40</option>
						</select>
					</div>
					<div class="col-4">
						<span class="text-label mt-0"><b class="text-vermelho">*</b> Local</span>
						<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
					</div>
					<div class="col-4">
						<span class="text-label mt-0"><b class="text-vermelho">*</b> Data</span>
						<input type="date" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
					</div>
				</div>
			</fieldset>
		</div>
		
		<div class="col-12 mt-2">
			<fieldset class="border radius-4">
				<legend class="pl-2 pr-2 text-center">Adquirente ou Encomendante</legend>
				<div class="p-2 py-1 rows pt-0">					
					<div class="col-4">
						<span class="text-label mt-0"><b class="text-vermelho">*</b> UF</span>
						<select class="form-campo menor">
							<option>área - 40</option>
							<option>área - 40</option>
						</select>
					</div>
					<div class="col-8">
						<span class="text-label mt-0"><b class="text-vermelho">*</b> Local</span>
						<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
					</div>
				</div>
			</fieldset>
		</div>
		
		<div class="col-12 mt-2">
			<fieldset class="border radius-4">
				<legend class="pl-2 pr-2 text-center">Adções (100 no máximo)</legend>
				<div class="p-2 py-1 rows pt-0">					
					<div class="tabela-responsiva px-0 rolagem-150">
					<div class="col-12">
						<table cellpadding="0" cellspacing="0" class="table border">
						<thead>
							<tr>
								<th width="120">
									<input type="checkbox" name="" value="" class="d-inline-block">
									Marcar todos
								</th>
								<th width="5">Item</th>
								<th>Número</th>
								<th>Fabricante</th>
								<th>Desconto</th>
								<th>Drawback</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
							<tr>
								<td align="center">
									<input type="checkbox" name="" value="" class="d-inline-block">
									<label class="text-label d-inline-block"></label>
								</td>
								<td align="left">Item</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
								<td align="center">NVE</td>
							</tr>
						</tbody>
					</table>
					</div>
					</div>
				</div>
					<div class="px-2 border-topo pb-2 d-inline-block">
					<input type="submit" class="btn d-inline-block" value="Incluir">
					<a href="" class="btn btn-vermelho d-inline-block fechar">Fechar</a>
					</div>
			</fieldset>
		</div>
	</div>
	
</div>

<!--modal exportacao-->
<div class="window caixa" id="janela-exportacao">
	<div class="caixa-titulo py-1 d-inline-block width-100">
        <span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Detalhe de exportação</span>
    </div>
	<div class="rows p-3">
		<div class="col-12">
			<span class="text-label">Número do alto concessório de drawback</span>
            <input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
		</div>		
		<div class="col-12 mt-1">
			<fieldset class="border radius-4">
				<legend class="pl-2 pr-2 text-center">Exportação Indireta</legend>
				<div class="p-2 py-1 rows pt-0">					
					<div class="col-8">						
						<span class="text-label"><b class="text-vermelho">*</b> Número Registro de exportação</span>
						<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
					</div>
					<div class="col-4">
						<span class="text-label mt-0"><b class="text-vermelho">*</b> Quantidade</span>
						<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
					</div>
					<div class="col-12">
						<span class="text-label mt-0"><b class="text-vermelho">*</b> Chave de acesso</span>
						<input type="text" name="" value="" placeholder="Digite aqui..." class="form-campo menor">
					</div>
				</div>
			</fieldset>
		</div>
		
		<div class="col-12 mt-2">			
			<div class="px-2 border-topo pb-2 d-inline-block">
				<input type="submit" class="btn d-inline-block" value="Ok">
				<a href="" class="btn btn-vermelho d-inline-block fechar">Fechar</a>
			</div>
		</div>
	</div>
	
</div>
<div id="mascara"></div>