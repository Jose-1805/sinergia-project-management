<script>
    $(function () {
        $('#btnIngresar').click(function () {
            var login = $('#txtLogin').val();
            var password = $('#txtPassword').val();
            if ((login.length < 1)) {
                lanzarMensaje('Error', 'Debe ingresar su correo electronico o numero de identificación', 5000, 2);
                $('#txtLogin').focus();
            } else if (password.length < 5) {
                lanzarMensaje('Error', 'Debe ingresar su password', 5000, 2);
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
        })
    })
</script>
<!-- CONTIENE TODO LO QUE ESTA DENTRO DEL ENCABEZADO DE LA PAGINA -->
<div class="row encabezado">

    <div class="logo col s4 m3 offset-m1 l2 offset-l1">
        <?php
        if ($errors->any()) {
            foreach ($errors->all() as $er) {
                ?>
                <h1><?php echo $er; ?></h1>
                <?php
            }
        }
        ?>
    </div>

    <!-- Modal Trigger -->
    <a id="btnInicioSesion" class="btn-flat waves-effect waves-orange modal-trigger hide-on-small-only col offset-m5 offset-l7" style="right: 50px; color: #373737;" href="#ingreso"><i class="mdi-action-account-circle right"></i>Ingresar</a>
    <a class="modal-trigger hide-on-med-and-up col offset-s4" style="margin-top: 10px; right: 50px; font-size: x-large; color: #000;" href="#ingreso"><i class="mdi-action-account-circle right"></i></a>

    <div id="ingreso" class="modal" style="margin-top: 100px; height: 250px; overflow: hidden;">
        <div class="modal-content row" >

            <!-- DIV QUE CONTIENE AL FORMULARIO DESDE EL CUAL SE INICIA SESION -->
            <form class="col s12 m10 offset-m1 l6 offset-l3" id="formInicioSesion">
                <div class="input-field">
                    <i class="mdi-action-account-box prefix"></i>
                    <input type="text" class="input" id="txtLogin" name="txtLogin" required/>
                    <label for="txtLogin">Correo o identificación</label>
                </div>

                <div class="input-field">
                    <i class="mdi-action-lock prefix"></i>
                    <input type="password" class="input" id="txtPassword" name="txtPassword" required/>
                    <label for="txtPassword">Password</label>
                </div>
                <a class="btn waves-effect waves-light" id="btnIngresar">ingresar</a>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <small><a href="{{url('/restaurar-contrasena')}}">olvide mi contraseña</a></small>

            </form>
            <div class="progress invisible">
                <div class="indeterminate"></div>
            </div>
        </div>
    </div>



    <a id="btnMenuMovil" class="hide-on-med-and-up col s1 btnMenuMovil " style="text-align:right; margin-top: 10px;font-size:x-large; color: #000;"><i class="mdi-action-view-headline"></i></a>

</div>    <!-- FIN DE ROW -->