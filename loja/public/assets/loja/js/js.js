$(function (){
	
	$('.filtro').click (function(){
	$('.mostraFiltro').slideToggle();
	$(this).toggleClass('active');
		return false;
	});
	
	$('.mobmenu').click (function(){
	$('.menu-lateral').slideToggle();
	$(this).toggleClass('active');
		return false;
	});	
	
	$('.senha').click (function(){
		$('.esquecisenha').slideToggle();
		$(this).toggleClass('active');
		return false;
	});
	
	$( function() {
		$( "#tab" ).tabs();
	  } );
	
	
	$( "#accordion" ).accordion({
		collapsible: true,
		autoHeight: false,
		active: false,
		heightStyle: "content" 
    }); 
	
	$( "#accordion_colapse" ).accordion({
		collapsible: false,
		autoHeight: false,
		active: false,
		heightStyle: "content" 
    });    
	
	//SliderShow
	(function(){
		var curr = 0;
		$("#jsNav .trigger").each(function(i){
			$(this).click(function(){
				curr = i;
				$("#js img").eq(i).fadeIn("slow").siblings("img").hide();
				$(this).siblings(".trigger").removeClass("imgSelected").end().addClass("imgSelected");
				return false;
			});
		});
		
		var pg = function(flag){
			if (flag) {
				if (curr == 0) {
					todo = 4;
				} else {
					todo = (curr - 1) % 5;
				}
			} else {
				todo = (curr + 1) % 5;
			}
			$("#jsNav .trigger").eq(todo).click();
		};
		
		//ǰ
		$("#prev").click(function(){
			pg(true);
			return false;
		});
		
		//
		$("#next").click(function(){
			pg(false);
			return false;
		});
		
		//Զ
		var timer = setInterval(function(){
			todo = (curr + 1) % 5;
			$("#jsNav .trigger").eq(todo).click();
		},5000);
		
		$("#js,#prev,#next").hover(function(){
				clearInterval(timer);
			},
			function(){
				timer = setInterval(function(){
					todo = (curr + 1) % 5;
					$("#jsNav .trigger").eq(todo).click();
				},5000);			
			}
		);
	})();
	
});

function fecharMsg(obj){	
	$(".msg").hide();
}
