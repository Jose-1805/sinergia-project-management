$(function () {
    $("#formSugerencia").submit(function (event) {
        event.preventDefault();
        var sugerencia = $('#sugerencia').val();

        if (sugerencia.length < 1) {
            lanzarMensaje('Error', 'No ha ingresado ninguna de sugerencia', 5000, 2);
        } else {
            params = $(this).serialize();
            $('.contenedor-botones').fadeOut(300);
            $.ajax({
                beforeSend: function () {
                    $('.progress').removeClass('invisible');
                    $('.progress').addClass('visible');
                },
                url: '/proyecto/registrar-sugerencia-perfil',
                type: 'post',
                data: params,
                success: function (resp) {
                    if(resp == '1'){
                        lanzarMensaje('Completo','Su sugerencia fue enviada al proponente lider del perfil',5000,1);
                        $('#txtSugerencias').val('');
                    }else if(resp == '2'){
                        lanzarMensaje('Error','Su sugerencia parece no haber sido enviada, puede intentarlo nuevamente',5000,2);
                    }else if(resp == "3"){
                        lanzarMensaje('Error','El elemento seleccionado ha sido descartado del proyecto.',5000,2);
                    }
                    $('.contenedor-botones').fadeIn(300);
                },
                //si ocurre un error 
                //recible los siguientes parametros
                //jqXHR: objeto XMLHttpRequest
                //estado: cadena con el tipo de error -> timeout,error,abort,parsererror
                //error: muestra la descripcion del error ejemplu no found, internal server error etc.
                error: function (jqXHR, estado, error) {
                    lanzarMensaje('Error','tu sugerencia parece no haber sido enviada, puedes intentarlo nuevamente',5000,2);
                    $('.contenedor-botones').fadeIn(300);
                },
                //se ejecuta despues de ejecutarse una de las anterioresfunciones
                //parametros: objeto XMLHttpRequest y estado
                //estado->succes,notmodified,timeout,error,abort,parsererror
                complete: function (jqXHR, estado) {
                    $('.progress').removeClass('visible');
                    $('.progress').addClass('invisible');
                },
                timeout: 10000
            });
        }
    });

    $('#componente').change(function(){
        var valor = $(this).val();
        if(valor.length == 0){
            dropSelects();
        }else {
            var params = {'select': 'actividades', 'id': valor, '_token': $('#_token').val()};
            $.post('/proyecto/select', params, function (data) {
                $("#cont_select_actividades").html(data);
                inicializarMaterializacss();
            })
        }
    })
})

function dropSelects(){
    $("#cont_select_actividades").html('');
    $("#cont_select_opc_actividad").html(data);
    $("#cont_select_rubros").html(data);
    $("#cont_select_productos").html(data);
}

function opcionesActividad(idSelect){
    var valor = $("#"+idSelect).val();
    if(valor.length == 0){
        dropSelects();
    }else {
        var params = {'select': 'opcionesActividades', 'id': valor, '_token': $('#_token').val()};
        $.post('/proyecto/select', params, function (data) {
            $("#cont_select_opc_actividad").html(data);
            inicializarMaterializacss();
        })
    }
}

function seleccionOpcion(idSelect){
    var opcion = $("#"+idSelect).val();
    var valor = $("#actividad").val();
    if(valor.length == 0){
        dropSelects();
    }else {
        var params = {'select': opcion, 'id': valor, '_token': $('#_token').val()};
        $.post('/proyecto/select', params, function (data) {
            if (opcion == 'selectRubros') {
                $("#cont_select_rubros").html(data);
                $("#cont_select_productos").html('');
            } else if (opcion == 'selectProductos') {
                $("#cont_select_productos").html(data);
                $("#cont_select_rubros").html('');
            }
            inicializarMaterializacss();
        })
    }
}