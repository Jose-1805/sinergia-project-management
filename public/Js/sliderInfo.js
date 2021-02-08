$(function(){
    var rutaBtn = ".contenedorPrincipal .row .pagina .row .col .col .hide-on-small-only ";
    $(".divBody").on("click",rutaBtn+".btn-left-desktop",function(){
        var visible = $(this).parent().children(".col").eq(0).children(".visible").eq(0);
        left(visible);
    });

    $(".divBody").on("click",rutaBtn+".btn-right-desktop",function(){
        var visible = $(this).parent().children(".col").eq(0).children(".visible").eq(0);
        right(visible);
    });

    var rutaBtn = ".contenedorPrincipal .row .pagina .row .col .col .hide-on-med-and-up ";
    $(".divBody").on("click",rutaBtn+".btn-left-movil",function(){
        var visible = $(this).parent().children(".visible").eq(0);
        left(visible);
    });

    $(".divBody").on("click",rutaBtn+".btn-right-movil",function(){
        var visible = $(this).parent().children(".visible").eq(0);
        right(visible);
    });
})

function left(visible){
    if($(visible).prev().hasClass("invisible")){
        $(visible).removeClass("visible");
        $(visible).addClass("invisible");
        $(visible).prev().removeClass("invisible");
        $(visible).prev().addClass("visible");
    }
}

function right(visible){
    if($(visible).next().hasClass("invisible")){
        $(visible).removeClass("visible");
        $(visible).addClass("invisible");
        $(visible).next().removeClass("invisible");
        $(visible).next().addClass("visible");
    }
}