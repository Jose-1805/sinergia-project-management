/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $("#btnOcultarMensaje").click(function () {
        ocultarMensaje();
    });

    $('input').keypress(function (event) {
        evitarCaracteresEspeciales(event);
    })


    var rutaBtn = ".contenedorPrincipal .row .pagina .row .col .col .hide-on-small-only .col .col .col .btnPerfil";
    $('.divBody').on("click",rutaBtn,function () {
        if($(this).hasClass("modal-trigger")) {
            var titulo = $(this).children('h5').text();
            perfilSeleccionado = $(this).children('input').attr('value');
            $('.tituloPerfilSeleccionado').each(function(index){
                $('.tituloPerfilSeleccionado').eq(index).text(titulo);
            })
        }else{
            window.location.href = "/proyecto/perfil/"+$(this).children('input').attr('value');
        }
    })

    $(".comprimible").click(function(){
        if($(this).hasClass("truncate")){
           $(this).removeClass("truncate");
        }else{
            $(this).addClass("truncate");
        }
    })

    $(".logo").click(function(){
        window.location.href = $("#base_url").val();
    })
})

function evitarCaracteresEspeciales(event) {
    if ((String.fromCharCode(event.keyCode) == "/") || (String.fromCharCode(event.keyCode) == "#") || (String.fromCharCode(event.keyCode) == "\\") || (String.fromCharCode(event.keyCode) == "\"") || (String.fromCharCode(event.keyCode) == "'")) {
        event.preventDefault();
    }
}

function lanzarMensaje(titulo, mensaje, duracion, tipo) {
    $("#tituloMensaje").text(titulo);
    $("#contenidoMensaje").html(mensaje);
    var icono = $("#iconoMensaje");
    icono.removeClass();
    switch (tipo) {
        case 1:
            icono.addClass('fa fa-check-circle-o');
            icono.css('color', '#5eb319');
            break;

        case 2:
            icono.addClass('fa fa-close');
            icono.css('color', '#C40D0D');
            break;

        case 3:
            icono.addClass('fa fa-ban');
            icono.css('color', '#C40D0D');
            break;

        case 4:
            icono.addClass('fa fa-info-circle');
            icono.css('color', '#08c');
            break;

        case 5:
            icono.addClass('fa fa-question-circle');
            icono.css('color', '#08c');
            break;

        case 6:
            icono.addClass('fa fa-exclamation-circle');
            icono.css('color', '#238276');
            break;

        case 7:
            icono.addClass('fa fa-exclamation-triangle');
            icono.css('color', '#FC0');
            break;
    }

    $("#mensaje").fadeIn(800, function () {
        setTimeout(function () {
            ocultarMensaje()
        }, duracion);
    });
}

function ocultarMensaje() {
    $("#mensaje").fadeOut(800);
}

function ocultarModal() {
    $('.lean-overlay').slideUp(500);
    while($('.lean-overlay').length > 0){
        $('.lean-overlay').each(function(index){
            $('.lean-overlay').eq(index).remove();
        });
    }
    $('.modal').slideUp(500);
    $("body").css({"overflow":"auto"});
}

function eliminarSubModal() {
    $('.lean-overlay').eq(1).slideUp(500,function(){
        $('.lean-overlay').eq(1).remove();
    });
}

function recargarContenido(url, divAltern) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (resp) {
            resp = resp.split('<body>');
            if (resp.length > 1) {
                resp = resp[1].split('</body>');
            }

            resp = resp[0].split('<div class="divBody">');

            if (resp.length > 1) {
                resp = resp[1].split('</div><!--FIN DIVBODY-->');
            }

            if (divAltern != null) {
                $('#' + divAltern).html(resp[0]);
            } else {
                $('.divBody').html(resp[0]);
            }
            inicializarMaterializacss();
        }
    })
}

function validarCampoRequired(campo){
    if((typeof(campo) == "undefined") || (campo.length == 0)){
        return false;
    }else{
        return true;
    }
}
/*onscroll = function () {
    if (window.innerWidth > 680) {
        if (scrollY > '115') {
            $(".autoFixed").css({"position": "fixed", "top": "170px", "right": "9.2%", "width": "34%"});
        } else {
            $(".autoFixed").css({"position": "relative", "top": "0px", "right": "0px", "width": "41.66667%"});
        }
    } 
}*/

function mensajeValidationFalse(jqXHR){
        var data = JSON.parse(jqXHR.responseText);
        var errorText = "<ol>";
        for(var aux in data){
            errorText += "<li> "+data[aux] +"</li>";
        }
        errorText += "</ol>";
        lanzarMensaje("Error",errorText,8000,2);
}

/**
 *    Si el campo input esta vacio lo marca Rojo de lo contrario lo marca Verde
 *    @returns {boolean}
 *    true: Si el campo contiene algun dato.
 *    false: Si el campo esta vacio
 */
function validar(campo) {
    if (campo.val() != "") {
        campo.css("border-bottom", "5px solid green");
        return true;
    } else {
        campo.css("border-bottom", "5px solid red");
        return false;
    }
}

$(document).ready(
    function(){
        $('form').addClass("forms");
        $('table').addClass("highlight centered bordered striped responsive-table");
        //$('.nuevo').addClass("btn-floating");
        //$('.nuevo').hover(function(){
        //    $('.btnNew').toggle("btn-floating");
        //});
    }
);