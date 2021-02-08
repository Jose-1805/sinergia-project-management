$(function () {
    $('.btnVerMas').click(function () {
        window.location.href = "/proyecto/perfil/" + perfilSeleccionado;
    })

    $('#btnEditar').click(function () {
        window.location.href = "/inv/editar-perfil/" + perfilSeleccionado;
    })
})