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
<form id="form-checkout" >
     @csrf
	<div class="col-12 mb-4">
       <fieldset class="caixa border radius-4">
            <legend><i class="far fa-list-alt"></i> Dados do Comprovante</legend>
			<input type="hidden" name="tipo_documento" value="{{ config('constantes.tipo_documento.FATURA')  }}" >
			
			<div class="rows">
        		<div class="col-4 mb-3">
        				<strong class="text-label">Número do cartão:</strong>
        			   <input type="text" name="cardNumber" id="form-checkout__cardNumber" value="550209508103" class="form-campo"/>
        		</div>
        		<div class="col-2 mb-3">
        				<strong class="text-label">Validade</strong>
    			   <input type="text" name="cardExpirationDate" id="form-checkout__cardExpirationDate" value="11/2028" class="form-campo"/>
    		  </div>
    		  <div class="col-6 mb-3">
        				<strong class="text-label">Titular do cartão:</strong>
    			   <input type="text" name="cardholderName" id="form-checkout__cardholderName" value="Manoel Nascimento" class="form-campo"/>
    		  </div>
    		  <div class="col-6 mb-3">
        				<strong class="text-label">Email</strong>
    			   <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail" value="mjailton@gmail.com" class="form-campo"/>
    		 </div>
    		 <div class="col-3 mb-3">
        				<strong class="text-label">Cód Segurança</strong>
    			   <input type="text" name="securityCode" id="form-checkout__securityCode" value="622" class="form-campo"/>
    	     </div>
    	   		<select name="issuer" id="form-checkout__issuer" class="form-campo" style="display:none"></select>
    		
    		<div class="col-3 mb-3">
        				<strong class="text-label">Tipo Documento</strong>
    			   <select name="identificationType" id="form-checkout__identificationType" class="form-campo"></select>
    	    </div>
    	    <div class="col-6 mb-3">
        				<strong class="text-label">Número do Documento:</strong>
    			   <input type="text" name="identificationNumber" id="form-checkout__identificationNumber" value="78589452387" class="form-campo" />
    	    </div>
    	    <div class="col-6 mb-3">
        			<strong class="text-label">Parcelas</strong>
    			   <select name="installments" id="form-checkout__installments" class="form-campo"></select>
    		</div>
    	    <div class="col-12">
				<progress value="0" class="progress-bar" style="width:100%">Carregando...</progress>
    		</div>
    			   
    		</div>
    		</fieldset>
		</div>
		
		<div class="tfooter end">
    			<button type="submit" id="form-checkout__submit" class="btn btn-verde">Pagar</button>
				<a href="javascript:;" onclick="fecharModal()" class="btn btn-vermelho fechar">Fechar</a>
    		</div>
	</form>
	</div>
   
   
 
</div>
@endsection