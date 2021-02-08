$(function () {
    $("#form-inicio-sesion-movil").fadeOut(0);
    $("#btnMenuMovil").click(
        function () {
            $("#form-inicio-sesion-movil").fadeOut(0);
            $("#menuNavegacionMovil").fadeToggle(800);
        }
    );
    $("#btnInicioSesionMovil").click(
        function () {
            $("#menuNavegacionMovil").fadeOut(0);
            $("#form-inicio-sesion-movil").fadeToggle(800);
        }
    );

    /*$('#btnIngresar').click(function () {
        var login = $('#txtLogin').val();
        var password = $('#txtPassword').val();
        if ((login.length < 1)) {
            lanzarMensaje('Error', 'Debes ingresar tu correo electronico o numero de identificación', 5000, 2);
            $('#txtLogin').focus();
        } else if (password.length < 5) {
            lanzarMensaje('Error', 'Debes ingresar tu password', 5000, 2);
            $('#txtPassword').focus()
        } else {
            $.ajax({
                beforeSend: function () {
                    $('.progress').removeClass('invisible');
                    $('.progress').addClass('visible');
                },
                url: '/login',
                type: 'POST',
                data: $('#formInicioSesion').serialize(),
                success: (function (resp) {
                    if (resp == '1') {
                        $('#lean-overlay').slideUp(800);
                        alert('A cerrar');
                        window.location.href = "/adminv";
                    } else if (resp == '2') {
                        $('#lean-overlay').slideUp(800);
                        window.location.href = "/inv";
                    } else if (resp == '3') {
                        $('#lean-overlay').slideUp(800);
                        window.location.href = "/eval";
                    } else if (resp == '4') {
                        lanzarMensaje('Error', 'La contraseña ingresada puede ser incorrecta, o su cuenta de usuario ha sido inhabilitada', 5000, 2);
                    } else if (resp == '5') {
                        lanzarMensaje('Error', 'No se encontraron datos relacionados con la identificación o el correo igresados', 5000, 2);
                    } else {
                        alert(resp);
                    }
                    $('.progress').removeClass('visible');
                    $('.progress').addClass('invisible');
                })
            })
        }
    })*/
})