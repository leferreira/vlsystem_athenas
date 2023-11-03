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
 
 
   <form action="{{route('admin.nfe.importar')}}" method="POST"  enctype="multipart/form-data">
	@csrf
            <div class="rows">
				<div class="col-12 d-block m-auto rows px-5 py-5">
					<div class="border radius-4 pt-4 px-5">
						<div class="col-12 mb-4">
							<span class="text-label">Nome do Arquivo</span>	
							<div class="file">
								<input type="file" name="arquivo[]"  multiple accept=".xml" class="form-campo" id="arquivo"><label for="arquivo">Selecionar arquivo</label>
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