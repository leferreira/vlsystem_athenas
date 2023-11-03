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
    			<button type="button" class="btn btn-azul" onclick="atualizarDadosPagamentos('S')"> Atualizar Valores</button>
    		</div>
    		
				    
            </div>
		</fieldset>	
	
<fieldset>
	<div class="rows">
	<div class="col-6 d-flex">           
	  <fieldset class="border radius-4 p-1">
		<legend class="">Dados do Pagamento</legend>	 
		<div class="rows">
          <div class="col-12 mb-3">
        		<label class="text-label">Meio de Pagamento</label>
        		<select class="form-campo" name="tPag" id="tPag" >	
        			 @foreach(ConstanteService::tiposPagamento() as $chave=>$valor)
            			<option value="{{$chave}}" {{ ($notafiscal->tPag ?? null ) == $chave ? 'selected' : null }} >{{$chave}} - {{$valor}}</option>
            		 @endforeach
        		</select>
        	</div>
		
				<div class="col-6 mb-3">	
                    <label class="text-label d-block">Forma de pagamento</label>
                    <select class="form-campo" name="indPag" id="indPag">
            			<option value="0" <?php ($notafiscal->indPag=='0') ? 'selected' : null?>>Pagamento à Vista</option>
            			<option value="1" <?php ($notafiscal->indPag=='1') ? 'selected' : null?>>Pagamento à Prazo</option>
            		</select>
                </div>                                     
                
                 <div class="col-6 mb-3">	
                    <label class="text-label d-block">Qt. Parcelas</label>
                    <select id="qtde_parcela"  class="form-campo">
                    	<option value="">Selecione</option>
                    	@for($i=1; $i<=12; $i++)
                    		<option value="{{$i}}">{{zeroEsquerda($i,2)}}</option>
                    	@endfor
					</select>
                </div>                                       
                
                 <div class="col-6 mb-3 validated">	
                    <label class="text-label d-block ">Vencimento</label>
                    <input type="date" name="primeiro_vencimento" value="0" id="primeiro_vencimento" class="form-campo">
                </div>
               
                <div class="col-6 mb-3">	
                    <label class="text-label d-block">Valor da parcela</label>
                    <input type="text" name="valor_parcela" value="{{ $notafiscal->vNF ?? null }}" id="valor_parcela" class="form-campo mascara-float">
                </div>                    
                
                <div class="col-12 text-center d-flex center-content-space-between">				
					<button type="button" class="btn btn-azul" onclick="salvarDuplicata()"> Gerar Parcelas </button>
				</div>
				                              
			</div>
        </fieldset>
        
       </div>
       
	   <div class="col-6">
		<fieldset class="p-1 border radius-4 ">
		<legend class="">Parcelas</legend>	
			<div class="tabela-responsiva scroll p-0 width-100" style="border-radius:5px 5px 0 0 !important;">
            <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                    <thead>
						<tr>
                            <th align="center">Id</th>
                            <th align="center">Data</th>
                            <th align="center">Valor</th>
                            <th align="center">Forma Pagto</th>
                            <th align="center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody id="lista_duplicata">
                    	@foreach($duplicatas as $duplicata)
                            <tr>
                            	<td align="center">{{ $duplicata->nDup }}</td>
                                <td align="center">{{ databr($duplicata->dVenc) }}</td>
                                <td align="center">R$ {{ $duplicata->vDup }}</td>
                                <td align="center">{{ $duplicata->forma_pagto }}</td>
                                <td align='center' >
                                	<a href='javascript:;' onclick='excluirDuplicata({{$duplicata->id}})'  class='btn btn-sm btn-danger d-inline-block' title='Excluir'>
                                <i class='fas fa-trash'></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
           </table>	
            </div>
           <div class="width-100 tabela-responsiva border radius-4 bg-body" style="border-radius: 0 0 5px 5px!important;">  
		      <table cellpadding="0" cellspacing="0" class="table">
					<tr>
						<td class="border-0">
							<strong>Total da Venda: <b class="text-azul h5 d-inline-block mb-0"><i id="total_da_venda"></i></b></strong> 
						</td>
						<td class="border-0">
							<strong>Total das Parcelas: <b class="h5 d-inline-block mb-0" style="color:#18bf91"><i id="soma_parcelas"></i></b></strong>
						</td>
						<td class="border-0">								
							<strong >Restante: <b class="text-vermelho h5 d-inline-block mb-0"><i id="restante_parcelas">00</i></b></strong>
						</td>
					</tr>
              </table>  			
			</div>
		</fieldset>
	   </div>
	   </div>
	</fieldset>
			




			
			