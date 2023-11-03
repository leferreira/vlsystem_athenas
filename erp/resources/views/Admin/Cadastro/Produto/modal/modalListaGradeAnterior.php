
<div class="window medio" id="modalListaGrade">

	<div class="p-2 px-4">
			<span class="d-block h3 border-bottom fw-700">Distribua as quantidades </span>
		<div class="rows">
			<div class="col-12">
                <div class="scroll tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" width="100%" id="tbl_grade_produto">
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th align="center">Código Barra</th>
                                    <th align="center">Descrição</th>
                                    <th align="center"><span id="nome_linha"></span></th>
                                    <th align="center"><span id="nome_coluna"></span></th>
                                    <th align="center">Estoque</th>
                                    <th align="center">Qtde</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="datatable-body" id="lista_grade_produto">   
                            
							</tbody>
                          </table>
								
                   </div>

                </div>
                </div>
                
			
         </div>
		 <div class="tfooter end">
		 <span>Total Geral: </span> <span id="qtde_total_movimento"></span>
		 	<input type="button" value="Inserir" id="btnInserir" class="btn btn-azul ">
			<a href="" class="btn btn-neutro fechar">Fechar</a>
		 </div>
	</div>
