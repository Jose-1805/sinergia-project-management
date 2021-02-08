$(function () {
    $('.btnVerMas').click(function () {
        window.location.href = "/proyecto/perfil/" + perfilSeleccionado;
    })

    $('.btnEvaluar').click(function () {
        window.location.href = "/proyecto/evaluar/" + perfilSeleccionado;
    })

    $('.btnSugerir').click(function () {
        window.location.href = "/eval/perfil-sugerir/" + perfilSeleccionado;
    })


    $('#btnAprobarNo').click(function () {
        //$('#opcionesPerfil').css('display','none');
        $('#aprobar').css('display', 'none');
        eliminarSubModal();
    })

    $('#btnDescartarNo').click(function () {
        //$('#opcionesPerfil').css('display','none');
        $('#descartar').css('display', 'none');
        eliminarSubModal();
    })

    $('#btnAprobarOk').click(function () {
        aprobarPerfil("eval");
    })

    $('#btnDescartarProyectoOk').click(function () {
        descartarPerfil("eval","enviarCorreoDescartarProyecto");
    })

    $('#btnDescartarProyectoOkView').click(function () {
        perfilSeleccionado = $("#idPerfil").val();
        descartarPerfil("eval","enviarCorreoDescartarProyecto");
    })

    $("#btnDescartarProyectoNoView").click(function(){
        ocultarModal();
    })
})