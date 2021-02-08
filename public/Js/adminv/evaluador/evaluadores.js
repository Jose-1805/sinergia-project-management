$(document).ready(function () {



    /**
     *    Valida que en los campos númericos no se ingrese otro valor ademas de Números.
     */
    $("input[type='number']").keydown(function (event) {
        if (event.shiftKey) {
            event.preventDefault();
        }
        if (event.keyCode == 46 || event.keyCode == 8) {
        }
        else {
            if (event.keyCode < 95) {
                if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
                }
            }
            else {
                if (event.keyCode < 96 || event.keyCode > 105) {
                    event.preventDefault();
                }
            }
        }
    });

    /**
     *   Valida que el correo ingresado no este registrado.
     */
    $("#Correo").on("focusout", function () {
        validarCorreo($(this).val());
    });
    $("#Correo").keyup(function () {
        validarCorreo($(this).val());
    });

    /**
     *  Valida que los campos tipo Input no queden vacios.
     */
    $("input").keyup(function () {
        validar($(this));
    });

    /**
     *  Se ejecuta antes de enviar el formulario.
     * @returns {boolean}
     * true: Si todos los campos estan llenos
     * false: Si algun campo esta vacio
     */
    function validar_datos() {
        var correcto = true;
        correcto = validar($("#Nombre"));
        correcto = validar($("#Telefono"));
        correcto = validar($("#Identidficacion"));
        correcto = validar($("#FechaDeNacimiento"));

        return correcto;
    }

    /**
     *  Se ejecuta al enviar el formulario.
     *  Muetra un mensaje de acuerdo al resultado de las validaciones o el registro.
     */
    $("#formNuevoEvaluador").submit(function (event) {
        event.preventDefault();
        if (!validar_datos()) {
            lanzarMensaje("Advertencia", "Debe ingresar todos los datos!", 5000, 3);
        } else {
            $("#formNuevoPerfilLoad").removeClass('invisible');
            $("#formNuevoPerfilLoad").addClass('visible');
            $.ajax({
                beforeSend: function () {
                },
                url: "registrar-evaluador",
                type: 'POST',
                data: $("#formNuevoEvaluador").serialize(),
                success: function (resp) {
                    $("#formNuevoPerfilLoad").removeClass('visible');
                    $("#formNuevoPerfilLoad").addClass('invisible');
                    lanzarMensaje('Correcto', 'Se ha registrado el evaluador.', 4000, 1);
                },
                error: function (jqXHR, estado, error) {
                    $("#formNuevoPerfilLoad").removeClass('visible');
                    $("#formNuevoPerfilLoad").addClass('invisible');
                    mensajeValidationFalse(jqXHR);

                }
            });
            //$("#formNuevoPerfilLoad").removeClass('visible');
            //$("#formNuevoPerfilLoad").addClass('invisible');
        }
    });

    /**
     *  Se ejecuta al enviar el formulario para actualizar el evaluador.
     *  Muetra un mensaje de acuerdo al resultado de las validaciones o el registro.
     */
    $("#formActualizarEvaluador").submit(function (event) {
        event.preventDefault();
        if (!validar_datos()) {
            lanzarMensaje("Advertencia", "Debe ingresar todos los datos!", 5000, 3);
        } else {
             $.ajax({
                beforeSend: function () {
                },
                url: "adminv/actualizar-evaluador",
                type: 'POST',
                data: $("#formActualizarEvaluador").serialize(),
                success: function (resp) {
                    $("#formNuevoPerfilLoad").removeClass('visible');
                    $("#formNuevoPerfilLoad").addClass('invisible');
                    lanzarMensaje('Correcto', 'Se ha actualizado el Evaluador.', 4000, 1);
                },
                error: function (jqXHR, estado, error) {
                    $("#formNuevoPerfilLoad").removeClass('visible');
                    $("#formNuevoPerfilLoad").addClass('invisible');
                    mensajeValidationFalse(jqXHR);
                }
            });
        }
    });

});

function validarCorreo(correo) {
    $.get("validar-correo-persona/" + correo, function (result) {
            if (result == 1) {
                $("#correoError").removeClass("invisible");
                $("#CorreoDeLocalizacion").css("border-bottom", "5px solid red");
            } else {
                $("#correoError").addClass("invisible");
                $("#CorreoDeLocalizacion").css("border-bottom", "5px solid green");
            }
        }
    );
}


