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
										'. date("d/m/Y").'<br>
										'.agora().'
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
						<th colspan="9" class="border-bottom" style="text-transform:uppercase;padding:15px 4px;font-size:16px">RELATÓRIO DE CONTAS A PAGAR <br> <small>Período: '.databr($filtro->data1).' a '.databr($filtro->data2).'</small></th>
					</tr>
				</thead>
			</table>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
				<thead>
					<tr class="thead"> 
						<th align="left" class="border-bottom">Cód</th> 
						<th align="center" class="border-bottom">Descrição</th> 
                        <th align="center" class="border-bottom">Data Emissão</th> 
                        <th align="center" class="border-bottom">Data Vencimento</th> 	
                        <th align="center" class="border-bottom">Data Pagamento</th> 														  
						<th align="center" class="border-bottom">Forma Pagto.</th>
                        <th align="center" class="border-bottom">Status</th>
                        <th align="center" class="border-bottom">Valor</th>	
					</tr>
				</thead>
				
				<tbody class="tbody thead">';
                    $tab = ""; 
                    $soma = 0;
                    foreach($lista as $l){
                        $data_vencimento = ($l->recebimento) ? databr($l->recebimento->data_vencimento) : "--";
                        $acrescimo = $l->valor_frete + $l->despesas_outras + $l->total_seguro;
                        $soma += $l->valor;
    					$tab.='<tr style="text-transform:uppercase">
    						<td class="border-bottom" align="left">'.$l->id.'</td>
                            <td class="border-bottom" align="left">'.$l->descricao.'</td>
    						<td class="border-bottom" align="center">'.databr($l->data_emissao).'</td>
                            <td class="border-bottom" align="center">'.databr($l->data_vencimento).'</td>
                            <td class="border-bottom" align="center">'.$data_vencimento.'</td>
                            <td class="border-bottom" align="center"><p>'.$l->forma_pagto->forma_pagto.'</p></td>
                            <td class="border-bottom" align="center"><p>'.$l->status->status.'</p></td>
    						<td class="border-bottom" align="center"><p>'.formataNumeroBr($l->valor).'</p>	</td>	
    							
    					</tr>';
                    }
					$tab.='<tr style="text-transform:uppercase">
						<td class="border-bottom" align="right" colspan="7"><p><b>TOTAIS</b></p></td>
						<td class="border-bottom" align="center"><p><b>'.formataNumeroBr($soma).'	</b></p></td>	
					</tr>
					
				</tbody>
			</table>	
			
			
		</div>
	</div>

</body>
</html>
';

//concatenando as variáveis
$html = $style.$head.$body. $tab;

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