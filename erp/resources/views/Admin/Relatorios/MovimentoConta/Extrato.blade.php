<?php $logo = 'https://erpmjailton.com.br/assets/img/logo-login.png';?>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">	
		<style>
			*{font-family:arial,sans-serif;font-size:12px;padding:0;margin:0}
				@page {
						margin-top:120px!important;
						margin-bottom: 80px!important;
					}
				
			.corpo{width:1040px;margin:0 auto;}
			table{width:100%}
			.corpo .tt-topo{font-size:16px;padding:1rem 0;text-transform:uppercase}
			#head{position:fixed;width:1040px;left:40.9px;right:4px;top:-84px;}
			.head h1{font-size:18px;display:block;padding:8px;text-transform:uppercase}
			.head small{font-size:.85rem;display:block;padding:2px 8px;font-weight:inherit}
			.head p{font-size:.95rem;display:block;padding-bottom:4px;padding-top:3px}
			.head h5{font-size:1rem;padding-bottom:5px;padding-top:0}
			.lista{margin-bottom:1rem}
			.lista .thead th{padding:10px;font-size:18px;}
			.lista td{padding:8px 4px;font-size:9px}
			.lista td p{padding:4px;font-size:9px}
			
			.rows{background:#f5f5f5}
			.rows:nth-of-type(2n+0){background:#fff}
			
			.footer{position:fixed;bottom:-28px;width:1040px;left:26px;}
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
			
			.border-top-traco{border-top:dashed 1px #000;}
			.border-bottom-traco{border-bottom:dashed 1px #000;}
			
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
					<th width="100" style="padding:15px"><img src="<?php echo $logo?>" height="50"></th>
					<th style="vertical-align:middle">
						<table cellpadding="0" cellspacing="0" width="100%" border="0">
							<tr>
								<th align="left" style="padding-top:4px">
									<span class="d-block" style="font-size:1.3rem;text-transform:uppercase;padding-left:10px">Flex loja magazine e tecnologia</span>
								</th>
							</tr>
							<tr>
								<th align="left" style="padding-top:4px">
									<small class="d-block" style="font-size:1.1rem;">CNPJ: 31.696.302/0001-70</small>
								</th>
							</tr>
							<tr>
								<th align="left" style="padding-top:4px">									
									<small class="d-block" style="font-size:1.1rem;">Tel: (98)3304-4200</small>
								</th>
							</tr>
							
							
						</table>
					</th>
					<th width="168" style="padding:0">
						<table  cellpadding="0" cellspacing="0" width="100%" border="0">							
							<tr>
								<th align="center" style="padding-bottom:4px;position:relative">
									<small>Páginas: </small>
									
								</th>
							</th>
							<tr>
						</table>
					</th>
				</tr>
			</thead>
			</table>			
		</div>			
	</div>

	<div class="corpo">
		<div class="lista">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border" style="border-bottom:0">
				<thead>
					<tr> 
						<th align="left" style="text-transform:uppercase;padding:15px 10px;font-size:16px">
							Extrato
						</th>
						<th align="center" style="text-transform:uppercase;padding:15px 4px;font-size:16px" class="border-left" width="162.3">
						<small style="font-weight:initial">Data: 01/12/2022 &nbsp; - &nbsp;Hora: 14:00 </small>
						</th>
					</tr>
				</thead>
			</table>
			
			<table width="100%" border="0" cellpadding="2" cellspacing="0" class="border" style="margin-bottom:10px">						
				<tr class="tbody thead">
					<th align="right" style="padding-bottom:0;padding-top:10px" width="120">Extrato Conta Corrente</th>
					<td colspan="7" class="border-left border-bottom-traco"  style="padding-bottom:5px;padding-top:10px"> </td>
				</tr>
				<tr class="tbody thead">
					<th align="right" style="padding-bottom:10px">Conta</th>
					<td colspan="7" class="border-left" style="padding-bottom:10px;padding-top:5px">Conta: {{$conta->conta->conta}} - {{$conta->conta->descricao}} - Agência: {{$conta->conta->agencia}} Banco: {{$conta->conta->banco->banco}}</td>
				</tr>
					<tr class="thead"> 
						<th align="center" class="border-bottom border-top">Dt.Comp</th> 
						<th align="center" class="border-bottom border-top">Emissão</th> 
						<th align="center" class="border-bottom border-top">Documento</th> 
						<th align="center" class="border-bottom border-top">Descricao Historico </th>  
						<th align="center" class="border-bottom border-top">Saldo Anterior </th>		
						<th align="center" class="border-bottom border-top">Debito</th>		
						<th align="center" class="border-bottom border-top">Credito</th>
						<th align="center" class="border-bottom border-top">Saldo Atual</th>
					</tr>
				
				<tbody class="tbody thead">
				@php
					$saldo_anterior = $conta->saldo_anterior;
					$total 			= 0;
					$soma_credito	= 0;
					$soma_debito    = 0;
				@endphp
				@foreach($conta->lista as $c)
					@php 
						if($c->tipo_movimento == "D" ){
							$total =  $saldo_anterior -  $c->valor ;
							$soma_debito += $c->valor;
						}else{
							$total =  $saldo_anterior +  $c->valor;
							$soma_credito += $c->valor;
						}
												
						
					@endphp
					<tr style="text-transform:uppercase" class="rows">
						<td class="" align="center">{{databr($c->data_compensacao)}}</td>
						<td class="" align="center">{{databr($c->data_emissao)}}</td>
						<td class="" align="center">{{$c->documento}}</td>
						<td class="" align="center">{{$c->historico}}</td>				 
						<td class="" align="center">{{$saldo_anterior}} </td>				 
						<td class="" align="center">{{$c->tipo_movimento == "D" ? $c->valor : "--"}}</td>				 
						<td class="" align="center">{{$c->tipo_movimento == "C" ? $c->valor : "--"}}</td>	
						<td class="" align="center">R$ {{$total}}</td>	
					</tr>
					@php 
						$saldo_anterior = $total;
					@endphp	
				 @endforeach		
					
					<tr style="text-transform:uppercase" class="rows">
						<td class="" align="center">&nbsp;</td>
						<td class="" align="center">&nbsp;</td>
						<td class="" align="center">&nbsp;</td>
						<td class="" align="center">&nbsp;</td>				 
						<td class="border-top-traco" align="center">0,00 </td>					 
						<td class="border-top-traco" align="center">{{$soma_debito}}</td>				 
						<td class="border-top-traco" align="center">{{$soma_credito}}</td>	
						<td class="border-top-traco" align="center">R$ {{$total}}</td>	
					</tr>
				</tbody>
			</table>	
		</div>
	</div>

</body>
</html>

