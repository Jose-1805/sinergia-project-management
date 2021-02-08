<script>
    $(function () {
        $('#linkOpcionesUsuario').click(function () {   
            $('#listaOpcionesUsuario').css('margin-top', "-20px");
        });

        $('#listaOpcionesUsuario').mouseleave(function () {
            $(this).css('margin-top', '-400px');
        });
        $("#btnMenuMovil").click(
                function () {
                    $("#menuNavegacionMovil").fadeToggle(800);
                }
        );

        $("#btnSalir").click(function () {
            $.ajax({
                url: "/salir",
                type: 'GET',
                success: function (resp) {
                    recargarContenido('/', null);
                    window.location.reload();
                }
            })
        })
    });

</script>
<!-- CONTIENE TODO LO QUE ESTA DENTRO DEL ENCABEZADO DE LA PAGINA -->
<div class="row encabezado">

    <div class="logo col s4 m3 offset-m1 l2 offset-l1">
    </div>


    <a id="btnMenuMovil" class="hide-on-large-only btnMenuMovil " style="float: right;text-align:left; margin-top: 10px; margin-right: 15px;font-size:x-large; color: #000;"><i class="mdi-action-view-headline"></i></a>


    <div id="opcionesUsuario" class="col s1 m7 offset-l1 offset-s5">
        <div id="imgUsuario" style="background-image: url(<?php
        $archivo = "imagenes/perfil/" . session('idPersona');

        if (file_exists($archivo . '.png')) {
            $archivo .= '.png';
            echo asset($archivo);
        } else if (file_exists($archivo . '.jpg')) {
            $archivo .= '.jpg';
            echo asset($archivo);
        } else {
            $archivo = 'imagenes/perfil/user.png';
            echo asset($archivo);
        }
        ?>); <?php
             $datosImg = getimagesize($archivo);
             if ($datosImg[0] > $datosImg[1]) {
                 echo 'background-size: auto 100%;';
             } else {
                 echo 'background-size: 100% auto;';
             }
             ?>"></div>


        <small id="linkOpcionesUsuario">
            <p class="hide-on-small-only"><?php echo Session::get('nombres') . " " . Session::get('apellidos') ?> ▼</p>
            <p class="hide-on-med-and-up" style="position: absolute; margin-top: 0px;margin-left: 35px;">▼</p>
        </small>
    </div>
</div>    <!-- FIN DE ROW -->

<div id="listaOpcionesUsuario" class="col s10 offset-s1 m2 offset-m8 offset-l9">

    <?php
    if ((Session::has('administrador investigativo')) && (Session::get('rol actual') != 'administrador investigativo') && (Session::get('administrador investigativo') == 'activo')) {
        ?>
        <a class="opcionUsuario link-verde" href="{{url('/')}}/adminv">Administrador investigativo</a>
        <?php
    }

    if ((Session::has('investigador')) && (Session::get('rol actual') != 'investigador') && (Session::get('investigador') == 'activo')) {
        ?>
        <a class="opcionUsuario link-verde" href="{{url('/')}}/inv">Investigador</a>
        <?php
    }

    if ((Session::has('evaluador')) && (Session::get('rol actual') != 'evaluador') && (Session::get('evaluador') == 'activo')) {
        ?>
        <a class="opcionUsuario link-verde" href="{{url('/')}}/eval">Evaluador</a>
        <?php
    }
    ?>
    <hr>
    <a class="opcionUsuario link-verde" href="{{url('/')}}/perfil/view/{{\Illuminate\Support\Facades\Crypt::encrypt(\Illuminate\Support\Facades\Session::get('idPersona'))}}">Ver perfil</a>
    <a class="opcionUsuario link-verde" href="{{url('/')}}/perfil/edit/{{\Illuminate\Support\Facades\Crypt::encrypt(\Illuminate\Support\Facades\Session::get('idPersona'))}}">Configurar perfil</a>
    @if((Session::has('administrador investigativo')) && (Session::get('administrador investigativo') == 'activo'))
        <a class="opcionUsuario link-verde" href="{{url('/adminv/administrar')}}">Administrar sistema</a>
    @endif
    <a class="opcionUsuario link-verde"  href="{{url('/')}}/salir">Salir</a>
</div>