@extends("Admin.template")
@section("conteudo")
<div class="central mb-3">
<div class="rows mt-4">
<div class="col-9 m-auto pb-4">
	<table cellspacing="0" cellpadding="0" border="0" class="border" width="100%" style="border-radius:10px">
		<tr>
			<td style="padding:10px" width="170" align="center" class="border-bottom"><img src="{{asset('assets/admin/img/logo-login.png')}}" width="140"></td>
			<td align="left" class="border-left p-1 border-bottom">
				<h3 style="text-transform:uppercase padding-bottom:10px;font-size:20px;display:block">Manoel Jailton sousa varejista</h3>
				<p style="padding-bottom:5px;font-size:.88rem">Rua 04 - cohama</p>
				<p style="padding-bottom:5px;font-size:.88rem">São luis MA</p>
				<p style="padding-bottom:5px;font-size:.88rem">CEP: 6503000-00 - FONE: 6503000-00 </p>
				<p style="padding-bottom:5px;font-size:.88rem">CNPJ:10.676.987/0001-12 Email:mjailton@gmail.com </p>
			</td>
			<td class="border-left border-bottom" align="center">
				<h4 style="font-size:20px">Duplicata</h4>
				-<br>
				Data emissão: <br>26/04/2022
				
			</td>
		</tr>
		<tr>
			<td colspan="3" style="vertical-align:top">
				<table cellspacing="0" cellpadding="0" border="0" class="" width="100%" style="">
					<tr>
						<td height="400" width="170" class="border-right">
							<span class="underline">Assinatura do Emitente</span>
						</td>
						<td class="">							
							<table cellspacing="0" cellpadding="0" border="0" class="border" width="100%" style="">
								<tr>
									<td>
										<table cellspacing="0" cellpadding="0" border="0" class="table-bordered" width="100%" style="">
											<tr>
												<th align="center" colspan="2" class="border-bottom border-right">Fatura</th>
												<th align="center" class="border-bottom  border-right" colspan="2">Duplicata</th>
												<th align="center" class="border-bottom" rowspan="2">Vencimento </th>
											</tr>
											<tr>
												<th align="center" class="border-left border-bottom">Valor-R$</th>
												<th align="center" class="border-left border-bottom border-right">Número</th>
												<th align="center" class="border-left border-bottom">Valor-R$</th>
												<th align="center" class="border-left border-bottom border-right">Número</th>
											</tr>
											
											
											<tr>
												<td align="center" class="border-left border-bottom">100,00</td>
												<td align="center" class="border-left border-bottom border-right">3</td>
												<td align="center" class="border-left border-bottom"><b>100,00</b></td>
												<td align="center" class="border-left border-bottom border-right">00003</td>
												<td align="center" class="border-left border-bottom border-right">20/04/2022</td>
											</tr>
											
											<tr>
												<td align="left" colspan="5" class="border-0">
													Desconto de ate <b>50%</b>
												</td>
											</tr>
											<tr>
												<td align="left" colspan="5" class="border-0">
													Condições especiais <b>50%</b>
												</td>
											</tr>
										</table>
									</td>
									<td class="border-left p-1" align="center" width="196">
										<small>Para uso da instituição financeira</small>
									</td>
								</tr>
								
								<tr>
									<td colspan="2">
										<table cellspacing="0" cellpadding="0" border="0" class="border-top" width="100%" style="">
											<tr>
												<th align="right" class="p-1" width="300">Nome do sacado ------------------- </th>
												<td>Manoel jailton sousa</td>
											</tr>
											<tr>
												<th align="right" class="p-1">Endereço do sacado ------------------- </th>
												<td>Rua josé patrocinio, 09 cohama</td>
											</tr>
											<tr>
												<th align="right" class="p-1">Parça de pagamento  ------------------- </th>
												<td colspan="2">
													<select>
														<option>Selecionar</option>
														<option>Selecionar</option>
														<option>Selecionar</option>
													</select>
												</td>
											</tr>
											<tr>
												<th align="right" class="p-1">Município ------------------- </th>
												<td>
													São Luís 
												</td>
												<th>UF --- </th>
												<td>
													MA
												</td>
												<th>CEP --- </th>
												<td>
													65074410
												</td>
											</tr>
											<tr>
												<th align="right" class="p-1">CNPJ ------------------- </th>
												<td>
													10.003.123/00001-10
												</td>
												<th>IE --- </th>
												<td>
													
												</td>
											</tr>
											
										</table>
									</td>
								</tr>
								
								<tr>
									<table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<th align="center" class="p-2 border-right" style="background:#eee" width="130">Valor por extenso</th>
											<td align="left" class="p-2">
												Cem reais
											</td>
										</tr>
										<tr>
											<td align="left" class="p-3 py-4 border-top" colspan="2">
												Reconheço(emos) a exatidão desta <b>duplicata de venda mercantil</b>, na importância acima que pagarei(emos) à <b>manoel jailton sousa</b>, ou à sua ordem, na praça e vencimento indicados.
											</td>
										</tr>
										<tr>
											<td align="left" class="p-3 border-top" colspan="2">
												<table cellpadding="0" cellspacing="0" width="100%">
													<tr>
														<td align="center">
														<div class="p-1" style="border-color:#111!important">
														Em ____/____/______ <br><span class="d-block pt-1"> Dados do aceite</span>
														</div>
														</td>
														<td width="200">&nbsp;</td>
														<td align="center" width="200">
														<div class="p-1" style="border-color:#111!important">
														____________________________________<br> <span class="d-block pt-1">Assinatura do sacado</span>
														</div>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</tr>
								
							</table>
						</td>
					</tr>				
				</table>
			</td>
		</tr>
		
	</table>
 
 
</div>
</div>
</div>

@endsection