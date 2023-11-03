

$(function () {
	
});

// Step #3
const cardForm = mp.cardForm({
  amount: "1",
  autoMount: true,
  form: {
    id: "form-checkout",
    cardholderName: {
      id: "form-checkout__cardholderName",
      placeholder: "Titular do cartão",
    },
    cardholderEmail: {
      id: "form-checkout__cardholderEmail",
      placeholder: "E-mail",
    },
    cardNumber: {
      id: "form-checkout__cardNumber",
      placeholder: "Número do cartão",
    },
    cardExpirationDate: {
      id: "form-checkout__cardExpirationDate",
      placeholder: "Data de vencimento (MM/YYYY)",
    },
    securityCode: {
      id: "form-checkout__securityCode",
      placeholder: "Código de segurança",
    },
    installments: {
      id: "form-checkout__installments",
      placeholder: "Parcelas",
    },
    identificationType: {
      id: "form-checkout__identificationType",
      placeholder: "Tipo de documento",
    },
    identificationNumber: {
      id: "form-checkout__identificationNumber",
      placeholder: "Número do documento",
    },
    issuer: {
      id: "form-checkout__issuer",
      placeholder: "Banco emissor",
    },
  },
  callbacks: {
    onFormMounted: error => {
      if (error) return 
    },
	onCardTokenReceived: (erros, dados) => {
            if(typeof erros != 'undefined'){
                erros.forEach((ee) => {
                    alert(ee.message);
                });
            }
        },
    onSubmit: event => {
      event.preventDefault();
      const {
        paymentMethodId: payment_method_id,
        issuerId: issuer_id,
        cardholderEmail: email,
        amount,
        token,
        installments,
        identificationNumber,
        identificationType,
      } = cardForm.getCardFormData();
	  
			beforeSend= function() {				
				$("#btnSalvar").hide();
			    giraGira();
				return fetch.apply(this, arguments);
			  }

			  beforeSend(base_url +  "mercadopago/cartao", {
				method: "POST",
				
				headers: {
				  "Content-Type": "application/json",
				},
				body: JSON.stringify({
				  _token: _token,
				  token,
				  issuer_id,
				  payment_method_id,
				  transaction_amount: Number(amount),
				  installments: Number(installments),
				  description: "Descrição do produto",
				  codigo 	 : $("#cobranca_id").val(),
				  cliente_id : $("#cliente_id").val(),
				  empresa_id : $("#empresa_id").val(),
				  payer: {
					email,
					identification: {
					  type: identificationType,
					  number: identificationNumber,
					},
				  },
				}),
			  }).then(response => response.json()).then((data)=>{
				  fecharModal();
				$("#btnSalvar").show();				  
				  if(data.tem_erro == true || data.tem_erro == "true"){
					  alert(data.erro);
				  }else{
					if(data.status === "approved"){
						window.location.href = base_url ;
					}else{
						alert("erro:" + data.erro)
					}
				  }
					
			}).finally(()=>{
				fecharModal();
				$("#btnSalvar").show();
			});
    },
    onFetching: (resource) => {
      console.log("Buscando Recurso: ", resource);

      // Animate progress bar
      const progressBar = document.querySelector(".progress-bar");
      progressBar.removeAttribute("value");

      return () => {
        progressBar.setAttribute("value", "0");
      };
    }
  },
});

function iniciarBusca(){
    cronometro = setInterval(function(){
     verificarNotificacao();
	},5000); 	
}

function pararBusca(){    
    clearInterval(cronometro);
}

function verificarNotificacao(){
	var cobranca_id 	= $("#cobranca_id").val();
	$.ajax({
	   url: base_url + "mercadopago/verificaSeCobrancaPagaNoPix/" + cobranca_id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
			 console.log(data);
			 if(data == 1 || data == "1"){
				 pararBusca();
				 fecharModal();
				 giraGira();
				 window.location.href = base_url ;
			 }
		 }
		
	});	
 }
 
function pagarComPix(){
	var nome 		= $("#payerFirstName").val();
	var sobrenome 	= $("#payerLastName").val();
	var cpf 		= $("#docNumber").val();
	var email 		= $("#payerEmail").val();
	var codigo 		= $("#cobranca_id").val();
	var cliente_id 	= $("#cliente_id").val();
	var empresa_id  = $("#empresa_id").val();
	$.ajax({
		   url: base_url + "mercadopago/pix",
		   type: "POST",
		   dataType: "json",
		   data:{
				"email"		:email,
				"nome"		:nome,
				"sobrenome"	:sobrenome,
				"cpf"		:cpf,			
				"codigo"	:codigo,			
				"cliente_id":cliente_id,
				"empresa_id" : empresa_id			
		   	},
		   	beforeSend: function (){
				$("#btnPagarPix").hide();
			   giraGira();
		   },
			 success: function(data){
				fecharModal();
				$("#btnPagarPix").show();
				$("#imageQRCode").attr('src', 'data:image/png;base64,' + data.qr_code_base64);
				$("#codigoPix").val(data.qr_code);
				abrirModal("#pix");
				iniciarBusca();
			 }, 
			 error: function (e) {			
				fecharModal();
				$("#btnPagarPix").show();
				var response = JSON.parse(e.responseText);			
				$("#mostrarErros").html(MostrarMsgErros(response.errors));	
			}
			
		});
	
}

function pagarComBoleto(){
	var nome 		= $("#nome").val();
	var sobrenome 	= $("#sobrenome").val();
	var cpf 		= $("#cpf").val();
	var email 		= $("#email").val();
	var cep 		= $("#cep").val();
	var logradouro 	= $("#logradouro").val();
	var numero 		= $("#numero").val();
	var complemento = $("#complemento").val();
	var cidade 		= $("#cidade").val();
	var uf 			= $("#uf").val();
	var codigo 		= $("#cobranca_id").val();
	var cliente_id 	= $("#cliente_id").val();
	var empresa_id  = $("#empresa_id").val();
	$.ajax({
		   url: base_url + "mercadopago/boleto",
		   type: "POST",
		   dataType: "json",
		   data:{
				"email"		:email,
				"nome"		:nome,
				"sobrenome"	:sobrenome,
				"cpf"		:cpf,	
				"cep"		:cep,
				"logradouro":logradouro,
				"numero"	:numero,
				"complemento":complemento,	
				"cidade":cidade,
				"uf":uf,	
				"codigo"	:codigo,			
				"cliente_id":cliente_id,
				"empresa_id" : empresa_id			
		   	},
			 beforeSend: function (){
				$("#btnPagarBoleto").hide();
			   giraGira();
		   },
			 success: function(data){
				fecharModal();
				$("#btnPagarBoleto").show();
				if(data.tem_erro == true){
					$("#mostrarUmErro").html(MostrarUmaMsgErro(" Erro: " + data.erro));
				}else{
					window.location.href = data.link;
				}
				
			 }, error: function (e) {			
				fecharModal();
				$("#btnPagarBoleto").show();
				var response = JSON.parse(e.responseText);			
				$("#mostrarErros").html(MostrarMsgErros(response.errors));	
		}
			
		});
	
}