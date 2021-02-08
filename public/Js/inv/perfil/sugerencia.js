$(function(){
    /**
     * PRODUCTOS
     */
    $('#btn_guardar_producto').click(function(){
        var token = $('#_token').val();
        var idProducto = $('#id_producto').val();
        var descripcion = $('#descripcion').val();

        if(descripcion.length == 0){
            lanzarMensaje('Error','Debe ingresar la descripción del producto.',5000,2);
        }else {
            var params = {'_token': token, 'idProducto': idProducto,'descripcion':descripcion};
            $('.contenedor-botones').addClass('invisible');
            $('.progress').removeClass('invisible');
            $.post('/producto/update', params, function (data) {
                if (data == '1') {
                    lanzarMensaje('Completo', 'La información del producto ha sido editada con exito.', 5000, 1);
                } else {
                    lanzarMensaje('Error', 'La información del producto no pudo ser editada.', 5000, 2);
                }
                $('.contenedor-botones').removeClass('invisible');
                $('.progress').addClass('invisible');
            })
        }
    })

    /**
     * RUBROS
     */
    $('#btn_guardar_rubro').click(function(){
        var params = $('#form_rubro').serialize()+'&_token='+$('#_token').val();

        $('.contenedor-botones').addClass('invisible');
        $('.progress').removeClass('invisible');
        $.post('/rubro/update',params,function(data){
            if(data == '1'){
                lanzarMensaje('Completo','La información del rubro ha sido actualizada con exito',5000,1);
            }else {
                mensaje = '<lu>';
                $.each(data, function(i, item) {
                    mensaje += '<li>'+ data[i] + '</li>';
                });
                mensaje += '</ul>';
                lanzarMensaje('Error',mensaje,5000,2);
            }
            $('.contenedor-botones').removeClass('invisible');
            $('.progress').addClass('invisible');
        })
    })

    $('#btn_agregar_componente').click(function(){
        var clon = $('.contenedorComponente').eq(0).clone();
        $(clon).children('td').eq(0).children('input').val('');
        $(clon).children('td').eq(1).children('input').val('0');
        $(clon).children('td').eq(2).children('input').val('0');
        $(clon).appendTo($('#tbodyComponentes'));
        reestructurarEtiquetasRubro();
    })

    $('.eliminar-componente-rubro').click(function(){
        if($('.eliminar-componente-rubro').length == 1){
            lanzarMensaje('Error','Cada rubro debe contener por lo menos un item.',4000,2);
        }else {
            $(this).parent().parent().remove();
            reestructurarEtiquetasRubro();
        }
    })


    /**
     * ACTIVIDAD
     */
    $('#btn_guardar_actividad').click(function(){
        var params = $('#form-actividad').serialize()+'&_token='+$('#_token').val();

        $('.contenedor-botones').addClass('invisible');
        $('.progress').removeClass('invisible');
        $.post('/actividad/update',params,function(data){
            if(data == 1){
                lanzarMensaje('Completo','La información de la actividad ha sido actualizada con exito',5000,1);
            }else {
                    alert(data);
            }
            $('.contenedor-botones').removeClass('invisible');
            $('.progress').addClass('invisible');
        }).error(function(jqXHR,estado,error){
            mensajeValidationFalse(jqXHR);
            $('.contenedor-botones').removeClass('invisible');
            $('.progress').addClass('invisible');
        });
    })

    /**
     * COMPONENTE
     */
    $('#btn_guardar_componente').click(function(){
        var params = $('#form-componente').serialize()+'&_token='+$('#_token').val();

        $('.contenedor-botones').addClass('invisible');
        $('.progress').removeClass('invisible');
        $.post('/componente/update',params,function(data){
            if(data == '1'){
                lanzarMensaje('Completo','La información del componente ha sido actualizada con exito',5000,1);
            }else {
                alert(data);
            }
            $('.contenedor-botones').removeClass('invisible');
            $('.progress').addClass('invisible');
        }).error(function(jqXHR,estado,error){
            mensajeValidationFalse(jqXHR);
            $('.contenedor-botones').removeClass('invisible');
            $('.progress').addClass('invisible');
        });
    })
})

function reestructurarEtiquetasRubro(){
    var num = 0;
    $('.contenedorComponente').each(function(indice){
        num++;
        $('.contenedorComponente').eq(indice).children('td').eq(0).children('input').attr('id','nombre'+num);
        $('.contenedorComponente').eq(indice).children('td').eq(0).children('input').attr('name','nombre'+num);

        $('.contenedorComponente').eq(indice).children('td').eq(1).children('input').attr('id','cantidad'+num);
        $('.contenedorComponente').eq(indice).children('td').eq(1).children('input').attr('name','cantidad'+num);

        $('.contenedorComponente').eq(indice).children('td').eq(2).children('input').attr('id','valorUnitario'+num);
        $('.contenedorComponente').eq(indice).children('td').eq(2).children('input').attr('name','valorUnitario'+num);
    })

    $('#cantidadComponentes').val(num);
}

function enviarRespuestaSugerencia(){
    $(".contenedor-botones-respuesta").addClass("invisible");
    $(".progress-respuesta").removeClass("invisible");
    var params = $("#form-respuesta").serialize()+"&_token="+$("#_token").val();
    $.post($("#base_url").val()+"/proyecto/guardar-respuesta-sugerencia",params,function(data){
        if(data == "1" || data == 1){
            window.location.reload();
        }else if(data == "-2" || data == -2){
            lanzarMensaje("Error","Ocurrio un error desconocido al intentar cambiar el estado de la solicitud.",7000,2);
        }else{
            lanzarMensaje("Error",data,7000,2);
        }

        $(".progress-respuesta").addClass("invisible");
        $(".contenedor-botones-respuesta").removeClass("invisible");
    })
}

function sugerenciaRevisada(){
    $(".contenedor-botones-respuesta").addClass("invisible");
    $(".progress-respuesta").removeClass("invisible");
    var params = {"_token":$("#_token").val(),"sugerencia":$("#sugerencia").val()};
    $.post($("#base_url").val()+"/proyecto/sugerencia-revisada",params,function(data){
        if(data == "1" || data == 1){
            window.location.reload();
        }else if(data == "-2" || data == -2){
            lanzarMensaje("Error","Ocurrio un error desconocido al intentar marcar la sugerencia como revisada.",7000,2);
        }else{
            lanzarMensaje("Error",data,7000,2);
        }

        $(".progress-respuesta").addClass("invisible");
        $(".contenedor-botones-respuesta").removeClass("invisible");
    })
}