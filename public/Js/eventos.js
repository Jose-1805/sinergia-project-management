/**
 * Created by Jose Luis on 10/03/2016.
 */
var cont_imagenes = 0;
$(function(){
    $("table").removeClass("striped");
    $(".cambiar-estado-evento").click(function(){
        var id = $(this).parent().parent().data("evento");
        var url = $("#base_url").val()+"/eventos/cambiar-estado";
        var params = {"id":id,"_token":$("#_token").val()};
        $.post(url,params,function(data){
            if(data == "1" || data == 1){
                window.location.reload();
            }else{
                lanzarMensaje("Error", "Ocurrio un error con la información enviada.", 5000, 2);
            }
        })
    })

    $("#eventos").change(function(){
        if($(this).val() == "numero"){
            $(".cantidad-mostrar").removeClass("invisible");
        }else{
            $(".cantidad-mostrar").addClass("invisible");
        }
    })

    $("#btn-previsualizar-eventos").click(function(){
        var cantidad = 1;
        var validCantidad = false;
        if($("#eventos").val() == "numero"){
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
            var params = {"eventos": $("#eventos").val(), "cantidad_mostrar": cantidad,"editar":-1,"estado":-1, "_token": $("#_token").val()};
            var url = $("#base_url").val() + "/eventos/list";
            $.post(url,params,function(data){
                $("#contenedor-lista").html(data);
                $(".progress").addClass("invisible");
                $("#contenedor-lista").removeClass("invisible");
            })

        }else{
            lanzarMensaje("Error","El valor ingresado en el campo cantidad es incorrecto",5000,2);
        }

    })

    $("#btn-guardar-conf-eventos").click(function(){
        var cantidad = 1;
        var validCantidad = false;
        if($("#eventos").val() == "numero"){
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
            var params = {"eventos": $("#eventos").val(), "cantidad_mostrar": cantidad,"_token": $("#_token").val()};
            var url = $("#base_url").val() + "/eventos/save";
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

    $("body").on("change",".imagen_evento",function(){
        var numero = 1;
        var data = $(this).attr('id').split('_');
        if(data.length >= 2){
            numero = data[data.length-1];
        }
        readURL(this, numero);
    })

    $("body").on("mouseover",".contenedor_img",function(){
        $(this).children(".btn-cerrar-img-evento").eq(0).removeClass("invisible");
    })

    $("body").on("mouseleave",".contenedor_img",function(){
        $(this).children(".btn-cerrar-img-evento").eq(0).addClass("invisible");
    })

    $("body").on("click",".btn-cerrar-img-evento", function(){
        $(this).parent().remove();
        reestablecerIndicesImg();
    })

    $(".btn-eliminar-imagen").click(function(){
        if(confirm("¿Esta seguro de eliminar esta imagen? Al eliminar la imagen la página se recargará.")){
            $("#fotos").slideUp(300,function(){
                $("#progress-fotos").removeClass('invisible');
                $("#contenedor-botones-editar-evento").addClass('invisible');
            })
            var evento = $(this).data('evento');
            var name = $(this).data('name');
            var token = $("#_token").val();
            var params = {"name":name,"evento":evento,"_token":token};
            var url = $("#base_url").val() + "/eventos/eliminar-imagen";
            $.post(url,params,function(data){
                if(data == '1' || data == 1){
                    window.location.reload();
                    /*url = $("#base_url").val() + "/eventos/view-fotos";
                    $.post(url,params,function(dat){
                        $("#fotos").html(dat);
                        $("#progress-fotos").addClass('invisible');
                        $("#contenedor-botones-editar-evento").removeClass('invisible');
                        $("#fotos").slideDown(300);
                    })*/
                }else{
                    lanzarMensaje('Error','Ocurrio un error al eliminar la imagen, por favor intente nuevante.',6000,2);
                }
            })
        }
    })
})

function readURL(input, numero) {
    var name = $(input).val();
    var data = name.split(".");
    var ext = data[data.length - 1];
    if(ext != "jpg" && ext != "jpeg" && ext != "png" && ext != "svg"){
        lanzarMensaje("Error","Las extenciones permitidas son (jpg, jpeg, png y svg)",6000,2);
        $('#preview_imagen_' + numero).attr('src', "");
        $('#preview_imagen_' + numero).addClass('invisible');
        $(input).val("");
    }else {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview_imagen_' + numero).attr('src', e.target.result);
                $('#preview_imagen_' + numero).removeClass('invisible');
            }

            reader.readAsDataURL(input.files[0]);
            inicializarMaterializacss();
        }
    }
}

function agregarImagen(){
    cont_imagenes++;
    /*var html = "<div class='contenedor_img'><input type='file' id='imagen_"+cont_imagenes+"' class='imagen_evento' data-numero='"+cont_imagenes+"'>"
                +"<img id='preview_imagen_"+cont_imagenes+"' width='100' height='100' class='invisible preview_imagen materialboxed'></div>";*/
        var html =  "<div class='col s12 m6 l4 contenedor_img'><i class='fa fa-times right invisible btn-cerrar-img-evento' style='cursor:pointer;' id='iconoMensaje'></i>"
                    +"<div class='file-field col s12'>"
                        +"<div class='col s12' style='text-align: center;'><img style='max-width:150px !important;' id='preview_imagen_"+cont_imagenes+"' class='invisible preview_imagen'></div>"
                        +"<div class='btn col s12'>"
                            +"<span>Seleccionar</span>"
                            +"<input type='file' id='imagen_"+cont_imagenes+"' name='imagen_"+cont_imagenes+"' class='imagen_evento'>"
                        +"</div>"

                        +"<div class='file-path-wrapper'>"
                            +"<input class='file-path validate' type='text'>"
                        +"</div>"
                    +"</div></div>";
        if(cont_imagenes % 3 == 0){
            html += "<div class='col s12 divider white hide-on-med-only divider-img'></div>";
        }

        if(cont_imagenes % 2 == 0){
            html += "<div class='col s12 divider white hide-on-large-only divider-img'></div>";
        }
    $("#contenedor-imagenes").append(html);
    //contenedor-imagenes

}

function reestablecerIndicesImg(){
    var contenedores = $(".contenedor_img");

    cont_imagenes = contenedores.length;
    var deleteAll = false;
    while(!deleteAll) {
        $(".divider-img").each(function (indice) {
            $(".divider-img").eq(indice).addClass("invisible");
            $(".divider-img").eq(indice).remove();
        })
        if($(".divider-img").length == 0){
            deleteAll = true;
        }
    }


    contenedores.each(function(indice){
        var contenedor = $(".contenedor_img").eq(indice);
        //contenedor.remove();
        //alert(contenedor.data('num'));
        if((indice +1)%3 == 0){
            contenedor.after("<div class='col s12 divider white hide-on-med-only divider-img'></div>");
        }

        if((indice +1)%2 == 0){
            contenedor.after("<div class='col s12 divider white hide-on-large-only divider-img'></div>");
        }

        var img = $(contenedor).children(".file-field").eq(0).children('.col').eq(0).children('img').eq(0);
        img.attr('id','preview_imagen_'+(indice+1));

        var input = $(contenedor).children(".file-field").eq(0).children('.btn').eq(0).children('input').eq(0);
        input.attr('id','imagen_'+(indice+1));
    })
}


function guardarEvento(){
    var formData = new FormData(document.getElementById('form-crear-evento'));
    //formData.append("imagen",document.getElementById("foto"));
    formData.append("_token",$("#_token").val());
    formData.append("cantidad_imagenes",cont_imagenes);

    $("#contenedor-botones-nuevo-evento").addClass("invisible");
    $("#progress-nuevo-evento").removeClass("invisible");

    $.ajax({
        url: $("#base_url").val()+"/eventos/guardar",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        if(data == "1" || data == 1){
            lanzarMensaje("Completo","El evento ha sido almacenado en el sistema.",6000,1);
            vaciarForm();
        }else if(data == "-3"){
            lanzarMensaje("Error","Seleccione archivos con un tamaño inferior a 7 Mb.",10000,2);
            $(".contenedor-botones").removeClass('invisible');
            $(".progress").addClass('invisible');
        }else if(data == "-2"){
            lanzarMensaje("Error","Todos los campos de imagenes agregados son obligatorios.",10000,2);
            $(".contenedor-botones").removeClass('invisible');
            $(".progress").addClass('invisible');
        }else if(data == "-1"){
            lanzarMensaje("Error","Seleccione unicamente archivos con extensión 'jpg.', 'jpng', 'png' o 'svg'.",10000,2);
            $(".contenedor-botones").removeClass('invisible');
            $(".progress").addClass('invisible');
        }
        $("#contenedor-botones-nuevo-evento").removeClass("invisible");
        $("#progress-nuevo-evento").addClass("invisible");
    }).error(function(jqXHR, textStatus ){
        mensajeValidationFalse(jqXHR);
        $(".contenedor-botones").removeClass('invisible');
        $(".progress").addClass('invisible');
    });
}

function editarEvento(){
    var formData = new FormData(document.getElementById('form-editar-evento'));
    //formData.append("imagen",document.getElementById("foto"));
    formData.append("_token",$("#_token").val());
    formData.append("cantidad_imagenes",cont_imagenes);

    $("#contenedor-botones-editar-evento").addClass("invisible");
    $("#progress-editar-evento").removeClass("invisible");

    $.ajax({
        url: $("#base_url").val()+"/eventos/editar",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        if(data == "1" || data == 1){
            window.location.reload();
        }else if(data == "-3"){
            lanzarMensaje("Error","Seleccione archivos con un tamaño inferior a 7 Mb.",10000,2);
            $("#contenedor-botones-editar-evento").removeClass('invisible');
            $("#progress-editar-evento").addClass('invisible');
        }else if(data == "-2"){
            lanzarMensaje("Error","Todos los campos de imagenes agregados son obligatorios.",10000,2);
            $("#contenedor-botones-editar-evento").removeClass('invisible');
            $("#progress-editar-evento").addClass('invisible');
        }else if(data == "-1"){
            lanzarMensaje("Error","Seleccione unicamente archivos con extensión 'jpg.', 'jpng', 'png' o 'svg'.",10000,2);
            $("#contenedor-botones-editar-evento").removeClass('invisible');
            $("#progress-editar-evento").addClass('invisible');
        }
        $("#contenedor-botones-editar-evento").removeClass("invisible");
        $("#progress-editar-evento").addClass("invisible");
    }).error(function(jqXHR, textStatus ){
        mensajeValidationFalse(jqXHR);
        $("#contenedor-botones-editar-evento").removeClass('invisible');
        $("#progress-editar-evento").addClass('invisible');
    });
}

function vaciarForm(){
    $("#titulo").val("");
    $("#descripcion_corta").val("");
    $("#descripcion_detallada").val("");
    $(".contenedor-imagenes").html("");
    cont_imagenes = 0;
}