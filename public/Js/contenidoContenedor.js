/**
 * Created by Jose Luis on 21/03/2016.
 */
/**
 * MANEJO DE LAS PROPIEDADES DE LOS CONTROLLES
 */
function establecerPropiedadesContenedor(id, id_form){
    var elemento = $("#"+id);
    if(agregarClaseMedidas(elemento,id_form)){
        if(agregarBackgroundColor(elemento,id_form)){
            if(agregarPaddings(elemento,id_form)){
                var numElement = 1;
                if($("#"+id_form+" #select-contenedor")){
                    numElement = $("#"+id_form+" #select-contenedor").val();
                }
                moverElemento(elemento,numElement);
                limpiarModal();
                ocultarModal();
                iniciarModal();
            }
        }
    }
}

/**
 *  GENERADORES DE HTML
 */

function nuevoContenedor(){
    cantidad_contenedores++;
    $("#cant-contenedores").val(cantidad_contenedores);
    //formActual = "propiedades-contenedor-"+cantidad_contenedores;
    //numFormActual = cantidad_contenedores;
    var html = "<div class='col s12 m12 l12 contenido-contenedor' style='padding:0px !important; background-color:#ffffff;' id='contenedor-"+cantidad_contenedores+"'>"
            +"<a class='contenido-btn-eliminar contenedor-btn-elemento'>"
                +"<i class='fa fa-trash-o right tooltipped red-text text-darken-2' data-position='bottom' data-delay='50' data-tooltip='Eliminar Contenedor "+cantidad_contenedores+"'></i>"
            +"</a>"

            +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-contenedor-',"+cantidad_contenedores+",'contenedor') class='modal-trigger contenido-btn-propiedades contenedor-btn-elemento' id='btn-propiedades-contenedor-"+cantidad_contenedores+"'>"
                +"<i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Contenedor "+cantidad_contenedores+"'></i>"
            +"</a>"
        +"</div>";

    $("#contenedor-1").append(html);
    nuevoModalContenedor();
    iniciarModal();
    //$("btn-propiedades-contenedor-"+cantidad_contenedores).click();
}

function nuevoModalContenedor(){
    //var htmlSelect = htmlSelectContenedores();
    var htmlSelect = "<select id='select-contenedor'></select>";
    html = "<form id='propiedades-contenedor-"+cantidad_contenedores+"'>"
    +"<p class='tituloPrincipalPag titulo'>Propiedades del contenedor "+cantidad_contenedores+"</p>"
    +"<p class='texto-informacion-medium'>Seleccione el contenedor dentro del cual debe estar este contenedor</p>"
    +"<div id='contenedor-select' class='col s12'>"+htmlSelect+"</div>"
    +"<p class='texto-informacion-medium'>Seleccione las medidas del contenedor en los diferentes tipos de pantalla. El ancho total de todas las pantallas es de 12 columnas, las cuales se dividen proporcionalmente de acuerdo al ancho en pixeles de la pantalla, de la misma manera trabaja cada contenedor incluido en su interfaz.</p>"
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

    +"<p class='texto-informacion-medium'>Establezca el tamaño del relleno (en pixeles) de cada uno de los lados del contenedor.</p>"

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
    +"<input type='text' value='' readonly='readonly' class='kolorPicker col s2 m1'>"
    +"<input type='hidden' value='#FFFFFF' id='background-color'>"
    +"<div class='view-color-background col s10 m11'>.</div>"
    +"</div>"
    +"</form>"
    +"<div id='contenido-footer-prop-contenedor-"+cantidad_contenedores+"'><a href='#!' class='modal-action waves-effect waves-teal btn-flat ' onclick=establecerPropiedadesContenedor('contenedor-"+cantidad_contenedores+"','propiedades-contenedor-"+cantidad_contenedores+"')>Guardar</a></div>";

    $("#contenedor-modals").append(html);
}
