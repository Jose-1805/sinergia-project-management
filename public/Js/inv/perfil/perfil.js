$(function () {
    $("#btnGuardarCambios").click(function (event) {
        //validar que los datos esten completos antes de enviarlos

        event.preventDefault();
        if (true) {
            $.ajax({
                beforeSend: function (xhr) {

                },
                url: "/editarPerfil",
                type: 'POST',
                data: $("#formEditarPerfil").serialize(),
                success: function (resp) {
                    if(resp == 1){
                        lanzarMensaje("Completo","La información del perfil ha sido modificada correctamente",5000,1);
                    }else{
                        lanzarMensaje("Error","La información del perfil NO ha sido modificada, intente mas tarde",5000,1);
                    }
                },
                error: function (jqXHR, estado, error) {
                    mensajeValidationFalse(jqXHR);
                },
                complete: function (jqXHR, estado) {
                }
            })
        }
    })
})

function validarCampos() {
    if ($("#objetivoGeneral").val().length < 1) {
        lanzarMensaje("Error", "Todos los campos son obligatorios, ingrese el objetivo general del perfil.", 5000, 2);
        $("#objetivoGeneral").focus();
        return false;
    } else if ($("#problema").val().length < 1) {
        lanzarMensaje("Error", "Todos los campos son obligatorios, ingrese el problema del perfil.", 5000, 2);
        $("#problema").focus();
        return false;
    } else if ($("#justificacion").val().length < 1) {
        lanzarMensaje("Error", "Todos los campos son obligatorios, ingrese la justificación del perfil.", 5000, 2);
        $("#justificacion").focus();
        return false;
    } else if ($("#presupuesto").val().length < 1) {
        lanzarMensaje("Error", "Todos los campos son obligatorios, ingrese el presupuesto estimado del perfil.", 5000, 2);
        $("#presupuesto").focus();
        return false;
    } else if ($("#sector").val().length < 1) {
        lanzarMensaje("Error", "Todos los campos son obligatorios, ingrese el sector al cual apunta su perfil del perfil.", 5000, 2);
        $("#sector").focus();
        return false;
    }
    return true;
}