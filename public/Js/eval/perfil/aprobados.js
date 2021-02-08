$(function () {
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
        perfilCompleto("eval");
    })

    $('#btnDescartarEnFormulacionOk').click(function () {
        descartarPerfil("eval","enviarCorreoDescartarEnFormulacion");
    })

    $('#btnAprobarNoView, #btnDescartarNoView').click(function () {
        ocultarModal();
    })


    $('#btnCompletoOkView').click(function () {
        perfilSeleccionado = $("#idPerfil").val();
        perfilCompleto("eval");
    })

    $('#btnDescartarOkView').click(function () {
        perfilSeleccionado = $("#idPerfil").val();
        descartarPerfil("eval","enviarCorreoDescartarEnFormulacion");
    })
})