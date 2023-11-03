@extends("template")
@section("conteudo")


<div class="conteudo">
<div class="caixa">
<div class="rows">
	<div class="col-12">
        <div class="rows">
            <div class="col-12 caixaAberto alt">
				<div class="caixa-titulo py-1 d-flex width-100 justify-content-space-between center-middle">
                <span class="d-flex center-middle">	<i class="fas fa-search mr-1"></i> Dados do Venda:<?php echo $venda->id ?>	</span>
				<a href="{{route('venda.ver')}}" class="btn btn-verde btn-pequeno float-right "><i class="fas fa-arrow-left mb-0"></i> Voltar</a>
				</div>
                    <div class="py-4 px-4">
                        <div class="btnFlex d-flex">										
							<div class="btn-verde co5 caixa">
								<div class="px-3 py-4 width-100 text-branco text-end">
                                    <small>Caixa</small>
                                    <h4 class="h4 mb-0 mt-3"><?php echo $venda->caixa->id ?> </h4>
								</div>
							</div>
                            <div class="btn-verde co2 caixa">
                                  <div class="px-3 py-4 width-100 text-branco">
                                          <small>Data</small>
                                          <h4 class="h4 mb-0 mt-3"><?php echo databr($venda->data_venda) ?></h4>
                                  </div>
                             </div>
                            
                            <div class="btn-verde co3 caixa">
                                 <div class="px-3 py-4 width-100 text-branco">
                                         <small>Total</small>
                                         <h4 class="h4 mb-0 mt-3">R$ <?php echo $venda->valor_venda ?></h4>
                                 </div>
                            </div>
                            <div class="btn-verde co4 caixa">
                                 <div class="px-3 py-4 width-100 text-branco">
                                         <small>Desconto</small>
                                         <h4 class="h4 mb-0 mt-3"><?php echo $venda->valor_desconto ?></h4>
                                 </div>
                            </div>
                            
                            <div class="btn-verde co2 caixa">
                                 <div class="px-3 py-4  width-100 text-branco">
                                         <small>Total a Receber</small>
                                         <h4 class="h4 mb-0 mt-3"><?php echo $venda->valor_liquido ?></h4>
                                 </div>
                            </div>
						</div>
                    </div>
            </div>
        </div>
</div>

<div class="col-12 px-4">

    <div class="caixa border radius-4">
		<strong class="d-block p-1 border-bottom mb-0 text-center text-uppercase">ìtens da venda</strong>
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
              <?php foreach($venda->itens as $item){?>
                <tr>
                   <td align="center"><?php echo $item->id ?></td>
                   <td align="left"><?php echo $item->produto->nome ?></td>
                   <td align="center">R$ <?php echo $item->valor ?></td>
                   <td align="center"><?php echo $item->qtde ?></td>                                                             
                   <td align="center">R$ <?php echo $item->subtotal ?></td>
                 
                </tr>
              <?php }?> 
                <tr>
                    <td align="right" colspan="8" ><b>Total:</b> <span class="text-verde minimo-font">R$ <?php echo $venda->valor_venda?></span></td>
                </tr>	
                </tbody>
            </table>          
		</div>    
    
   
    </div> 
   
</div>

 </div>
 </div>
 </div>


@endsection