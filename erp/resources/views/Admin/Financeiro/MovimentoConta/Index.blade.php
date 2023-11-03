<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h5 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Movimento de Conta </span>
						<div>
							<a href="{{ route('admin.movimentoconta.create')}}" class="btn btn-azul d-inline-block" title="Adicionar novo"><i class="fas fa-plus-circle"></i> </a>
						</div>
					</div>
                        
					<form action="" method="GET">
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Compensação 01 </label>
                                                <input type="date" name="compensacao01" value="{{$filtro->compensacao01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Compensação 02 </label>
                                                <input type="date" name="compensacao012 value="{{$filtro->compensacao02 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Emissão 01 </label>
                                                <input type="date" name="emissao01" value="{{$filtro->emissao01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Emissão 02 </label>
                                                <input type="date" name="emissao02" value="{{$filtro->emissao02 ?? ''}}" class="form-campo">
                                        </div>
                                     
                                        <div class="col-4">	
                                             <label class="text-label d-block text-branco">Conta Corrente </label>
                                            <select name="conta_id" class="form-campo">
                                                <option value="">Selecione</option>  
                                               @foreach($contas as $c) 
                                                	<option value="{{$c->id}}" {{$filtro->conta_id==$c->id ? 'selected' : ''}}>{{$c->descricao}}</option>  
                                               @endforeach                                                  
                                            </select>
                                        </div>
                                        
                                        <div class="col-4">	
                                             <label class="text-label d-block text-branco">Classificação Financeira </label>
                                            <select name="classificacao_id" class="form-campo">
                                                <option value="">Selecione</option>  
                                               @foreach($classificacoes as $cl) 
                                                	<option value="{{$cl->id}}" {{$filtro->classificacao_id==$cl->id ? 'selected' : ''}}>{{$cl->id}} - {{$cl->descricao}}</option>  
                                               @endforeach                                                  
                                            </select>
                                        </div>
                                        
                                        
                                        <div class="col-2">	
                                             <label class="text-label d-block text-branco">Tipo </label>
                                            <select name="tipo" class="form-campo">
                                                <option value="">Selecione</option>  
                                                <option value="C" {{$filtro->tipo =='C' ? 'selected' : ''}}>Crédito</option>  
                                                <option value="D" {{$filtro->tipo =='D' ? 'selected' : ''}}>Débito</option>                                                 
                                            </select>
                                        </div>
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Pesquisar" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
                </div>

		
		<div class="col">
			<div class="px-2">			
				<div class="p-1">
					<?php //$this->verMsg(); ?>
				</div>
               <div class="tabela-responsiva pb-4 mt-3">
                    <table cellpadding="0" cellspacing="0"  width="100%" id="dataTable">
                            <thead>
                                    <tr>
                                       <th align="center">Id</th>
                                       <th class="text-left">Lançamento</th>
                                       <th align="center">Data Emissão</th>
                                       <th align="center">Data Compensação</th>
                                       <th align="center">Conta</th>
                                       <th align="center">Classificação Financeira</th>
                                       <th align="center">Valor</th>
                                       <th align="center">Tipo Movimento</th>
                                       <th align="center">Origem</th>
                                    </tr>
                            </thead>
                           
							<tbody>
							 	@foreach($lista as $lancamento) 
                                    <tr>
                                       <td align="center">{{ $lancamento->id }}</td>
                                       <td align="left"> <small class="d-block text-azul">{{ $lancamento->historico }}</small></td>
                                       <td align="center">{{ databr($lancamento->data_emissao) }}</td>
                                       <td align="center">{{ databr($lancamento->data_compensacao) }}</td>
                                       <td align="center">{{ $lancamento->conta->descricao }}</td>
                                       <td align="center">{{ $lancamento->classificacaoFinanceira->descricao ?? null }}</td>
                                       <td align="center">{{ $lancamento->valor }}</td>
                                       <td align="center"><i class="{{($lancamento->tipo_movimento=='C') ? 'ientrada' : 'isaida'}}"></i>{{ $lancamento->tipo_movimento }}</td>	
                                       <td align="center">{{ $lancamento->origem }}</td>						
                                    </tr>                                      
								@endforeach
                                  
                                  
                            </tbody>
                    </table>								
                 </div>

            </div>
        </div>

		<!-- MOSTRA AS OPÇÕES  MostraOpcoes --->
		<div class="col-2 MostraOpcoes sm-mx" id="opcoes_receber">
		
			<ul class="cx-opcoes" >
				<li class="titulo bg-padrao text-branco d-flex center-middle justify-content-space-between">
					<span>Opções: <span id="id_receber"></span> </span> 
					<a href="javascript:;" onClick="fechar_opcoes_receber()" title="Fechar Opções" class="text-vermelho position-inherit p-0"><i class="fas fa-times position-inherit"></i></a>
				</li>
				<li><a href="javascript:;" onclick="verEdicao()" class="" title="Editar "><i class="fas fa-edit"></i> Editar</a></li>
				<li><a href="javascript:;" onClick="confirmarPagamento()" title="Confirmar Pagamento"><i class="fas fa-eye"></i> Confirmar Pagamento</a></li>
				<li><a href="javascript:;" onclick="verDetalhe()" class="" title="Detalhes "><i class="fas fa-edit"></i> Detalhes</a></li>
				
				<li><a href="javascript:;" onClick="abrirDuplicata()" title="Gerar Nota Fiscal"><i class="fas fa-eye"></i> Imprimir Duplicata</a></li>
				<li><a href="javascript:;" onclick="excluir()"><i class="fas fa-trash-alt"></i> Excluir</a></li>
	
			</ul>
		</div>
		
        </div>
        </div>
<script>
var receber_id = 0;
function pesquisar(mes){
	var ano = $("#ano").val();
	window.location.href=base_url + "admin/movimentoconta/pormes/?ano=" + ano + "&mes=" + mes;
}
function abrir_opcoes_receber(id){
	receber_id = id;
	$("#id_receber").html(id);
	mostrar_opcoes('opcoes_receber')
}

function fechar_opcoes_receber(){
	esconder_opcoes('opcoes_receber');
}

function confirmarPagamento(){
	giraGira();
	location.href = base_url + "admin/movimentoconta/confirmarPagamento/" + receber_id;	
}

function verDetalhe(){
	giraGira();
	location.href = base_url + "admin/movimentoconta/detalhe/" + receber_id;	
}

function verEdicao(){
	giraGira();
	location.href = base_url + "admin/movimentoconta/" + receber_id + "/edit";	
}

function abrirDuplicata(){
	window.location.href=base_url + "admin/movimentoconta/duplicata";
}

function excluir(){
    if (confirm('Tem Certeza?')){
    	$.ajax({
         url: base_url + "admin/movimentoconta/" + receber_id,
         type: "DELETE",
         dataType:"Json",
         data:{},
         success: function(data){
			  fecharGiraGira(0);
			  location.reload();
        	
         },
         beforeSend: function(){           
            giraGira(); 
        }
         
     });
    }	
}
</script>
@endsection