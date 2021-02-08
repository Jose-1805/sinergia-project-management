$(document).ready(function () {

    /**
     * Inicilaiza el formato del campo date para las fechas
     */
    //$('.datepicker').pickadate({
    //    selectMonths: true, // Creates a dropdown to control month
    //    selectYears: 15 // Creates a dropdown of 15 years to control year
    //});

    /**
     * Busca en la base de datos las divisiones de actividades económicas dependiendo la sección seleccionada y
     * las agrega al select de las divisiones actividades económicas.
     * */
    $("#seccActEco").change(function (e) {

        $("#divacteco").empty();
        $("#entActividadEco").empty();

        console.log(e);
        var id = e.target.value;
        var stri = "";
        $.get(("/adminv/traerdivacteco/" + id), function (result) {
            $.each(result, function (index, divaObj) {
                stri += ('<option value="' + divaObj.id + '">' + divaObj.div_act_descripcion + '</option>');
            });
            if (result.length > 0) {
                $("#divacteco").append(stri);
            } else {
                $("#divacteco").append('<option value="0">Seleccione</option>');
            }
            $("#entActividadEco").append("<option value='0'>Seleccione</option>");
            inicializarMaterializacss();
        });
    });

    /**
     * Busca en la base de datos las actividades económicas dependiendo la división seleccionada y
     * las agrega al select de las actividades económicas.
     * */
    $("#divacteco").change(function (e) {
        $("#entActividadEco").empty();

        console.log(e);
        var id = e.target.value;
        var stri = "";
        $.get(("/adminv/traeracteco/" + id), function (result) {
            $.each(result, function (index, divaObj) {
                stri += ('<option value="' + divaObj.id + '">' + divaObj.act_eco_descripcion + '</option>');
            });
            if (result.length > 0) {
                $("#entActividadEco").append(stri);
            } else {
                $("#entActividadEco").append("<option value='0'>Seleccione</option>");
            }
            inicializarMaterializacss();
        });
    });


    /**
     * Consulta en la base de datos las ciudades o municipios relacionados al departamento
     * seleccionado y los agrega al select de municipios.
     * */
    $("#DepartamentoDeLocalizacion").change(function (e) {
        $("#CiudadDeLocalizacion").empty();
        console.log(e);
        var id = e.target.value;
        var stri = "";
        $.get(("/adminv/traermunicipios/" + id), function (result) {
            $.each(result, function (index, divaObj) {
                stri += ('<option value="' + divaObj.id + '">' + divaObj.ciu_nombre + '</option>');
            });
            if (result.length > 0) {
                $("#CiudadDeLocalizacion").append(stri);
            } else {
                $("#CiudadDeLocalizacion").append("<option value='0'>Seleccione</option>");
            }
            inicializarMaterializacss();
        });
    });


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
     *    Valida que el nombre ingresado para la Entidad no este registrado.
     */
    //$("input [type=text]")

    $("#Nombre").keyup(function () {
        validarNombreEntidad($(this).val());
    });
    $("#Nombre").on("focusout" ,function () {
        validarNombreEntidad($(this).val() )
    } );

    /**
     *   Valida que el correo ingresado no este registrado.
     */
    $("#CorreoDeLocalizacion").on("focusout", function () {
        validarCorreo($(this).val());
    });
    $("#CorreoDeLocalizacion").keyup(function () {
        validarCorreo($(this).val());
    });

    $("#CamaraComercio").on("focusout", function(){
        //alert($(this).val());
        validarCamaraComercio($(this).val());
    });
    $("#CamaraComercio").keyup(function(){
        //alert($(this).val());
        validarCamaraComercio($(this).val());
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
        correcto = validar($("#CamaraComercio"));
        correcto = validar($("#SectorEconomico"));
        correcto = validar($("#NumeroDeEmpleados"));
        correcto = validar($("#FechaDeConstitucion"));
        correcto = validar($("#Estado"));
        correcto = validar($("#NumeroDeLaCalle"));
        correcto = validar($("#NumeroDeLaCarrera"));
        correcto = validar($("#NumeroDeEdificacion"));
        correcto = validar($("#CorreoDeLocalizacion"));
        correcto = validar($("#FaxDeLocalizacion"));
        correcto = validar($("#SitioWebDeLocalizacion"));
        correcto = validar($("#CiudadDeLocalizacion"));
        correcto = validar($("#DepartamentoDeLocalizacion"));
        return correcto;
    }

    /**
     *  Se ejecuta al enviar el formulario.
     *  Muetra un mensaje de acuerdo al resultado de las validaciones o el registro.
     */
    $("#formNuevaEntidad").submit(function (event) {
        event.preventDefault();
        if (!validar_datos()) {
            lanzarMensaje("Advertencia", "Debe ingresar todos los datos!", 5000, 3);
        } else {
            $("#formNuevoPerfilLoad").removeClass('invisible');
            $("#formNuevoPerfilLoad").addClass('visible');
            $.ajax({
                beforeSend: function () {
                },
                url: "registrar-entidad",
                type: 'POST',
                data: $("#formNuevaEntidad").serialize(),
                success: function (resp) {
                    $("#formNuevoPerfilLoad").removeClass('visible');
                    $("#formNuevoPerfilLoad").addClass('invisible');
                    lanzarMensaje('Correcto', 'Se ha registrado la Entidad.', 4000, 1);
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
     *  Se ejecuta al enviar el formulario para actualizar la entidad.
     *  Muetra un mensaje de acuerdo al resultado de las validaciones o el registro.
     */
    $("#formActualizarEntidad").submit(function (event) {
        event.preventDefault();
        if (!validar_datos()) {
            lanzarMensaje("Advertencia", "Debe ingresar todos los datos!", 5000, 3);
        } else {
            $("#formActualizarEntidad").removeClass('invisible');
            $("#formActualizarEntidad").addClass('visible');
            $.ajax({
                beforeSend: function () {
                },
                url: "/adminv/actualizar-entidad",
                type: 'POST',
                data: $("#formActualizarEntidad").serialize(),
                success: function (resp) {
                    $("#formNuevoPerfilLoad").removeClass('visible');
                    $("#formNuevoPerfilLoad").addClass('invisible');
                    lanzarMensaje('Correcto', 'Se ha actualizado la Entidad.', 4000, 1);
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
    $.get("validar-correo-entidad/" + correo, function (result) {
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

function validarNombreEntidad(nombreEntidad){
    $.get("validarnombre/" + nombreEntidad, function (result) {
            if (result == 1 || result==2) {
                if(result == 1){
                    $("#nombreEntError").removeClass("invisible");
                    $(this).addClass("has-error");
                    $(this).addClass("alert-danger");
                    $("#Nombre").css("border-bottom", "5px solid red");
                }else{
                    $("#Nombre").css("border-bottom", "5px solid red");
                }
            } else {

                $("#nombreEntError").addClass("invisible");
                $("#Nombre").removeClass("texto-error");
                $("#Nombre").css("border-bottom", "5px solid green");
            }
        }
    );
}

function validarCamaraComercio(camaraComercio){
    $.get("validar-camara-comercio/" + camaraComercio, function (result) {
            if (result == 1) {
                $("#CamaraComercioError").removeClass("invisible");
                $("#CamaraComercio").css("border-bottom", "5px solid red");
            } else {
                $("#CamaraComercioError").addClass("invisible");
                $("#CamaraComercio").css("border-bottom", "5px solid green");
            }
        }
    );
}

function validarUrl(url){
    if(url != ""){
        $.get("validar-camara-comercio/" + camaraComercio, function (result) {
                if (result == 1) {
                    $("#CamaraComercioError").removeClass("invisible");
                    $("#CamaraComercio").css("border-bottom", "5px solid red");
                } else {
                    $("#CamaraComercioError").addClass("invisible");
                    $("#CamaraComercio").css("border-bottom", "5px solid green");
                }
            }
        )

    }
}

