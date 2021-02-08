/**
 * Created by Jose Luis on 12/02/2016.
 */
$(function(){
    $(".btn-notificaciones").click(function(){
        if($(this).hasClass("cerrar-notificacion")){
            ocultarNotificaciones();
        }else{
            mostrarNotificaciones();
        }
    });


    $(".btn-mas-opciones").click(function(){
        if($(this).hasClass("cerrar-mas-opciones")){
            ocultarMasOpciones();
        }else{
            mostrarMasOpciones();
        }
    });

    $(".contenedor-notificaciones").mouseleave(function(){
        ocultarNotificaciones();
    })

    $(".contenedor-mas-opciones").mouseleave(function(){
        ocultarMasOpciones();
    })

    $("#masNotificaciones").click(function(){
        $.get("/masNotificaciones/"+$(".notificacion").length,function(data){
            if(data == "no-notificaciones"){
                $("#no-notificaciones").removeClass("invisible");
            }else {
                $("#no-notificaciones").addClass("invisible");
                $(".notificaciones-secundario").eq(0).html($(".notificaciones-secundario").eq(0).html() + data);
            }
            $(".contenedor-notificaciones-body").eq(0).animate({scrollTop: $('.contenedor-notificaciones-body').eq(0)[0].scrollHeight}, 1000);
        });
    })
})

function mostrarNotificaciones(){
    $(".btn-notificaciones").addClass("cerrar-notificacion");
    $(".contenedor-notificaciones").animate({right:"0px",opacity:.9},600);
    $(".btn-notificaciones strong").text("0");
    $(".btn-notificaciones").animate({right:"-50px",opacity:.9},600);
    $(".btn-mas-opciones").animate({right:"-50px",opacity:.9},600);
}

function ocultarNotificaciones(){
    $.get("/notificacionesRevisadasOk",function(data){});
    $(".contenedor-notificaciones").animate({right:"-280px",opacity:0},600);
    $(".btn-notificaciones").removeClass("cerrar-notificacion");
    $(".btn-notificaciones").animate({right:"0px",opacity:.9},600);
    $(".btn-mas-opciones").removeClass("cerrar-notificacion");
    $(".btn-mas-opciones").animate({right:"0px",opacity:.9},600);
}

function mostrarMasOpciones(){
    $(".btn-mas-opciones").addClass("cerrar-mas-opciones");
    $(".contenedor-mas-opciones").animate({right:"0px",opacity:.9},600);
    $(".btn-notificaciones").animate({right:"-50px",opacity:.9},600);
    $(".btn-mas-opciones").animate({right:"-50px",opacity:.9},600);
}

function ocultarMasOpciones(){
    $(".contenedor-mas-opciones").animate({right:"-280px",opacity:0},600);
    $(".btn-mas-opciones").removeClass("cerrar-mas-opciones");
    $(".btn-notificaciones").animate({right:"0px",opacity:.9},600);
    $(".btn-mas-opciones").removeClass("cerrar-notificacion");
    $(".btn-mas-opciones").animate({right:"0px",opacity:.9},600);
}


if (typeof (EventSource) == "undefined") {
    alert("El Api SSE de HTML no es soportado en su navegador, lo cual impide mostrar notificaciones del sistema.");
}

var sourceNotificaciones = new EventSource("/notificaciones");
sourceNotificaciones.onmessage = function (event) {
    $(".notificaciones-primario").eq(0).html(event.data);
};

var sourceNotificacionesNuevas = new EventSource("/notificacionesNuevas");
sourceNotificacionesNuevas.onmessage = function (event) {
    $("#contador-notificaciones").eq(0).text(event.data);
};