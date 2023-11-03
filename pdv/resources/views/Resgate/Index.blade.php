@extends("template")
@section("conteudo")
<div class="conteudo">
	<div class="caixa">
		<div class="rows">	
			<div class="col-12">
					<div class="caixa-titulo py-1 d-flex width-100 justify-content-space-between center-middle">
						<span class="h5  pt-1 mb-0 d-inline-block"><i class="far fa-list-alt"></i> Resgatar Venda</span>
						<a href="{{route('pdv.livre')}}" class="btn btn-pequeno btn-azul"><i class="fas fa-arrow-left"></i> Voltar</a>
					</div>
				
					 
					<div class="pt-2 px-5 pb-5 width-100 d-inline-block">
					<form action="{{route('suplemento.store')}}" method="POST">
					@csrf
					<div class="border">
					<span class="d-block p-2 h4 border-bottom">Resgate</span>
                         <div class="rows px-4">
                                  
                                <div class="col-4">
                                        <label class="text-label">Plataforma</label>
                                        <select class="form-campo" name="plataforma" id="plataforma">
                                        	<option value="">Selecione uma Opção</option>
                                        	<option value="balcao">Venda Balcão</option>
                                        	<option value="loja">Loja Virtual</option>
                                        	<option value="orcamento">Orçamento</option>
                                        	<option value="os">Ordem de Serviço</option>
                                        	<option value="venda">Venda</option>
                                        	<option value="pedido">Pedido - Plataforma Cliente</option>
                                        </select>
                                </div>
                                <div class="col-3">
                                        <label class="text-label">Código</label>
                                        <input type="text" name="codigo" id="codigo"  class="form-campo">
                                </div>
                                <div class="col-2 mt-4  pb-5">
                                	<a href="javascript:;" onclick="buscar()" class="btn btn-verde btn-medio d-block width-100">Buscar</a>           
                                </div> 
                                <div class="col-3 mt-4  pb-5">
                                	<a href="javascript:;" onclick="resgatar()" class="btn btn-verde btn-medio d-block width-100">Enviar para o Caixa</a>           
                                </div>                                												
       					</div>
				
				</div>
				</form>
				</div>
				
				
			</div>
				
			<div class="col-12 px-0">
			Data: <span id="data"></span> |  Total:<span id="total"></span> 
				<div class="px-5 pb-5 width-100 d-inline-block">
					<div class="tabela-responsiva">					
						<table cellpadding="0" cellspacing="0" >
                            <thead>
                                <tr>
                                    <th align="left">Id</th>
                                    <th align="left" >Produto</th>
                                    <th align="left" >Qtde</th>
                                    <th align="left" >Valor</th>
                                    <th align="left" >Subtotal</th>
                                    
                                </tr>
                            </thead>
                            <tbody id="listaVendasParaResgate"></tbody>
						</table>
					</div>
					</div>
			</div>
				
	</div>
	</div>
	</div>
<script>
function resgatar(){
	var codigo 				= $("#codigo").val();
	var plataforma			= $("#plataforma").val();	

	$.ajax({
		type: 'POST',
		data: {
			id				: codigo,
			plataforma		: plataforma
		},
		url: base_url + 'resgate/enviarParaCaixa',
		dataType: 'json',
		beforeSend: function (){
	   },
		success: function (e) {
			if(e.tem_erro==true){
				alert('Não foi encontrado');
				$("#data").html("");
				$("#total").html("");
				listaItens("");
			}else{
			console.log(e);
				location.href = base_url + "pdv/pagamento/" + e.retorno.id;
			}
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}

function buscar(){
	var codigo 				= $("#codigo").val();
	var plataforma			= $("#plataforma").val();	

	$.ajax({
		type: 'POST',
		data: {
			codigo				: codigo,
			plataforma			: plataforma
		},
		url: base_url + 'resgate/resgatar',
		dataType: 'json',
		beforeSend: function (){
	   },
		success: function (e) {
			if(e.tem_erro==true){
				alert('Não foi encontrado');
				$("#data").html("");
				$("#total").html("");
				listaItens("");
			}else{
				$("#data").html(e.retorno.cabecalho.data);
				$("#total").html(e.retorno.cabecalho.total);
				listaItens(e.retorno.produtos);
			}
		}, error: function (e) {
			var response = JSON.parse(e.responseText);
			fecharModal();
			alert(response.errors);	
		}
	});
}

function listaItens(itens) {
	html = '<tr>';
	for(var i in itens){	
		html += "<tr class='datatable-row' style='left: 0px;'>";
		html += "<td class='datatable-cell cod'><span class='codigo' style='width: 60px;'>" + itens[i].produto_id + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + itens[i].produto + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 100px;'>" + converteFloatMoeda(itens[i].qtde) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].valor) + "</span></td>";
		html += "<td class='datatable-cell'><span class='' style='width: 80px;'>" + converteFloatMoeda(itens[i].subtotal) + "</span></td>";
		html += "</tr>";
	}	
	$("#listaVendasParaResgate").html(html);
}
</script>
@endsection