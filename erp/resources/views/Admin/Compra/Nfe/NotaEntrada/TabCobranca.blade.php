<?php
use App\Service\ConstanteService;
?>

  <div class="rows pb-4 px-3 mt-4">
		<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">Dados de Pagamento </legend>
			 
            <div class="caixa px-2">
           
            
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered menor fatura" width="100%">
                    <thead>
						<tr>
                            <th align="center">Id</th>
                            <th align="center">Data</th>
                            <th align="center">Forma Pagto</th>
                            <th align="center">Valor</th>     
                            <th align="center">Observação</th>    
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



			
			