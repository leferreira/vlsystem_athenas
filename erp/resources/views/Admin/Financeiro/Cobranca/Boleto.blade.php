@extends("Admin.template")
@section("conteudo")
<div class="col-9 central mb-3">
<span class="p-2 bg-title text-light text-uppercase text-branco justify-content-space-between d-flex">
	<span class="h5 mb-0"><i class="fas fa-check"></i> Pagamento com Boleto Bancário</span>
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
<form id="form-checkout" >
     @csrf
	<div class="col-12 mb-4">
       <fieldset class="caixa border radius-4">
            <legend><i class="far fa-list-alt"></i> Pagamento com Boleto Bancário</legend>
			<input type="hidden" name="tipo_documento" value="{{ config('constantes.tipo_documento.FATURA')  }}" >
			
			<div class="rows">
        		<div class="col-4 mb-3">
        				<strong class="text-label">Nome:</strong>
        			   <input type="text" name="payerFirstName" id="form-checkout__payerFirstName" value="Manoel " class="form-campo"/>
        		</div>
        		
    		  <div class="col-6 mb-3">
        				<strong class="text-label">Sobrenome:</strong>
    			   <input type="text" name="payerLastName" id="form-checkout__payerLastName" value="Jailton Nascimento" class="form-campo"/>
    		  </div>
    		  <div class="col-4 mb-3">
        				<strong class="text-label">Email</strong>
    			   <input type="email" name="email" id="form-checkout__email" value="mjailton@gmail.com" class="form-campo"/>
    		 </div>
    		 <div class="col-4 mb-3">
        				<strong class="text-label">Tipo Documento</strong>
    			   <select name="identificationType" id="form-checkout__identificationType" class="form-campo"></select>
    	    </div>   	    
    		     		
    	    <div class="col-4 mb-3">
        				<strong class="text-label">Número do Documento:</strong>
    			   <input type="text" name="identificationNumber" id="form-checkout__identificationNumber" value="78589452387" class="form-campo" />
    	    </div>
    	   
    	   
    			   
    		</div>
    		</fieldset>
		</div>
		
		<div class="tfooter end">
		        <input type="hidden" name="transactionAmount" id="transactionAmount" value="100">
        		<input type="hidden" name="description" id="description" value="Nome do Produto">		
		
    			<button type="submit"  class="btn btn-verde">Pagar</button>
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar">Fechar</a>
    		</div>
	</form>
	</div>
   
   
 
</div>
@endsection