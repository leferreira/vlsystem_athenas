<?php
$logo =  url('assets/admin/img/logo-login.png');
$style='<html lang="pt-br">
	<head>
		<meta charset="utf-8">	
		<style>
			*{font-family:arial,sans-serif;font-size:12px;padding:0;margin:0}
				@page {
						margin-top:160px!important;
						margin-bottom: 80px!important;
					}
				
			.corpo{width:740px;margin:0 auto;}
			table{width:100%}
			.corpo .tt-topo{font-size:16px;padding:1rem 0;text-transform:uppercase}
			#head{position:fixed;width:740px;left:26.7px;right:4px;top:-123px;}
			.head h1{font-size:18px;display:block;padding:8px;text-transform:uppercase}
			.head small{font-size:.85rem;display:block;padding:2px 8px;font-weight:inherit}
			.head p{font-size:.95rem;display:block;padding-bottom:4px;padding-top:3px}
			.head h5{font-size:1rem;padding-bottom:5px;padding-top:0}
			.lista{margin-bottom:1rem}
			.lista .thead th{padding:5px;font-size:11px;}
			.lista td{padding:2px;font-size:9px}
			.lista td p{padding:2px;font-size:9px}
			
			.footer{position:fixed;bottom:-28px;width:740px;left:26px;}
			.footer td b{padding:6px;display:block}
			.thead th{color:#111;padding:4px!importan;background:#ddd!important;border:0;font-size:9px!important}			
			
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
	</head>';
$head='	
<body>
<div id="head" class="head">
		<table border="1" cellpadding="0" cellspacing="0" width="100%" class="border">
			<thead>
				<tr> 
					<th width="164"	height="73" style="padding:15px"><img src="'.$logo.'" width="100%"></th>
					<th style="vertical-align:middle">
						<table cellpadding="0" cellspacing="0" width="100%" border="0">
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
';



$body='
	<div class="corpo">
		<div class="lista">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
				<thead>
					<tr> 
						<th colspan="11" class="border-bottom" style="text-transform:uppercase;padding:15px 4px;font-size:16px">RELATÓRIO DE CONTAS A PAGAR<br> <small>(Pag:1)</small></th>
					</tr>
				</thead>
			</table>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
				<thead>
					<tr class="thead"> 
						<th align="left" class="border-bottom">DOC./NF</th> 
						<th align="center" class="border-bottom">PEDIDO</th> 
						<th align="center" class="border-bottom">FORNECEDOR</th> 
						<th align="center" class="border-bottom">ATR</th>  
						<th align="center" class="border-bottom">EMISSÃO</th>										  
						<th align="center" class="border-bottom">VENC/PREV.</th>
						<th align="center" class="border-bottom">VLR.LIQ.</th>
						<th align="center" class="border-bottom">COBRADO</th>
						<th align="center" class="border-bottom">RESTANTE</th>
						<th align="center" class="border-bottom">JUROS</th>
						<th align="center" class="border-bottom">DÉB.TOTAL</th>
					</tr>
				</thead>
				
				<tbody class="tbody thead">	
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left" colspan="6"><p><b>TOTAIS</b></p></td>
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00		</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
					</tr>
				</tbody>
			</table>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border" style="margin-top:10px">
				<thead>
					<tr class="thead"> 
						<th align="left" class="border-bottom">DOC./NF</th> 
						<th align="center" class="border-bottom">PEDIDO</th> 
						<th align="center" class="border-bottom">FORNECEDOR</th> 
						<th align="center" class="border-bottom">ATR</th>  
						<th align="center" class="border-bottom">EMISSÃO</th>										  
						<th align="center" class="border-bottom">VENC/PREV.</th>
						<th align="center" class="border-bottom">VLR.LIQ.</th>
						<th align="center" class="border-bottom">COBRADO</th>
						<th align="center" class="border-bottom">RESTANTE</th>
						<th align="center" class="border-bottom">JUROS</th>
						<th align="center" class="border-bottom">DÉB.TOTAL</th>
					</tr>
				</thead>
				
				<tbody class="tbody thead">	
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left" colspan="6"><p><b>TOTAIS</b></p></td>
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00		</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left" colspan="6"><p><b>TOTAIS</b></p></td>
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00		</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
					</tr>
				</tbody>
			</table>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border" style="margin-top:10px">
				<thead>
					<tr class="thead"> 
						<th align="left" class="border-bottom">DOC./NF</th> 
						<th align="center" class="border-bottom">PEDIDO</th> 
						<th align="center" class="border-bottom">FORNECEDOR</th> 
						<th align="center" class="border-bottom">ATR</th>  
						<th align="center" class="border-bottom">EMISSÃO</th>										  
						<th align="center" class="border-bottom">VENC/PREV.</th>
						<th align="center" class="border-bottom">VLR.LIQ.</th>
						<th align="center" class="border-bottom">COBRADO</th>
						<th align="center" class="border-bottom">RESTANTE</th>
						<th align="center" class="border-bottom">JUROS</th>
						<th align="center" class="border-bottom">DÉB.TOTAL</th>
					</tr>
				</thead>
				
				<tbody class="tbody thead">	
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left" colspan="6"><p><b>TOTAIS</b></p></td>
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00		</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
					</tr>
				</tbody>
			</table>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border" style="margin-top:10px">
				<thead>
					<tr class="thead"> 
						<th align="left" class="border-bottom">DOC./NF</th> 
						<th align="center" class="border-bottom">PEDIDO</th> 
						<th align="center" class="border-bottom">FORNECEDOR</th> 
						<th align="center" class="border-bottom">ATR</th>  
						<th align="center" class="border-bottom">EMISSÃO</th>										  
						<th align="center" class="border-bottom">VENC/PREV.</th>
						<th align="center" class="border-bottom">VLR.LIQ.</th>
						<th align="center" class="border-bottom">COBRADO</th>
						<th align="center" class="border-bottom">RESTANTE</th>
						<th align="center" class="border-bottom">JUROS</th>
						<th align="center" class="border-bottom">DÉB.TOTAL</th>
					</tr>
				</thead>
				
				<tbody class="tbody thead">	
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left">154137/1-NF:154137</td>
						<td class="border-bottom" align="center">0</td>
						<td class="border-bottom" align="center"><p>43-ANJO QUIMICA DO BRASIL LTDA</p></td>
						<td class="border-bottom" align="center">122</td>				 
						<td class="border-bottom" align="center"><p>23/02/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>V:16/03/2022</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p>	</td>	
						<td class="border-bottom" align="center"><p>0,00</p>	</td>	
						<td class="border-bottom" align="center"><p>1.184,17</p></td>	
					</tr>
					<tr style="text-transform:uppercase">
						<td class="border-bottom" align="left" colspan="6"><p><b>TOTAIS</b></p></td>
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
						<td class="border-bottom" align="center"><p><b>0,00		</b></p></td>	
						<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
					</tr>
				</tbody>
			</table>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border" style="margin-top:10px">
				<tr>
					<td style="width:440px;padding:10px 4px"><b>TOTAIS (CONTAS: 26)</b></td>					
					<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
					<td class="border-bottom" align="center"><p><b>0,00	</b></p></td>	
					<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>	
					<td class="border-bottom" align="center"><p><b>0,00		</b></p></td>	
					<td class="border-bottom" align="center"><p><b>1.184,17	</b></p></td>
				</tr>
			</table>
			
			
		</div>
	</div>

</body>
</html>
';

//concatenando as variáveis
$html = $style.$head.$body;

//gerando o pdf
	 $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'); 
	//echo $html;
	//exit;
    $dompdf->loadHtml($html);
    $dompdf->setPaper("a4","portrait");
    $dompdf->render();
    $color = array(0, 0, 0);
    $font = null;
    $size = 10;
    $canvas = $dompdf->get_canvas();
    //$canvas->page_text(532, 815, "Pág: {PAGE_NUM} / {PAGE_COUNT}", $font, $size, $color);
    $dompdf->stream();
	
?>