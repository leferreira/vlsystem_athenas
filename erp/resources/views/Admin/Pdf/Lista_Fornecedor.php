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
			#head{position:fixed;width:740px;left:26px;right:4px;top:-123px;}
			.head h1{font-size:18px;display:block;padding:8px;text-transform:uppercase}
			.head small{font-size:.85rem;display:block;padding:2px 8px;font-weight:inherit}
			.head p{font-size:.95rem;display:block;padding-bottom:4px;padding-top:3px}
			.head h5{font-size:1rem;padding-bottom:5px;padding-top:0}
			.lista{margin-bottom:1rem}
			.lista .thead th{padding:4px;font-size:18px;}
			.lista td{padding:0;font-size:9px}
			.lista td p{padding:4px;font-size:11px}
			.footer{position:fixed;bottom:-28px;width:740px;left:26px;}
			.footer td b{padding:6px;display:block}
			.thead th{color:#111;padding:4px!importan;background:#ddd!important;border:0;font-size:11px!important}
			.
    
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
		</style>
	</head>';
$head='
<body>
<div id="head" class="head">
		<table border="1" cellpadding="0" cellspacing="0" width="100%" class="border">
			<thead>
				<tr>
					<th width="164" height="70" style="padding:10px"><img src="'.$logo.'" height="70"></th>
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
								<th align="left"  style="padding-bottom:4px">
									<small class="d-block" >Tel: (98)3304-4200</small>
								</th>
							</tr>
						</table>
					</th>
				</tr>
			</thead>
			</table>
					    
		</div>
';


$footer='
	<!--O Rodape fica nesta posição aqui mesmo-->
		<div class="footer">
            <table cellpadding="0" cellspacing="0" border="0" class="border">
					<td>
						<table cellpadding="0" cellspacing="0" class="" width="100%">
    
							<thead>
								<tr class="tbody" style="vertical-align:top">
									<td align="center"><b>Quantidade de Itens: '.count($lista).'</b> </td>
									
								</tr>
							</thead>
						</table>
					</td>
				</table>
        </div>
';


$body='
	<div class="corpo">
		<div class="lista">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
				<thead>
					<tr>
						<th colspan="6" class="border-bottom" style="text-transform:uppercase;padding:8px 4px;font-size:16px">Listagem de Fornecedor: '.date('d/m/Y').'</th>
					</tr>
					<tr class="thead">
						<th align="center" class="border-left">ID</th>
						<th align="center" class="border-left">CPF/CNPJ</th>
						<th align="center" class="border-left">Nome</th>
						<th align="center" class="border-left">Email</th>
						<th align="center" class="border-left">Fone</th>
						<th align="center" class="border-left">Cidade</th>
					</tr>
				</thead>
    
				<tbody class="tbody">';
                $tab='';
                foreach($lista as $p){ 
					$tab .='<tr>
						<td align="center" class="border-left border-top"><p>'.$p->id.'</p></td>
						<td align="center" class="border-left border-top"><p>'.$p->cnpj.'</p>	</td>
						<td align="center" class="border-left border-top"><p>'.$p->razao_social.'</p></td>
						<td align="center" class="border-left border-top"><p>'.$p->email.'</p></td>
						<td align="center" class="border-left border-top"><p>'.$p->telefone.'</p>	</td>
						<td align="center" class="border-left border-top"><p>'.$p->cidade.'</p>	</td>
					</tr>';
                }
    
				$tab .='</tbody>
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