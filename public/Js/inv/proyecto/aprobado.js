var perfilCompletoSeleccionado;
$(function () {
    /*$('.btnPerfilCompleto').click(function () {
        var titulo = $(this).children('h5').text();
        perfilCompletoSeleccionado = $(this).children('input').attr('value');
        $('#tituloPerfilCompletoSeleccionado').text(titulo);
    })*/

    $('#btnVerMas').click(function () {
        window.location.href = $("#base_url").val()+"/proyecto/perfil/" + perfilSeleccionado;
    })

    $('#btnEntidades').click(function () {
        window.location.href = $("#base_url").val()+"/proyecto/entidades/" + perfilSeleccionado;
    })

    $('#btnGrupo').click(function () {
        window.location.href = $("#base_url").val()+"/proyecto/grupo/" + perfilSeleccionado;
    })

    $('#btnAsignarTareas').click(function () {
        window.location.href = $("#base_url").val()+"/inv/asignacion-tareas/" + perfilSeleccionado;
    })
})
