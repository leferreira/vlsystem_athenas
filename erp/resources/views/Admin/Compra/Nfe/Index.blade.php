@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="rows">	
                <div class="col-12">
                <div class="caixa">
                    <div class="p-2 py-1 bg-title text-light text-uppercase  text-branco d-flex justify-content-space-between">
					<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Lista de NFEs </span>
						<div>
							<a href="{{route('admin.nfe.lerArquivo')}}" class="btn btn-azul mx-1 d-inline-block"><i class="fas fa-plus-circle"></i> Ler Xml</a>
					
						</div>
					</div>
                        
					<form name="busca" action="{{route('admin.nfeentrada.filtro')}}" method="get">                        
                        <div class="px-2 pt-2">
							  <div class=" bg-padrao mt-2 p-2 radius-4">
							  <div class="rows">
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data Cadastro 1</label>
                                            <input type="date" name="data1" value="{{$filtro->data1 ?? null}}" class="form-campo">
                                        </div>
                                        
                                        <div class="col-2">	
                                            <label class="text-label d-block text-branco">Data Cadastro 2</label>
                                            <input type="date" name="data2" value="{{$filtro->data2 ?? null}}" class="form-campo">
                                        </div>
                                        <div class="col-3">	
                                            <label class="text-label d-block text-branco">Status da Venda</label>
                                            <select class="form-campo" name="status_id">
                                            <option value="">Selecione</option>
                                            @foreach($status as $s)
												<option value="{{$s->id}}" {{( $filtro->status_id ?? null)==$s->id ? 'selected' : null}}>{{$s->status}}</option>
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
                    <div class="tabela-responsiva pb-4">
                    <table cellpadding="0" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                             <tr>
                                    <th align="center" width="10">Id</th>
                                    <th align="left">Fornecedor</th>
                                    <th align="center">Chave</th>
                                    <th align="center">Data</th>
                                    <th align="center">Total</th>
                                    <th align="center">Frete</th>
                                    <th align="center">Desc</th>
                                    <th align="center">ICMS</th>
                                    <th align="center">IPI</th>
                                    <th align="center">PIS</th>
                                    <th align="center">Cofins</th>
                                    <th align="center">Valor Nota</th>
                                    <th align="center" >Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                               @foreach($lista as $c)                                      
                                 <tr>
                                    <td align="center">{{$c->id}}</td>
                                    <td align="center">{{$c->fornecedor->razao_social ?? "---"}}</td>
                                    <td align="center">{{$c->chave}}</td>
                                    <td align="center">{{ databr(dataNfe($c->dhEmi))}}</td>
                                    
                                    <td align="center">{{ formataNumero($c->vProd)  }}	</td>
                                    <td align="center">{{ formataNumero($c->vFrete)  }}	</td>
                                    <td align="center">{{ formataNumero($c->vDesc)  }}	</td>
                                    <td align="center">{{ formataNumero($c->vICMS)  }}	</td>
                                    <td align="center">{{ formataNumero($c->vIPI)  }}	</td>
                                    <td align="center">{{ formataNumero($c->vPIS)  }}	</td>
                                    <td align="center">{{ formataNumero($c->vCOFINS)  }}	</td>
                                    <td align="center">{{ formataNumero($c->vNF)  }}	</td>
                                    <td align="center"> 
                                 		<a href="{{route('admin.nfeentrada.produtos',$c->id )}}" class="btn btn-azul d-inline-block" title="Visulizar Produtos"><i class="fas fa-eye "></i></a>
    							    	<a href="{{route('admin.nfeentrada.ver', $c->id)}}" class="btn btn-vermelho d-inline-block" title="Excluir"><i class="fas fa-eye"></i></a>
   							
    									<a href="{{route('admin.nfeentrada.excluir', $c->id)}}" class="btn btn-vermelho d-inline-block" title="Excluir"><i class="fas fa-trash"></i></a>
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
<div class="window medio" id="enviarNfe">
	<div class="titulo d-flex justify-content-space-between"><b id="titulo_erro">Enviando NFE</b> <a href="" class="fechar text-vermelho">X</a></div>
	<div class="p-2 text-center mt-2">
    	<div id="gira_gira_envio">
    		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
    		<span class="text-cinza d-block mt-2 mb-2"> Aguarde Enviando...</span>
    	</div>
		<span class="msg msg-vermelho p-1" id="div_erro" >
			<i class="fas fa-bug"></i> <b id="erro_nota"></b>
		</span>
	</div>
	<div class="tfooter center" id="opcoes_nota">
		<a href="" class="btn btn-azul btn-pequeno">Imprimir NFE</a>
		<a href="" class="btn btn-azul btn-pequeno">Outros </a>
		<a href="" class="btn btn-azul btn-pequeno">Outros </a>
		<a href="" class="btn btn-azul btn-pequeno">Outros </a>
	</div>
</div>


<div class="window medio" id="modal_opcoes_nota">
	<div class="titulo d-flex justify-content-space-between">Escolha uma Opção <a href="" class="fechar text-vermelho">X</a></div>
	<div class="p-2 text-center mt-2">
		<div id="gira_gira_opcoes">
    		<img src="{{asset('assets/admin/img/load2.gif')}}" width="60" class="m-auto">
    		<span class="text-cinza d-block mt-2 mb-2"> Aguarde Enviando...</span>
    	</div>
		<span class="msg msg-vermelho p-1" id="div_erro_opcoes" >
			<i class="fas fa-bug"></i> <b id="erro_nota_opcoes"></b>
		</span>
		<form name="correcao"  action="{{route('admin.nfe.email')}}" method="Post">
		@csrf
		<div class="rows" id="verEmail">			
			<div class="col-12">						
				<div class="rows">	
					<div class="col-3 mb-3 px-0">
						<input type="text" name="email" id="email" value="testesmjailton@gmail.com" class="form-campo" placeholder="Insira o Email">
					</div>
					<div class="col-3 mb-3">
						<input type="submit"  class="btn btn-verde btn-medio width-100" value="Enviar Email" />
						<input type="hidden" id="id_nfe" name="id_nfe">
					</div>
				</div>
			</div>			
		 </div>
		</form>			
					
	</div>
	<div class="tfooter center">
		<a href="javascript:;" onclick="danfe()" class="btn btn-azul btn-pequeno">Imprimir NFE</a>
		<a href="javascript:;" onclick="baixarXml()" class="btn btn-azul btn-pequeno">Baixar XML </a>
		<a href="javascript:;" onclick="baixarPdf()" class="btn btn-azul btn-pequeno">Baixar PDF</a>
		<a href="" class="btn btn-azul btn-pequeno">Consultar NFE</a>
		<a href="" class="btn btn-azul btn-pequeno">Correção (CC-e)</a>
		<a href="" class="btn btn-azul btn-pequeno">Cancelar NFE</a>		
		<a href="javascript:;" onclick="verEmail()" class="btn btn-azul btn-pequeno">Enviar Email</a>		
	</div>
</div>
@endsection