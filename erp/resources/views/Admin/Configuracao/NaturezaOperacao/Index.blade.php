<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
            <div class="col-12">
           <div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
				<span class="d-flex center-middle  h5 mb-0"><i class="far fa-list-alt mr-1"></i> Lista de Natureza da Operação </span></span>
				<div>
					<a href="{{route('admin.naturezaoperacao.create')}}" class="btn btn-azul ml-1 d-inline-block" title=" Adicionar novo"><i class="fas fa-plus-circle"></i></a>
				</div>
			</div>
                     
				<div class="px-2 pt-2"> 
					<form name="busca" action="" method="GET">
					<div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
						 <div class="rows p-3">	
							<div class="col-6">
									<span class="text-label text-branco">Cliente</span>
									<input type="text" name="cliente" value="" placeholder="Digite aqui..." class="form-campo">
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
                                <th align="left" >Descrição</th>
                                <th align="center">Padrão</th>
                                <th align="center">Editar</th>
                                <th align="center">Tributações</th>
                        </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $l)
                  
						<tr>
							<td align="center">{{$l->id}}</td>
							<td align="left">{{$l->descricao}}</td>
							<td align="center">{{ConstanteService::getPadraoNatureza($l->padrao)}}</td>
							<td align="center"><a href="{{route('admin.naturezaoperacao.edit', $l->id)}}" class="btn btn-outline-roxo">Editar</a></td>							
							<td align="center"><a href="{{route('admin.naturezaoperacao.tributacao', $l->id)}}" class="btn btn-outline-roxo">Tributações</a></td>
						 </tr>
					@endforeach
					</tbody>
			</table>   
	</div>
								
								<!-- qunado não hover pedido 
								
								<div class="caixa p-2">
									<div class="msg msg-verde">
									<p><b><i class="fas fa-check"></i> Mensagem de boas vindas</b> Parabéns seu cliente foi inserido com sucesso</p>
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