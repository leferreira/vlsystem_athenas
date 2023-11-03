@extends("template")
@section("conteudo")


<div class="rows">
	<div class="col-12">
        <div class="rows">
            <div class="col-12">
				<div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
                <span class="d-flex center-middle">	<i class="fas fa-search mr-1"></i> Dados do Venda:<?php echo $venda->id_venda ?>	</span>
				<a href="<?php echo "venda"?>" class="btn btn-verde btn-pequeno float-right "><i class="fas fa-arrow-left mb-0"></i> Voltar</a>
				</div>
                    <div class="py-4 px-4">
                        <div class="rows text-escuro">										
							<div class="col-2 px-1 d-flex">
								<div class="px-3 py-4 border radius-4 width-100">
                                    <i class="fas fa-users pequeno-font float-left mr-1 text-padrao"></i>
                                    <small>Caixa</small>
                                    <h4 style="line-height:1rem"><?php echo $venda->id_caixa ?> </h4>
								</div>
							</div>
                            <div class="col d-flex">
                                  <div class="px-3 py-4 border radius-4 width-100">
                                          <i class="fas fa-calendar-alt pequeno-font float-left mr-1 text-padrao"></i>
                                          <small>Data</small>
                                          <h4><?php echo databr($venda->data_venda) ?></h4>
                                  </div>
                             </div>
                             <div class="col d-flex">
                                <div class="px-3 py-4 border radius-4 width-100">
                                        <i class="far fa-clock pequeno-font float-left mr-1 text-padrao"></i>
                                        <small>Hora</small>
                                        <h4><?php echo $venda->hora_venda ?></h4>
                                </div>
                            </div>
                            <div class="col d-flex">
                                 <div class="px-3 py-4 border radius-4 width-100">
                                         <i class="fab fa-bitcoin pequeno-font float-left mr-1 text-padrao"></i>
                                         <small>Total</small>
                                         <h4>R$ <?php echo $venda->total ?></h4>
                                 </div>
                            </div>
                            <div class="col d-flex">
                                 <div class="px-3 py-4 border radius-4 width-100">
										<i class="fas fa-map-marker-alt  pequeno-font float-left mr-1 text-padrao"></i>
                                         <small>Desconto</small>
                                         <h4><?php echo $venda->desconto ?></h4>
                                 </div>
                            </div>
                            
                            <div class="col d-flex">
                                 <div class="px-3 py-4 border radius-4 width-100">
										<i class="fas fa-map-marker-alt  pequeno-font float-left mr-1 text-padrao"></i>
                                         <small>Total a Receber</small>
                                         <h4><?php echo $venda->total_receber ?></h4>
                                 </div>
                            </div>
						</div>
                    </div>
            </div>
        </div>
</div>

<div class="col-12 px-4">

    <div class="caixa border radius-4">
		<span class="p-2 bg-title text-light text-uppercase h4 mb-0 text-branco"><i class="far fa-list-alt"></i> Itens do Venda</span>
		<div class="tabela-responsiva">
            <table cellpadding="0" cellspacing="0" class="table-bordered">
               <thead>
                   <tr>
                      <th align="center">ID</th>
                      <th align="left" width="290">Produto</th>
                      <th align="center">Preço</th>
                      <th align="center">Qtde</th>                                                         
                      <th align="center">Subtotal</th>
                   </tr>
               </thead>
               <tbody>
              <?php foreach($lista as $item){?>
                <tr>
                   <td align="center"><?php echo $item->id_item_venda ?></td>
                   <td align="left"><?php echo $item->produto ?></td>
                   <td align="center">R$ <?php echo $item->valor ?></td>
                   <td align="center"><?php echo $item->qtde ?></td>                                                             
                   <td align="center">R$ <?php echo $item->subtotal ?></td>
                 
                </tr>
              <?php }?> 
                <tr>
                    <td align="right" colspan="8" ><b>Total:</b> <span class="text-verde minimo-font">R$ <?php echo $venda->total?></span></td>
                </tr>	
                </tbody>
            </table>          
		</div>    
    
   
    </div> 
   
</div>

    </div>


@endsection