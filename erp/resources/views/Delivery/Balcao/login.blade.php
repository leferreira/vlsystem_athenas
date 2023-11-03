@extends("Delivery.Frente.template")
@section("conteudo")


<div class="col-6 m-auto">
<div class="base-login">

	<div class="caixa-login position-relative">
	<div class="caixa p-2 px-4">
		<?php //$this->verMsg() ?>
		<form action="<?php echo URL_BASE ."login/logar" ?>" method="post">
			<h1 class="h4">login</h1>
			<label class="mb-3 d-block"> 
				<span class="text-label label">Email</span> 
				<input	type="text" name="email" placeholder="Digite seu email" class="form-campo">		
			</label> 
			<label class="mb-3 d-block"> 
				<span class="text-label label">Senha</span> 
				<input	type="password" name="senha" placeholder="Digite sua senha" class="form-campo">
			</label> 
			<input type="submit" value="Entrar" class="btn btn-gra-amarelo  m-auto">
		</form>
		<a href="" class="senha text-azul mt-3 d-block">Esqueci minha senha</a>
		</div>
		<div class="esquecisenha mostraCampo">
		<div class="caixa">
			<span class="sair senha position-absolute" style="right:10px;top:10px">X</span>
			<h1 class="h3 mb-0 pb-1">Esqueci minha senha </h1>
			<p class="text-center pb-4">Digite seu email no campo abaixo para recuperar sua senha</p>
			<form action="<?php echo URL_BASE ."login/recuperar" ?>" name="frmrecupear" method="post">
				<label class="mb-3 d-block">
					<input type="text" name="email2" placeholder="Inserir email" class="form-campo">
				</label>							
				<input type="submit" value="Enviar" class="btn btn-verde m-auto">
			</form>
		</div>
		</div>
	</div>

</div>
</div>



@endsection
	