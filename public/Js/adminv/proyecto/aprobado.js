/**
 * Created by Jose Luis on 04/02/2016.
 */
$(function () {
    $('.btnAsignarAprobado').click(function () {
        window.location.href = $("#base_url").val()+"/adminv/perfil-asignar/" + perfilSeleccionado;
    })

    $('.btnSugerirAprobado').click(function () {
        window.location.href = $("#base_url").val()+"/adminv/perfil-sugerir/" + perfilSeleccionado;
    })

    $('.btnSugerirAprobadoEval').click(function () {
        window.location.href = $("#base_url").val()+"/eval/perfil-sugerir/" + perfilSeleccionado;
    })

    $('.btnEstablecerInicio').click(function () {
        window.location.href = $("#base_url").val()+"/proyecto/inicio-proyecto/" + perfilSeleccionado;
    })
})