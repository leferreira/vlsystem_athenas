
<html lang="pt-br">
	<head>
		<title>OTTO PDV</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="{{asset('assets/pdv/img/uploads_oie_NBm7086Phavb.ico')}}" type="image/x-icon" rel="icon" />
		<link href="{{asset('assets/pdv/img/uploads_oie_NBm7086Phavb.ico')}}" type="image/x-icon" rel="shortcut icon" />
		<link href="{{asset('assets/pdv/img/uploads_oie_NBm7086Phavb.ico')}}" rel="apple-touch-icon" />
		<!--css-->
		<link rel="stylesheet" href="{{asset('assets/pdv/js/datatables/css/jquery.dataTables.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/js/datatables/css/responsive.dataTables.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('assets/pdv/js/datatables/css/style_dataTable.css')}}">

		<link rel="stylesheet" href="{{asset('assets/pdv/css/grade.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/css/auxiliar.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/css/style.css')}}">
		<link rel="stylesheet" href="{{asset('assets/pdv/css/style-m.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.5/dist/css/tom-select.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">  

		<!--icones-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

		<script src="{{asset('assets/pdv/js/jquery.min.js')}}"></script>     

	</head>
	<body>
		<div class="site">
			@include("pdv/cabecalho")
            <div id="app" v-cloak>
			    @yield("conteudo")
            </div>
		</div>


		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

		<script src="{{asset('assets/pdv/js/datatables/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/pdv/js/datatables/js/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/pdv/js/js.js')}}"></script>
		<script src="{{asset('assets/pdv/js/componentes/js_modal.js')}}"></script>
		<script src="{{asset('assets/pdv/js/componentes/js_data_table.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.5/dist/js/tom-select.complete.min.js"></script>              

	</body>
</html>
