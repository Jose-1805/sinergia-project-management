/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var duracion1 = 1200;
var duracion2 = 800;
var idIntervalo = 0;
var intervaloRun = false;
iniciarIntervalo();
$(function () {
    $(".btnSlider").click(
            function () {
                window.clearInterval(idIntervalo);
                intervaloRun = false;
                var direccion = 1;
                if ($(this).attr("id") == "btnSliderIzquierdo") {
                    direccion = -1;
                }
                movimientoSlider(direccion);
            }
    )


})

function iniciarIntervalo() {
    idIntervalo = window.setInterval(function () {
        movimientoSlider(1)
    }, 8000);
    intervaloRun = true;
}

function movimientoSlider(direccion) {

    var numElementos = $(".imagenSlider").length;
    if (numElementos > 1) {
        $.each($(".imagenSlider"), function (index, value) {
            if ($(this).hasClass("activo")) {
                var anim = claseAnimacionAleatoria();
                var animElementoSlider = claseAnimacionAleatoria();
                $('.elementoSlider').addClass(animElementoSlider);
                $(this).addClass(anim);
                $(this).fadeOut(duracion1, function () {
                    $(this).removeClass(anim);
                    $('.elementoSlider').removeClass(animElementoSlider);
                    mostrarNuevoImagenSlider(index + direccion);
                }).removeClass("activo");
                var anim2 = claseAnimacionAleatoria();
                $(".infoSlider").eq(index).addClass(anim2);
                $(".infoSlider").eq(index).slideUp(duracion2, function () {
                    $(".infoSlider").eq(index).removeClass(anim2);
                    mostrarNuevoInfoSlider(index + direccion);
                }).removeClass("activo");
            }
        })
    }
}

function mostrarNuevoImagenSlider(indice) {
    if (indice == -1) {
        indice = $(".imagenSlider").size() - 1;
    } else if (indice == $(".imagenSlider").size()) {
        indice = 0;
    }
    $(".imagenSlider").eq(indice).fadeIn(duracion2).addClass("activo");
}

function mostrarNuevoInfoSlider(indice) {
    if (indice == -1) {
        indice = $(".imagenSlider").size() - 1;
    } else if (indice == $(".imagenSlider").size()) {
        indice = 0;
    }
    $(".infoSlider").eq(indice).slideDown(duracion2+100, function () {
        $(this).addClass("activo");
        if (!intervaloRun) {
            iniciarIntervalo();
        }
    });
}

function claseAnimacionAleatoria(){
    var numero = Math.round(Math.random()*2);
    return 'animacion'+(numero+1);
}