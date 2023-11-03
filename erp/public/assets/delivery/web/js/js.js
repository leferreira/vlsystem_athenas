//ver carrinho
$(function(){
	$('.carr').click (function(){
	$('#vercarrinho .cx-carrinho').slideToggle();
	$(this).toggleClass('active');
		return false;
	});
        
        $('.thumb-min').on('click', function(){
            var url = $(this).find('img').attr('src');
            $('.caixa-prod').find('img').attr('src', url);
        });
        
        //Adiciona no carrinho
        $('.addtocartform button').on('click', function(e){
		e.preventDefault();

		var qt = parseInt($('.addtocart_qt').val());
		var action = $(this).attr('data-action');

		if(action == 'decrease') {
			if(qt-1 >= 1) {
				qt = qt - 1;
			}
		}
		else if(action == 'increase') {
			qt = qt + 1;
		}

		$('.addtocart_qt').val(qt);
		$('input[name=qtde]').val(qt);

	});
        
});



//menu mobile
$(function(){
    $('.mobile').click (function(){
    $('#mfiltro .menu-lateral').slideToggle();
    $(this).toggleClass('active');
            return false;
    });
});


//menu mobile2
$(function(){
    $('.mfiltro').click (function(){
    $('#mfiltro .menu-lateral').slideToggle();
    $(this).toggleClass('active');
            return false;
    });
});


//abas
$(document).ready(function(){
	
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});
	
/*** modal **/
	$("a[rel=modal]").click( function(ev){
        ev.preventDefault();
 
        var id = $(this).attr("href");
 
        var alturaTela = $(document).height();
        var larguraTela = $(window).width();
		
		
			
        //colocando o fundo preto
        $('#mascara').css({'width':larguraTela,'height':alturaTela});
        //$('#mascara').fadeIn(500); 
        $('#mascara').fadeTo("slow",0.8);
			
			
        //colocando o fundo preto
        $('#fundo').css({'width':larguraTela,'height':alturaTela});
        //$('#mascara').fadeIn(500); 
        $('#fundo').fadeTo("slow",0.8);
 
        var left = ($(window).width() /2) - ( $(id).width() / 2 );
        var top = ($(window).height() / 2) - ( $(id).height() / 2 );
     
        $(id).css({'top':top,'left':left});
        $(id).show(); 
		$(window).scrollTop(0) ;
		
    });
 
    $("#mascara").click( function(){
        $(this).hide();
        $(".window").hide();
    });
 
    $('.fechar').click(function(ev){
        ev.preventDefault();
        $("#mascara").hide();
        $(".window").hide();
    });
	
	/*** fim modal **/

})