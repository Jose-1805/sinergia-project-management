var cantidad_contenedores = 1;
var cantidad_titulos = 0;
var cantidad_parrafos = 0;
var cantidad_links = 0;
var cantidad_imagenes = 0;
var cantidad_contenido_externo = 0;
var formActual = "propiedades-contenedor-1";
var nameFormActual ="propiedades-contenedor-";
var numFormActual = 1;
var actualObject = "contenedor";
var modalPropiedades = true;

$(function(){
    iniciarModal();
    $("#contenido").on("click","a",function(event){
        event.preventDefault();
    })
    $("table").removeClass("striped");

    //SE INICIALIZAN LOS CONTADORES
    inicializarContadores();

    $("#btn-propiedades-contenedor-1").click();
    //$("#modal-ancho-contenedor").openModal();

    $("#btn-guardar-contenido").click(function(){
        guardarContenido();
    })


    $("#contenido").on("click",".contenido-btn-eliminar",function(){
        if(confirm("¿Esta seguro de eliminar el elemento?")){
            $(this).parent().remove();
        }
    })

    $(".cambiar-estado-contenido").click(function(){
        var id = $(this).parent().parent().data("contenido");
        var url = $("#base_url").val()+"/contenido/cambiar-estado";
        var params = {"id":id,"_token":$("#_token").val()};
        $.post(url,params,function(data){
            if(data == "1" || data == 1){
                window.location.reload();
            }else{
                lanzarMensaje("Error", "Ocurrio un error con la información enviada.", 5000, 2);
            }
        })
    })

    $("#contenidos").change(function(){
        if($(this).val() == "numero"){
            $(".cantidad-mostrar").removeClass("invisible");
        }else{
            $(".cantidad-mostrar").addClass("invisible");
        }
    })

    $("#btn-previsualizar-contenidos").click(function(){
        var cantidad = 1;
        var validCantidad = false;
        if($("#contenidos").val() == "numero"){
            if($.isNumeric($("#cantidad_mostrar").val())){
                if($("#cantidad_mostrar").val() % 1 == 0){
                    cantidad = $("#cantidad_mostrar").val();
                    validCantidad = true;
                }
            }
        }else{
            validCantidad = true;
        }

        if(validCantidad) {
            $(".progress").removeClass("invisible");
            $("#contenedor-lista").addClass("invisible");
            var params = {"contenidos": $("#contenidos").val(), "cantidad_mostrar": cantidad,"editar":-1,"estado":-1, "_token": $("#_token").val()};
            var url = $("#base_url").val() + "/contenido/list";
            $.post(url,params,function(data){
                $("#contenedor-lista").html(data);
                $(".progress").addClass("invisible");
                $("#contenedor-lista").removeClass("invisible");
            })

        }else{
            lanzarMensaje("Error","El valor ingresado en el campo cantidad es incorrecto",5000,2);
        }

    })

    $("#btn-guardar-conf-contenidos").click(function(){
        var cantidad = 1;
        var validCantidad = false;
        if($("#contenidos").val() == "numero"){
            if($.isNumeric($("#cantidad_mostrar").val())){
                if($("#cantidad_mostrar").val() % 1 == 0){
                    cantidad = $("#cantidad_mostrar").val();
                    validCantidad = true;
                }
            }
        }else{
            validCantidad = true;
        }

        if(validCantidad) {
            $(".progress").removeClass("invisible");
            $("#contenedor-lista").addClass("invisible");
            var params = {"contenidos": $("#contenidos").val(), "cantidad_mostrar": cantidad,"_token": $("#_token").val()};
            var url = $("#base_url").val() + "/contenido/save-conf";
            $.post(url,params,function(data){
                $("#contenedor-lista").removeClass("invisible");if(data == "1" || data == 1){
                    window.location.reload();
                }else{
                    $(".progress").addClass("invisible");
                    lanzarMensaje("Error", "Ocurrio un error con la información enviada.", 5000, 2);
                }
            })

        }else{
            lanzarMensaje("Error","El valor ingresado en el campo cantidad es incorrecto",5000,2);
        }

    })

    /*alert("Contenedores: "+cantidad_contenedores
    +"   Titulos: "+cantidad_titulos
    +"   Parrafos: "+cantidad_parrafos);*/
})

function inicializarContadores(){
    cantidad_contenedores = $("#cant-contenedores").val();
    cantidad_titulos = $("#cant-titulos").val();
    cantidad_parrafos = $("#cant-parrafos").val();
    cantidad_links = $("#cant-links").val();
    cantidad_imagenes = $("#cant-imagenes").val();
    cantidad_contenido_externo = $("#cant-contenido-externo").val();
}
function establecerFormActual(name,numero,nameObject){
    formActual = name+""+numero;
    numFormActual = numero;
    nameFormActual = name;
    actualObject = nameObject;
    modalPropiedades = true;
}


function iniciarModal(){
    $('.modal-trigger').leanModal({
            dismissible: true,
            opacity: .5,
            in_duration: 300,
            out_duration: 200,
            ready: function() {
                var capa = $(".lean-overlay").eq(0);
                var padre = $(".lean-overlay").eq(0).parent();
                $(".lean-overlay").remove();
                $(capa).appendTo($(padre));
                $(".lean-overlay").prop("style", "display: block;opacity: .5;z-index:10000 !important;");
                if(modalPropiedades) {
                    $("#" + formActual).appendTo($("#modal-propiedades .modal-content").eq(0));
                    $("#contenido-footer-prop-" + actualObject + "-" + numFormActual).appendTo($("#modal-propiedades .modal-footer").eq(0));
                    establecerSelect();
                    inicializarMaterializacss();
                    cargarPropiedades();
                    // },3000);
                }
            }, // Callback for Modal open
            complete: function() {
                ocultarModal();
                if(modalPropiedades) {
                    limpiarModal();
                }
            } // Callback for Modal close
        }
    );

    $(".lean-overlay").click(function(event){
        ocultarModal();
    })

}

function limpiarModal(){
    $("#"+formActual).appendTo($("#contenedor-modals"));
    $("#contenido-footer-prop-"+actualObject+"-"+numFormActual).appendTo($("#contenedor-modals"));
    $("#modal-propiedades .modal-content").eq(0).html("");
    $("#modal-propiedades .modal-footer").eq(0).html("");
    modalPropiedades = false;
}


function moverElemento(elemento,numeroContenedor){
    var padre = $(elemento).parent();//contenedor del elemento
    if($(padre).attr('id') != "contenedor-"+numeroContenedor) {//si no es el mismo div
        if(destinoEsHijo(elemento,numeroContenedor)){
            var btnProp = $(elemento).children(".contenido-btn-propiedades").eq(0);
            var copiaBtn = btnProp;
            $(btnProp).remove();
            var html = $(elemento).html();
            $(elemento).html("");
            $(elemento).parent().append(html);
            $(elemento).appendTo($("#contenedor-" + numeroContenedor));
            $(copiaBtn).appendTo($(elemento));
        }else{
            if ($(elemento).attr("id") != "contenedor-1" && $(elemento).attr("id") != "contenedor-" + numeroContenedor && typeof(numeroContenedor) != undefined) {
                $(elemento).appendTo($("#contenedor-" + numeroContenedor));
            }
        }
    }
}

/**
 * Determiona si el div de deestino del elemento esta incluido en el elemento
 * @param elemento
 * @param numeroContenedor -> numero del contenedor a donde se envia el div
 */
function destinoEsHijo(elemento,numeroContenedor){
    //alert("Revisando contenido en "+$(elemento).attr('id'));
    var boolReturn = false;
    $(elemento).children(".contenido-contenedor").each(function(index){
        if($(elemento).children(".contenido-contenedor").eq(index).attr("id") == "contenedor-"+numeroContenedor){
            //alert("Es hijo retorno true");
            boolReturn = true;
        }else{
            if(destinoEsHijo($(elemento).children(".contenido-contenedor").eq(index),numeroContenedor)){

                //alert("Es hijo retorno true 2");
                boolReturn = true;
            }
        }
    })


    //alert("No es hijo retorno false");
    return boolReturn;
}

function agregarPaddings(elemento,id_form){
    if(validInputPaddings(id_form,true)) {
        var l = $("#"+id_form+" #input-padding-left").val();
        var d = $("#"+id_form+" #input-padding-down").val();
        var r = $("#"+id_form+" #input-padding-right").val();
        var u = $("#"+id_form+" #input-padding-up").val();

        $(elemento).css({"padding-left":l+"px"});
        $(elemento).css({"padding-bottom":d+"px"});
        $(elemento).css({"padding-right":r+"px"});
        $(elemento).css({"padding-top":u+"px"});
        return true;
    }
    return false;
}

//todos los valores de padding deben ser mayores o iguales a 0
function validInputPaddings(id_form,msj){
    var l = $("#"+id_form+" #input-padding-left").val();
    var d = $("#"+id_form+" #input-padding-down").val();
    var r = $("#"+id_form+" #input-padding-right").val();
    var u = $("#"+id_form+" #input-padding-up").val();
    var error = false;

    if(l < 0){
        error = true;
    }else if(d < 0){
        error = true;
    }else if(r < 0){
        error = true;
    }else if(u < 0){
        error = true;
    }

    if(msj && error){
        lanzarMensaje("Error","El valor de relleno no puede ser menor a 0",5000,2);
    }
    return !error;
}

function agregarBackgroundColor(elemento,id_form){
    $(elemento).css({"background-color":$("#"+id_form+" #background-color").val()});
    return true;
}
function agregarFontColor(elemento,id_form){
    $(elemento).css({"color":$("#"+id_form+" #color").val()});
    return true;
}
function agregarBorderColor(elemento,id_form){
    $(elemento).css({"border-color":$("#"+id_form+" #border-color").val()});
    return true;
}

//agrega las clases para determinar el ancho del objeto jquery en cada medida
function agregarClaseMedidas(elemento,id_form){
    var s = $("#"+id_form+" #clase-ancho-s").val();
    var m = $("#"+id_form+" #clase-ancho-m").val();
    var l = $("#"+id_form+" #clase-ancho-l").val();

    if(validClaseMedidas(id_form,true)){
        borrarClaseMedidas(elemento);
        $(elemento).addClass("s"+s);
        $(elemento).addClass("m"+m);
        $(elemento).addClass("l"+l);
        return true;
    }
    return false;
}

function borrarClaseMedidas(elemento){
      for(var i = 1;i < 13;i++){
          $(elemento).removeClass("s"+i);
          $(elemento).removeClass("m"+i);
          $(elemento).removeClass("l"+i);
      }
}


//Valida si el numero seleccionado para el ancho de un objeto
function validClaseMedidas(id_form,msj){
    var s = $("#"+id_form+" #clase-ancho-s").val();
    var m = $("#"+id_form+" #clase-ancho-m").val();
    var l = $("#"+id_form+" #clase-ancho-l").val();
    var error = false;

    if(s < 1 || s > 12){
        error = true;
    }else if(m < 1 || m > 12){
        error = true;
    }else if(l < 1 || l > 12){
        error = true;
    }

    if(msj && error){
        lanzarMensaje("Error","El valor del ancho debe estar entre 1 y 12",5000,2);
    }
    return !error;
}

function establecerTexto(elemento,id_form){
    var texto = $("#"+id_form+" #texto").val();

    $(elemento).children('span').eq(0).text(texto);
}

function establecerHref(elemento,id_form){
    var texto = $("#"+id_form+" #textoHref").val();

    $(elemento).attr('href',texto);
}

function establecerSrc(elemento,id_form){
    var texto = $("#"+id_form+" #textoSrc").val();
    $(elemento).attr('src',texto);
}

function establecerSelect(){
    var html = htmlSelectContenedores();
    //alert(htmlSelectContenedores());
    $("#propiedades-"+actualObject+"-"+numFormActual+" #contenedor-select").html(""+html);
    inicializarMaterializacss();
}


function htmlSelectContenedores(){
    var padre = $("#"+actualObject+"-"+numFormActual).parent();
    if(actualObject == "imagen" || actualObject == "iframe"){
        padre = $(padre).parent();
    }
    var id = $(padre).attr("id");
    var num_padre = id.split("-")[id.split("-").length - 1];
    var htmlOptions = "";
    //alert(actualObject+"-"+numFormActual);
    //return "<select><option>Opcion</option></select>";
    for(var e = 1;e <= cantidad_contenedores;e++ ){
        if(nameFormActual == "propiedades-contenedor-") {
            if (numFormActual != e) {
                if (e == num_padre) {
                    if ($("#contenedor-" + e).length) {
                        htmlOptions += "<option selected value='" + e + "'>Contenedor " + e + "</option>";
                    }
                } else {
                    if ($("#contenedor-" + e).length) {
                        htmlOptions += "<option value='" + e + "'>Contenedor " + e + "</option>";
                    }
                }
            }
        }else{
            if (e == num_padre) {
                if ($("#contenedor-" + e).length) {
                    htmlOptions += "<option selected value='" + e + "'>Contenedor " + e + "</option>";
                }
            } else {
                if ($("#contenedor-" + e).length) {
                    htmlOptions += "<option value='" + e + "'>Contenedor " + e + "</option>";
                }
            }
        }
    }

    var html = "<label>Contenedor</label>"
        +"<select id='select-contenedor'>"
        +htmlOptions
        +"</select>";
    return html;
}

function guardarContenido(){
    if(validSaveContenido(true)){
        $("#btn-guardar-contenido").addClass("invisible");
        $("#progress-guardar-contenido").removeClass("invisible");
        var url = $("#base_url").val()+"/contenido/save";
        var params = $("#form-guardar-contenido").serialize();

        $("#contenido-guardar").html($("#contenido").html());
        var htmlVista = generarHtmlGuardar($("#contenido-guardar"));
        $("#contenido-guardar").html("");

        var htmlContenidoEdicion = $("#contenido").html();
        var htmlContenidoModals = $("#contenedor-modals").html();
        //console.log(htmlContenidoModals);

        var htmlEdicion = "<div id='datos-elementos' class='invisible'>"+$("#datos-elementos").html()+"</div>" +
            "<div class='col s9 m11 l10 white z-depth-1' id='contenido'>"+htmlContenidoEdicion
            +"</div> "
            +"<div id='contenedor-modals'>"+htmlContenidoModals+"</div>";

        params += "&html="+htmlVista+"&htmlEdit="+htmlEdicion+"&_token="+$('#_token').val();
        if($("#contenido_id").val()){
            params += "&contenido_editar="+$("#contenido_id").val();
        }
        $.post(url,params,function(data){
            if(data == 1 || data == '1'){
                window.location.href = $("#base_url").val()+"/contenido/administrar";
            }else{
                lanzarMensaje("Error",data,6000,2);
            }
            $("#btn-guardar-contenido").removeClass("invisible");
            $("#progress-guardar-contenido").addClass("invisible");
        })

    }
}

function validSaveContenido(msj){
    if($("#nombre").val().length < 1){
        if(msj){
            lanzarMensaje("Error","Ingrese el nombre del contenido.",5000,2);
        }
        return false;
    }

    if(!$("#administrador").prop("checked") && !$("#evaluador").prop("checked") && !$("#investigador").prop("checked") && !$("#sin_sesion").prop("checked")){
        if(msj){
            lanzarMensaje("Error","Seleccione por lo menos un rol al cual mostrar el contenido.",5000,2);
        }
        return false;
    }
    return true;
}

function generarHtmlGuardar(contenedor){
    var contenedores = $(contenedor).find(".contenido-contenedor");
    var parrafos = $(contenedor).find(".contenido-parrafo");
    var titulos = $(contenedor).find(".contenido-titulo");
    var links = $(contenedor).find(".contenido-link");
    var imagenes = $(contenedor).find(".contenido-imagen");
    var iframes = $(contenedor).find(".contenido-iframe");
    quirarEtiquetas(contenedores);
    quirarEtiquetas(parrafos);
    quirarEtiquetas(titulos);
    quirarEtiquetas(links);
    quirarEtiquetas(imagenes);
    quirarEtiquetas(iframes);

    return $(contenedor).html();
}


function quirarEtiquetas(elements){
    for(var i = 0; i < elements.length;i++){
        $(elements[i]).children(".contenedor-btn-elemento").remove();
        $(elements[i]).attr("id","");
    }
}


function cargarPropiedades(){
    var obj = $("#"+actualObject+"-"+numFormActual);
    var form = $("#"+nameFormActual+""+numFormActual);

    if(actualObject == "titulo"){
        //texto del titulo
        loadTexto(form,obj);
        loadPaddings(form,obj);
        loadClasesAncho(form,obj);
    }else if(actualObject == "parrafo"){
        //texto del titulo
        loadTexto(form,obj);
        loadPaddings(form,obj);
        loadClasesAncho(form,obj);
    }else if(actualObject == "contenedor"){
        loadPaddings(form,obj);
        loadClasesAncho(form,obj);
    }else if(actualObject == "link"){
        //texto del titulo
        loadTexto(form,obj);
        loadPaddings(form,obj);
        loadHref(form,obj);
    }else if(actualObject == "iframe"){
        loadPaddings(form,$(obj).parent());
        loadSrc(form,obj);
        loadClasesAncho(form,$(obj).parent());
    }
}

function loadTexto(form,obj){
    $("#"+$(form).attr("id")+" #texto").val($("#"+$(obj).attr("id")+" span").text());
}

function loadHref(form,obj){
    $("#"+$(form).attr("id")+" #textoHref").val($("#"+$(obj).attr("id")).attr("href"));
}

function loadSrc(form,obj){
    $("#"+$(form).attr("id")+" #textoSrc").val($("#"+$(obj).attr("id")).attr("src"));
}

function loadSrc(form,obj){
    $("#"+$(form).attr("id")+" #textoSrc").val($("#"+$(obj).attr("id")).attr("src"));
}

function loadClasesAncho(form,obj){
    var clases = ["s","m","l"];
    var variables = [1,2,3,4,5,6,7,8,9,10,11,12];

    for(var i = 0; i < clases.length; i++){
        for(var e = 0; e < variables.length; e++){
            if($(obj).hasClass(clases[i]+""+variables[e])){
                $("#"+$(form).attr("id")+" #clase-ancho-"+clases[i]).val((variables[e]));
                break;
            }
        }
    }
}

function loadPaddings(form, obj){
    var left = $(obj).css("padding-left").split("px")[0];
    $("#"+$(form).attr("id")+" #input-padding-left").val(left);

    var down = $(obj).css("padding-bottom").split("px")[0];
    $("#"+$(form).attr("id")+" #input-padding-down").val(down);

    var right = $(obj).css("padding-right").split("px")[0];
    $("#"+$(form).attr("id")+" #input-padding-right").val(right);

    var up = $(obj).css("padding-top").split("px")[0];
    $("#"+$(form).attr("id")+" #input-padding-up").val(up);
}

