$(function () {
    $('.btnAsignarEnFormulacion').click(function () {
        window.location.href = "/adminv/perfil-asignar/" + perfilSeleccionado;
    })

    $('#btnCompletoNo').click(function () {
        //$('#opcionesPerfil').Css('display','none');
        $('#completo').css('display', 'none');
        eliminarSubModal();
    })

    $('#btnDescartarEnFormulacionNo').click(function () {
        //$('#opcionesPerfil').Css('display','none');
        $('#descartarEnFormulacion').css('display', 'none');
        eliminarSubModal();
    })

    $('#btnCompletoOk').click(function () {
        perfilCompleto("adminv");
    })

    $('#btnDescartarEnFormulacionOk').click(function () {
        descartarPerfil("adminv","enviarCorreoDescartarEnFormulacion");
    })

    $('#btnAprobarNoView, #btnDescartarNoView').click(function () {
        ocultarModal();
    })


    $('#btnCompletoOkView').click(function () {
        perfilSeleccionado = $("#idPerfil").val();
        perfilCompleto("adminv");
    })

    $('#btnDescartarOkView').click(function () {
        perfilSeleccionado = $("#idPerfil").val();
        descartarPerfil("adminv","enviarCorreoDescartarEnFormulacion");
    })
})