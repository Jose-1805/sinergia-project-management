<div class="col s12 center-align contPerfiles" id="contPerfilesRecibidos" style="margin-bottom: 50px;">
    @if (count($perfilesRecibidos) > 0)
        <?php
            $contProyectos = 0;
            $class = "visible";
            $idModal="opcionesPerfilRecibido";
            $perfiles = $perfilesRecibidos;
        ?>
        <p style="font-size: small;text-align: left; padding-left: 10px;">Perfiles {{$nombreRecibidos}}: {{count($perfilesRecibidos)}}</p>
        @include('plantillas/listaPerfiles')
    @else
        <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen perfiles {{$nombreRecibidos}}</p>
    @endif
</div>


