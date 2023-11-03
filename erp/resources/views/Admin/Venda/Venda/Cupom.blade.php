<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!--  -->

	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@200;400&display=swap');
		body{margin:0}
		*{font-family: 'Source Code Pro', monospace;font-size:13px;-webkit-print-color-adjust: exact;}
		@page {			
			 margin:30px 0					
		}
		.border-top{border-top:1px solid #555}
		.border-bottom{border-bottom:1px solid #555}
		.border-left{border-left:1px solid #555}
		.border-right{border-right:1px solid #555}
		.border{border:1px solid #555}
		
		.border-bottom-traco{border-bottom:1px dashed #222}
		.p-1{padding:5px;}
		.py-1{padding:2px 0;}
		.py-2{padding:8px 0;}
		
		.corpo{width: 450px; margin:0 auto;position:relative}
		
		table{width:100%;}
		.cabecalho small{font-size:1rem;display:block;}
		.cabecalho h4{font-size:1.25rem;margin-bottom: 0px;padding-bottom: 5px;margin-top:0;text-transform:uppercase}
		
		.dados h4{text-align:center;font-weight:700;font-size:1.26rem;margin-bottom: 0px;padding-bottom: 0px;margin-top:0px;text-transform:uppercase}		
		.dados small{font-size:1rem;display:block;}
		
		.divisao{margin:20px 0;width:100%;display:inline-block;height:6px;border-bottom:1px dashed #222}
		
		.assinatura{
			width:250px;
			position:fixed;
			bottom:50px;
			left:34%
		}
		.assinatura .cupon{
			font-size:1.5rem;
		}
		.assinatura .voltesempre{
			font-size:2rem;font-weight:700;font-family:arial, 'sans-serif';text-transform:uppercase;color:#bbb
		}

	</style>

</head>
<body>
	<div class="corpo">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="border-bottom-traco" style="padding-bottom:10px">
				<table cellspacing="0" cellpadding="0" class="" width="100%">
				<tr>
					<td width="113px" class="p-1"><img src="{{asset('assets/admin/img/logo-login.png')}}" style="width:100%"></td>
					<td width="" style="padding:0; padding-left:20px;vertical-align: top;">
						<table cellspacing="0" cellpadding="0" width="100%">				
								<tr>
									<td align="center" width="" class="cabecalho">
										<table cellspacing="0" cellpadding="0" border="0" width="100%">
												<tr>	
													<td class="left"  colspan="2"><h4>{{$venda->empresa->razao_social}}</h4></td>
												</tr>
												<tr>	
													<td class="left"  colspan="2"><small>CNPJ:{{$venda->empresa->cpf_cnpj}}</small></td>
												</tr>	
												<tr>	
													<td align="left"  colspan="2"><small>{{$venda->empresa->cidade}}- {{$venda->empresa->uf}}</small></td>
												</tr>
												<tr>
													<td colspan="2"><small>Atendente: {{$venda->usuario->name}}</small></td>
												</tr>
										</table>
									</td>
								</tr>										
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	<br>
	<table cellpadding="0" cellspacing="0" class="dados ">
		<tr>
			<td style="padding-bottom:10px">
				<h4 class="">Pedido Nº 0{{$venda->id}}</h4>
			</td>
		</tr>
		<tr>
			<td class="py-1"><small><b>Data:</b> {{databr($venda->data_venda)}} </small></td>
		</tr>
		<tr>
			<td class="py-1"><small><b>Cliente:</b> {{$venda->cliente->nome_razao_social}} </small></td>
		</tr>
		<tr>
			<td class="py-1"><small><b>CNPJ/CPF:</b> {{$venda->cliente->cpf_cnpj}}</small></td>
		</tr>
		<tr>
			<td class="py-1"><small><b>Email:</b> {{$venda->cliente->email}}</small></td>
		</tr>	
	</table>
	
	<span class="divisao"></span>
	<br>
	
	<table cellpadding="0" cellspacing="0" class="dados">
		<tr>
			<td style="padding-bottom:10px" colspan="5 ">
				<h4 class="">Produtos</h4>
			</td>
		</tr>
		<tr>
			<th class="p-1" align="left">Produto</th>
			<th class="p-1" align="center">Qtd</th>
			<th class="p-1" align="center">Valor uni.</th>
			<th class="p-1" align="center">Desc.</th>
			<th class="p-1" align="center">Subtotal</th>
		</tr>
		@foreach($venda->itens as $v)
		<tr>
			<td class="p-1" align="left"><small>{{$v->produto->nome}}</small></td>
			<td class="p-1" align="center"><small>{{$v->quantidade}}</small></td>
			<td class="p-1" align="center"><small>{{$v->valor}}</small></td>
			<td class="p-1" align="center"><small>--</small></td>
			<td class="p-1" align="center"><small>{{$v->subtotal}}</small></td>
		</tr>
		@endforeach	
	</table>
	
	<span class="divisao"></span>
	<br>
	
	<table cellpadding="0" cellspacing="0" class="dados">
		<tr>
			<td style="padding-bottom:10px" colspan="3">
				<h4 class="">Pagamento</h4>
			</td>
		</tr>
		<tr>
			<th align="left">Vencimento</th>
			<th>Valor </th>
			<th>Status</th>
		</tr>
		@foreach($venda->contas as $d)
		<tr>
			<td class="py-2" align="left"><small>{{databr($d->data_vencimento)}}</small></td>
			<td class="py-2" align="center"><small>{{$d->valor}}</small></td>
			<td class="py-2" align="center"><small>{{$d->status->status}}</small></td>
		</tr>
		@endforeach
		
		<tr>
			<td colspan="3" style="padding-bottom:5px;padding-top:5px;text-align:right">
				<h4 style="font-size:1rem;text-transform:initial;text-align:right">Total da venda: <strong style="font-size:1.1rem">{{$venda->valor_total}}</strong></h4>
			</td>
		</tr>		
	</table>
	
	<span class="divisao"></span>
	<br>	
	<table cellpadding="0" cellspacing="0" class="dados">
		<tr>
			<td style="padding-bottom:10px">
				<h4 class="">Observação</h4>
			</td>
		</tr>
		<tr>
			<td class="p-1" align="left"><small>Observação</small></td>
		</tr>
	</table>
	
	
	
	
	</div>


</body>
</html>