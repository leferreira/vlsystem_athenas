<html lang="pt-br">
	<head>
		<title>DELIVERY</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--css-->
		<link rel="stylesheet" href="{{asset('assets/delivery/balcao/js/datatables/css/jquery.dataTables.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/delivery/balcao/js/datatables/css/responsive.dataTables.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('assets/delivery/balcao/js/datatables/css/style_dataTable.css')}}">
		
		<link rel="stylesheet" href="{{asset('assets/delivery/balcao/css/grade.css')}}">
		<link rel="stylesheet" href="{{asset('assets/delivery/balcao/css/auxiliar.css')}}">
		<link rel="stylesheet" href="{{asset('assets/delivery/balcao/css/style.css')}}">
		<link rel="stylesheet" href="{{asset('assets/delivery/balcao/css/style-m.css')}}">
		<!--icones-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		
		<script src="{{asset('assets/delivery/balcao/js/jquery.min.js')}}"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<script>
			let prot = window.location.protocol;
			let host = window.location.host;

			//const path = "http://localhost/metodoagora/athenas/public/balcao/";
			const path = prot + "//" + host + "/public/balcao/";


			var _token   = "{{csrf_token()}}";
				
			let user = $('#user').val() ? $('#user').val() : 0;
	</script>
		
	</head>
	<body>
		<div class="site">				
			@include("Delivery.Balcao.cabecalho")
		<div class="Home">	
			<div class="conteudo">	
				<div class="rows">
					@yield("conteudo")	
													
				</div>
			</div>
		</div>
		
		<div class="footer">
			<p>copyRigth - mjailton 2022</p>
		</div>
		</div>
		
		@isset($balcaoJS)
            <script src="{{asset('assets/delivery/balcao/js/js_balcao.js')}}"></script>
        @endisset
		 
		<script src="{{asset('assets/delivery/balcao/js/datatables/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/delivery/balcao/js/datatables/js/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/delivery/balcao/js/js.js')}}"></script>
		<script src="{{asset('assets/delivery/balcao/js/componentes/js_modal.js')}}"></script>
		<script src="{{asset('assets/delivery/balcao/js/componentes/js_data_table.js')}}"></script>
		
		
	</body>
</html>