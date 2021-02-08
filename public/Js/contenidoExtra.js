/**
 * Created by Jose Luis on 29/03/2016.
 */
$(function(){
    resizeIFrame();
    $( window ).resize(function() {
        resizeIFrame();
    });
})

function resizeIFrame(){
    if($(".iframe-content").length){
        $(".iframe-content").each(function(index) {
            var ancho = $(".iframe-content").eq(index).css("width").split('px')[0];
            var alto = (ancho * 2) / 3;
            $(".iframe-content").eq(index).css("height",alto+"px");
        })
    }
}

function establecerPropiedadesIFrame(id, id_form){
    var elemento = $("#"+id);
    if(agregarClaseMedidas($(elemento).parent(),id_form)){
        if(agregarPaddings($(elemento).parent(),id_form)){
            establecerSrc(elemento,id_form);
            agregarBackgroundColor($(elemento).parent(),id_form);
            var numElement = 1;
            if($("#"+id_form+" #select-contenedor")){
                numElement = $("#"+id_form+" #select-contenedor").val();
            }
            moverElemento($(elemento).parent(),numElement);
            limpiarModal();
            ocultarModal();
            iniciarModal();
            resizeIFrame();
        }
    }
}

function nuevoIFrame(){
    cantidad_contenido_externo++;
    $("#cant-contenido-externo").val(cantidad_contenido_externo);
    //formActual = "propiedades-iframe-"+cantidad_contenido_externo;
    //numFormActual = cantidad_contenido_externo;
    /*var html = "<div class='col s12 m12 l12 contenido-contenedor' style='padding:0px !important;' id='contenedor-"+cantidad_titulos+"'>"
     +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-contenedor-',"+cantidad_titulos+",'contenedor') class='col s12 modal-trigger contenido-btn-propiedades' id='btn-propiedades-contenedor-"+cantidad_titulos+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Contenedor "+cantidad_titulos+"'></i></a>"
     +"</div>";*/

    var html = "<div class='col s12 m12 l12 contenido-iframe iframe-content' style='background-color:#FFFFFF;'>"
        +"<a class='contenido-btn-eliminar contenedor-btn-elemento'>"
        +"<i class='fa fa-trash-o right tooltipped red-text text-darken-2' data-position='bottom' data-delay='50' data-tooltip='Eliminar Contenido Externo "+cantidad_contenido_externo+"'></i>"
        +"</a>"
        +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-iframe-',"+cantidad_contenido_externo+",'iframe') class='modal-trigger contenido-btn-propiedades contenedor-btn-elemento' id='btn-propiedades-iframe-"+cantidad_contenido_externo+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Contenido Externo "+cantidad_contenido_externo+"'></i></a>"
        +"<iframe class='col s12 m6 l12' src='https://www.youtube.com/embed/3vJ2Xq8YrmI' frameborder='0' allowfullscreen style='width:100% !important; height: 100% !important; background-color: transparent;' id='iframe-"+cantidad_contenido_externo+"'></iframe>"
        +"</div>";

    $("#contenedor-1").append(html);
    nuevoModalIFrame();
    iniciarModal();
    resizeIFrame();
    //$("btn-propiedades-contenedor-"+cantidad_titulos).click();
}


function nuevoModalIFrame(){
    //var htmlSelect = htmlSelectContenedores();
    var htmlSelect = "<select id='select-contenedor'></select>";
    html = "<form id='propiedades-iframe-"+cantidad_contenido_externo+"'>"
    +"<p class='tituloPrincipalPag titulo'>Propiedades del contenido externo "+cantidad_contenido_externo+"</p>"
    +"<p class='texto-informacion-medium'>Seleccione el contenedor dentro del cual debe estar esta iframe</p>"
    +"<div id='contenedor-select' class='col s12'>"+htmlSelect+"</div>"
    +"<p class='texto-informacion-medium'>Seleccione las medidas del contenido externo en los diferentes tipos de pantalla. El ancho total de todas las pantallas es de 12 columnas, las cuales se dividen proporcionalmente de acuerdo al ancho en pixeles de la pantalla, de la misma manera trabaja cada contenedor incluido en su interfaz.</p>"
    +"<div class='col s12 m4'>"
    +"<label>Pantalla pequeña</label>"
    +"<input id='clase-ancho-s' type='number' value='12' class='validate' min='1' max='12'>"
    +"</div>"

    +"<div class='col s12 m4'>"
    +"<label>Pantalla mediana</label>"
    +"<input id='clase-ancho-m' type='number' value='12' class='validate' min='1' max='12'>"
    +"</div>"

    +"<div class='col s12 m4'>"
    +"<label>Pantalla grande</label>"
    +"<input id='clase-ancho-l' type='number' value='12' class='validate' min='1' max='12'>"
    +"</div>"

    +"<p class='texto-informacion-medium'>Establezca el tamaño del relleno (en pixeles) de cada uno de los lados del contenido externo.</p>"

    +"<div class='input-field col s6 m3'>"
    +"<i class='prefix fa fa-hand-o-left texto-informacion-medium'></i>"
    +"<input id='input-padding-left' type='number' value='0' class='validate' min='0'>"
    +"</div>"

    +"<div class='input-field col s6 m3'>"
    +"<i class='prefix fa fa-hand-o-down texto-informacion-medium'></i>"
    +"<input id='input-padding-down' type='number' value='0' class='validate' min='0'>"
    +"</div>"

    +"<div class='input-field col s6 m3'>"
    +"<i class='prefix fa fa-hand-o-right texto-informacion-medium'></i>"
    +"<input id='input-padding-right' type='number' value='0' class='validate' min='0'>"
    +"</div>"

    +"<div class='input-field col s6 m3'>"
    +"<i class='prefix fa fa-hand-o-up texto-informacion-medium'></i>"
    +"<input id='input-padding-up' type='number' value='0' class='validate' min='0'>"
    +"</div>"

    +"<div class='input-field col s12'>"
    +"<label for='textoSrc' class='active'>Establezca la url donde se encuentra el contenido externo.</label>"
    +"<input type='text' value='https://www.youtube.com/embed/3vJ2Xq8YrmI' class='' id='textoSrc'>"
    +"</div>"

    +"<p class='texto-informacion-medium'>Establezca el color de fondo.</p>"

    +"<div class='input-field col s12'>"
    +"<input type='text' value='' readonly='readonly' class='kolorPicker col s2 m1'>"
    +"<input type='hidden' value='#FFFFFF' id='background-color'>"
    +"<div class='view-color-background col s10 m11'>.</div>"
    +"</div>"

    +"</form>"
    +"<div id='contenido-footer-prop-iframe-"+cantidad_contenido_externo+"'><a href='#!' class='modal-action waves-effect waves-teal btn-flat ' onclick=establecerPropiedadesIFrame('iframe-"+cantidad_contenido_externo+"','propiedades-iframe-"+cantidad_contenido_externo+"')>Guardar</a></div>";

    $("#contenedor-modals").append(html);
}
