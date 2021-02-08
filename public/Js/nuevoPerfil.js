var interval = 0;
var tituloError = false;
var correoError = false;
var passwordError = false;
$(function () {
    $("#titulo").keyup(function () {
        validacionTitulo();
    })

    $("#titulo").focusout(function () {
        $('#tituloLoad').removeClass('fa-spinner');
    })

    $("#correo").keyup(function () {
        validacionCorreo();
    })

    $("#correo").focusout(function () {
        $('#correoLoad').removeClass('fa-spinner');
    })

    $("#password").keyup(function () {
        validacionPassword();
    })

    $("#correo").focus();

    $("#formNuevoPerfil").submit(function (event) {
        event.preventDefault();
        if (tituloError) {
            lanzarMensaje('Error', 'Ya existe un proyecto con el título ingresado', 5000, 2);
        } else if (passwordError) {
            msjContraseñaIncorrecta();
        } else if (correoError) {
            lanzarMensaje('Error', 'La cuenta relacionada al correo ingresdo no se encuentra activa', 5000, 2);
        } else {
            $(".progress").removeClass('invisible');
            $(".contenedor-botones").addClass('invisible');

            $.ajax({
                beforeSend: function () {
                },
                url: "registroPerfil",
                type: 'POST',
                data: $("#formNuevoPerfil").serialize(),
                success: function (resp) {
                    switch (resp) {
                        case '1':
                            msjContraseñaIncorrecta();
                            break;
                        case '2':
                            lanzarMensaje('Error', 'El correo ingresado no se relaciona con una cuenta de investigador', 5000, 2);
                            break;
                        case '3':
                            lanzarMensaje('Error', 'La cuenta relacionada al correo ingresdo no se encuentra activa', 5000, 2);
                            break;
                        case '4':
                            lanzarMensaje('Error', 'Ya existe un proyecto con el titulo ingresado, para registrar su perfil cambie el titulo', 8000, 2);
                            break;
                        case '5':
                            msjPerfilRegistrado();
                            vaciarCamposnuevoPerfil();
                            break;
                        default:
                            alert(resp);
                            break;
                    }
                }, //si ocurre un error
                //recible los siguientes parametros
                //jqXHR: objeto XMLHttpRequest
                //estado: cadena con el tipo de error -> timeout,error,abort,parsererror
                //error: muestra la descripcion del error ejemplu no found, internal server error etc.
                error: function (jqXHR, estado, error) {
                    var data = JSON.parse(jqXHR.responseText);
                    var errorText = "<ol>";
                    for(var aux in data){
                      errorText += "<li> "+data[aux] +"</li>";
                    }
                    errorText += "</ol>";
                    lanzarMensaje("Error",errorText,8000,2);
                },
                //se ejecuta despues de ejecutarse una de las anterioresfunciones
                //parametros: objeto XMLHttpRequest y estado
                //estado->succes,notmodified,timeout,error,abort,parsererror
                complete: function (jqXHR, estado) {
                    $(".progress").addClass('invisible');
                    $(".contenedor-botones").removeClass('invisible');
                },
                timeout: 10000
                        //tiempo maximo de espera de la peticion en milisegundos

            })
        }
    })
})

function validacionTitulo() {
    var titulo = $('#titulo').val();
    if (titulo.length > 0) {
        var load = $('#tituloLoad');
        $.ajax({
            //antes de enviar la informacion
            beforeSend: function () {
                load.addClass('fa-spinner');
            }, //archivo a abrir
            url: 'validarTitulo/' + titulo,
            //metodo de envio de informacion
            type: 'get',
            //data: $('#PerformancePerDay form').serialize(),
            //funcion que se ejecuta cuando se tiene una respuesta de la peticion
            //el parametro es la respusta
            success: function (resp) {
                if (resp == "1") {
                    $("#tituloError").removeClass('invisible');
                    $("#titulo").addClass('invalid');
                    tituloError = true;
                } else {
                    $("#tituloError").addClass('invisible');
                    $("#titulo").removeClass('invalid');
                    tituloError = false;
                }
            },
            //si ocurre un error 
            //recible los siguientes parametros
            //jqXHR: objeto XMLHttpRequest
            //estado: cadena con el tipo de error -> timeout,error,abort,parsererror
            //error: muestra la descripcion del error ejemplu no found, internal server error etc.
            error: function (jqXHR, estado, error) {

            },
            //se ejecuta despues de ejecutarse una de las anterioresfunciones
            //parametros: objeto XMLHttpRequest y estado
            //estado->succes,notmodified,timeout,error,abort,parsererror
            complete: function (jqXHR, estado) {

            },
            timeout: 10000
                    //tiempo maximo de espera de la peticion en milisegundos

        })
    } else {
        $('#tituloError').removeClass('visible');
        $('#tituloError').addClass('invisible');
        $('#tituloLoad').removeClass('fa-spinner');
    }
}

function validacionCorreo() {
    var correo = $('#correo').val();
    if (correo.length > 0) {
        var load = $('#correoLoad');
        $.ajax({
            //antes de enviar la informacion
            beforeSend: function () {
                load.addClass('fa-spinner');
            }, //archivo a abrir
            url: 'validarCorreoInvestigador/' + correo,
            //metodo de envio de informacion
            type: 'get',
            //para enviar los datos tambien se puede crear
            //data: {titulo: ""},
            //data: $('#PerformancePerDay form').serialize(),
            //funcion que se ejecuta cuando se tiene una respuesta de la peticion
            //el parametro es la respusta
            success: function (resp) {
                if (resp == "1") {
                    $("#correoError").removeClass('visible');
                    $("#correoError").addClass('invisible');
                    $("#correo").removeClass('invalid');
                    if ($("#divPassword").length == 0) {
                        $("#divCorreo").after("<div id='divPassword' class='form-group'><label for='password'>Contraseña</label>" +
                                "<input type = 'password' class = 'form-control' id = 'password' name = 'password' required /></div>");
                    }
                    correoError = false;
                } else if (resp == '2') {
                    if ($("#divPassword").length > 0) {
                        $("#divPassword").remove();
                    }
                    $("#correoError").removeClass('invisible');
                    $("#correoError").addClass('visible');
                    $("#correo").addClass('invalid');
                    correoError = true;
                } else {
                    if ($("#divPassword").length > 0) {
                        $("#divPassword").remove();
                    }
                    $("#correoError").removeClass('visible');
                    $("#correoError").addClass('invisible');
                    $("#correo").removeClass('invalid');
                    correoError = false;
                }
            },
            //si ocurre un error 
            //recible los siguientes parametros
            //jqXHR: objeto XMLHttpRequest
            //estado: cadena con el tipo de error -> timeout,error,abort,parsererror
            //error: muestra la descripcion del error ejemplu no found, internal server error etc.
            error: function (jqXHR, estado, error) {

            },
            //se ejecuta despues de ejecutarse una de las anterioresfunciones
            //parametros: objeto XMLHttpRequest y estado
            //estado->succes,notmodified,timeout,error,abort,parsererror
            complete: function (jqXHR, estado) {

            },
            timeout: 10000
                    //tiempo maximo de espera de la peticion en milisegundos

        })
    } else {
        $('#correoError').removeClass('visible');
        $('#correoError').addClass('invisible');
        $('#correoLoad').removeClass('fa-spinner');
        $("#divPassword").removeClass('visible');
        $('#divPassword').addClass('invisible');
    }
}

function validacionPassword() {
    var password = $('#password').val();
    var correo = $('#correo').val();
    if (password.length > 0) {
        $.ajax({
            url: 'validarPassword/' + password + '/' + correo,
            type: '',
            succes: function (resp) {
                if (resp == "1") {
                    passwordError = false;
                } else {
                    passwordError = true;
                }
            },
            //si ocurre un error 
            //recible los siguientes parametros
            //jqXHR: objeto XMLHttpRequest
            //estado: cadena con el tipo de error -> timeout,error,abort,parsererror
            //error: muestra la descripcion del error ejemplu no found, internal server error etc.
            error: function (jqXHR, estado, error) {

            },
            //se ejecuta despues de ejecutarse una de las anterioresfunciones
            //parametros: objeto XMLHttpRequest y estado
            //estado->succes,notmodified,timeout,error,abort,parsererror
            complete: function (jqXHR, estado) {

            },
            timeout: 10000
                    //tiempo maximo de espera de la peticion en milisegundos
        });
    } else {
        passwordError = false;
    }
}

function vaciarCamposnuevoPerfil(){
    $("#titulo").val("");
    $("#objetivoGeneral").val("");
    $("#problema").val("");
    $("#justificacion").val("");
    $("#presupuesto").val("");
    $("#sector").val("");
    $("#password").val("");

}