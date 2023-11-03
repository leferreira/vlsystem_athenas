@if (isset($errors))
	
	@if(count($errors) ==1 )	 
     	<span class="msg msg-vermelho position-fixed right top" id="msg_lista_um_erro">
     		@foreach($errors->all() as $erro)     			
      			<i class="fas fa-bug"></i> <b>Ops!</b> {{$erro}} <a href="javascript:;" onclick="fecharMsg()" class="sair">x</a>
      		@endforeach
      	</span> 
      	<script>$("#msg_lista_um_erro").hide(5000);</script>     	
    @elseif (count($errors) > 1)  	
         <span class="msg msg-vermelho position-fixed right top" id="msg_lista_varios_erros">
    		<i class="fas fa-bug"></i> <b>Ops!</b> Erros Encontrados
    		<ul>
    		@foreach($errors->all() as $erro)
    			<li>{{$erro}}</li>
    		@endforeach
    		</ul>
    		<a href="javascript:;" onclick="fecharMsg()" class="sair">x</a>			
    	</span>
    	
   @endif
   <script>$("#msg_lista_um_erro").hide(10000);</script>
   <script>$("#msg_lista_varios_erros").hide(10000);</script>  
@endif


