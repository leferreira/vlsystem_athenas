<?php
$logo = 'https://erpmjailton.com.br/assets/img/logo-login.png';
$style='<html lang="pt-br">
	<head>
		<meta charset="utf-8">	
		<style>
			*{font-family:arial,sans-serif;font-size:12px;padding:0;margin:0}
				@page {
						margin-top:160px!important;
						margin-bottom: 80px!important;
					}
				body:before{
					content:"	";
					position:absolute;
					top:-132px;
					left:20px;
					right:20px;
					bottom:-38px;
					border:solid 1px #111;
					}
				body:after{
					content:"	";
					position:absolute;
					top:-132px;
					left:20px;
					right:20px;
					bottom:-38px;
					border:solid 1px #111;
					}
			.corpo{width:740px;margin:0 auto;}
			table{width:100%}
			.corpo .tt-topo{font-size:16px;padding:1rem 0;text-transform:uppercase}
			#head{position:fixed;width:740px;left:26px;right:4px;top:-123px;}
			.head h1{font-size:18px;display:block;padding:8px;text-transform:uppercase}
			.head small{font-size:.85rem;display:block;padding:2px 8px;font-weight:inherit}
			.head p{font-size:.95rem;display:block;padding-bottom:4px;padding-top:3px}
			.head h5{font-size:1rem;padding-bottom:5px;padding-top:0}
			.lista{margin-bottom:1rem}
			.lista .thead th{padding:10px;font-size:18px;}
			.lista td{padding:0 4px;font-size:11px}
			.lista td p{padding:4px;font-size:11px}
			
			.footer{position:fixed;bottom:-28px;width:740px;left:26px;}
			.footer td b{padding:6px;display:block}
			.thead th{color:#111;padding:4px!importan;background:#ddd!important;border:0;font-size:11px!important}			
			
			.border-top{border-top:solid 1px #444!important}
			.border-bottom{border-bottom:solid 1px #444!important}
			.border-left{border-left:solid 1px #444!important}
			.border-right{border-right:solid 1px #444!important}
			.comentario-txt p {margin-bottom:1rem;page-break-inside: avoid}
			.cabecalho th{padding:5px 5px}
			
			.fotos img{width:100%;height:210px}
			.fotos td{padding:0rem;}
			.fotos .comentario{display:block;padding:10px;margin-bottom:8px;border:solid 1px #111;min-height:60px}
			.fotos .comentario h4,
			.fotos .comentario p{margin:0;padding:0;display:block}
			.fotos .comentario h4{padding-top:0px;font-size:14px;padding-bottom:4px;display:block}
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
					<th width="164" style="padding:8px"><img src="'.$logo.'" width="125"></th>
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
';



$body='
	<div class="corpo">
		<div class="lista">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
				<thead>
					<tr> 
						<th colspan="7" class="border-bottom" style="text-transform:uppercase;padding:15px 4px;font-size:16px">RELATORIO DE VENDA DE PRODUTOS PERIODO: 01/08/2022 00:00 A 22/08/2022 00:00</th>
					</tr>
					<tr class="thead"> 
						<th align="center" class="">ULT. VENDA</th> 
						<th align="left" class="">DESCRICAO / CÓD.ITEM / UND</th> 
						<th align="center" class="">QUANT.</th>  
						<th align="center" class="">TT. CUSTO</th>										  
						<th align="center" class="">TT. VENDA</th>
						<th align="center" class="">TT. LUCRO</th>
						<th align="center" class="">LUCRO%</th>
					</tr>
				</thead>
				
				<tbody class="tbody thead">					
					<tr> 			
						<td align="center" class="border-top"><p>09/08/2022</p></td>
						<td align="left" class="border-top"><p>COLA INSTANTANEA MAXX BOND 880 - 100 GR - (4) (TB)</p>	</td>
						<td align="center" class="border-top"><p>1,00</p></td>
						<td align="center" class="border-top"><p>0,00</p></td>				 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
					</tr>				
					<tr> 			
						<td align="center" class="border-top"><p>09/08/2022</p></td>
						<td align="left" class="border-top"><p>COLA INSTANTANEA MAXX BOND 880 - 100 GR - (4) (TB)</p>	</td>
						<td align="center" class="border-top"><p>1,00</p></td>
						<td align="center" class="border-top"><p>0,00</p></td>				 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
					</tr>				
					<tr> 			
						<td align="center" class="border-top"><p>09/08/2022</p></td>
						<td align="left" class="border-top"><p>COLA INSTANTANEA MAXX BOND 880 - 100 GR - (4) (TB)</p>	</td>
						<td align="center" class="border-top"><p>1,00</p></td>
						<td align="center" class="border-top"><p>0,00</p></td>				 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
					</tr>				
					<tr> 			
						<td align="center" class="border-top"><p>09/08/2022</p></td>
						<td align="left" class="border-top"><p>COLA INSTANTANEA MAXX BOND 880 - 100 GR - (4) (TB)</p>	</td>
						<td align="center" class="border-top"><p>1,00</p></td>
						<td align="center" class="border-top"><p>0,00</p></td>				 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
						<td align="center" class="border-top"><p>13,93 </p>	</td>					 
					</tr>			
					<tr>
						<td class="border-top" colspan="2"><p><b>TOTALIZAÇÃO DO RELATÓRIO</b>	</p></td>
						<td class="border-top" align="center" style="text-transform:uppercase;padding:8px 4px"><b>33,79</b></p></td>
						<td class="border-top" align="center" style="text-transform:uppercase;padding:8px 4px"><p><b>33,79</b></p></td>							 
						<td class="border-top" align="center" style="text-transform:uppercase;padding:8px 4px"><p><b>33,79</b></p></td>							 
						<td class="border-top" align="center" style="text-transform:uppercase;padding:8px 4px"><p><b>33,79</b></p></td>							 
						<td class="border-top" align="center" style="text-transform:uppercase;padding:8px 4px"><p><b>33,79</b></p></td>							 
					</tr>															
					
				</tbody>
			</table>
			
			
		</div>
	</div>

</body>
</html>
';

//concatenando as variáveis
$html = $style.$head.$footer.$body.$tab;

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