<?php $logo = 'https://erpmjailton.com.br/assets/img/logo-login.png';?>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">	
		<style>
			*{font-family:arial,sans-serif;font-size:12px;padding:0;margin:0}
				@page {
						margin-top:140px!important;
						margin-bottom: 80px!important;
					}
				
			.corpo{width:740px;margin:0 auto;}
			table{width:100%}
			.corpo .tt-topo{font-size:16px;padding:1rem 0;text-transform:uppercase}
			#head{position:fixed;width:740px;left:26.8px;right:4px;top:-119px;}
			.head h1{font-size:18px;display:block;padding:8px;text-transform:uppercase}
			.head small{font-size:.85rem;display:block;padding:2px 8px;font-weight:inherit}
			.head p{font-size:.95rem;display:block;padding-bottom:4px;padding-top:3px}
			.head h5{font-size:1rem;padding-bottom:5px;padding-top:0}
			.lista{margin-bottom:1rem}
			.lista .thead th{padding:10px;font-size:18px;}
			.lista td{padding:8px 4px;font-size:9px}
			.lista td p{padding:4px;font-size:9px}
			
			.footer{position:fixed;bottom:-28px;width:740px;left:26px;}
			.footer td b{padding:6px;display:block}
			.thead th{color:#111;padding:4px!importan;background:#eee!important;border:0;font-size:8px!important;text-transform:uppercase}			
			
			.border-top{border-top:solid 1px #444!important}
			.border-bottom{border-bottom:solid 1px #444!important}
			.border-left{border-left:solid 1px #444!important}
			.border-right{border-right:solid 1px #444!important}
			.comentario-txt p {margin-bottom:1rem;page-break-inside: avoid}
			.cabecalho th{padding:5px 5px}
			
				input[type="checkbox"]:before{font-family:"DejaVu Sans"; }
				input[type="radio"]:before{font-family:"DejaVu Sans"; }
				.altura{
					height:42px
				}
			.border{border:solid 1px #000;}
			.border-bottom{border-bottom:solid 1px #000;}
			.border-left{border-left:solid 1px #000;}
			.border-right{border-right:solid 1px #000;}
			.border-top{border-top:solid 1px #000;}
			
			.tab,.tab .cell{width:100%;float:left;}
			.tab .col{width:50%;float:left;}
			.data{position:absolute;right:5px;top:-28px;padding:8px;text-align:right}
		</style>				 
	</head>
	
	
<body>
<div id="head" class="head">
		<table border="1" cellpadding="0" cellspacing="0" width="100%" class="border">
			<thead>
				<tr> 
					<th width="100" style="padding:10px"><img src="<?php echo $logo ?>" height="50"></th>
					<th style="vertical-align:middle">
						<table cellpadding="0" cellspacing="0" width="100%" border="0">
							<tr>
								<th align="left" class="border-bottom">
									<h1>Sistema ERP - Athenas</h1>
								</th>
							</tr>
							<tr>
								<th align="left" style="padding-top:4px">
									<small class="d-block" >CNPJ: 31.696.302/0001-70</small>
								</th>
							</tr>
							<tr>
								<th align="left" class="">
									<small class="d-block" > AV. JERONIMO DE ALBUQUERQUE, N. 14 - VINHAIS</small>
								</th>
							<tr>
							</tr>
							<tr>
								<th align="left" class="">
									<small class="d-block" > SAO LUIS-MA</small>
								</th>
							</tr>
							<tr>
								<th align="left"  style="padding-bottom:4px;position:relative">
									<small class="d-block" >Tel: (98)3304-4200</small>
									
									<div class="data">
										24/08/2022<br>
										28:30h
									</div>
								</th>								
							</tr>
						</table>
					</th>
				</tr>
			</thead>
			</table>
			
	</div>

	<div class="corpo">
		<div class="lista">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
				<thead>
					<tr> 
						<th colspan="7" class="" style="text-transform:uppercase;padding:15px 4px;font-size:16px">
						Lista de Recebimentos agrupados por dia de vencimento<br> 
						<small style="font-weight:initial">Filtrado por data de emissão. De {{databr($filtro->recebimento01)}} até {{databr($filtro->recebimento02)}} com as situação</small>
						</th>
					</tr>
				</thead>
			</table>
		@foreach($lista as $l)	
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border" style="border-top:0;margin-bottom:20px">
				<thead>
					<tr class="thead"> 
						<th align="left" colspan="10" class="border-bottom border-top" style="font-size:1rem!important">Vencimento: {{databr($l->data)}}</th> 
					</tr>
					<tr class="thead"> 
						<th align="center">Id</th>
                       <th  class="border-bottom">Descrição</th>
                       
                       <th align="center" class="border-bottom">Forma Pagto</th>
                       <th align="center"  class="border-bottom">Data Recebimento</th>
                       <th align="center" class="border-bottom">Número</th>
                       <th align="center" class="border-bottom">Valor Original</th>
                       <th align="center" class="border-bottom">Juros</th>
                       <th align="center" class="border-bottom">Desconto</th>
                       <th align="center" class="border-bottom">Multa</th>
                       <th align="center" class="border-bottom">Valor Recebido</th>
                       
					</tr>
				</thead>
				
				<tbody class="tbody thead">	
				@php
					$soma_total_recebido = 0;				
					
				@endphp
				
				@foreach($l->lista as $lancamento)
				@php
					$soma_total_recebido += $lancamento->valor_recebido;			
					
				@endphp
					<tr style="text-transform:uppercase">						
					   <td class="border-bottom border-right" align="center">{{ $lancamento->id }}</td>
                       <td class="border-bottom border-right" align="left">{{ $lancamento->descricao_recebimento }} </td>
                       <td class="border-bottom border-right" align="center">{{ ($lancamento->forma_pagamento) ? $lancamento->forma_pagamento->forma_pagto : '--' }}</td>  
                       <td class="border-bottom border-right" align="center">{{ databr($lancamento->data_recebimento) }}</td>
                       <td class="border-bottom border-right" align="center">{{ $lancamento->numero_documento }}</td>
                       <td class="border-bottom border-right" align="center">{{ formataNumeroBr($lancamento->valor_original) }}</td>
                       <td class="border-bottom border-right" align="center">{{ formataNumeroBr($lancamento->juros) }}</td>
                       <td class="border-bottom border-right" align="center">{{ formataNumeroBr($lancamento->desconto) }}</td>
                       <td class="border-bottom border-right" align="center">{{ formataNumeroBr($lancamento->multa) }}</td>
                       <td class="border-bottom border-right" align="center">{{ formataNumeroBr($lancamento->valor_recebido) }}</td>
                                                            
					</tr>	
				@endforeach					
					<tr> 
						<td align="right" colspan="10" class="border-bottom" style="font-size:1rem!important;padding:5px 20px"><b>Total: {{formataNumeroBr($soma_total_recebido)}}</b></td> 
					</tr>
				</tbody>
			</table>			
			
		@endforeach			
			
		</div>
	</div>

</body>
</html>

