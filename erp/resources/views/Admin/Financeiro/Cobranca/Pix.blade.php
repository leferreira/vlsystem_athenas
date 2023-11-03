@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-check"></i> Enviar Comprovante</span>
	<div class="d-flex">
		<a href="{{route('admin.fatura.index')}}" class="btn btn-azul btn-pequeno" title="Voltar"><i class="fas fa-arrow-left"></i> </a>
		<a href="" class="retorna btn btn-roxo btn-pequeno ml-1 d-inline-block" title="Menu"><i class="fas fa-bars"></i></a>
	</div>
</span>
<div class="rows">

	<div class="col-12 mt-4">
	
        <div class="col-12 mb-4">
            <fieldset class="caixa border radius-4">
            <legend><i class="far fa-list-alt"></i> Fatura : <b class="text-vermelho">{{ $fatura->id}}</b></legend>

            <div class="caixa">
				<div class="px-4">
				<div class="rows pt-3 pb-4">
					
					<div class="col-6 mb-3">
						<label class="text-label">Descricao</label>
						 <input type="text" name="descricao" value="{{ $fatura->descricao }}" id="descricao"  class="form-campo">												
					</div>
					<div class="col-6">	
                        <label class="text-label d-block">Observação</label>
                        <input type="text" name="observacao" value="{{ $fatura->observacao }}"   class="form-campo">												

                    </div>
                    
                                        
					<div class="col-4 mb-3">
						<label class="text-label">Data Emissão</label>
						 <input type="date" name="data_emissao" value="{{ $fatura->data_emissao }}" id="data_emissao" readonly class="form-campo">												
					</div>	
					
					<div class="col-4 mb-3">
						<label class="text-label">Data Vencimento</label>
						 <input type="date" name="data_vencimento" value="{{ $fatura->data_vencimento }}"  readonly id="data_vencimento"  class="form-campo">												
					</div>						
					<div class="col-4 mb-3">
						<label class="text-label">Valor</label>
						<input type="text" name="valor" id="valor_original" readonly="readonly" value="{{ $fatura->valor }}"    class="form-campo">												
					</div>
					
					                
										
					   
					</div>
				</div>          
			</div>
        </div>
	</div>
	
	<div class="col-12">
<form action="{{ route('admin.comprovante.store')}}" method="post" enctype="multipart/form-data">
     @csrf
	<div class="col-12 mb-4">
       <fieldset class="caixa border radius-4">
            <legend><i class="far fa-list-alt"></i> Pagamento com PIX</legend>
			<input type="hidden" name="tipo_documento" value="{{ config('constantes.tipo_documento.FATURA')  }}" >
            <div class="caixa">
            <div class="p-3 px-md">					
			<p  class="mb-2 pt-3">Preencha os campus com os dados do titular</p>
				<div class="rows">								
					<div class="col-6 mb-3">
						<strong class="text-label">Nome:</strong>
						<input type="text" name="payerFirstName" id="payerFirstName" value="{{ primeiroNome($empresa->razao_social) ?? null }}" class="form-campo"> 
					</div>
					<div class="col-6 mb-3">
						<strong class="text-label">Sobrenome:</strong>
						<input type="text" name="payerLastName" id="payerLastName" value="{{ ultimoNome($empresa->razao_social) ?? null }}" class="form-campo"> 
					</div>
					
					<div class="col-3 mb-3">
						<strong class="text-label">CPF</strong>
						<input type="text" name="docNumber" id="docNumber" value="{{ $empresa->cpf_cnpj ?? null }}" class="form-campo"> 
					</div>
					<div class="col-6 mb-3">
						<strong class="text-label">Email:</strong>
						<input type="text" name="payerEmail" id="payerEmail" value="{{ $empresa->email ?? null }}" class="form-campo"> 
					</div>
					<div class="col-3 m-auto text-center ">										
						
					</div>	
			
		</div>
		</div>
		
		<div class="tfooter end">
			<input type="hidden" name="transactionAmount" id="transactionAmount" >		
			<input type="hidden" name="productDescription" id="productDescription" value="Nome do Produto">			
			<input type="hidden" name="fatura_id" id="fatura_id" value="{{$fatura->id}}">		
			<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar">Fechar</a>
			<a href="javascript:;" onclick="pagarComPix()"  class="btn btn-verde">Finalizar Compra</a>					
		</div>
            
            
            
        
	</div>
   
   </form>
 
</div>


<div class="window form" id="pix">
			<span class="tacord">Pague com Pix e receba a confirmação imediata do seu pagamento</span>
	<div class="card pag1">
		<div class="p-3 px-md">
			<div class="rows">
				<ul class="col-8 mt-4"> 
					<li class="d-block mb-1"><span>1 - Abra o aplicativo do seu banco de preferência</span></li>
					<li class="d-block mb-1"><span>2 - Selecione a opção pagar com Pix</span></li>
					<li class="d-block mb-1"><span>3 - Leia o QR code ou copie o código abaixo e cole no campo de pagamento</span></li>
				</ul>
				<div class="col-4">
					<img src="" id="imageQRCode" class="img-fluido">
				</div>
				<div class="col-6 grupo-form-btn">
					<input type="text" class="form-campo" id="codigoPix" style="">
				</div>
			</div>
		</div>
		<div class="tfooter end">
			<a href="" class="fechar btn btn-vermelho ">Fechar</a>
		</div>
		</div>
	</div>

@endsection