@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase  text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-plus-circle"></i> Ler NFE</span>
	<div class="d-flex">
		<a href="{{route('admin.compra.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>
 
 
   <form action="{{route('admin.notafiscal.importarNfe')}}" method="POST"  enctype="multipart/form-data">
	@csrf
            <div class="rows">
				<div class="col-12 d-block m-auto rows px-5 py-5">
					<div class="border radius-4 pt-4 px-5 rows">
					<div class="col-6 mb-3">
                     <label class="text-label">Natureza Operação<span class="text-vermelho">*</span></label>
						<div class="group-btn">
                            <select class="form-campo" name="natureza_operacao_id" id="natureza_operacao_id">
                            @foreach($naturezas as $natureza)
                                <option value="{{$natureza->id}}" >{{$natureza->descricao}}</option>
                            @endforeach
                            </select>
						</div> 
                    </div>                    
                    <div class="col-6 mb-4">
							<span class="text-label">Nome</span>	
							<div class="file">
								<input type="file" name="arquivo"  multiple accept=".xml" class="form-campo" id="arquivo"><label for="arquivo">Selecionar arquivo</label>
							</div>
						</div>
						
                   <div class="col-12 mb-3">
                         <span class="text-label fw-700 h5 mb-1">Opções</span>
                            <div class="width-100 border radius-5 d-flex center-middle">
    							<div class="check radio p-6 d-flex p-3">
    								<label class="d-flex mb-1"><input type="checkbox" name="vbc_frete" id="vbc_frete" value="S"> Salvar Produto</label>
    								<label class="d-flex mb-1 ml-2"><input type="checkbox" name="vbc_ipi" id="vbc_ipi" value="S"> Salvar Transportadora</label>
    							</div>
    						</div>
                     </div>
                     </div>
					
						                                                   
						<div class="col-12 mt-3 mb-3 border-top pt-2">
							<input type="submit" value="Importar XML" class="btn btn-azul d-block m-auto">
						</div>
					</div>
                </div>
            </div>
        </form>
</div>
@endsection