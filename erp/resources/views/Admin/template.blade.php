<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Sistema ERP - mjailton</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale =1">
		<link href="{{asset('assets/admin/img/ico-athenas.svg')}}" type="image/x-icon" rel="icon" />
		<link href="{{asset('assets/admin/img/ico-athenas.svg')}}" type="image/x-icon" rel="shortcut icon" />
		<link href="{{asset('assets/admin/img/ico-athenas.svg')}}" rel="apple-touch-icon" />


        <style>
            .desabilitado{
                pointer-events: none;
                opacity: 0.4;
            }
        </style>
		<link rel="stylesheet" href="{{asset('assets/admin/css/datatables.css')}}">
		<link rel="stylesheet" href="{{asset('assets/admin/css/style_datatables.css')}}">
		<link rel="stylesheet" href="{{asset('assets/admin/css/app.css')}}">

		<!--Css Componentes-->
		<link rel="stylesheet" href="{{asset('assets/componentes/css/style_Componente.css')}}">

		<!--font icones-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<script src="{{asset('assets/admin/js/jquery.js')}}"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

		<script>
				var base_url = "{{asset('')}}";
				var _token   = "{{csrf_token()}}";

				let prot = window.location.protocol;
				let host = window.location.host;
				const path = prot + "//" + host + "/public/admin/";
                window.MP_PUBLIC_KEY = "{{env('MP_PUBLIC_KEY')}}";

		</script>

	</head>

<body>


	@include("Admin.cabecalho")
	@include("Admin.menu")
	@include('inc.erros')
    @include('inc.msg')
    <div id="mostrarErros"></div>
    <div id="mostrarUmErro"></div>
    <div id="mostrarSucesso"></div>
<div class="rows mx-0" id="appp">
		@yield("conteudo")

	<!--CARREGA O GIRA GIRA-->
    <div class="window load fechar_giragira" id="giragira">
    	<span class="text-load">Carregando...</span>
    </div>
</div>

	<script src="{{asset('assets/admin/js/datables/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/datables/js/dataTables.responsive.min.js')}}"></script>

	<script src="{{asset('assets/admin/js/jquery.mask.js')}}"></script>

	<script src="{{asset('assets/componentes/js/js_data_table.js')}}"></script>
	<script src="{{asset('assets/componentes/js/js_modal.js')}}"></script>
	<script src="{{asset('assets/componentes/js/js_util.js')}}"></script>
	<script src="{{asset('assets/componentes/js/js_mascara.js')}}"></script>
	<script src="{{asset('assets/componentes/js/upload.js')}}"></script>

@isset($mercadoPagoJs)
        <script src="https://sdk.mercadopago.com/js/v2"></script>

        <script type="text/javascript">
            const mp = new MercadoPago(MP_PUBLIC_KEY);
        </script>
        
        <script type="text/javascript" src="{{asset('assets/admin/js/js_mercado_pago.js')}}"></script>
    @endisset
  
	
	<!-- Graphs -->
	@if(isset($excluirJS))
    	<script type="text/javascript" src="{{asset('assets/admin/js/excluir.js')}}"></script>
	@endif
	
	@if(isset($graficoJs))
    	<script src="{{url('assets/admin/js/chart.js/Chart.min.js')}}"></script>
    	<script src="{{asset('assets/admin/js/js_grafico.js')}}"></script>
	@endif


	@if(isset($opcoesNfeJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_opcoes_nfe.js')}}"></script>
	@endif
	
	@if(isset($nfeCompraJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_nfe_compra.js')}}"></script>
	@endif
	
	@if(isset($importarXmlJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_nfe_importacao.js')}}"></script>
	@endif
	
	@if(isset($naturezaJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_natureza.js')}}"></script>
	@endif
	
	@if(isset($categoriaJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_categoria.js')}}"></script>
	@endif
	
	@if(isset($tributacaoJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_tributacao.js')}}"></script>
	@endif
	
	@if(isset($regraTributariaJS))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_regra_tributaria.js')}}"></script>
	@endif

	@if(isset($opcoesNfceJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_opcoes_nfce.js')}}"></script>
	@endif

	@if(isset($lojaPacoteJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_loja_pacote.js')}}"></script>
	@endif

	@if(isset($ordemCompraJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_ordem_compra.js')}}"></script>
	@endif

	@if(isset($compraJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_compra.js')}}"></script>
	@endif
	
	@if(isset($compraEditJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_compra_edit.js')}}"></script>
	@endif

	@if(isset($vendaJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_venda.js')}}"></script>
	@endif
	
	@if(isset($vendaEditJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_venda_edit.js')}}"></script>
	@endif

	@if(isset($osJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_os.js')}}"></script>
	@endif
	
	@if(isset($osEditJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_os_edit.js')}}"></script>
	@endif
	
	@if(isset($pdvVendaJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_pdvvenda.js')}}"></script>
	@endif
	
	@if(isset($pdvVendaEditJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_pdvvenda_edit.js')}}"></script>
	@endif

	@if(isset($orcamentoJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_orcamento.js')}}"></script>
	@endif
	
	@if(isset($orcamentoEditJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_orcamento_edit.js')}}"></script>
	@endif
	
	@if(isset($compraFiscalJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/compraFiscal.js')}}"></script>
	@endif

	@if(isset($produtoJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_produto.js')}}"></script>
	@endif

	@if(isset($servicoJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_servico.js')}}"></script>
	@endif
	
	@if(isset($produtoRecorrenteJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_produto_recorrente.js')}}"></script>
	@endif
	
	@if(isset($vendaRecorrenteJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_venda_recorrente.js')}}"></script>
	@endif
	
	@if(isset($entradaJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_entrada.js')}}"></script>
	@endif

	@if(isset($saidaJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_saida.js')}}"></script>
	@endif

	@if(isset($emitenteJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_emitente.js')}}"></script>
	@endif

	@if(isset($empresaJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_empresa.js')}}"></script>
	@endif

	@if(isset($clienteJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_cliente.js')}}"></script>
	@endif
	
	@if(isset($vendedorJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_vendedor.js')}}"></script>
	@endif

	@if(isset($uploadJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/upload.js')}}"></script>
	@endif

	@if(isset($fornecedorJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_fornecedor.js')}}"></script>
	@endif
	
	@if(isset($tipoDespesaJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_tipo_despesa.js')}}"></script>
	@endif
	
	@if(isset($despesaJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_despesa.js')}}"></script>
	@endif

	@if(isset($transportadoraJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_transportadora.js')}}"></script>
	@endif
	
	@if(isset($tecnicoJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_tecnico.js')}}"></script>
	@endif

	@if(isset($equipamentoJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_equipamento.js')}}"></script>
	@endif
	
	@if(isset($lojaPedidoJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_loja_pedido.js')}}"></script>
	@endif
	
	@if(isset($lojaPedidoEditJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_loja_pedido_edit.js')}}"></script>
	@endif
	
	@if(isset($variacaoGradeJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_variacao_grade.js')}}"></script>
	@endif
	
	@if(isset($financeiroJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_financeiro.js')}}"></script>
	@endif

	@if(isset($gradeJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_grade.js')}}"></script>
	@endif
	
	@if(isset($gradeTempJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_grade_temp.js')}}"></script>
	@endif
	
	@if(isset($js_delivery))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_delivery.js')}}"></script>
	@endif
	
	@if(isset($vendaRecorrenteJs))
		<script type="text/javascript" src="{{asset('assets/admin/js/js_venda_recorrente.js')}}"></script>
	@endif
	
  <script>
	  $( function() {
		$( "#tab" ).tabs();
	  } );
  </script>

  <!--Fundo Preto-->
<div id="fundo_preto"></div>
<div id="fundo_modal_livre1"></div>
@include('inc.modais')

 @yield('mpjs')
</body>

</html>
