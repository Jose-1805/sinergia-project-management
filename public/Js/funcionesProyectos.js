$(function(){
})


/**
 * ¨FINCIONES PARA LOS PERFILES
 */

function aprobarPerfil(rol){
    var correo = 1;
    if ($('#enviarCorreoAprobar').prop('checked')) {
        correo = 2
    }
    var token = $("#_token").val();
    var params = {"perfil":perfilSeleccionado,"enviarCorreo":correo,"_token":token};

    $.ajax({
        beforeSend: function () {
            $('.progress').removeClass('invisible');
            $('.progress').addClass('visible');
        },
        url: "/proyecto/aprobar-perfil",
        type: 'POST',
        data: params,
        success: function (resp) {
            if(resp == 1){
                recargarContenido('/'+rol+'/perfiles',null);
                lanzarMensaje('Completo','Se ha cambiado el estado del perfil a propuesta aprobada',5000,1);
            }else{
                lanzarMensaje('Error','Ocurrio un problema al cambiar el estado del perfil, intentelo más tarde.',5000,2);
            }
            ocultarModal();
        },
        complete: function (jqXHR, textStatus) {
            $('.progress').removeClass('visible');
            $('.progress').addClass('invisible');
        }
    });
}

function descartarPerfil(rol,idEnviarCorreo){
    var correo = 1;
    if ($('#'+idEnviarCorreo).prop('checked')) {
        correo = 2
    }

    var token = $("#_token").val();
    var params = {"perfil":perfilSeleccionado,"enviarCorreo":correo,"_token":token};

    $.ajax({
        beforeSend: function () {
            $('.progress').removeClass('invisible');
            $('.progress').addClass('visible');
        },
        url: "/proyecto/descartar-perfil",
        type: 'POST',
        data:params,
        success: function (resp) {
            if(resp == 1){
                recargarContenido('/'+rol+'/perfiles',null);
                lanzarMensaje('Completo','Se ha cambiado el estado del perfil o proyecto a descartado',5000,1);
            }else{
                lanzarMensaje('Error','Ocurrio un problema al cambiar el estado del perfil o proyecto, intentalo más tarde.',5000,2);
            }
            ocultarModal();
        },
        complete: function (jqXHR, textStatus) {
            $('.progress').removeClass('visible');
            $('.progress').addClass('invisible');
        }
    });
}

function perfilCompleto(rol){
    var correo = 1;
    if ($('#enviarCorreoPerfilCompleto').prop('checked')) {
        correo = 2
    }
    var token = $("#_token").val();
    var params = {"perfil":perfilSeleccionado,"enviarCorreo":correo,"_token":token};

    $.ajax({
        beforeSend: function () {
            $('.progress').removeClass('invisible');
            $('.progress').addClass('visible');
        },
        url: "/proyecto/perfil-completo",
        type: 'POST',
        data: params,
        success: function (resp) {
            if(resp == 1){
                recargarContenido('/'+rol+'/perfiles',null);
                lanzarMensaje('Completo','Se ha cambiado el estado del perfil a propuesta aprobada completa',5000,1);
            }else{
                lanzarMensaje('Error','Ocurrio un problema al cambiar el estado del perfil, intentelo más tarde.',5000,2);
            }
            ocultarModal();
        },
        complete: function (jqXHR, textStatus) {
            $('.progress').removeClass('visible');
            $('.progress').addClass('invisible');
        }
    });
}

function fechaInicioProyecto(){
    $(".progress").removeClass("invisible");
    $(".contenedor-botones").addClass("invisible");

    var params = $("#form-fecha-proyecto").serialize()+"&_token="+$("#_token").val();

    $.post($("#base_url").val()+"/proyecto/establecer-fecha-inicio",params,function(data){
        if(data == "1" || data == 1){
            window.location.reload();
        }else if(data == "-2" || data == -2){
            lanzarMensaje("Error","Ocurrio un error desconocido al intentar establecer la fecha de inicio del proyecto.",7000,2);
        }else{
            lanzarMensaje("Error",data,7000,2);
        }
        $(".contenedor-botones").removeClass("invisible");
        $(".progress").addClass("invisible");
    });
}