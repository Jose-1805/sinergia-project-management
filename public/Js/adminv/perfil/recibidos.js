$(function () {
    $('.btnVerMas').click(function () {
        window.location.href = "/proyecto/perfil/" + perfilSeleccionado;
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
    
    $('#btnDescartarOk').click(function () {
        descartarPerfil("adminv","enviarCorreoDescartar");
    })

    $('#btnAprobarNoView, #btnDescartarNoView').click(function () {
        ocultarModal();
    })


    $('#btnAprobarOkView').click(function () {
        perfilSeleccionado = $("#idPerfil").val();
        aprobarPerfil("adminv");
    })

    $('#btnDescartarOkView').click(function () {
        perfilSeleccionado = $("#idPerfil").val();
        descartarPerfil("adminv","enviarCorreoDescartar");
    })
})