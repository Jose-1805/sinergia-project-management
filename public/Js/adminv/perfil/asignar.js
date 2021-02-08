$(function () {
    $('#btnAsignar').click(function () {
        var evaluador = $('input[name="evaluadores[]"]:checked').val();

        if (typeof (evaluador) == "undefined") {
            lanzarMensaje('Error', 'Seleccione un evaluador', 3000, 2);
        } else {
            $(".contenedor_botones").addClass("invisible");
            $('.progress').removeClass('invisible');
            $.ajax({
                url: '/proyecto/asignar-perfil',
                type: 'POST',
                data: $('#formAsignarPerfil').serialize(),
                success: function (resp) {
                    if (resp == 1) {
                        lanzarMensaje('Confirmación', 'El perfil ha sido relacionado con la informaciión seleccionada.', 4000, 1);
                        recargarContenido('/adminv/perfiles', null);
                        setTimeout(function(){
                            window.location.href = "/adminv/perfiles";
                        },4000);
                    } else {
                        lanzarMensaje('Error', 'Ocurrio un error asignando el perfil, por favor intentelo nuevamente', 5000, 2);
                    }
                    $(".contenedor_botones").removeClass("invisible");
                    $('.progress').addClass('invisible');
S                }

            })
        }
    })
})