

$(function () {
	
});

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
		console.warn("Erro de Manipulação do Formulário montado: ", error);
      console.log("Formulário Montado");
    },
	onCardTokenReceived: (erros, token) => {        
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

      fetch(base_url + "admin/mercadopago/pix", {
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
          payer: {
            email,
            identification: {
              type: identificationType,
              number: identificationNumber,
            },
          },
        }),
      }).then(response => response.json()).then((dados)=>{
		  console.log(dados);
			if(dados.status === "approved"){
				alert("Pagamento efetuado com sucesso.");
				//window.location.reload();
			}else{
				alert("erro:" + dados.status)
			}
		}).finally(()=>{
			//
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
	var pedido_id 	= $("#pedido_id").val();
	$.ajax({
	   url: base_url + "carrinho/verificaSePedidoTemVenda/" + pedido_id,
	   type: "GET",
	   dataType: "json",
	   data:{},
		 success: function(data){
			 console.log(data);
			 if(data == true){
				 pararBusca();
				 fecharModal();
				 giraGira();
				 window.location.href = base_url + "pagar/finalizado/" + pedido_id;
			 }
		 }
		
	});	
 }
 
function pagarComPix(){	
	var nome 		= $("#payerFirstName").val();
	var sobrenome 	= $("#payerLastName").val();
	var cpf 		= $("#docNumber").val();
	var email 		= $("#payerEmail").val();
	var fatura_id 	= $("#fatura_id").val();
	var cliente_id 	= $("#cliente_id").val();
	$.ajax({
		   url: base_url + "admin/mercadopago/pix",
		   type: "POST",
		   dataType: "json",
		   data:{
				"email"		:email,
				"nome"		:nome,
				"sobrenome"	:sobrenome,
				"cpf"		:cpf,				
				"cliente_id":cliente_id,
				"fatura_id" :fatura_id,			
		   	},
			 success: function(data){
				console.log(data);
				$("#imageQRCode").attr('src', 'data:image/png;base64,' + data.qr_code);
				$("#codigoPix").val(data.code);
				abrirModal("#pix");
				iniciarBusca();
			 }
			
	});
	
}


(async function getIdentificationTypes() {
      try {
        const identificationTypes = await mp.getIdentificationTypes();
        const identificationTypeElement = document.getElementById('form-checkout__identificationType');

        createSelectOptions(identificationTypeElement, identificationTypes);
      } catch (e) {
        return console.error('Error getting identificationTypes: ', e);
      }
    })();

    function createSelectOptions(elem, options, labelsAndKeys = { label: "name", value: "id" }) {
      const { label, value } = labelsAndKeys;

      elem.options.length = 0;

      const tempOptions = document.createDocumentFragment();

      options.forEach(option => {
        const optValue = option[value];
        const optLabel = option[label];

        const opt = document.createElement('option');
        opt.value = optValue;
        opt.textContent = optLabel;

        tempOptions.appendChild(opt);
      });

      elem.appendChild(tempOptions);
    }
