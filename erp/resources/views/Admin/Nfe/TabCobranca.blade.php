<?php
use App\Service\ConstanteService;
?>
<fieldset>
<legend class="h5 mb-0 text-left">Valores Totais</legend>										
            <div class="rows pb-4 p-3">	
            <div class="col-2 mb-3 position-relative">
    			<label class="text-label">Núm. Fatura</label>	                   
    			<input type="text" name="nFat" id="nFat" value="{{ $notafiscal->nFat ?? null }}"  class="form-campo">
    		</div>     																						
            	
            <div class="col-2 mb-1">
                    <label class="text-label">Total de frete</label>	
                    <input type="text"  id="vFreteTot" value="<?php echo $notafiscal->vFrete ?? null ?>"  class="form-campo mascara-float">
            </div>	
            <div class="col-2 mb-1">
                    <label class="text-label">Total de seguro</label>	
                    <input type="text"  id="vSegTot" value="<?php echo $notafiscal->vSeg ?? null ?>"  class="form-campo mascara-float">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Total Outras Despesas</label>	
                    <input type="text"  id="vOutroTot" value="<?php echo $notafiscal->vOutro ?? null ?>"  class="form-campo mascara-float">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Desconto Nota(R$)</label>	
                    <input type="text" id="desconto_nota"  value="<?php echo $notafiscal->desconto_nota ?? null ?>"  class="form-campo mascara-float">
            </div>
            <div class="col-2 mb-1">
                    <label class="text-label">Desconto Itens</label>	
                    <input type="text" readonly="readonly" value="<?php echo $notafiscal->desconto_itens ?? null ?>"  class="form-campo mascara-float">
            </div>                
            
            
            <div class="col-2 mb-1">
                    <label class="text-label">Desconto Total(R$)</label>	
                    <input type="text"  readonly="readonly" id="vDescTot" value="<?php echo $notafiscal->vDesc ?? null ?>"  class="form-campo mascara-float">
            </div>	
           	<div class="col-2 mb-1">
                    <label class="text-label">Total dos Produto</label>	
                    <input type="text"  id="vProdTot" value="<?php echo $notafiscal->vProd ?? null ?>" readonly class="form-campo mascara-float">
            </div>	
             <div class="col-2 mb-1">
                     <label class="text-label">Total da Nota</label>	
                     <input type="text"  id="vNF" value="<?php echo $notafiscal->vNF ?? null ?>" readonly class="form-campo mascara-float">
             </div>
                 
    		<div class="col-2 mb-3 position-relative">
    			<label class="text-label">Valor original </label>	                   
    			<input type="text"  id="vOrig"  value="{{ $notafiscal->vOrig ?? null }}" class="form-campo mascara-float">
    		</div>     
    		  
    		<div class="col-2 mb-3 position-relative">
    			<label class="text-label">Valor líquido </label>	                   
    			<input type="text"  id="vLiq"  value="{{ $notafiscal->vLiq ?? null }}"  class="form-campo mascara-float">
    		</div> 
    		<div class="col-2 mb-3 position-relative">                   
    			<button type="button" class="btn btn-azul" onclick="atualizarDadosPagamentos('N')"> Atualizar Valores</button>
    		</div>
    		
    		
				    
            </div>
		</fieldset>	
  <div class="rows pb-4 px-3 mt-4">
		<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">Dados de Pagamento </legend>
			 
            <div class="caixa px-2">
            <div class="rows">
            	<div class="col-4 mb-3" id="ver_combo_notar_refereciada">
                 	<label class="text-label">Forma de Pagamento</label>	
               	 	<select class="form-campo" id="tPag" >		
            			 @foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                			<option value="{{$chave}}" {{ ($notafiscal->tPag ?? null ) == $chave ? 'selected' : null }} >{{$chave}} - {{$valor}}</option>
                		 @endforeach
            		</select>	
                </div>
                <div class="col-3 mb-3" >
                 	<label class="text-label">Forma de Parcelar</label>	
               	 	<select class="form-campo" id="forma_de_parcelar" onchange="mudarTipoInput()">		
            			<option value="1">1 - Número de Parcelas</option>
                		<option value="2">2 - Condições especiais</option>
            		</select>	
                </div>
                
            	<div class="col-2 mb-3" >
                 	<label class="text-label">Parcelas</label>	
               	 	<input type="number"  class="form-campo " value="1" id="qtde_parcela">	
                </div>
              
                <div class="col-1 mt-1 pt-1"> 
                	<input type="button" onclick="inserirDuplicata()" value="Ok" class="btn btn-azul width-100" />                              
                </div> 
                
            </div>
            
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                    <thead>
						<tr>
                            <th align="center">Id</th>
                            <th align="center">Data</th>
                            <th align="center">Forma Pagto</th>
                            <th align="center">Valor</th>     
                            <th align="center">Observação</th>                       
                            <th align="center">Salvar</th>
                             <th align="center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody id="lista_duplicata">
                  @foreach($duplicatas as $duplicata)
                            <tr>
                            	<td align="center">{{$duplicata->nDup}}</td>
                                <td align="center" width="10%"><input type="date" value="{{$duplicata->dVenc}}" id="vencimento_{{$duplicata->id}}" class="form-campo" onchange="alterarDuplicata({{$duplicata->id}})" ></td>
                                
                                <td align="center" width="25%">
                                    <select class="form-campo" name="tPag" id="tPag_{{$duplicata->id}}" onchange="alterarDuplicata({{$duplicata->id}})">		
                            			 @foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
                                			<option value="{{$chave}}" {{ ($duplicata->tPag ?? null ) == $chave ? 'selected' : null }} >{{$chave}} - {{$valor}}</option>
                                		 @endforeach
                            		</select>
        						</td>
                                <td align="center" width="15%"><input type="text" readonly="readonly" value="{{ $duplicata->vDup }}" name="primeiro_vencimento"  class="form-campo"></td>
                                <td align="center" width="35%"><input type="text"  id="obs_{{$duplicata->id}}" value="{{ $duplicata->obs }}" class="form-campo"></td>
                                <td align="center"><a href="javascript:;" onclick="alterarDuplicata({{$duplicata->id}})"   class="btn btn-outline-verde d-inline-block  btn-pequeno" title="Detalhes">Salvar </a></td>
                                
                                <td align='center' >
                                	<a href='javascript:;' onclick='excluirDuplicata({{$duplicata->id}})'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'>
                                <i class='fas fa-trash'></i></a></td>
                            </tr>
                     @endforeach
                    </tbody>
           </table>	
                  
            </div>

		
            </div>
			
     
		</fieldset>
			</div>
        </div>	

			
<script>
	function mudarTipoInput(){
		var tipo = $("#forma_de_parcelar").val();
		if(tipo=="1"){
			$("#qtde_parcela").val("1");
			$("#qtde_parcela").prop("type", "number")
		}else{
			$("#qtde_parcela").val("");
			$("#qtde_parcela").prop("type", "text")
		}
		
	}
</script>



			
			