<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!--  -->

	<style type="text/css">
		body{margin:0}
		*{font-family:verdana,sans-serif;font-size:13px;-webkit-print-color-adjust: exact;}
		@page {			
			 margin:30px 0					
		}
		.border-top{border-top:1px solid #555}
		.border-bottom{border-bottom:1px solid #555}
		.border-left{border-left:1px solid #555}
		.border-right{border-right:1px solid #555}
		.border{border:1px solid #555}
		.p-1{padding:5px;}
		.py-2{padding:8px 0;}
		.corpo{width: 700px; margin:0 auto;position:relative;}
		table{width:100%;}
		.cabecalho small{font-size:.8rem;display:block;}
		.cabecalho h4{font-size:1.19rem;margin-bottom: 0px;padding-bottom: 0px;margin-top:0}
		
		.dados h4{font-weight:400;font-size:1.26rem;margin-bottom: 0px;padding-bottom: 0px;margin-top:0px;text-transform:uppercase}		
		.dados small{font-size:.8rem;display:block;}
		
		.divisao{margin:20px 0;width:100%;display:inline-block;height:6px;background:#eee}
		
		.assinatura{
			width:250px;
			position:fixed;
			bottom:0;
			left:34%
		}
	</style>

</head>
<body>
	<div class="corpo">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table cellspacing="0" cellpadding="0" class="" width="100%">
				<tr>
					<td width="140px" class="p-1"><img src="{{asset('assets/admin/img/logo-login.png')}}" style="width:100%"></td>
					<td width="" style="padding:0; padding-left:20px;vertical-align: top;">
						<table cellspacing="0" cellpadding="0" width="100%">				
								<tr>
									<td align="center" width="" class="cabecalho">
										<table cellspacing="0" cellpadding="0" border="0" width="100%">
												<tr>
													<td align="left" class="p-1 border-bottom" width="220"><h4 style="text-transform:uppercase">Orçamento #00{{$orcamento->id}}</h4></td>
													<td align="left" class="border-bottom" width="120" style="padding-top:5px">
														<span style="display:block;margin-bottom: 3px;padding-bottom: 3px;"><small><b>Data do Orçamento:</b> {{databr($orcamento->data_orcamento)}}</small>
														<small><b>impresso em:</b> {{date("d/m/Y H:i:s")}}</small>
														</span>
													</td>
												</tr>
												<tr>
													<td align="left" class="border-top py-2"  colspan="2"><small><strong>{{$orcamento->empresa->razao_social}} CNPJ:</strong> {{$orcamento->empresa->cpf_cnpj}}</small></td>
												</tr>	
												<tr>	
													<td class="left"  colspan="2"><small>{{$orcamento->empresa->fone}} </small></td>
												</tr>	
												<tr>	
													<td align="left"  colspan="2"><small>{{$orcamento->empresa->email}}</small></td>
												</tr>
												<tr>
													<td colspan="2"><small>Venda realizada por: {{$orcamento->usuario->name}}</small></td>
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
	<span class="divisao"></span>	
	<table cellpadding="0" cellspacing="0" class="dados">
		<tr>
			<td colspan="2" style="padding-bottom:10px">
				<h4 class="border-bottom">Dados do cliente</h4>
			</td>
		</tr>
		<tr>
			<td class="p-1"><small><b>Cliente:</b> {{$orcamento->cliente->nome_razao_social}} </small></td>
			<td class="p-1"><small><b>CNPJ/CPF:</b> {{$orcamento->cliente->cpf_cnpj}}</small></td>
		</tr>
		<tr>
			<td class="p-1"><small><b>Endereço:</b> {{$orcamento->cliente->logradouro}} </small></td>
			<td class="p-1"><small><b>CEP:</b> {{$orcamento->cliente->cep}}</small></td>
		</tr>
		<tr>
			<td class="p-1"><small><b>Cidade:</b> {{$orcamento->cliente->cidade}}</small></td>
			<td class="p-1"><small><b>Estados:</b> {{$orcamento->cliente->uf}}</small></td>
		</tr>
		<tr>
			<td class="p-1"><small><b>Telefone:</b> {{$orcamento->cliente->fone}} </small></td>
			<td class="p-1"><small><b>E-mail:</b> {{$orcamento->cliente->email}}</small></td>
		</tr>
	</table>
	
	<span class="divisao"></span>	
	<table cellpadding="0" cellspacing="0" class="dados">
		<tr>
			<td colspan="9" style="padding-bottom:10px">
				<h4 class="border-bottom">Produtos</h4>
			</td>
		</tr>
		<tr>
			<th>Item</th>
			<th>Nome</th>
			<th>Unidade</th>
			<th>Qtd</th>
			<th>Valor unit</th>
			<th>Desc. unitário</th>
			<th>Val. Bruto</th>
			<th>Desconto total</th>
			<th>Total Líquido</th>
		</tr>
		@foreach($orcamento->itens as $v)
		<tr>
			<td class="p-1" align="center"><small>{{$v->id}}</small></td>
			<td class="p-1" align="center"><small>{{$v->produto->nome}}</small></td>
			<td class="p-1" align="center"><small>{{$v->produto->unidade}}</small></td>
			<td class="p-1" align="center"><small>{{formataNumeroBr($v->quantidade)}}</small></td>
			<td class="p-1" align="center"><small>{{formataNumeroBr($v->valor)}}</small></td>
			<td class="p-1" align="center"><small>{{formataNumeroBr($v->desconto_por_unidade)}}</small></td>
			<td class="p-1" align="center"><small>{{formataNumeroBr($v->subtotal)}}</small></td>
			<td class="p-1" align="center"><small>{{formataNumeroBr($v->total_desconto_item) }}</small></td>
			<td class="p-1" align="center"><small>{{formataNumeroBr($v->subtotal_liquido)}}</small></td>
			
		</tr>
		@endforeach
	</table>
	
	<span class="divisao"></span>	
	<table cellpadding="0" cellspacing="0" class="dados">
			
		
		<tr>
			<td colspan="5" class="border-top" style="padding-bottom:5px;padding-top:5px;text-align:right">
				<h4 style="font-size:1.2rem;text-transform:initial">
					Total Bruto:<strong style="font-size:1.3rem">{{formataNumeroBr($orcamento->valor_orcamento)}}</strong> 
					Desconto: <strong style="font-size:1.3rem">{{formataNumeroBr($orcamento->valor_desconto)}}</strong>
					Frete: <strong style="font-size:1.3rem">{{formataNumeroBr($orcamento->valor_frete)}}</strong>
					Total Líquido: <strong style="font-size:1.3rem">{{formataNumeroBr($orcamento->valor_liquido)}}</strong>
				</h4>
			</td>
		</tr>
	</table>
	
	
	
	<span class="divisao"></span>	
	<table cellpadding="0" cellspacing="0" class="dados">
		<tr>
			<td style="padding-bottom:10px">
				<h4 class="border-bottom">Observação</h4>
			</td>
		</tr>
		<tr>
			<td class="p-1" align="left"><small>Observação</small></td>
		</tr>
	</table>	
	
	
	<div class="assinatura">
		<table cellpadding="0" cellspacing="0" class="dados" width="100%">
			<tr>
				<td class="p-1" align="center"><small>__________________________________________________</small></td>
			</tr>
			<tr>
				<td class="p-1" align="center"><small>Assinatura do cliente</small></td>
			</tr>
		</table>
	</div>
</div>

</body>
</html>