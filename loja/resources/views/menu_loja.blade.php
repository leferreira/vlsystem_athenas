@if($categorias)
<div class="menu-lateral">
			 @foreach($categorias as $cat)	
				<div class="titulo"><span>{{$cat->categoria}}<i class="fas fa-angle-double-right"></i></span></div>
				  <ul>	
				  @foreach($cat->subcategorias as $sub)			   
					<li><a href="{{route('subcategoria', $sub->id)}}"><i class="fas fa-angle-right"></i> {{$sub->subcategoria}} </a></li>					
				  @endforeach						
				</ul> 
			@endforeach
</div>
@endif