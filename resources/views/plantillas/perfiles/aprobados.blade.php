<div class="col s12 center-align contPerfiles" id="contPerfilesAprobados" style="margin-bottom: 50px;">
    @if(count($perfilesAprobados) > 0)
        <?php
                $contProyectos = 0;
                $class = "visible";
                $idModal="opcionesPerfilEnFormulacion";
                $perfiles = $perfilesAprobados;
        ?>
        <p style="font-size: small;text-align: left; padding-left: 10px;">Perfiles en formulación: {{count($perfilesAprobados)}}</p>
        @include('plantillas/listaPerfiles')

    @else
        <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen perfiles en formulación</p>
    @endif
</div>