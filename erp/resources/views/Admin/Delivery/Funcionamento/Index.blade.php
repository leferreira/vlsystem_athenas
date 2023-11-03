@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de funcionamentodelivery </span>
						<div>
							<a href="{{route('admin.funcionamentodelivery.create')}}" class="btn btn-verde mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Adicionar novo</a>
						</div>
					</div>
                        
					<form  action="{{route('admin.funcionamentodelivery.store')}}" method="POST"> 
					@csrf                      
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
							  			<div class="col-3">	
                                             <label class="text-label d-block text-branco">Dia da Semana </label>
                                             @if(!isset($funcionamento))
                                                <select id="dia" name="dia" class="form-campo">
                                                	@foreach($dias as $d)
                                                    	<option value="{{$d}}">{{$d}}</option>                                                 
                                                    @endforeach                                                
                                                </select>
                                              @else
                    							<input type="text" class="form-control" name="dia" value="{{$funcionamento->dia}}" disabled="">
                    						@endif
                                        </div>
                                        <div class="col-2">	
                                                <label class="text-label d-block text-branco">Inicio </label>
                                                <input type="text" id="inicio" name="inicio" value="{{{ isset($funcionamento->inicio_expediente) ? $funcionamento->inicio_expediente : '18:00' }}}"class="form-campo">
                                        </div>
                                        <div class="col-2">	
                                                <label class="text-label d-block text-branco">Fim </label>
                                                <input type="text" id="fim" name="fim" value="{{{ isset($funcionamento->fim_expediente) ? $funcionamento->fim_expediente : '23:59' }}}" class="form-campo">
                                        </div>
                                        
                                        <div class="col-2 mt-1 pt-1">
                                                <input type="submit" value="Inserir" class="btn btn-roxo text-uppercase">
                                        </div>
                                </div>
                                </div>
                        </div>
                    </form>
                </div>
                </div>

		<div class="col-12">
            <div class="px-2">
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                    <tr>
                                       
                                       <th align="center">Id</th>
                                       <th align="left" >Dia</th>
                                       <th align="left" >Início</th>
                                       <th align="left" >Fim</th>
                                       <th align="center">Status</th>
                                       <th align="center">Editar</th>
                                       <th align="center">Excluir</th>
                                    </tr>
                            </thead>
                            <tbody> 
                          @foreach($lista as $l)                                     
                             <tr>
								<td align="center">{{$l->id}}</td>
								<td align="center">{{$l->dia}}</td>
                                <td align="left">{{$l->inicio_expediente}}</td>
							    <td align="left">{{$l->fim_expediente}}</td>
							    <td align="left">
							    	@if($l->ativo)
    									<span class="label label-xl label-inline label-light-success">ATIVO</span>
    								@else
    									<span class="label label-xl label-inline label-light-danger">DESATIVADO</span>
    								@endif
								</td>
							     											
                                <td align="center"><a href="{{route('admin.funcionamentodelivery.edit', $l->id)}}" class="d-inline-block btn btn-outline-roxo btn-pequeno"><i class="fas fa-edit"></i> Editar</a>                              </td>									
                                <td align="center">
                                <a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$l->id}}').submit() : '';" class="d-inline-block btn btn-outline-vermelho btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.funcionamentodelivery.destroy', $l->id)}}" method="POST" id="apagar{{$l->id}}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{csrf_field()}}
                                    </form>
                                 </td>
                             </tr>                                       
                         @endforeach 
                                            						
                        </tbody>
                                </table>
								
                        </div>

                        </div>

                   
                    <!--
                        <div class="caixa p-2">
                                <div class="msg msg-verde">
                                <p><b><i class="fas fa-check"></i> Mensagem de boas vindas</b> Parabéns seu produto foi inserido com sucesso</p>
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