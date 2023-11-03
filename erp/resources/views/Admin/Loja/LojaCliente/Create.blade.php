@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<div class="p-2 py-1 bg-title text-light text-uppercase text-branco d-flex justify-content-space-between">
	<span class="h5 mb-0 d-flex center-middle"><i class="far fa-list-alt mr-1"></i> Dados do Cliente </span></span>
	<div>
		<a href="{{route('admin.loja.lojacliente.index')}}" class="btn btn-azul btn-pequeno d-inline-block" title="Volta"><i class="fas fa-arrow-left"></i> </a>		
	<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</div>                      
 @if(isset($cliente))    
   <form action="{{route('admin.loja.lojacliente.update', $cliente->id)}}" method="POST">
   <input name="_method" type="hidden" value="PUT"/>
 @else                       
	<form action="{{route('admin.loja.lojacliente.store')}}" method="Post">
@endif
	@csrf
   <div id="tab">
	  <ul>
		<li><a href="#tab-1">Produto</a></li>
	  </ul>
	  <div id="tab-1">
		<div class="p-2 pt-4">
			<fieldset>
				<legend>Informações básicas</legend>
				<div class="rows">							
					
						 <div class="col-12 px-2">
                           <div class="rows">                                                        
                                
                                <div class="col-4 mb-3">
                                        <label class="text-label">Nome</label>
                                        <input type="text" name="nome" value="{{isset($cliente->nome) ? $cliente->nome : old('nome')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">Sobrenome</label>
                                        <input type="text" name="sobre_nome" value="{{isset($cliente->sobre_nome) ? $cliente->sobre_nome : old('sobre_nome')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">CPF</label>
                                        <input type="text" name="cpf" value="{{isset($cliente->cpf) ? $cliente->cpf : old('cpf')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">Email</label>
                                        <input type="text" name="email" value="{{isset($cliente->email) ? $cliente->email : old('email')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-2 mb-3">
                                        <label class="text-label">Telefone</label>
                                        <input type="text" name="telefone" value="{{isset($cliente->telefone) ? $cliente->telefone : old('telefone')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>
                                <div class="col-4 mb-3">
                                        <label class="text-label">Senha</label>
                                        <input type="text" name="senha" value="{{isset($cliente->senha) ? $cliente->senha : old('senha')}}" placeholder="Digite aqui..." class="form-campo">
                                </div>                              
                                
                                 <div class="col-2 mb-3">
                                        <label class="text-label">Status </label>
                                        <select class="form-campo" name="status_id">
                                        @foreach(config('constantes.status') as $chave=>$valor)                                            
                                          	<option value="{{$valor}}">{{$chave}}</option>
                                       @endforeach
                                          
                    				   </select>
                                </div>
                                                          
                        </div>
					</div>
				</div>
			</fieldset>
		</div>
	  </div>

 </div>
		<div class="col-12 text-center pb-4">
		    <input type="hidden" id="cliente_id" value="{{($cliente->id) ?? null }}" >	
		    <input type="hidden" id="cnpj" value="{{($cliente->empresa->cpf_cnpj) ?? null }}" >	
			<input type="submit" value="Salvar" class="btn btn-azul m-auto">
		</div>
	  </div>
	
</form>
</div>

@endsection