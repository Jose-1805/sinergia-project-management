<section class="col s12 m8 offset-m2" style="padding: 40px 15px !important;">
        <header>
            <h1 class="tituloMediano tituloPrincipalPag">¿Olvidó su contraseña?</h1>
        </header>

        <div class="col s12 grey lighten-5">
            <p class="justificado">Para obtener una nueva contraseña ingrese el correo o número de documento registrado en el sistema. Enviaremos
            a la dirección de correo registrada una nueva contraseña, si recuerda su antigua contraseña puede ingresar normalmente y la contraseña que enviemos
            se eliminará automaticamente.</p>
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            <div class="input-field col s12">
                  <i class="material-icons prefix azul">account_circle</i>
                  <input id="usuario" type="text">
                  <label for="usuario">Correo o identificación</label>
            </div>

            <div class="contenedor-botones">
                <a class="btn col s12 teal darken-1 waves-effect waves-light white-text" id="btnRestaurarContrasena">enviar</a>
            </div>

            <div class="progress invisible">
                <div class="indeterminate"></div>
            </div>

        </div>
</section>

<script>
 $(function(){
    $("#btnRestaurarContrasena").click(function(){
        var dato = $("#usuario").val();
        var token = $("#_token").val();
        if(dato.length){
            params = {"usuario":dato,"_token":token};
            $(".progress").removeClass('invisible');
            $(".contenedor-botones").addClass('invisible');
            $.post($("#base_url").val()+"/restaurar-contrasena-send",params,function(data){
                switch(data){
                     case '1':
                        lanzarMensaje("Completo","Se ha establecido una contraseña de restauración, la información de como utilizar esta contraseña ha sido enviada a su correo electrónico.",8000,1);
                        break;
                     case '-1':
                        lanzarMensaje("Error","No se ha encontrado información relacionada con el usuario ingresado, verifique la información e intente nuevamente.",6000,2);
                        break;
                     case '-2':
                        lanzarMensaje("Error","Los datos de la persona ingresada no se relacionan con ninguna cuenta de usuario creada.",4000,2);
                        break;
                     case '-3':
                        lanzarMensaje("Error","Actualmente tiene una solicitud de restauración de contraseña no comprobada.",4000,2);
                        break;
                }
                $(".progress").addClass('invisible');
                $(".contenedor-botones").removeClass('invisible');
                $("#usuario").val("");
            });
        }else{
            lanzarMensaje("Error","Ingrese su identificación  o correo electrónico.","4000",2);
        }
    })
 })
</script>