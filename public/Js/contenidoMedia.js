/**
 * Created by Jose Luis on 26/03/2016.
 */
function establecerPropiedadesImagen(id, id_form){
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
        }
    }
}

function nuevaImagen(){
    cantidad_imagenes++;
    $("#cant-imagenes").val(cantidad_imagenes);
    //formActual = "propiedades-imagen-"+cantidad_imagenes;
    //numFormActual = cantidad_imagenes;
    /*var html = "<div class='col s12 m12 l12 contenido-contenedor' style='padding:0px !important;' id='contenedor-"+cantidad_titulos+"'>"
     +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-contenedor-',"+cantidad_titulos+",'contenedor') class='col s12 modal-trigger contenido-btn-propiedades' id='btn-propiedades-contenedor-"+cantidad_titulos+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Contenedor "+cantidad_titulos+"'></i></a>"
     +"</div>";*/

    var html = "<div class='col s12 m12 l12 contenido-imagen' style='background-color:#FFFFFF;'>"
        +"<a class='contenido-btn-eliminar contenedor-btn-elemento'>"
        +"<i class='fa fa-trash-o right tooltipped red-text text-darken-2' data-position='bottom' data-delay='50' data-tooltip='Eliminar Imagen "+cantidad_imagenes+"'></i>"
        +"</a>"
        +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-imagen-',"+cantidad_imagenes+",'imagen') class='modal-trigger contenido-btn-propiedades contenedor-btn-elemento' id='btn-propiedades-imagen-"+cantidad_imagenes+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Imagen "+cantidad_imagenes+"'></i></a>"
        +"<img src='https://lh3.googleusercontent.com/4du0mHj8w1qda63UqiOfrpcyniJwHdcEa2J0LltTSB0Y8KKx138zmuZUS26G-C6I2Ve17w' class='' style='width:100% !important; background-color: transparent;' id='imagen-"+cantidad_imagenes+"'>"
        +"</div>";

    $("#contenedor-1").append(html);
    nuevoModalImagen();
    iniciarModal();
    //$("btn-propiedades-contenedor-"+cantidad_titulos).click();
}


function nuevoModalImagen(){
    //var htmlSelect = htmlSelectContenedores();
    var htmlSelect = "<select id='select-contenedor'></select>";
    html = "<form id='propiedades-imagen-"+cantidad_imagenes+"'>"
    +"<p class='tituloPrincipalPag titulo'>Propiedades del imagen "+cantidad_imagenes+"</p>"
    +"<p class='texto-informacion-medium'>Seleccione el contenedor dentro del cual debe estar esta imagen</p>"
    +"<div id='contenedor-select' class='col s12'>"+htmlSelect+"</div>"
    +"<p class='texto-informacion-medium'>Seleccione las medidas de la imagen en los diferentes tipos de pantalla. El ancho total de todas las pantallas es de 12 columnas, las cuales se dividen proporcionalmente de acuerdo al ancho en pixeles de la pantalla, de la misma manera trabaja cada contenedor incluido en su interfaz.</p>"
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

    +"<p class='texto-informacion-medium'>Establezca el tamaño del relleno (en pixeles) de cada uno de los lados de la imagen.</p>"

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
    +"<label for='textoSrc' class='active'>Establezca la url donde se encuentra la imagen.</label>"
    +"<input type='text' value='https://lh3.googleusercontent.com/4du0mHj8w1qda63UqiOfrpcyniJwHdcEa2J0LltTSB0Y8KKx138zmuZUS26G-C6I2Ve17w' class='' id='textoSrc'>"
    +"</div>"

    +"<p class='texto-informacion-medium'>Establezca el color de fondo del contenedor de la imagen.</p>"

    +"<div class='input-field col s12'>"
    +"<input type='text' value='' readonly='readonly' class='kolorPicker col s2 m1'>"
    +"<input type='hidden' value='#FFFFFF' id='background-color'>"
    +"<div class='view-color-background col s10 m11'>.</div>"
    +"</div>"

    +"</form>"
    +"<div id='contenido-footer-prop-imagen-"+cantidad_imagenes+"'><a href='#!' class='modal-action waves-effect waves-teal btn-flat ' onclick=establecerPropiedadesImagen('imagen-"+cantidad_imagenes+"','propiedades-imagen-"+cantidad_imagenes+"')>Guardar</a></div>";

    $("#contenedor-modals").append(html);
}