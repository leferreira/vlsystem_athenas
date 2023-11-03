@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Meus Planos </span></span>
				<div>
					<a href="{{route('admin.meus_planos.assinar')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Ver os Planos Disponíveis</a>
					<a href="" class="btn btn-laranja filtro mx-1 d-inline-block"><i class="fas fa-filter"></i> Filtrar</a>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form name="busca" action="" method="GET">
					<div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Fornecedor</span>
									<input type="text" name="fornecedor" value="" placeholder="Digite aqui..." class="form-campo">
							</div>
							<div class="col-4">
									<span class="text-label text-branco">Categoria</span>
									<select class="form-campo" name="idCategoria">
									<option value="">Escolha uma Opção</option>
									<option value="1">Panela</option><option value="2">Cuzcuzeira</option><option value="3">Copo</option><option value="4">Caneca</option><option value="5">Papeiro</option><option value="6">Leiteira</option><option value="7">Frigideira</option><option value="8">Bacia</option><option value="9">Balde</option><option value="10">Assadeira</option><option value="11">Baquelite</option><option value="12">yyy</option>                                         </select>
							</div>
							 <div class="col-2 pt-1 mt-1">
								  <input type="submit" value="Pesquisar" class="btn btn-azul width-100 text-uppercase">
							  </div>
						</div>								 
                    </div>								 
                     </form>
				</div>
            </div>		
    <div class="col-12">
        <div class="px-2 pb-4">
            <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                    <thead>
                            <tr>
                                    <th align="center">Id</th>
                                    <th align="left" >Plano</th>
                                    <th align="center">Código</th>
                                    <th align="center">Forma Pagto</th>
                                    <th align="center">Data Pagamento</th>
                                    <th align="center">Expira em</th>
                                    <th align="center">Valor</th>
                                    <th align="center">Status</th>
                                    <th align="center">pagar</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->plano->nome}}</td>
							<td align="center">{{$l->cnpj}}</td>
							<td align="center">{{$l->forma_pagto->forma_pagto}}</td>
							<td align="center">{{$l->celular}}</td>
							<td align="center">{{ databr($l->data_vencimento)}}</td>
							<td align="center">{{$l->valor_recorrente}}</td>
							<td align="center">{{$l->status->status}}</td>
							<td align="center"><a href="{{route('admin.meus_planos.pagamento', $l->id)}}" class="btn btn-outline-roxo">Pagar</a></td>										
                           
					@endforeach
					</tbody>
			</table>   
	</div>
								
								<!-- qunado não hover pedido 
								
								<div class="caixa p-2">
									<div class="msg msg-verde">
									<p><b><i class="fas fa-check"></i> Mensagem de boas vindas</b> Parabéns seu fornecedor foi inserido com sucesso</p>
									</div>
									<div class="msg msg-vermelho">
									<p><b><i class="fas fa-times"></i> Mensagem de Erro</b> Houve um erro</p>
									</div>
									<div class="msg msg-amarelo">
									<p><b><i class="fas fa-exclamation-triangle"></i> Mensagem de aviso</b> Tem um aviso pra você</p>
									</div>
								</div>
								-->
							</div>
							
	</div>
</div>
@endsection