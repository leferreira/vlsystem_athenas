<?php
use App\Service\ConstanteService;
?>
<div class="window form alt" id="modalPrevisao">

	<div class="p-2 px-4">
			<span class="d-block h3 border-bottom fw-700">Inseria uma nova Previsão</span>
<div class="p-0">
	<form id="frmCadIva" method="post">
		<div class="rows">
				
						
				<div class="col-2 mb-3">
                        <label class="text-label">Data previsão</label>
                        <input type="date" id="data_previsao"    class="form-campo  ">
                </div>
                            
				<div class="col-8 mb-3" >
						<label class="text-label">Observação</label>	
						<input type="text" name="historico"   id="historico"  class="form-campo  ">
				</div>				
				
														
				 <div class="col-2 mb-3">
				 	<input type="hidden" id="conta_receber_id"  >
				 	<label class="text-label">.</label>					 	
				 	<input type="button" value="Ins" id="btnInserirPrevisao" class="btn btn-azul border-bottom width-100">						 	
        		 </div>
					
         </div>
    </form>     
         <div class="rows mt-4">
			<div class="col-12 scroll-modal">
                <div class=" tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" width="100%" >
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th class="text-left">Data Previsão</th>
                                    <th class="text-left">Histórico</th>
                                    <th align="center">Opções</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body" id="lista_previsao_pagamento">   
                            
							</tbody>
                          </table>
								
                   </div>

                </div>
                </div>
                
	</div>		
         </div>
		 <div class="tfooter end">
			<a href="" class="btn btn-neutro fechar">Fechar</a> 
		 </div>
	</div>
