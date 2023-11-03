<<<<<<< HEAD
Fluxo
=======
<?php
$logo = 'https://erpmjailton.com.br/assets/img/logo-login.png';
$style='<html lang="pt-br">
	<head>
		<meta charset="utf-8">	
		<style>
			*{font-family:arial,sans-serif;font-size:12px;padding:0;margin:0}
				@page {
						margin-top:110px!important;
						margin-bottom: 20px!important;
					}
				
			.corpo{width:740px;margin:0 auto;}
			table{width:100%}
			.corpo .tt-topo{font-size:16px;padding:1rem 0;text-transform:uppercase}
			#head{position:fixed;width:740px;left:27.3px;right:4px;top:-84px;}
			.head h1{font-size:18px;display:block;padding:8px;text-transform:uppercase}
			.head small{font-size:.75rem;display:block;padding:2px 8px;font-weight:initial!Important;text-transform:uppercase}
			.head p{font-size:.95rem;display:block;padding-bottom:4px;padding-top:3px}
			.head h5{font-size:1rem;padding-bottom:5px;padding-top:0}
			.lista{margin-bottom:1rem}
			.lista .thead th{padding:8px 5px;font-size:11px;}
			.tbody td{padding:8px 5px;font-size:11px; text-transform:uppercase}
			.tbody td small{font-size:9px;display:block;padding-bottom:4px}
			
			.footer{position:fixed;bottom:-28px;width:1040px;left:26px;}
			.footer td b{padding:6px;display:block}
			.thead th{color:#111;padding:4px!importan;background:#eae7e7!important;border:0;font-size:9px!important;text-transform:uppercase}			
			.rows{background:#f5f5f5}
			.rows:nth-of-type(2n+0){background:#fff}
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
	</head>';
$head='	
<body>
<div id="head" class="head">
		<table border="1" cellpadding="0" cellspacing="0" width="100%" class="border">
			<thead>
				<tr> 
					<th width="100" style="padding:15px"><img src="'.$logo.'" height="50"></th>
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
';



$body='
	<div class="corpo">
		<div class="lista">
		
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
				<thead>
					<tr> 
						<th align="left" style="text-transform:uppercase;padding:15px 10px;font-size:16px">
							Fluxo da conta
						</th>
						<th align="center" style="text-transform:uppercase;padding:15px 4px;font-size:16px" class="border-left" width="162.3">
						<small style="font-weight:initial">Data: 01/12/2022 &nbsp; - &nbsp;Hora: 14:00 </small>
						</th>
					</tr>
				</thead>
			</table>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border" style="margin-bottom:10px;margin-top:10px" align="center">
				<tr class="tbody thead">
					<td colspan="7" class="border-left" style="padding:0">					
					<table border="0" cellpadding="0" cellspacing="0" style="width:50%!important;margin:0 auto" class="border-right border-left" align="center">
						<tr>
							<td class="border-bottom" colspan="2"><b>COnta:</b> BRADESCO. De 07/12/2022 até 07/12/2022 <br/></td>
						</tr>
						<tr>
							<td class="border-bottom-traco">Saldo atual:</td>
							<td class="border-bottom-traco" align="right">118.771,54</td>
						</tr>
						<tr>
							<td class="border-bottom-traco">À Pagar:</td>
							<td class="border-bottom-traco" align="right">118.771,54</td>
						</tr>
						<tr>
							<td class="border-bottom-traco">À Receber:</td>
							<td class="border-bottom-traco" align="right">118.771,54</td>
						</tr>
						<tr>
							<td>Saldo Final:</td>
							<td align="right">118.771,54</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			
			<table width="100%" border="0" cellpadding="2" cellspacing="0" class="border" style="margin-bottom:10px">									
					<tr class="thead"> 
						<th align="center" colspan="4" class="border-bottom border-top" style="font-size:12px!important">Contas a receber</th>
					</tr>
					<tr class="thead"> 
						<th align="center" class="border-bottom border-top">Documento</th> 
						<th align="center" class="border-bottom border-top">Pessoa</th> 
						<th align="center" class="border-bottom border-top">Vencimento</th> 
						<th align="center" class="border-bottom border-top">Valor</th>
					</tr>
				
				<tbody class="tbody thead">	
					<tr style="text-transform:uppercase" class="rows">
						<td class="" align="center">1058 - 1</td>
						<td class="" align="center">ALUDI COMERCIO DE COSMETICOS E PERFUMARIA LTDA</td>				 
						<td class="" align="center">07/12/2022 </td>	
						<td class="" align="center">R$ 200,00</td>	
					</tr>	
					<tr style="text-transform:uppercase" class="rows">
						<td class="" align="center">1058 - 1</td>
						<td class="" align="center">ALUDI COMERCIO DE COSMETICOS E PERFUMARIA LTDA</td>				 
						<td class="" align="center">07/12/2022 </td>	
						<td class="" align="center">R$ 200,00</td>	
					</tr>	
					<tr style="text-transform:uppercase" class="rows">
						<td class="" align="center">1058 - 1</td>
						<td class="" align="center">ALUDI COMERCIO DE COSMETICOS E PERFUMARIA LTDA</td>				 
						<td class="" align="center">07/12/2022 </td>	
						<td class="" align="center">R$ 200,00</td>	
					</tr>	
					<tr style="text-transform:uppercase" class="rows">
						<td align="center">&nbsp;</td>
						<td align="center">&nbsp;</td>				 
						<td align="center" class="border-top-traco"><b>Total à receber:</b> </td>	
						<td align="center" class="border-top-traco">R$ 200,00</td>	
					</tr>	
				</tbody>
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
    $size = 8;
    $canvas = $dompdf->get_canvas();
    $canvas->page_text(510, 44, "{PAGE_NUM} / {PAGE_COUNT}", $font, $size, $color);
    $dompdf->stream("arqivo.pdf",["Attachment"=>false]);
	
?>
>>>>>>> 6b80df7b8fdc2812a311cd72036c3ee20d0b6ab4
