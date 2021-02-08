<div class="col s12 center-align contPerfiles" id="contProyectosTerminados" style="margin-bottom: 50px;">
    @if (count($proyectosTerminados) > 0)
        <?php
            $contProyectos = 0;
            $class = "visible";
            $idModal="opcionesProyectoTerminado";
            $perfiles = $proyectosTerminados;
        ?>
        <p style="font-size: small;text-align: left; padding-left: 10px;">Proyectos terminados: {{count($proyectosTerminados)}}</p>
        @include('plantillas/listaPerfiles')
    @else
        <p class="center-align white btnDataProyecto" style="padding: 15px;">No existen proyectos terminados</p>
    @endif
</div>