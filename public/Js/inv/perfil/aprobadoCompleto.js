var perfilCompletoSeleccionado;
$(function () {
    $('.btnPerfilCompleto').click(function () {
        var titulo = $(this).children('h5').text();
        perfilCompletoSeleccionado = $(this).children('input').attr('value');
        $('#tituloPerfilCompletoSeleccionado').text(titulo);
    })

    $('#btnVerMas').click(function () {
        window.location.href = "/adminv/perfil/" + perfilCompletoSeleccionado;
    })

    $('#btnSugerir').click(function () {
        window.location.href = "/adminv/perfil-sugerir/" + perfilCompletoSeleccionado;
    })

    $('#btnAsignar').click(function () {
        window.location.href = "/adminv/perfil-asignar/" + perfilCompletoSeleccionado;
    })
})
