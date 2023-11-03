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
									<small>Usuário: <b><?php echo $usuario->name ?></b></small>
									
								</th>
						
							<tr>
						</table>
					</th>
				</tr>
			</thead>
		</table>		
	</div>			


	<div class="corpo">
		<div class="lista">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border" style="border-bottom:0">
				<thead>
					<tr> 
						<th align="left" style="text-transform:uppercase;padding:15px 10px;font-size:16px">
							Relação de Títulos a Pagar Agrupado por Fornecedor
						</th>
						<th align="center" style="text-transform:uppercase;padding:15px 4px;font-size:16px" class="border-left" width="162.3">
						<small style="font-weight:initial">Data: <?php echo databr(hoje()) ?>  &nbsp; - &nbsp;Hora: <?php echo agora() ?> </small>
						</th>
					</tr>
				</thead>
			</table>
			@foreach($lista as $l)
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border" style="margin-bottom:10px">
									
				<tr class="tbody thead">
					<th>Fornecedor</th>
					<td colspan="9" class="border-left"> {{$l->fornecedor->razao_social}} </td>
				</tr>	
						
                   				
					<tr class="thead"> 
					    <th align="left" class="border-bottom border-top">Emissão</th>  
						<th align="center" class="border-bottom border-top">Descrição</th> 
						<th align="center" class="border-bottom border-top">Fornecedor</th> 
						<th align="center" class="border-bottom border-top">Valor Original</th>										  
						<th align="center" class="border-bottom border-top">Total Recebido</th>
						<th align="center" class="border-bottom border-top">Total Restante</th>
						<th align="center" class="border-bottom border-top ">Juros</th>
						<th align="center" class="border-bottom border-top">Multa</th>
						<th align="center" class="border-bottom border-top">Desconto</th>						
						<th align="left" class="border-bottom border-top">Status</th>
					</tr>
				
				<tbody class="tbody thead">	
				@php
					$soma_valor_original = 0;
					$soma_total_recebido = 0;
					$soma_total_restante = 0;
					$soma_total_juros = 0;
					$soma_total_multa = 0;
					$soma_total_desconto = 0;
					
					
				@endphp
				@foreach($l->lista as $v)
				@php
					$soma_valor_original += $v->valor;
					$soma_total_recebido += $v->total_recebido;
					$soma_total_restante += $v->total_restante;
					$soma_total_juros 	 += $v->total_juros;
					$soma_total_multa    += $v->total_multa;
					$soma_total_desconto += $v->total_desconto;				
					
				@endphp
					<tr style="text-transform:uppercase">
						<td class="border-bottom-traco" align="left">{{databr($v->data_emissao)}}</td>
						
						<td class="border-bottom-traco" align="center"><p>{{$v->descricao}}</p></td>
						<td class="border-bottom-traco" align="left">{{$l->fornecedor->razao_social ?? '---'}}</td>
						<td class="border-bottom-traco" align="center"><p>{{formataNumeroBr($v->valor)}}</p></td>				 
						<td class="border-bottom-traco" align="center"><p>{{formataNumeroBr($v->total_recebido)}} </p>	</td>	
						<td class="border-bottom-traco" align="center"><p>{{formataNumeroBr($v->total_restante)}} </p>	</td>	
						<td class="border-bottom-traco" align="center"><p>{{formataNumeroBr($v->total_juros)}} </p>	</td>	
						<td class="border-bottom-traco" align="center"><p>{{formataNumeroBr($v->total_multa)}} </p>	</td>
						<td class="border-bottom-traco" align="center"><p>{{formataNumeroBr($v->total_desconto)}} </p>	</td>
						<td class="border-bottom-traco" align="left">{{$v->status->status}}</td>	
					</tr>
				@endforeach
				
					<tr style="text-transform:uppercase">
						<td class="border-bottom-traco" align="center">&nbsp;</td>
						<td class="border-bottom-traco" align="center">&nbsp;</td>
						<td class="border-bottom-traco" align="center">&nbsp;</td>
						<td class="border-bottom-traco" align="center"><b>{{formataNumeroBr($soma_valor_original)}}</b></td>
						<td class="border-bottom-traco" align="center">{{formataNumeroBr($soma_total_recebido)}}</td>				 
						<td class="border-bottom-traco" align="center">{{formataNumeroBr($soma_total_restante)}}</td>				 
						<td class="border-bottom-traco" align="center">{{formataNumeroBr($soma_total_juros)}}</td>	
						<td class="border-bottom-traco" align="center">{{formataNumeroBr($soma_total_multa)}}</td>	
						<td class="border-bottom-traco" align="center"><b>{{formataNumeroBr($soma_total_desconto)}}</b></td>	
						<td class="border-bottom-traco" align="center"></td>	
					</tr>
				</tbody>
			</table>	
			@endforeach			
		</div>
	</div>

</body>
</html>

