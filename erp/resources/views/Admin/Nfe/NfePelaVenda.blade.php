@extends("templates.template_admin")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase h5 mb-0 text-branco"><i class="fas fa-plus-circle"></i> Cadastrar produto</span>
                      
                     
	<form action="" method="Post">

	@csrf
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Dados Pessoais</a></li>
		<li><a href="#tab-2">Fornecedor</a></li>
		<li><a href="#tab-3">Itens/Produtos</a></li>
		<li><a href="#tab-4">Totais</a></li>
		<li><a href="#tab-5">Transportadora</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2">
				<span class="d-block mt-4 mb-4 h4 border-bottom text-uppercase">Informações básicas</span>		
				<div class="rows">									
					<div class="col-2 mb-3">
                <label class="text-label">Num NFe </label>	
                <input type="text" name="numero_nfe" value="{{ $identificacao->nNF }}" class="form-campo">
    	</div>				

		<div class="col-2 mb-3">
                    <label class="text-label">Tipo de operação</label>	
                    <select class="form-campo" name="tpNF" id="tpNF" onchange="selecionar_tipo_operacao();">
                            <option value="0" {{ ($identificacao->tpNF=='0') ? "selected": NULL }} >ENTRADA</option>
                            <option value="1" {{ (($identificacao->tpNF=='1') || (!$identificacao->tpNF)) ? "selected": NULL }}>SAÍDA</option>
                    </select>
		</div>
		<div class="col-6 mb-3">
                <label class="text-label">Natureza Operação</label>	
                <input type="text" name="numero_nfe" value="{{ $identificacao->natOp }}" class="form-campo">  
		</div>					
		<div class="col-2 mb-3">
                <label class="text-label">Ambiente</label>	
                <select class="form-campo" name="tpAmb" id="tpAmb">
                        <option value="1" {{ ($identificacao->tpAmb =="1") ? "selected": NULL }} >Produção</option>
                        <option value="2" {{ ($identificacao->tpAmb =="2") ? "selected": NULL }} >Homologação</option>                                                
				</select>
        </div>
		
                <div class="col-3 mb-3">
                    <label class="text-label">Data Emissão NF</label>	
                    <input type="date" name="data_emissao_nfe" value="{{ ($identificacao->dhEmi)? dataNfe($identificacao->dhEmi): date('Y-m-d') }}"  placeholder="Digite aqui..." class="form-campo">
                </div>
                <div class="col-2 mb-3">
                    <label class="text-label">Hora emissão NF</label>	
                    <input type="time" name="hora_emissao_nfe" value="{{ ($identificacao->dhEmi) ? horaNfe($identificacao->dhEmi): date('H:i:s') }}" placeholder="Digite aqui..." class="form-campo">
                </div>                             
	
                <div class="col-3 mb-3">
                    <label class="text-label">Data saída/entrada</label>	
                    <input type="date" name="data_saida_nfe" value="{{ ($identificacao->dhSaiEnt)? dataNfe($identificacao->dhSaiEnt):date('Y-m-d') }}" placeholder="Digite aqui..." class="form-campo">
                </div> 
                <div class="col-2 mb-3">
                    <label class="text-label">Hora saída/entrada</label>	
                    <input type="time" name="hora_saida_nfe" value="{{ ($identificacao->dhSaiEnt)? horaNfe($identificacao->dhSaiEnt):date('H:i:s') }}"  placeholder="Digite aqui..." class="form-campo">
                </div>
	
				
                		
				
	
                <div class="col-2 mb-3">
                        <label class="text-label">Dest consr final</label>	
                        <select class="form-campo" name="indFinal" id="indFinal">
                                <option value="0" {{ ($identificacao->indFinal =="0") ? "selected": NULL }}>NÃO</option>
                                <option value="1" {{ ($identificacao->indFinal =="1") ? "selected": NULL }}>SIM</option>
                        </select>
                </div>
			  
                <div class="col-3 mb-3">
                <label class="text-label">Finalidade da emissão</label>	
                <select class="form-campo" name="finNFe" id="finNFe">
                    <option value="1" {{ ($identificacao->finNFe =="1") ? "selected": NULL }}> NORMAL</option>
                    <option value="2" {{ ($identificacao->finNFe =="2") ? "selected": NULL }}>COMPLEMENTAR</option>
                    <option value="3" {{ ($identificacao->finNFe =="3") ? "selected": NULL }}>DE AJUSTE</option>
                    <option value="4" {{ ($identificacao->finNFe =="4") ? "selected": NULL }}>DEVOLUÇÃO DE MERCADORIA</option>
                </select>
                </div>
                
				                                       
                <div class="col-4  mb-3">
                        <label class="text-label">Presença do comprador</label>
                        <select class="form-campo" name="indPres" id="indPres">
                            <option value="0" {{ ($identificacao->indPres =="0") ? "selected": NULL }}>NÃO SE APLICA</option>
                            <option value="1" {{ ($identificacao->indPres =="1") ? "selected": NULL }}>OPERAÇÃO PRESENCIAL</option>
                            <option value="2" {{ ($identificacao->indPres =="2") ? "selected": NULL }}>OPERAÇÃO NÃO PRESENCIAL, PELA INTERNET</option>
                            <option value="3" {{ ($identificacao->indPres =="3") ? "selected": NULL }}>OPERAÇÃO NÃO PRESENCIAL, TELEATENDIMENTO</option>
                            <option value="4" {{ ($identificacao->indPres =="4") ? "selected": NULL }}>NFC-e EM OPERAÇÃO COM ENTREGA A DOMICÍLIO</option>
                            <option value="5" {{ ($identificacao->indPres =="5") ? "selected": NULL }}>OPERAÇÃO PRESENCIAL, FORA DO ESTABELECIMENTO</option>
                            <option value="9" {{ ($identificacao->indPres =="9") ? "selected": NULL }}>OPERAÇÃO NÃO PRESENCIAL, OUTROS</option> 
                        </select>
                </div>                                    
    			
				

				</div>
		</div>
	  </div>
	  
	  
	  <div id="tab-2">
		<div class="p-2">									
        <span class="d-block mt-4 h4 border-bottom text-uppercase">Fornecedor</span>										
        <div class="rows">	
                <div class="col-6 mb-1">
                    <label class="text-label">Nome / Razão Social </label>	
                    <input type="text" name="xNome" id="razaoSocial" value="{{isset($fornecedor->xNome) ? $fornecedor->xNome : null}}" class="form-campo">
            </div>
            <div class="col-6 mb-1">
                <label class="text-label">Nome Fantasia </label>	
                <input type="text" name="fantasia" id="CPF" value="{{isset($fornecedor->xFant) ? $fornecedor->xFant : null}}" class="form-campo">
            </div>
            <div class="col-6 mb-1">
                <label class="text-label">CNPJ </label>	
                <input type="text" name="cnpj" id="CNPJ" value="{{isset($fornecedor->CNPJ) ? $fornecedor->CNPJ: null}}" class="form-campo">
            </div>         
            <div class="col-3 mb-1">
                <label class="text-label">Inscr. Estadual</label>	
                <input type="text" name="IE" id="IE" value="{{isset($fornecedor->IE) ? $fornecedor->IE : null}}" class="form-campo">
            </div>
          
            
            
            <fieldset class="mt-2">
   <legend class="h5 mb-0 text-left">Endereço Fornecedor</legend>	    
	<div class="rows p-2"> 
			<div class="col-6 mb-1">
                    <label class="text-label">Logradouro</label>	
                   <input type="text" name="xLgr" id="xLgr" value="{{isset($fornecedor->enderEmit->xLgr) ? $fornecedor->enderEmit->xLgr : null}}" class="form-campo rua">
            </div>
            
            <div class="col-2 mb-1">
                    <label class="text-label">Numero</label>	
                    <input type="text" name="nro" id="nro" value="{{isset($fornecedor->enderEmit->nro) ? $fornecedor->enderEmit->nro : null}}"  class="form-campo">
            </div>
            
            <div class="col-4 mb-1">
                <label class="text-label">Complemento</label>	
                <input type="text" name="xCpl" id="xCpl" value="{{isset($fornecedor->enderEmit->xCpl) ? $fornecedor->enderEmit->xCpl : null}}"  class="form-campo">
            </div>
            
            <div class="col-4 mb-1">
                    <label class="text-label">Bairro</label>	
                    <input type="text" name="xBairro" id="xBairro" value="{{isset($fornecedor->enderEmit->xBairro) ? $fornecedor->enderEmit->xBairro : null}}"  class="form-campo bairro">
            </div>
            
	   		<div class="col-2 mb-1">
                <label class="text-label">CEP</label>
                 <div class="input-grupo">
                            <input type="text" name="CEP" id="CEP" value="{{isset($fornecedor->enderEmit->CEP) ? $fornecedor->enderEmit->CEP : null}}"  class="form-campo busca_cep">

                 </div>
            </div>
             <div class="col-2 mb-1">
                     <label class="text-label">Telefone</label>	
                    <input type="text" name="fone" id="fone" value="{{isset($fornecedor->enderEmit->fone) ? $fornecedor->enderEmit->fone : null}}"  class="form-campo">
             </div>            
            <div class="col-4 mb-2">
                    <label class="text-label">UF</label>	
                    <input type="text" name="UF" id="UF" value="{{isset($fornecedor->enderEmit->UF) ? $fornecedor->enderEmit->UF : null}}"   class="form-campo estado"> 
                  
            </div>
           
            <div class="col-4 mb-1">
                <label class="text-label">Cidade</label>	
                <input type="text" name="xMun" id="xMun" value="{{isset($fornecedor->enderEmit->xMun) ? $fornecedor->enderEmit->xMun : null}}"  class="form-campo cidade">
			</div>  
			<div class="col-2 mb-3">
                 <label class="text-label">Ibge</label>	
                 <input type="text" name="cMun" id="cMun" value="{{isset($fornecedor->enderEmit->cMun) ? $fornecedor->enderEmit->cMun : null}}"  class="form-campo ibge">
         </div>             
 
            </div>	
     </fieldset>                         
                           
        </div>
        </div>
	  </div>
	  
        <div id="tab-3">									
        <div class="p-2">									
            <span class="d-block mt-4 h4 border-bottom text-uppercase">Produto</span>										
            <div class="rows">
            		<fieldset class="mt-2 pb-4">
		<legend class="h5 mb-0 text-left">Produto </legend>
			 
			
                    <table cellpadding="0" cellspacing="0">
                            <thead>
                                    <tr>
                                        <th align="left">Item</th>
                                        <th align="left">Produto</th>
                                        <th align="center">Preço</th>
                                        <th align="center">Quantidade</th>							
                                        <th align="center">Subtotal</th>
                                        <th align="center">Detalhes</th>
                                        <th align="center">Excluir</th>
                                  </tr>
                            </thead>
                           <tbody id="lista_itens">
                               @foreach($itens as $item)
                                <tr>
                                    <td align="left">{{ $item->cProd  }}</td>
                                    <td align="left">{{ $item->xProd }}</td>
                                    <td align="center">R$ {{ $item->vUnCom }}</td>
                                    <td align="center">{{ $item->qCom }}</td>							
                                    <td align="center">R$ {{ $item->vUnCom }}</td>
                                    <td align="center"><a href="" target="_blank"  class="btn btn-outline-verde btn-pequeno">Detalhes</a></td>
                                    <td align="center"><a href="javascript:;" onclick="excluirProduto()" class="btn btn-outline-vermelho btn-pequeno">Excluir</a></td>
                                </tr>
                              @endforeach
                       </tbody>
                    </table>
                  
          
		
	 
            </fieldset>			
                                
                                
            
            </div>
         </div>
         </div>
   
          <div id="tab-4">
		<div class="p-2">									
        <span class="d-block mt-4 h4 border-bottom text-uppercase">Totais</span>										
        <div class="rows">	
               <fieldset>
				<legend class="h5 mb-0 text-left">Totalizadores</legend>										
            <div class="rows pb-4 p-3">																					
            
            <div class="col-2 mb-1">
                    <label class="text-label">Total BC ICMS</label>	
                    <input type="text" value="{{ $total->vBC }}" readonly  class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total ICMS</label>	
                    <input type="text"  value="{{ $total->vICMS }}" readonly  class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total ICMS desonerado</label>	
                    <input type="text"  value="{{ $total->vICMSDeson }}" readonly class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                     <label class="text-label">Total do FCP</label>	
                     <input type="text"  value="{{ $total->vFCP }}" readonly class="form-campo">
             </div>	
             <div class="col-2 mb-1">
                     <label class="text-label">Total BC ICMS ST</label>	
                     <input type="text"  value="{{ $total->vBCST }}" readonly class="form-campo">
             </div>	
             <div class="col-2 mb-1">
                     <label class="text-label">Total ICMS ST</label>	
                     <input type="text"  value="{{ $total->vST }}" readonly class="form-campo">
             </div>

            <div class="col-2 mb-1">
                    <label class="text-label">Total do FCPST</label>	
                    <input type="text"  value="{{ $total->vFCPST }}" readonly class="form-campo">
            </div>
            <div class="col-2 mb-4">
                    <label class="text-label">Total do FCPST Ret.</label>	
                    <input type="text"  value="{{ $total->vFCPSTRet }}" readonly class="form-campo">
            </div>          

            <div class="col-2 mb-1">
                    <label class="text-label">Total bruto dos produtos</label>	
                    <input type="text" value="{{ $total->vProd }}" readonly class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total de frete</label>	
                    <input type="text"  value="{{ $total->vFrete }}" readonly class="form-campo">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total de seguro</label>	
                    <input type="text"  value="{{ $total->vSeg }}" readonly class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de desconto</label>	
                    <input type="text"  value="{{ $total->vDesc }}" readonly class="form-campo">
            </div>	

            <div class="col-2 mb-1">
                    <label class="text-label">Total de II</label>	
                    <input type="text"  value="{{ $total->vII }}" readonly class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de IPI</label>	
                    <input type="text" value="{{ $total->vIPI }}" readonly class="form-campo">
            </div>
                
                <div class="col-2 mb-1">
                    <label class="text-label">Total de IPI Devolução</label>	
                    <input type="text"  value="{{ $total->vIPIDevol }}" readonly  class="form-campo">
            </div>             
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total de PIS</label>	
                    <input type="text"  value="{{ $total->vPIS }}" readonly  class="form-campo">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Total de COFINS</label>	
                    <input type="text"  value="{{ $total->vCOFINS }}" readonly  class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                    <label class="text-label">Total Outras Despesas</label>	
                    <input type="text"  value="{{ $total->vOutro }}" readonly  class="form-campo">
            </div>
                
            <div class="col-2 mb-1">
                    <label class="text-label">TOTAL DA NF</label>	
                    <input type="text"  value="{{ $total->vNF }}" readonly  class="form-campo">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Total Aproximado</label>	
                    <input type="text"  value="{{ $total->vTotTrib }}" readonly  class="form-campo">
            </div>
                       
            </div>
		</fieldset>
        </div>
        </div>
	  </div>
	  
	  <div id="tab-5">
	  <div class="p-2">									
        <span class="d-block mt-4 h4 border-bottom text-uppercase">Totais</span>										
      <div class="rows">
      		
		<fieldset class="mt-2">
		<legend class="h5 mb-0 text-left">Transportadora</legend>
			<div class="rows p-2">
				
				
				<div class="col-6 mb-3">
				   <label class="text-label">Nome da transportadora </label>
                    <input type="text" name="xNome" id="xNome" value="<?php  echo isset($transportadora->transporta) ? $transportadora->transporta->xNome: null ?>" placeholder="Digite aqui..." class="form-campo">
				</div>
				<div class="col-3 mb-3">
                    <label class="text-label">CNPJ/CPF transport.</label>	
                    <input type="text" name="CNPJ"  id="CNPJ" value="<?php   echo isset($transportadora->transporta) ? $transportadora->transporta->CNPJ: null  ?>" placeholder="Digite aqui..." class="form-campo">
				</div>
				<div class="col-3 mb-3">
                    <label class="text-label">Inscr. Est. transp.</label>	
                    <input type="text" name="IE" id="IE" value="<?php   echo isset($transportadora->transporta) ? $transportadora->transporta->xNome: null  ?>" placeholder="Digite aqui..." class="form-campo">
				</div>
				<div class="col-6 mb-3">
                    <label class="text-label">Endereço completo</label>	
                    <input type="text" name="xEnder" id="xEnder" value="<?php   echo isset($transportadora->transporta) ? $transportadora->transporta->xEnder: null  ?>" placeholder="Digite aqui..." class="form-campo">
				</div>
				<div class="col-4 mb-3">
                    <label class="text-label">Município</label>	
                    <input type="text" name="xMun" id="xMun" value="<?php   echo isset($transportadora->transporta) ? $transportadora->transporta->xMun: null  ?>" placeholder="Digite aqui..." class="form-campo">
				</div>
				<div class="col-2 mb-3">
                    <label class="text-label">UF transportador</label>	
                    <input type="text" name="UF" id="UF" value="<?php   echo isset($transportadora->transporta) ? $transportadora->transporta->UF: null  ?>" placeholder="Digite aqui..." class="form-campo">
                    
				</div>		
			</div>
	</fieldset>
			               
			
<fieldset class="mt-2">
<legend class="h5 mb-0 text-left">Veículo/Reboque/Balsa/Vagão</legend>
			<div class="rows p-2">				
				<div class="col-4 mb-3">
                    <label class="text-label">Placa veículo</label>	
                    <input type="text" name="veiculo_placa" id="veiculo_placa" value="<?php   echo $transportadora->veiculo_placa ?>" placeholder="Digite aqui..." class="form-campo">
				</div>
				<div class="col-4 mb-3">
                    <label class="text-label">UF veículo</label>	
                   <select  class="form-campo" name="veiculo_UF" id="veiculo_UF" >
                   		<option value="">Selecione</option>
                   		<option value="AC">AC</option>
                   </select>
				</div>
				<div class="col-4 mb-3">
                    <label class="text-label">Reg. Nac. Trans. Carga</label>	                   
                    <input type="text" name="veiculo_RNTC" id="veiculo_RNTC" value="<?php   echo $transportadora->veiculo_RNTC ?>" placeholder="Digite aqui..." class="form-campo">
				</div>
				<div class="col-6 mb-3">
                    <label class="text-label">Identificação vagão</label>	                   
                    <input type="text" name="veiculo_vagao" id="veiculo_vagao" value="<?php   echo $transportadora->veiculo_vagao ?>" placeholder="Digite aqui..." class="form-campo">
				</div>
				<div class="col-6 mb-3">
                    <label class="text-label">Identificação balsa</label>	                   
                    <input type="text" name="veiculo_balsa" id="veiculo_balsa" value="<?php   echo $transportadora->veiculo_balsa ?>" placeholder="Digite aqui..." class="form-campo">
				</div>
			</div>	
</fieldset>



			
    

			<fieldset>
				<legend class="h5 mb-0 text-left">Volumes transportados</legend>
			<div class="rows p-2">
				<div class="col mb-1">
					<label class="text-label">Quantidade de vol.</label>	                   
					<input type="text" name="vol_qVol" id="vol_qVol" value="<?php echo  isset($transportadora->vol) ? $transportadora->vol->qVol: null   ?>" placeholder="Digite aqui..." class="form-campo">
				</div> 
				<div class="col mb-1">
					<label class="text-label">Espécie dos vol.</label>	                   
					<input type="text" name="vol_esp" id="vol_esp" value="<?php   echo isset($transportadora->vol) ? $transportadora->vol->esp: null  ?>" placeholder="Digite aqui..." class="form-campo">
				</div>

				<div class="col mb-1">
					<label class="text-label">Marca dos volumes</label>	                   
					<input type="text" name="vol_marca" id="vol_marca" value="<?php   echo isset($transportadora->vol) ? $transportadora->vol->marca: null   ?>" placeholder="Digite aqui..." class="form-campo">
				</div>      
				<div class="col mb-1">
					<label class="text-label">Numeração dos vol.</label>	                   
					<input type="text" name="vol_nVol" id="vol_nVol" value="<?php   echo isset($transportadora->vol) ? $transportadora->vol->nVol: null  ?>" placeholder="Digite aqui..." class="form-campo">
				</div>      
				<div class="col mb-1">
					<label class="text-label">Peso líquido</label>	                   
					<input type="text" name="vol_pesoL" id="vol_pesoL" value="<?php   echo isset($transportadora->vol) ? $transportadora->vol->pesoL: null ?>" placeholder="Digite aqui..." class="form-campo">
				</div>     
				<div class="col mb-1">
					<label class="text-label">Peso bruto</label>	                   
					<input type="text" name="vol_pesoB"  id="vol_pesoB" value="<?php   echo isset($transportadora->vol) ? $transportadora->vol->pesoB: null ?>" placeholder="Digite aqui..." class="form-campo">
				</div>      
				<div class="col mb-1">
					<label class="text-label">Números dos lacres</label>	                   
					<input type="text" name="vol_nLacre" id="vol_nLacre" value="<?php   echo isset($transportadora->vol) ? $transportadora->vol->UF: null ?>" placeholder="Digite aqui..." class="form-campo">
				</div>           
			</div>
			</fieldset>
      </div>
      </div>
      </div>
      
         
 </div>
		<div class="col-12 text-center pb-4">
			<input type="submit" value="Salvar" class="btn btn-laranja m-auto">
		</div>
	
	
</form>
</div>
@endsection