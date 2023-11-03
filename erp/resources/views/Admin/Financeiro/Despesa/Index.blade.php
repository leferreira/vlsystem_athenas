<?php
use App\Service\ConstanteService;
?>
@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
						<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de Despesas</span>
						<div>
							<a href="{{ route('admin.despesa.create')}}" class="btn btn-azul d-inline-block"><i class="fas fa-plus-circle"></i> Adicionar novo</a>
						</div>
					</div>
                        
					<form  action="{{route('admin.despesa.filtro')}}" method="GET">
                        <div class="px-2 pt-2">	
							  <div class="mostraFiltro bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
							    		@php
                                        	$id_fornecedor 	= $filtro->fornecedor_id ?? '';
                                        	$id_status 		= $filtro->status_id ?? '';
                                        	$id_tipo_despesa= $filtro->tipo_despesa_id ?? '';
                                        @endphp
                                        
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Vencimento 01 </label>
                                                <input type="date" name="venc01" value="{{$filtro->venc01 ?? ''}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                                <label class="text-label d-block text-branco">Vencimento 02 </label>
                                                <input type="date" name="venc02" value="{{$filtro->venc02 ?? ''}}" class="form-campo">
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
                                             <label class="text-label d-block text-branco">Tipo Despesa </label>
                                            <select name="tipo_despesa_id" class="form-campo">
                                                <option value="">Selecione</option>  
                                               @foreach($tipos as $t) 
                                                	<option value="{{$t->id}}" {{$id_tipo_despesa==$t->id ? 'selected' : ''}}>{{$t->nome}}</option>  
                                               @endforeach                                                  
                                            </select>
                                        </div>
                                        
                                        <div class="col-4">	
                                             <label class="text-label d-block text-branco">Fornecedor </label>
                                            <select name="fornecedor_id" class="form-campo">
                                                <option value="">Selecione</option>  
                                               @foreach($fornecedores as $f) 
                                                	<option value="{{$f->id}}" {{$id_fornecedor==$f->id ? 'selected' : ''}}>{{$f->razao_social}}</option>  
                                               @endforeach                                                  
                                            </select>
                                        </div>
                                        
                                        <div class="col-4">	
                                             <label class="text-label d-block text-branco">Status </label>
                                            <select name="status_id" class="form-campo">
                                                <option value="">Selecione</option>  
                                               @foreach(config('constantes.status') as $c=>$v) 
                                                	<option value="{{$v}}" {{$id_status==$c ? 'selected' : ''}}>{{$c}}</option>  
                                               @endforeach                                                  
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

		
		<div class="col-12">
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
                                       <th align="center">Vencimento</th>
                                       <th align="center">Valor total</th>
                                       <th align="center">Status</th>
                                       <th align="center">Status Financeiro</th>
                                       <th align="center">Opções</th>
                                    </tr>
                            </thead>                             
								
							<tbody>
							@foreach($lista as $lancamento)  
                                    <tr>
                                       <td align="center">{{ $lancamento->id }}</td>
                                       <td align="left">{{ $lancamento->descricao }} <small class="d-block text-azul">{{ $lancamento->fornecedor->razao_social }} <b class="qtd">{{ $lancamento->num_parcela }} / {{ $lancamento->ult_parcela }} </b></small></td>
                                       <td align="center">{{ databr($lancamento->data_emissao) }}</td>                                       
                                       <td align="center">{{ databr($lancamento->data_vencimento) }}</td>
                                       <td align="center">{{ formataNumeroBr($lancamento->valor_despesa) }}</td>
                                       <td align="center"><span class="{{ strtolower($lancamento->status->status) }}">{{ $lancamento->status->status }}</span></td>
                                       <td align="center"><span class="{{ strtolower($lancamento->status_financeiro->status) }}">{{ $lancamento->status_financeiro->status }}</span></td>
                                       <td align="center">
											<a href="{{route('admin.despesa.confirmarPagamento', $lancamento->id)}}" class="btn btn-roxo d-inline-block"><i class="fas fa-eye" title="Confirmar Pagamento"></i></a>
											<a href="{{route('admin.despesa.edit', $lancamento->id)}}" class="btn btn-verde d-inline-block"><i class="fas fa-edit" title="Editar"></i></a>
											<a href="javascript:;" onclick="excluir({{ $lancamento->id }})" class="btn btn-vermelho d-inline-block"><i class="fas fa-trash" title="Excluir"></i></a>
									   </td>
                                    </tr>
                                 @endforeach
                              
                             
                            </tbody>
                    </table>								
                 </div>

            </div>
        </div>

        </div>
        </div>
<script>
	function pesquisar(mes){
		var ano = $("#ano").val();
		window.location.href=base_url + "admin/despesa/pormes/?ano=" + ano + "&mes=" + mes;
	}
	
	function excluir(id){
    if (confirm('Tem Certeza?')){
    	$.ajax({
         url: base_url + "admin/despesa/" + id,
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