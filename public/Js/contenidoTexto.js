/**
 * Created by Jose Luis on 21/03/2016.
 */
/**
 * MANEJO DE LAS PROPIEDADES DE LOS CONTROLLES
 */
function establecerPropiedadesTitulo(id, id_form){
    var elemento = $("#"+id);
    if(agregarClaseMedidas(elemento,id_form)){
            if(agregarPaddings(elemento,id_form)){
                establecerTexto(elemento,id_form);
                agregarFontColor(elemento,id_form);
                agregarBorderColor(elemento,id_form);
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

function establecerPropiedadesParrafo(id, id_form){
    var elemento = $("#"+id);
    if(agregarClaseMedidas(elemento,id_form)){
            if(agregarPaddings(elemento,id_form)){
                establecerTexto(elemento,id_form);
                agregarFontColor(elemento,id_form);
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

function establecerPropiedadesLink(id, id_form){
    var elemento = $("#"+id);
    if(agregarPaddings(elemento,id_form)){
        establecerTexto(elemento,id_form);
        establecerHref(elemento,id_form);
        agregarFontColor(elemento,id_form);
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

/**
 *  GENERADORES DE HTML
 */

function nuevoTitulo(){
    cantidad_titulos++;
    $("#cant-titulos").val(cantidad_titulos);
    //formActual = "propiedades-titulo-"+cantidad_titulos;
    //numFormActual = cantidad_titulos;
    /*var html = "<div class='col s12 m12 l12 contenido-contenedor' style='padding:0px !important;' id='contenedor-"+cantidad_titulos+"'>"
        +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-contenedor-',"+cantidad_titulos+",'contenedor') class='col s12 modal-trigger contenido-btn-propiedades' id='btn-propiedades-contenedor-"+cantidad_titulos+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Contenedor "+cantidad_titulos+"'></i></a>"
        +"</div>";*/

    var html = "<p class='col s12 m12 l12 contenido-titulo tituloPrincipalPag tituloMediano' style='padding:0px !important;' id='titulo-"+cantidad_titulos+"'>"
        +"<a class='contenido-btn-eliminar contenedor-btn-elemento'>"
            +"<i class='fa fa-trash-o right tooltipped red-text text-darken-2' data-position='bottom' data-delay='50' data-tooltip='Eliminar Título "+cantidad_titulos+"'></i>"
        +"</a>"
        +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-titulo-',"+cantidad_titulos+",'titulo') class='modal-trigger contenido-btn-propiedades contenedor-btn-elemento' id='btn-propiedades-titulo-"+cantidad_titulos+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Titulo "+cantidad_titulos+"'></i></a>"
        +"<span>Nuevo título</span></p>";

    $("#contenedor-1").append(html);
    nuevoModalTitulo();
    iniciarModal();
    //$("btn-propiedades-contenedor-"+cantidad_titulos).click();
}

function nuevoModalTitulo(){
    //var htmlSelect = htmlSelectContenedores();
    var htmlSelect = "<select id='select-contenedor'></select>";
    html = "<form id='propiedades-titulo-"+cantidad_titulos+"'>"
    +"<p class='tituloPrincipalPag titulo'>Propiedades del título "+cantidad_titulos+"</p>"
    +"<p class='texto-informacion-medium'>Seleccione el contenedor dentro del cual debe estar este título</p>"
    +"<div id='contenedor-select' class='col s12'>"+htmlSelect+"</div>"
    +"<p class='texto-informacion-medium'>Seleccione las medidas del titulo en los diferentes tipos de pantalla. El ancho total de todas las pantallas es de 12 columnas, las cuales se dividen proporcionalmente de acuerdo al ancho en pixeles de la pantalla, de la misma manera trabaja cada contenedor incluido en su interfaz.</p>"
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

    +"<p class='texto-informacion-medium'>Establezca el tamaño del relleno (en pixeles) de cada uno de los lados del título.</p>"

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
    +"<label for='texto' class='active'>Establezca el texto del titulo.</label>"
    +"<input type='text' value='Nuevo título' class='' id='texto'>"
    +"</div>"

    +"<p class='texto-informacion-medium'>Establezca el color del texto en el título.</p>"

    +"<div class='input-field col s12'>"
    +"<input type='text' value='' readonly='readonly' class='kolorPicker col s2 m1'>"
    +"<input type='hidden' value='#238276' id='color'>"
    +"<div class='view-color col s10 m11'>.</div>"
    +"</div>"

    +"<p class='texto-informacion-medium'>Establezca el color del borde en el título.</p>"

    +"<div class='input-field col s12'>"
    +"<input type='text' value='' readonly='readonly' class='kolorPicker col s2 m1'>"
    +"<input type='hidden' value='#FF9F49' id='border-color'>"
    +"<div class='view-border-color col s10 m11'>.</div>"
    +"</div>"

    +"</form>"
    +"<div id='contenido-footer-prop-titulo-"+cantidad_titulos+"'><a href='#!' class='modal-action waves-effect waves-teal btn-flat ' onclick=establecerPropiedadesTitulo('titulo-"+cantidad_titulos+"','propiedades-titulo-"+cantidad_titulos+"')>Guardar</a></div>";

    $("#contenedor-modals").append(html);
}

function nuevoParrafo(){
    cantidad_parrafos++;
    $("#cant-parrafos").val(cantidad_parrafos);
    //formActual = "propiedades-parrafo-"+cantidad_parrafos;
    //numFormActual = cantidad_parrafos;
    /*var html = "<div class='col s12 m12 l12 contenido-contenedor' style='padding:0px !important;' id='contenedor-"+cantidad_titulos+"'>"
     +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-contenedor-',"+cantidad_titulos+",'contenedor') class='col s12 modal-trigger contenido-btn-propiedades' id='btn-propiedades-contenedor-"+cantidad_titulos+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Contenedor "+cantidad_titulos+"'></i></a>"
     +"</div>";*/

    var html = "<p class='col s12 m12 l12 contenido-parrafo texto-informacion-medium' style='padding:0px !important;' id='parrafo-"+cantidad_parrafos+"'>"
        +"<a class='contenido-btn-eliminar contenedor-btn-elemento'>"
            +"<i class='fa fa-trash-o right tooltipped red-text text-darken-2' data-position='bottom' data-delay='50' data-tooltip='Eliminar Parrafo "+cantidad_parrafos+"'></i>"
        +"</a>"
        +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-parrafo-',"+cantidad_parrafos+",'parrafo') class='modal-trigger contenido-btn-propiedades contenedor-btn-elemento' id='btn-propiedades-parrafo-"+cantidad_parrafos+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Parrafo "+cantidad_parrafos+"'></i></a>"
        +"<span>Nuevo párrafo</span></p>";

    $("#contenedor-1").append(html);
    nuevoModalParrafo();
    iniciarModal();
    //$("btn-propiedades-contenedor-"+cantidad_titulos).click();
}

function nuevoModalParrafo(){
    //var htmlSelect = htmlSelectContenedores();
    var htmlSelect = "<select id='select-contenedor'></select>";
    html = "<form id='propiedades-parrafo-"+cantidad_parrafos+"'>"
    +"<p class='tituloPrincipalPag titulo'>Propiedades del párrafo "+cantidad_parrafos+"</p>"
    +"<p class='texto-informacion-medium'>Seleccione el contenedor dentro del cual debe estar este párrafo</p>"
    +"<div id='contenedor-select' class='col s12'>"+htmlSelect+"</div>"
    +"<p class='texto-informacion-medium'>Seleccione las medidas del párrafo en los diferentes tipos de pantalla. El ancho total de todas las pantallas es de 12 columnas, las cuales se dividen proporcionalmente de acuerdo al ancho en pixeles de la pantalla, de la misma manera trabaja cada contenedor incluido en su interfaz.</p>"
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

    +"<p class='texto-informacion-medium'>Establezca el tamaño del relleno (en pixeles) de cada uno de los lados del título.</p>"

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
    +"<label for='texto' class='active'>Establezca el texto del párrafo.</label>"
    +"<textarea class='materialize-textarea' id='texto'>Nuevo párrafo</textarea>"
    +"</div>"

    +"<p class='texto-informacion-medium'>Establezca el color del texto en el párrafo.</p>"

    +"<div class='input-field col s12'>"
    +"<input type='text' value='' readonly='readonly' class='kolorPicker col s2 m1'>"
    +"<input type='hidden' value='#000900' id='color'>"
    +"<div class='view-color-background col s10 m11'>.</div>"
    +"</div>"

    +"</form>"
    +"<div id='contenido-footer-prop-parrafo-"+cantidad_parrafos+"'><a href='#!' class='modal-action waves-effect waves-teal btn-flat ' onclick=establecerPropiedadesParrafo('parrafo-"+cantidad_parrafos+"','propiedades-parrafo-"+cantidad_parrafos+"')>Guardar</a></div>";

    $("#contenedor-modals").append(html);
}

function nuevoLink(){
    cantidad_links++;
    $("#cant-links").val(cantidad_links);
    //formActual = "propiedades-parrafo-"+cantidad_parrafos;
    //numFormActual = cantidad_parrafos;
    /*var html = "<div class='col s12 m12 l12 contenido-contenedor' style='padding:0px !important;' id='contenedor-"+cantidad_titulos+"'>"
     +"<a href='#modal-propiedades' onclick=establecerFormActual('propiedades-contenedor-',"+cantidad_titulos+",'contenedor') class='col s12 modal-trigger contenido-btn-propiedades' id='btn-propiedades-contenedor-"+cantidad_titulos+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Contenedor "+cantidad_titulos+"'></i></a>"
     +"</div>";*/

    var html = "<a href='http://gestionproyectos.ticscomercio.edu.co/' target='_blank' class='contenido-link texto-informacion-medium' style='display: inline-block;padding:0px !important; color: #009efe;' id='link-"+cantidad_links+"'>"
        +"<p class='contenido-btn-eliminar contenedor-btn-elemento'>"
            +"<i class='fa fa-trash-o right tooltipped red-text text-darken-2' data-position='bottom' data-delay='50' data-tooltip='Eliminar Link "+cantidad_links+"'></i>"
        +"</p>"
        +"<p href='#modal-propiedades' onclick=establecerFormActual('propiedades-link-',"+cantidad_links+",'link') class='modal-trigger contenido-btn-propiedades contenedor-btn-elemento' id='btn-propiedades-link-"+cantidad_links+"'><i class='fa fa-cog right tooltipped' data-position='bottom' data-delay='50' data-tooltip='Propiedades Link "+cantidad_links+"'></i></p>"
        +"<span>Nuevo Link</span></a>";

    $("#contenedor-1").append(html);
    nuevoModalLink();
    iniciarModal();
    //$("btn-propiedades-contenedor-"+cantidad_titulos).click();
}

function nuevoModalLink(){
    //var htmlSelect = htmlSelectContenedores();
    var htmlSelect = "<select id='select-contenedor'></select>";
    html = "<form id='propiedades-link-"+cantidad_links+"'>"
    +"<p class='tituloPrincipalPag titulo'>Propiedades del link "+cantidad_links+"</p>"
    +"<p class='texto-informacion-medium'>Seleccione el contenedor dentro del cual debe estar este link</p>"
    +"<div id='contenedor-select' class='col s12'>"+htmlSelect+"</div>"

    +"<p class='texto-informacion-medium'>Establezca el tamaño del relleno (en pixeles) de cada uno de los lados del link.</p>"

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
    +"<label for='texto' class='active'>Establezca texto a mostrar en el link</label>"
    +"<input type='text' value='Nuevo Link' class='' id='texto'>"
    +"</div>"

    +"<div class='input-field col s12'>"
    +"<label for='textoHref' class='active'>Establezca la url que se debe abrir</label>"
    +"<input type='text' value='http://gestionproyectos.ticscomercio.edu.co/' class='' id='textoHref'>"
    +"</div>"



    +"<p class='texto-informacion-medium'>Establezca el color del texto en el link.</p>"

    +"<div class='input-field col s12'>"
    +"<input type='text' value='' readonly='readonly' class='kolorPicker col s2 m1'>"
    +"<input type='hidden' value='#009efe' id='color'>"
    +"<div class='view-color-background col s10 m11'>.</div>"
    +"</div>"

    +"</form>"
    +"<div id='contenido-footer-prop-link-"+cantidad_links+"'><a href='#!' class='modal-action waves-effect waves-teal btn-flat ' onclick=establecerPropiedadesLink('link-"+cantidad_links+"','propiedades-link-"+cantidad_links+"')>Guardar</a></div>";

    $("#contenedor-modals").append(html);
}

