$(function () {
    $("#formSugerencia").submit(function (event) {
        event.preventDefault();
        var sugerencia = $('#txtSugerencias').val();
        var idPerfil = $('#idPerfil').val();
        var avisarPorCorreo = 2;
        if($('#enviarCorreo').prop('checked')){
            avisarPorCorreo = 1;
        }

        if (sugerencia.length < 1) {
            lanzarMensaje('Error', 'No ha ingresado ninguna de sugerencia', 5000, 2);
        } else {
            params = {"sugerencia":sugerencia,"idPerfil":idPerfil,"enviarCorreo":avisarPorCorreo,"_token":$("#_token").val()};
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
                        lanzarMensaje('Completo','tu sugerencia fue enviada al proponente lider del perfil',5000,1);
                        $('#txtSugerencias').val('');
                    }else if(resp == '2'){
                        lanzarMensaje('Error','tu sugerencia parece no haber sido enviada, puedes intentarlo nuevamente',5000,2);
                    }
                },
                //si ocurre un error 
                //recible los siguientes parametros
                //jqXHR: objeto XMLHttpRequest
                //estado: cadena con el tipo de error -> timeout,error,abort,parsererror
                //error: muestra la descripcion del error ejemplu no found, internal server error etc.
                error: function (jqXHR, estado, error) {
                    lanzarMensaje('Error','tu sugerencia parece no haber sido enviada, puedes intentarlo nuevamente',5000,2);
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
})