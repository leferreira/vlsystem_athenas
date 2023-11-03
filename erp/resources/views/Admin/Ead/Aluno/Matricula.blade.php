@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase h4 mb-0 text-branco d-flex justify-content-space-between">
						<span class="d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Matrícula do Aluno: {{$aluno->nome}}   </span>
						
					</div>
                        
					 @if(isset($funcao))    
                       <form action="{{route('ead.matricula.update', $matricula->id)}}" method="POST" >
                       <input name="_method" type="hidden" value="PUT"/>
                     @else                       
                    	<form action="{{route('ead.matricula.store')}}" method="Post" >
                    @endif
                    	@csrf
                        
                        <div class="px-2 pt-2">	
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-6">	
                                                <label class="text-label d-block text-branco">Curso </label>
                                                <select name="curso_id" class="form-campo">
                                                @foreach($cursos as $c)
                                                	<option value="{{$c->id}}">{{$c->curso}}</option>
                                                @endforeach
                                                </select>
                                        </div>
                                        <div class="col-2">	
                                                <label class="text-label d-block text-branco">Data Matrícula </label>
												<input type="date" name="data_matricula" value="{{ hoje() }}" class="form-campo">
                                        </div> 
                                        <div class="col-2">	
                                                <label class="text-label d-block text-branco">Hora Matrícula </label>
												<input type="time" name="hora_matricula" value="{{ date('H:i:s') }}" class="form-campo">
                                        </div>                                      
                                        
                                        <div class="col-2 mt-1 pt-1">
                                        		<input type="hidden" name="aluno_id" value="{{isset($aluno->id) ? $aluno->id: NULL }}">
                                                <input type="submit" value="Salvar" class="btn btn-roxo text-uppercase">
                                        </div>
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
                                    <th align="left" >Curso</th>
                                    <th align="center">Data</th>
                                    <th align="left" >hora</th>
                                    <th align="center">Editar</th>
                                    <th align="center">Excluir</th>
                            </tr>
                    </thead>
                    <tbody>	
                    @foreach($lista as $funcao)
						<tr>
							<td align="center">{{$funcao->id}}</td>
							<td align="left">{{$funcao->curso->curso}}</td>
							<td align="center">{{databr($funcao->data_matricula)}}</td>
							<td align="center">{{$funcao->hora_matricula}}</td>
							
							<td align="center"><a href="{{route('admin.funcao.edit', $funcao->id)}}" class="btn btn-outline-roxo">Editar</a></td>
							 <td align="center">
							<a href="#" onclick="confirm('Tem Certeza?') ? document.getElementById('apagar{{$funcao->id}}').submit() : '';" class="d-inline-block btn btn-vermelho btn-circulo btn-pequeno"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{route('admin.funcao.destroy', $funcao->id)}}" method="POST" id="apagar{{$funcao->id}}">
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

        </div>
        </div>
        @endsection