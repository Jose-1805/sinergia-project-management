$(function () {
    $('.btnVerMas').click(function () {
        window.location.href = "/proyecto/perfil/" + perfilSeleccionado;
    })

    $('.btnEvaluar').click(function () {
        window.location.href = "/proyecto/evaluar/" + perfilSeleccionado;
    })

    $('.btnSugerir').click(function () {
        window.location.href = "/adminv/perfil-sugerir/" + perfilSeleccionado;
    })

    $('.btnAsignar').click(function () {
        window.location.href = "/adminv/perfil-asignar/" + perfilSeleccionado;
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
        aprobarPerfil("adminv");
    })
    
    $('#btnDescartarProyectoOk').click(function () {
        descartarPerfil("adminv","enviarCorreoDescartarProyecto");
    })

    $('#btnDescartarProyectoOkView').click(function () {
        perfilSeleccionado = $("#idPerfil").val();
        descartarPerfil("adminv","enviarCorreoDescartarProyecto");
    })

    $("#btnDescartarProyectoNoView").click(function(){
        ocultarModal();
    })
})