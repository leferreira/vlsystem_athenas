$(function () {
	

});	

function abrirModal(id){
   var alturaTela = $(document).height();
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
function fecharModal(){
	//inicio();	
	$("#fundo_preto").hide();
    $(".window").hide();
}
