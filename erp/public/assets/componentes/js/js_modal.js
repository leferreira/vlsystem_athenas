
function abrirModalLivre(id){
    var alturaTela  = $(document).height();
    var larguraTela = $(window).width();

    //colocando o fundo preto
    $('#fundo_modal_livre').css({'width':larguraTela,'height':alturaTela});
    $('#fundo_modal_livre').fadeIn(1000);	
    $('#fundo_modal_livre').fadeTo("slow",0.95);

    var left = ($(window).width() /2) - ( $(id).width() / 2 );
    var top = ($(window).height() / 2) - ( $(id).height() / 2 );

    $(id).css({'top':top,'left':left});
    $(id).show();
	$(window).scrollTop(0) ;
}


function fecharModalLivre(){
	//inicio();	
	$("#fundo_modal_livre").hide();
    $(".modal_livre").hide();
}


function abrirModal(id){
    var alturaTela  = $(document).height();
    var larguraTela = $(window).width();

    //colocando o fundo preto
    $('#fundo_preto').css({'width':larguraTela,'height':alturaTela});
    $('#fundo_preto').fadeIn(1000);	
    $('#fundo_preto').fadeTo("slow",0.8);


    var left = ($(window).width() /2) - ( $(id).width() / 2 );
    var top = ($(window).height() / 2) - ( $(id).height() / 2 );

    $(id).css({'top':top,'left':left});
    $(id).show();
	$(window).scrollTop(0) ;
}

function fecharModal(eh_modal_livre=0){
	if(eh_modal_livre == 1){
		$("#fundo_modal_livre").hide();
    	$(".modal_livre").hide();
	}else{
		console.log(".");
		$("#fundo_preto").hide();
    	$(".window").hide();
	}
}

$(function () {
	 $('.fechar').click(function(ev){
        ev.preventDefault();
        $("#fundo_preto").hide();
        $(".window").hide();
		
    });
	
	$('.fechar_livre').click(function(ev){
        ev.preventDefault();
        $("#fundo_modal_livre").hide();
        $(".modal_livre").hide();
    });

});	